<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function create()
    {
        $inventoryItems = Inventory::where('quantity', '>', 0)
            ->select('id', 'name', 'quantity', 'unit_price')
            ->get();
            
        return view('sales.create', compact('inventoryItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $inventory = Inventory::findOrFail($request->inventory_id);
            
            if ($inventory->quantity < $request->quantity) {
                return back()->withErrors(['quantity' => 'No hay suficiente stock disponible.']);
            }

            // Calculate total amount
            $totalAmount = $inventory->unit_price * $request->quantity;

            // Create transaction record for the sale
            $transaction = Transaction::create([
                'type' => 'Ingreso', // Registramos como ingreso ya que es una venta
                'amount' => $totalAmount,
                'description' => "Venta de {$inventory->name} - Cantidad: {$request->quantity} - Precio unitario: $" . number_format($inventory->unit_price, 2),
                'user_id' => auth()->id(),
                'date' => now(),
            ]);

            // Update inventory quantity
            $inventory->update([
                'quantity' => $inventory->quantity - $request->quantity
            ]);

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Venta registrada exitosamente como transacción.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al procesar la venta: ' . $e->getMessage()]);
        }
    }
} 