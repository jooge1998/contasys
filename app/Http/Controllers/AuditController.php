<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request): View
    {
        $audits = Audit::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('audit.index', compact('audits'));
    }
} 