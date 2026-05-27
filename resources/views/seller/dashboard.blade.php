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

            <!-- PRODUCT LIST -->
            <div class="bg-white shadow rounded-xl p-6">

                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                    My Products
                </h3>

                <div class="space-y-4">

                    @forelse(auth()->user()->products as $product)

                        <div
                            class="flex flex-col md:flex-row md:justify-between md:items-center border rounded-xl p-4 hover:shadow transition bg-gray-50">

                            <!-- LEFT -->
                            <div class="mb-3 md:mb-0">

                                <!-- TITLE -->
                                <h4 class="font-semibold text-gray-800 text-lg">
                                    {{ $product->title }}
                                </h4>

                                <!-- DETAILS -->
                                <p class="text-sm text-gray-500 mt-1">
                                    ₱{{ number_format($product->price, 2) }}
                                    • {{ $product->category }}
                                    • {{ $product->condition }}
                                </p>

                                <!-- STATUS -->
                                <span
                                    class="inline-block mt-3 px-3 py-1 text-xs rounded-full font-medium

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

                            <!-- RIGHT ACTIONS -->
                            <div class="flex flex-wrap gap-2">

                                <!-- SOLD PRODUCT -->
                                @if($product->status == 'sold')

                                    <!-- DELETE SOLD PRODUCT -->
                                    <form method="POST"
                                          action="{{ route('seller.products.destroy', $product->id) }}"
                                          onsubmit="return confirm('Delete this sold product?');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-3 py-1 text-sm border border-red-500 text-red-500 rounded-lg hover:bg-red-50 transition">
                                            Delete
                                        </button>

                                    </form>

                                @else

                                    <!-- EDIT BUTTON -->
                                    <button
                                        type="button"
                                        @click="openEdit({
                                            id: {{ $product->id }},
                                            title: '{{ addslashes($product->title) }}',
                                            price: '{{ $product->price }}',
                                            category: '{{ addslashes($product->category) }}',
                                            condition: '{{ addslashes($product->condition) }}'
                                        })"
                                        class="px-3 py-1 text-sm border rounded-lg hover:bg-gray-100 transition">
                                        Edit
                                    </button>

                                    <!-- MARK SOLD -->
                                    @if($product->status == 'approved')

                                        <form method="POST"
                                              action="{{ route('seller.products.sold', $product->id) }}">
                                            @csrf

                                            <button
                                                class="px-3 py-1 text-sm border border-green-500 text-green-600 rounded-lg hover:bg-green-50 transition">
                                                Mark Sold
                                            </button>

                                        </form>

                                    @elseif($product->status == 'pending')

                                        <!-- DISABLED BUTTON -->
                                        <button
                                            disabled
                                            class="px-3 py-1 text-sm border border-gray-300 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                            Waiting Approval
                                        </button>

                                    @endif

                                    <!-- DELETE -->
                                    <form method="POST"
                                          action="{{ route('seller.products.destroy', $product->id) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this product?');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-3 py-1 text-sm border border-red-500 text-red-500 rounded-lg hover:bg-red-50 transition">
                                            Delete
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-10 text-gray-500">

                            <p class="text-lg font-medium">
                                No products yet
                            </p>

                            <p class="text-sm mt-1">
                                Start selling now 🚀
                            </p>

                        </div>

                    @endforelse

                </div>

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