<x-app-layout>
    @section('title', 'Configuración de la Aplicación')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ajustes de la Aplicación</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="company_name" :value="__('Nombre de la Compañía')" />
                                <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $settings['company_name'])" required autofocus autocomplete="company_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                            </div>

                            <div>
                                <x-input-label for="currency" :value="__('Moneda')" />
                                <x-text-input id="currency" name="currency" type="text" class="mt-1 block w-full" :value="old('currency', $settings['currency'])" required autocomplete="currency" />
                                <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                            </div>

                            <div>
                                <x-input-label for="low_stock_threshold" :value="__('Umbral de Stock Bajo')" />
                                <x-text-input id="low_stock_threshold" name="low_stock_threshold" type="number" class="mt-1 block w-full" :value="old('low_stock_threshold', $settings['low_stock_threshold'])" required autocomplete="low_stock_threshold" />
                                <x-input-error class="mt-2" :messages="$errors->get('low_stock_threshold')" />
                            </div>

                            <div>
                                <x-input-label for="date_format" :value="__('Formato de Fecha')" />
                                <select id="date_format" name="date_format" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="Y-m-d" @selected(old('date_format', $settings['date_format']) == 'Y-m-d')>YYYY-MM-DD (2023-01-25)</option>
                                    <option value="d/m/Y" @selected(old('date_format', $settings['date_format']) == 'd/m/Y')>DD/MM/YYYY (25/01/2023)</option>
                                    <option value="m/d/Y" @selected(old('date_format', $settings['date_format']) == 'm/d/Y')>MM/DD/YYYY (01/25/2023)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('date_format')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Guardar Cambios') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 