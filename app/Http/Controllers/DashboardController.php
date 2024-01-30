<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_produk = Produk::all()->count();

        return view('admin.dashboard', [
            'total_produk' => $total_produk,
        ]);
    }
}
