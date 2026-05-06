<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">{{ $product->name }}</h3>
                    <p>Quantity: {{ $product->qty }}</p>
                    <p>Price: {{ $product->price }}</p>
                    <a href="{{ route('products.index') }}" class="text-blue-500">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>