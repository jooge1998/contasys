<x-app-layout>
    @section('title', 'Crear Venta')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('sales.store') }}" class="space-y-6">
                        @csrf

                        <!-- Product Selection -->
                        <div>
                            <x-input-label for="inventory_id" :value="__('Producto')" />
                            <select id="inventory_id" name="inventory_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Seleccione un producto</option>
                                @foreach($inventoryItems as $item)
                                    <option value="{{ $item->id }}" 
                                        data-price="{{ $item->unit_price }}" 
                                        data-stock="{{ $item->quantity }}">
                                        {{ $item->name }} - Stock: {{ $item->quantity }} - Precio: ${{ number_format($item->unit_price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('inventory_id')" class="mt-2" />
                        </div>

                        <!-- Quantity -->
                        <div>
                            <x-input-label for="quantity" :value="__('Cantidad')" />
                            <x-text-input id="quantity" name="quantity" type="number" min="1" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <!-- Total Preview -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-300">Precio Unitario:</span>
                                <span class="font-medium">$<span id="unit-price">0.00</span></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-300">Cantidad:</span>
                                <span class="font-medium"><span id="quantity-display">0</span> unidades</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total:</span>
                                <span class="text-lg font-bold text-gray-900 dark:text-white">$<span id="total-amount">0.00</span></span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Crear Venta') }}</x-primary-button>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
        console.log('Script loaded');
        
        window.addEventListener('load', function() {
            console.log('Window loaded');
            
            const inventorySelect = document.getElementById('inventory_id');
            const quantityInput = document.getElementById('quantity');
            const totalAmount = document.getElementById('total-amount');
            const unitPriceDisplay = document.getElementById('unit-price');
            const quantityDisplay = document.getElementById('quantity-display');

            console.log('Elements found:', {
                inventorySelect: !!inventorySelect,
                quantityInput: !!quantityInput,
                totalAmount: !!totalAmount,
                unitPriceDisplay: !!unitPriceDisplay,
                quantityDisplay: !!quantityDisplay
            });

            function calculateTotal() {
                console.log('Calculating total...');
                const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
                console.log('Selected option:', selectedOption);
                
                if (!selectedOption || !selectedOption.value) {
                    console.log('No option selected');
                    unitPriceDisplay.textContent = '0.00';
                    quantityDisplay.textContent = '0';
                    totalAmount.textContent = '0.00';
                    return;
                }

                const price = parseFloat(selectedOption.dataset.price || 0);
                const quantity = parseInt(quantityInput.value) || 0;
                const total = price * quantity;

                console.log('Values:', { price, quantity, total });

                unitPriceDisplay.textContent = price.toFixed(2);
                quantityDisplay.textContent = quantity;
                totalAmount.textContent = total.toFixed(2);
            }

            inventorySelect.addEventListener('change', function() {
                console.log('Product changed');
                const selectedOption = this.options[this.selectedIndex];
                
                if (selectedOption.value) {
                    const maxStock = parseInt(selectedOption.dataset.stock) || 0;
                    quantityInput.max = maxStock;
                    
                    if (!quantityInput.value) {
                        quantityInput.value = 1;
                    }
                    
                    calculateTotal();
                } else {
                    quantityInput.value = '';
                    calculateTotal();
                }
            });

            quantityInput.addEventListener('input', function() {
                console.log('Quantity changed');
                const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
                
                if (selectedOption.value) {
                    const maxStock = parseInt(selectedOption.dataset.stock) || 0;
                    let value = parseInt(this.value) || 0;
                    
                    if (this.value === '') {
                        value = 0;
                    } else if (value < 1) {
                        value = 1;
                        this.value = 1;
                    } else if (value > maxStock) {
                        value = maxStock;
                        this.value = maxStock;
                    }
                }
                
                calculateTotal();
            });

            // Initial calculation
            if (inventorySelect.value) {
                console.log('Initial product selected');
                const event = new Event('change');
                inventorySelect.dispatchEvent(event);
            } else {
                console.log('No initial product');
                calculateTotal();
            }
        });
    </script>
    @endpush
</x-app-layout> 