<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Seller Dashboard
        </h2>
    </x-slot>

    <!-- MOVE x-data HERE -->
    <div class="py-10 bg-gray-100 min-h-screen" x-data="editModal()">

        <div class="max-w-7xl mx-auto px-4">

            <!-- TOP ACTION -->
            <div class="flex justify-between items-center mb-8 mt-6 px-2">

                <h3 class="text-lg font-bold text-gray-700">
                    My Overview
                </h3>

                <a href="{{ route('seller.products.create') }}"
                   class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition mt-2">
                    + Add Product
                </a>

            </div>

            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

                <!-- TOTAL PRODUCTS -->
                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-gray-500">Total Products</p>

                    <h2 class="text-2xl font-bold">
                        {{ auth()->user()->products()->count() }}
                    </h2>
                </div>

                <!-- PENDING -->
                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-gray-500">Pending</p>

                    <h2 class="text-2xl font-bold text-yellow-500">
                        {{ auth()->user()->products()->where('status','pending')->count() }}
                    </h2>
                </div>

                <!-- APPROVED -->
                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-gray-500">Approved</p>

                    <h2 class="text-2xl font-bold text-green-600">
                        {{ auth()->user()->products()->where('status','approved')->count() }}
                    </h2>
                </div>

                <!-- SOLD -->
                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-gray-500">Total Sold</p>

                    <h2 class="text-2xl font-bold text-blue-600">
                        {{ auth()->user()->products()->where('status','sold')->count() }}
                    </h2>
                </div>

            </div>

            <!-- PRODUCT SECTION -->
<div class="bg-white shadow rounded-2xl overflow-hidden">

    <!-- TABS -->
    <div class="border-b flex overflow-x-auto">

        <a href="{{ route('seller.dashboard', ['status' => 'all']) }}"
           class="px-6 py-4 text-sm font-medium
           {{ request('status') == 'all' || !request('status')
                ? 'border-b-2 border-blue-600 text-blue-600'
                : 'text-gray-500 hover:text-blue-600' }}">
            All
        </a>

        <a href="{{ route('seller.dashboard', ['status' => 'pending']) }}"
           class="px-6 py-4 text-sm font-medium
           {{ request('status') == 'pending'
                ? 'border-b-2 border-yellow-500 text-yellow-500'
                : 'text-gray-500 hover:text-yellow-500' }}">
            Pending
        </a>

        <a href="{{ route('seller.dashboard', ['status' => 'approved']) }}"
           class="px-6 py-4 text-sm font-medium
           {{ request('status') == 'approved'
                ? 'border-b-2 border-green-600 text-green-600'
                : 'text-gray-500 hover:text-green-600' }}">
            Approved
        </a>

        <a href="{{ route('seller.dashboard', ['status' => 'rejected']) }}"
           class="px-6 py-4 text-sm font-medium
           {{ request('status') == 'rejected'
                ? 'border-b-2 border-red-500 text-red-500'
                : 'text-gray-500 hover:text-red-500' }}">
            Rejected
        </a>

        <a href="{{ route('seller.dashboard', ['status' => 'sold']) }}"
           class="px-6 py-4 text-sm font-medium
           {{ request('status') == 'sold'
                ? 'border-b-2 border-blue-600 text-blue-600'
                : 'text-gray-500 hover:text-blue-600' }}">
            Sold
        </a>

    </div>

    <!-- PRODUCTS -->
    <div class="p-6 space-y-4">

        @forelse($products as $product)

            <div class="flex flex-col md:flex-row justify-between items-center border rounded-xl p-4 bg-gray-50 hover:shadow">

                <!-- LEFT -->
                <div class="w-full">

                    <h4 class="font-semibold text-lg text-gray-800">
                        {{ $product->title }}
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        ₱{{ number_format($product->price,2) }}
                        • {{ $product->category }}
                        • {{ $product->condition }}
                    </p>

                    <!-- STATUS -->
                    <span class="inline-block mt-3 px-3 py-1 text-xs rounded-full font-medium

                        @if($product->status == 'approved')
                            bg-green-100 text-green-700

                        @elseif($product->status == 'pending')
                            bg-yellow-100 text-yellow-700

                        @elseif($product->status == 'sold')
                            bg-blue-100 text-blue-700

                        @else
                            bg-red-100 text-red-700
                        @endif">

                        {{ ucfirst($product->status) }}

                    </span>

                </div>

                <!-- ACTIONS -->
<div class="flex items-center gap-2 mt-4 md:mt-0 whitespace-nowrap">

    @if($product->status != 'sold')

        <!-- EDIT -->
        <!-- EDIT -->
<button
    type="button"
    @click="openEdit({
        id: {{ $product->id }},
        title: '{{ addslashes($product->title) }}',
        price: '{{ $product->price }}',
        category: '{{ addslashes($product->category) }}',
        condition: '{{ addslashes($product->condition) }}'
    })"
    class="px-3 py-2 text-xs bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">

    Edit

</button>

    @endif

    <!-- MARK SOLD -->
    @if($product->status == 'approved')

        <form method="POST"
              action="{{ route('seller.products.sold', $product->id) }}">
            @csrf

            <!-- MARK SOLD -->
<button
    class="px-3 py-2 text-xs bg-green-10000 text-green rounded-lg hover:bg-green-700 transition shadow">

    Mark Sold

</button>

        </form>

    @endif

    <!-- DELETE -->
    <form method="POST"
          action="{{ route('seller.products.destroy', $product->id) }}"
          onsubmit="return confirm('Delete this product?')">

        @csrf
        @method('DELETE')

        <!-- DELETE -->
<button
    class="px-3 py-2 text-xs bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow">

    Delete

</button>

    </form>

</div>

            </div>

        @empty

            <div class="text-center py-12 text-gray-500">

                No products found.

            </div>

        @endforelse

    </div>

</div>

        <!-- ================= EDIT MODAL ================= -->
        <div x-cloak>

            <!-- BACKDROP -->
            <div
    x-show="open"
    x-transition.opacity
    class="fixed inset-0 bg-gray-900/80 flex items-center justify-center z-50 px-4">

                <!-- MODAL -->
                <div
                    
    x-show="open"
    x-transition.scale.90
    class="bg-gray-800 text-white rounded-2xl shadow-2xl overflow-hidden border border-gray-700">

                    <!-- HEADER -->
                    <div
                        class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white">

                        <h2 class="text-lg font-semibold">
                            Edit Product
                        </h2>

                        <button
                            @click="open = false"
                            class="text-white text-xl hover:opacity-70 transition">
                            ✕
                        </button>

                    </div>

                    <!-- FORM -->
                    <form
                        :action="`/seller/products/${form.id}`"
                        method="POST"
                        class="p-6 space-y-4">

                        @csrf
                        @method('PUT')

                        <!-- TITLE -->
                        <div>
                            <label class="text-sm font-medium text-gray-1000">
                                Product Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                x-model="form.title"
                                class="w-full mt-1 bg-white text-gray-900 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        </div>

                        <!-- PRICE -->
                        <div>
                            <label class="text-sm font-medium text-gray-1000">
                                Price (₱)
                            </label>

                            <input
                                type="number"
                                name="price"
                                x-model="form.price"
                                class="w-full mt-1 bg-white text-gray-900 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        </div>

                        <!-- CATEGORY -->
                        <div>
                            <label class="text-sm font-medium text-gray-1000">
                                Category
                            </label>

                            <input
                                type="text"
                                name="category"
                                x-model="form.category"
                                class="w-full mt-1 bg-white text-gray-900 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        </div>

                        <!-- CONDITION -->
                        <div>
                            <label class="text-sm font-medium font-color-text-gray-1000">
                                Condition
                            </label>

                            <input
                                type="text"
                                name="condition"
                                x-model="form.condition"
                                class="w-full mt-1 bg-white text-gray-900 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                        </div>

                        <!-- BUTTONS -->
                        <div class="flex justify-end gap-3 pt-4 border-t">

                            <button
                                type="button"sss
                                @click="open = false"
                                class="px-4 py-2 rounded-lg border hover:bg-gray-100 transition">

                                Cancel

                            </button>

                            <button
                                type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">

                                Save Changes

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- ================= ALPINE JS ================= -->
    <script>
        function editModal() {
            return {
                open: false,

                form: {
                    id: null,
                    title: '',
                    price: '',
                    category: '',
                    condition: ''
                },

                openEdit(product) {
                    this.form = {
                        id: product.id,
                        title: product.title,
                        price: product.price,
                        category: product.category,
                        condition: product.condition
                    };

                    this.open = true;
                }
            }
        }
    </script>

</x-app-layout>