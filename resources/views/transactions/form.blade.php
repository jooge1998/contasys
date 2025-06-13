<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($transaction) ? __('Editar Transacción') : __('Nueva Transacción') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($transaction) ? route('transactions.update', $transaction) : route('transactions.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if(isset($transaction))
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="date" :value="__('Fecha')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', isset($transaction) ? $transaction->date->format('Y-m-d') : '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date')" />
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Tipo')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="Ingreso" {{ old('type', $transaction->type ?? '') === 'Ingreso' ? 'selected' : '' }}>Ingreso</option>
                                <option value="Egreso" {{ old('type', $transaction->type ?? '') === 'Egreso' ? 'selected' : '' }}>Egreso</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Monto')" />
                            <x-text-input id="amount" name="amount" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('amount', $transaction->amount ?? '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Descripción')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" required>{{ old('description', $transaction->description ?? '') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ isset($transaction) ? __('Actualizar') : __('Crear') }}</x-primary-button>
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 