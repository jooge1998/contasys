<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function transactions(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $transactions = Transaction::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        $summary = [
            'total_income' => $transactions->where('type', 'income')->sum('amount'),
            'total_expense' => $transactions->where('type', 'expense')->sum('amount'),
            'net_balance' => $transactions->where('type', 'income')->sum('amount') - $transactions->where('type', 'expense')->sum('amount'),
        ];

        return view('reports.transactions', compact('transactions', 'summary', 'startDate', 'endDate'));
    }

    public function inventory()
    {
        $inventory = Inventory::all();
        
        $summary = [
            'total_items' => $inventory->count(),
            'total_value' => $inventory->sum(function($item) {
                return $item->quantity * $item->unit_price;
            }),
            'low_stock' => $inventory->where('quantity', '<', 10)->count(),
        ];

        return view('reports.inventory', compact('inventory', 'summary'));
    }
} 