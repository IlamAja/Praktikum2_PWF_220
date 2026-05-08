<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('products.update', $product) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="mt-1 block w-full rounded border px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                                value="{{ old('name', $product->name) }}"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="qty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah (Qty)</label>
                            <input
                                type="number"
                                name="qty"
                                id="qty"
                                class="mt-1 block w-full rounded border px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $errors->has('qty') ? 'border-red-500' : 'border-gray-300' }}"
                                value="{{ old('qty', $product->qty) }}"
                            >
                            @error('qty')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga (Price)</label>
                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                id="price"
                                class="mt-1 block w-full rounded border px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $errors->has('price') ? 'border-red-500' : 'border-gray-300' }}"
                                value="{{ old('price', $product->price) }}"
                            >
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>