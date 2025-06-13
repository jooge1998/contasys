<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($inventory) ? __('Editar Producto') : __('Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($inventory) ? route('inventory.update', $inventory) : route('inventory.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if(isset($inventory))
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="product_name" :value="__('Nombre del Producto')" />
                            <x-text-input id="product_name" name="product_name" type="text" class="mt-1 block w-full" :value="old('product_name', $inventory->product_name ?? '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('product_name')" />
                        </div>

                        <div>
                            <x-input-label for="quantity" :value="__('Cantidad')" />
                            <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full" :value="old('quantity', $inventory->quantity ?? '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                        </div>

                        <div>
                            <x-input-label for="unit_price" :value="__('Precio Unitario')" />
                            <x-text-input id="unit_price" name="unit_price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('unit_price', $inventory->unit_price ?? '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('unit_price')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ isset($inventory) ? __('Actualizar') : __('Crear') }}</x-primary-button>
                            <a href="{{ route('inventory.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 