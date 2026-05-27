<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Add Product
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white shadow rounded-xl p-6">

                <h3 class="text-lg font-semibold mb-6 text-gray-800">
                    Product Details
                </h3>

                <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- TITLE -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Product Title</label>
                        <input type="text" name="title"
                               class="w-full mt-1 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                               required>
                    </div>

                    <!-- PRICE -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Price (₱)</label>
                        <input type="number" name="price" step="0.01"
                               class="w-full mt-1 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                               required>
                    </div>

                    <!-- CATEGORY -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Category</label>

                        <select name="category" id="category"
                                class="w-full mt-1 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                required>

                            <option value="">Select category</option>
                            <option value="clothes">Clothes</option>
                            <option value="shoes">Shoes</option>
                            <option value="gadgets">Gadgets</option>
                            <option value="books">Books</option>
                            <option value="other">Other</option>

                        </select>
                    </div>

                    <!-- OTHER CATEGORY -->
                    <div class="mb-4 hidden" id="otherCategoryBox">
                        <label class="block text-sm font-medium text-gray-700">Please specify</label>

                        <input type="text" name="other_category" id="other_category"
                               class="w-full mt-1 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                               placeholder="Enter category name">
                    </div>

                    <!-- CONDITION -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Condition</label>

                        <select name="condition"
                                class="w-full mt-1 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                required>
                            <option value="">Select condition</option>
                            <option value="new">New</option>
                            <option value="like new">Like New</option>
                            <option value="used">Used</option>
                        </select>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>

                        <textarea name="description" rows="4"
                                  class="w-full mt-1 border-gray-300 rounded-lg focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <!-- IMAGE -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Product Image</label>

                        <input type="file" name="image"
                               class="w-full mt-1 border-gray-300 rounded-lg">
                    </div>

                    <!-- BUTTONS -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('seller.dashboard') }}"
                           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 text-sm">
                            Save Product
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <!-- FIXED JS -->
    <script>
        const category = document.getElementById('category');
        const box = document.getElementById('otherCategoryBox');
        const otherInput = document.getElementById('other_category');

        function toggleOtherCategory() {
            if (category.value === 'other') {
                box.classList.remove('hidden');
                otherInput.setAttribute('required', 'required');
            } else {
                box.classList.add('hidden');
                otherInput.removeAttribute('required');
                otherInput.value = '';
            }
        }

        category.addEventListener('change', toggleOtherCategory);
    </script>

</x-app-layout>