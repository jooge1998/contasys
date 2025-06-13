<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $inventory = Inventory::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $users = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('audit.index', compact('transactions', 'inventory', 'users'));
    }
} 