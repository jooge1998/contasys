<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Producto en Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('inventories.store') }}" class="space-y-6">
                        @csrf

                        <!-- Nombre del Producto -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre del Producto')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Cantidad -->
                        <div>
                            <x-input-label for="quantity" :value="__('Cantidad')" />
                            <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full" :value="old('quantity')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                        </div>

                        <!-- Stock Mínimo -->
                        <div>
                            <x-input-label for="min_stock" :value="__('Stock Mínimo')" />
                            <x-text-input id="min_stock" name="min_stock" type="number" min="0" class="mt-1 block w-full" :value="old('min_stock')" required />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Cantidad mínima de stock antes de mostrar alerta</p>
                            <x-input-error class="mt-2" :messages="$errors->get('min_stock')" />
                        </div>

                        <!-- Precio Unitario -->
                        <div>
                            <x-input-label for="unit_price" :value="__('Precio Unitario')" />
                            <x-text-input id="unit_price" name="unit_price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('unit_price')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('unit_price')" />
                        </div>

                        <!-- Descripción -->
                        <div>
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar') }}</x-primary-button>
                            <a href="{{ route('inventories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const minStockInput = document.getElementById('min_stock');
            
            function checkStockLevel() {
                const quantity = parseInt(quantityInput.value) || 0;
                const minStock = parseInt(minStockInput.value) || 0;
                
                if (quantity <= minStock) {
                    // Show alert
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'mt-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 dark:bg-yellow-900/20 dark:border-yellow-500 dark:text-yellow-300';
                    alertDiv.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">¡Alerta! El stock está por debajo del mínimo establecido.</p>
                            </div>
                        </div>
                    `;
                    
                    // Remove any existing alert
                    const existingAlert = document.querySelector('.mt-4.p-4.bg-yellow-100');
                    if (existingAlert) {
                        existingAlert.remove();
                    }
                    
                    // Add new alert after the form
                    document.querySelector('form').insertAdjacentElement('afterend', alertDiv);
                } else {
                    // Remove alert if it exists
                    const existingAlert = document.querySelector('.mt-4.p-4.bg-yellow-100');
                    if (existingAlert) {
                        existingAlert.remove();
                    }
                }
            }
            
            // Add event listeners
            quantityInput.addEventListener('input', checkStockLevel);
            minStockInput.addEventListener('input', checkStockLevel);
            
            // Initial check
            checkStockLevel();
        });
    </script>
    @endpush
</x-app-layout> 