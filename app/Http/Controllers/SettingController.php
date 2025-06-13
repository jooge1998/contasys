<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'company_name' => Cache::get('company_name', ''),
            'currency' => Cache::get('currency', 'USD'),
            'low_stock_threshold' => Cache::get('low_stock_threshold', 10),
            'date_format' => Cache::get('date_format', 'Y-m-d'),
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'low_stock_threshold' => 'required|integer|min:1',
            'date_format' => 'required|string|in:Y-m-d,d/m/Y,m/d/Y',
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever($key, $value);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Configuración actualizada exitosamente.');
    }
} 