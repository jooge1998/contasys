<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total balance from transactions
        $totalBalance = Transaction::sum('amount');

        // Get count of recent transactions (last 30 days)
        $recentTransactions = Transaction::where('created_at', '>=', now()->subDays(30))->count();

        // Get total inventory items
        $inventoryItems = Inventory::count();

        // Get recent transactions for the table
        $transactions = Transaction::latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBalance',
            'recentTransactions',
            'inventoryItems',
            'transactions'
        ));
    }
} 