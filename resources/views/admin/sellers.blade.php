@extends('admin.lay-out')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-4">Manage Sellers</h3>
    <div class="mb-3">
    <a href="{{ route('admin.dashboard') }}"
       class="btn btn-outline-dark btn-sm">
        ← Back to Dashboard
    </a>
</div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">
            Seller Accounts
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($sellers as $seller)

                        <tr>

                            <td class="fw-semibold">{{ $seller->name }}</td>
                            <td>{{ $seller->email }}</td>

                            <td>
                                @if($seller->is_blocked)
                                    <span class="badge bg-danger">Blocked</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>

                            <td>{{ $seller->created_at->format('Y-m-d') }}</td>
<td class="text-center">

    <!-- DELETE ONLY -->
    <form method="POST"
          action="{{ route('admin.sellers.delete', $seller->id) }}"
          onsubmit="return confirm('Delete this seller permanently?')">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-sm">
            Delete Seller
        </button>

    </form>

</td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No sellers found
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection