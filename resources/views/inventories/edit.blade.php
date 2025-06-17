<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Item del Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('inventories.update', $inventory) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nombre del Producto')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $inventory->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea
                                id="description"
                                name="description"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                rows="3"
                            >{{ old('description', $inventory->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="quantity" :value="__('Cantidad')" />
                                <x-text-input id="quantity" name="quantity" type="number" step="0.01" class="mt-1 block w-full" :value="old('quantity', $inventory->quantity)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                            </div>

                            <div>
                                <x-input-label for="min_stock" :value="__('Stock Mínimo')" />
                                <x-text-input id="min_stock" name="min_stock" type="number" min="0" step="1" class="mt-1 block w-full" :value="old('min_stock', $inventory->min_stock)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('min_stock')" />
                                <p class="mt-1 text-sm text-gray-500">Cantidad mínima de stock antes de mostrar alerta</p>
                            </div>

                            <div>
                                <x-input-label for="unit_price" :value="__('Precio Unitario')" />
                                <x-text-input id="unit_price" name="unit_price" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('unit_price', $inventory->unit_price)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('unit_price')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                            <a href="{{ route('inventories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 