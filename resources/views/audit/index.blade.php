<x-app-layout>
    @section('title', 'Registro de Auditoría')

    <x-slot name="header">
        <div class="flex items-center">
            <!-- Icono de auditoría (ejemplo: un icono de lista/documento) -->
            <svg class="w-6 h-6 text-gray-800 dark:text-gray-200 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Registro de Auditoría') }}
            </h2>
        </div>
        <div class="flex-grow text-right">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Exportar
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 p-6 bg-white dark:bg-gray-700 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Resumen de Transacciones</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                                <div class="text-sm text-green-600 dark:text-green-400 mb-1">Ingreso Total</div>
                                <div class="text-2xl font-bold text-green-700 dark:text-green-300">
                                    ${{ number_format($totalIncome, 2) }}
                                </div>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg border border-red-200 dark:border-red-800">
                                <div class="text-sm text-red-600 dark:text-red-400 mb-1">Gastos Totales</div>
                                <div class="text-2xl font-bold text-red-700 dark:text-red-300">
                                    ${{ number_format($totalExpenses, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Evento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cambios</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($audits as $audit)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $audit->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $audit->user ? $audit->user->name : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $audit->event === 'created' ? 'bg-green-100 text-green-800' : 
                                                   ($audit->event === 'updated' ? 'bg-blue-100 text-blue-800' : 
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($audit->event) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ class_basename($audit->auditable_type) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            @if($audit->new_values)
                                                <div class="space-y-1">
                                                    @foreach($audit->new_values as $key => $value)
                                                        <div class="flex items-start">
                                                            <span class="font-medium text-gray-700 dark:text-gray-300 mr-2">
                                                                {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                                            </span>
                                                            <span class="text-gray-600 dark:text-gray-400">
                                                                {{ is_array($value) ? json_encode($value) : $value }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No hay registros de auditoría disponibles.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $audits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 