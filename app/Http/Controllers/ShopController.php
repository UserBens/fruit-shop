<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {

        $keyword = $request->input('search');

        $produk = Produk::when($keyword, function ($query, $keyword) {
            return $query->where('nama_produk', 'like', '%' . $keyword . '%')
                ->orWhere('deskripsi_produk', 'like', '%' . $keyword . '%');
        })->latest()->paginate(2)->withQueryString();

        return view('pengunjung.shop', [
            'produk' => $produk,
        ]);
    }

    public function singleproduct($id)
    {
        $produk = Produk::find($id);
        return view('pengunjung.singleproduct', [
            'produk' => $produk,
        ]);
    }
}
