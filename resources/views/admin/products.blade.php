@extends('admin.lay-out')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-2">Manage Products (Pending Approval)</h3>

    <div class="mb-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm">
            ← Back to Dashboard
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-dark text-white">
            Pending Product Listings
        </div>

        <div class="card-body p-0">

            <!-- ================= TABLE ================= -->
            <div class="table-responsive d-none d-md-block">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Seller</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($pending as $product)

                        <tr>

                            <!-- IMAGE -->
                            <td style="width:90px;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         width="70"
                                         height="70"
                                         class="rounded border"
                                         style="object-fit: cover;">
                                @endif
                            </td>

                            <!-- DETAILS -->
                            <td>
                                <div class="fw-bold">{{ $product->title }}</div>

                                <div class="text-muted small">
                                    ₱{{ number_format($product->price, 2) }}
                                </div>

                                <div class="small">
                                    {{ $product->category }} • {{ $product->condition }}
                                </div>

                                @if($product->rejection_reason)
                                    <div class="text-danger small mt-1">
                                        Reason: {{ $product->rejection_reason }}
                                    </div>
                                @endif
                            </td>

                            <!-- SELLER -->
                            <td>
                                <div class="fw-semibold">
                                    {{ $product->user->name ?? 'Unknown' }}
                                </div>
                            </td>

                            <!-- STATUS -->
                            <td>
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            <!-- ACTIONS -->
                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    <!-- APPROVE -->
                                    <form method="POST"
                                          action="{{ route('admin.products.approve', $product->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm px-3">
                                            Approve
                                        </button>
                                    </form>

                                    <!-- REJECT -->
                                    <button class="btn btn-danger btn-sm px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $product->id }}">
                                        Reject
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No pending products found
                            </td>
                        </tr>

                    @endforelse

                    </tbody>
                </table>
            </div>

            <!-- ================= MOBILE ================= -->
            <div class="d-block d-md-none p-3">

                @forelse($pending as $product)

                <div class="card mb-3 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex gap-3">

                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     width="60"
                                     height="60"
                                     class="rounded border"
                                     style="object-fit: cover;">
                            @endif

                            <div>
                                <div class="fw-bold">{{ $product->title }}</div>

                                <div class="text-muted small">
                                    ₱{{ number_format($product->price, 2) }}
                                </div>

                                <div class="small">
                                    {{ $product->category }} • {{ $product->condition }}
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="small">
                            <strong>Seller:</strong> {{ $product->user->name ?? 'Unknown' }}
                        </div>

                        <div class="d-flex gap-2 mt-3">

                            <form method="POST"
                                  action="{{ route('admin.products.approve', $product->id) }}"
                                  class="w-100">
                                @csrf
                                <button class="btn btn-success btn-sm w-100">
                                    Approve
                                </button>
                            </form>

                            <button class="btn btn-danger btn-sm w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rejectModal{{ $product->id }}">
                                Reject
                            </button>

                        </div>

                    </div>

                </div>

                @empty
                    <div class="text-center text-muted">
                        No pending products found
                    </div>
                @endforelse

            </div>

        </div>
    </div>
</div>

<!-- ================= REJECT MODALS ================= -->
@foreach($pending as $product)

<div class="modal fade" id="rejectModal{{ $product->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

        <form method="POST"
              action="{{ route('admin.products.reject', $product->id) }}"
              class="modal-content">

            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Reject Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <label class="form-label">Reason for rejection</label>

                <textarea name="rejection_reason"
                          class="form-control"
                          required
                          placeholder="Enter reason here..."></textarea>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger w-100">
                    Confirm Reject
                </button>
            </div>

        </form>

    </div>
</div>

@endforeach

@endsection