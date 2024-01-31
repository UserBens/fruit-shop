<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $produk = Produk::when($keyword, function ($query, $keyword) {
            return $query->where('nama_produk', 'like', '%' . $keyword . '%')
                ->orWhere('deskripsi_produk', 'like', '%' . $keyword . '%');
        })->where('status', true)->orderBy('nama_produk', 'desc')->paginate(6);

        return view('pengunjung.shop', [
            'produk' => $produk,
        ]);
    }

    public function singleproduct($id)
    {
        // $produk = Produk::find($id);
        // return view('pengunjung.singleproduct', [
        //     'produk' => $produk,
        //     'allproduk' => Produk::orderBy('id', 'asc')->take(3)->get(),

        // ]);

        // $prod = Produk::find($id);
        // return view('pengunjung.singleproduct', [
        //     // 'postingan' => Postingan::orderBy('id', 'asc')->take(3)->get(),
        //     'produk' => Produk::orderBy('id', 'asc')->take(3)->get(),
        //     'prod' => $prod,
        // ]);

        $prod = Produk::find($id);
        $allproduk = Produk::orderBy('id', 'asc')->take(3)->get();

        return view('pengunjung.singleproduct', [
            'produk' => $prod,
            'allproduk' => $allproduk,
        ]);
    }

    public function createpayment(Request $request,  $id, Transaction $transactionModel)
    {
        $data = $request->all();

        $produk = Produk::find($id);

        $transaction = $transactionModel::create([
            'produk_id' => $produk->id,
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.serverkey');  
        \Midtrans\Config::$clientKey = config('midtrans.clientkey');  
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $produk->harga_produk,
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;

        $transaction->save();

        return view('payment.create', compact('snapToken'));
    }
}
