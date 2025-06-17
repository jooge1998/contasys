<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center  dark:bg-blue-900  rounded-t-lg  ">
            <h2 class="font-semibold text-xl text-blue-900 dark:text-blue-100 leading-tight">
                {{ __('Inventario') }}
            </h2>
            @role(['Administrador', 'Contador'])
            <a href="{{ route('inventories.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-150 ease-in-out">
                Nuevo Producto
            </a>
            @endrole
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-blue-100 dark:bg-blue-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">Precio Unitario</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">Alerta de Stock</th>
                                    @role(['Administrador', 'Contador'])
                                    <th class="px-6 py-3 text-left text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wider">Acciones</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($inventories as $item)
                                <tr @if($item->quantity <= $item->min_stock) class="bg-red-50 dark:bg-red-900/10" @else class="hover:bg-gray-50 dark:hover:bg-gray-700 transition" @endif>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $item->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $item->product_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <span class="font-bold text-lg {{ $item->quantity <= $item->min_stock ? 'text-red-600' : 'text-green-700 dark:text-green-300' }}">{{ $item->quantity }}</span>
                                        <span class="text-xs text-gray-500">/ {{ $item->min_stock }}</span>
                                        @if($item->quantity <= $item->min_stock)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 bg-red-200 text-red-800 text-xs font-bold rounded-full shadow">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Bajo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        ${{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $item->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($item->quantity <= $item->min_stock)
                                            <span class="inline-flex items-center px-2 py-1 bg-yellow-200 text-yellow-900 text-xs font-bold rounded shadow dark:bg-yellow-900/30 dark:text-yellow-200">
                                                <svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                ¡Stock bajo! (Mín: {{ $item->min_stock }})
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 bg-green-200 text-green-900 text-xs font-bold rounded shadow dark:bg-green-900/30 dark:text-green-200">
                                                OK
                                            </span>
                                        @endif
                                    </td>
                                    @role(['Administrador', 'Contador'])
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('inventories.edit', $item) }}" 
                                               class="text-blue-700 dark:text-blue-300 hover:text-blue-900 dark:hover:text-blue-200 font-bold">
                                                Editar
                                            </a>
                                            <form action="{{ route('inventories.destroy', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-700 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-bold"
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endrole
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 