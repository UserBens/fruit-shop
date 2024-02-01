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
        $prod = Produk::find($id);
        $allproduk = Produk::orderBy('id', 'asc')->take(3)->get();

        return view('pengunjung.singleproduct', [
            'produk' => $prod,
            'allproduk' => $allproduk,
        ]);
    }

    public function createpayment(Request $request, $id, Transaction $transactionModel)
    {
        $produk = Produk::find($id);

        $transaction = $transactionModel::create([
            'produk_id' => $produk->id,
            'order_id' => uniqid(),
            'status' => 'pending',
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.serverkey');
        \Midtrans\Config::$clientKey = config('midtrans.clientkey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => $produk->harga_produk,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params); // tambahkan titik koma di sini
        $transaction->snap_token = $snapToken;
        $transaction->save();

        // Pengurangan stok produk
        $produk->stok_produk -= 1; // Ubah sesuai kebutuhan
        $produk->save();

        if ($request->input('result_type') == 'notification') {
            // Proses notifikasi Midtrans
            $notification = json_decode($request->input('notification'));

            // Validasi signature (sesuai dengan dokumentasi Midtrans)
            // ...

            // Periksa apakah status pembayaran adalah 'settlement'
            if ($notification->transaction_status == 'settlement') {
                // Ubah status menjadi 'success'
                $transaction->status = 'success';
                $transaction->save();

                // Disini Anda dapat melakukan hal-hal lain yang diperlukan setelah pembayaran sukses
            }
        }

        return view('payment.create', compact('snapToken'));
    }

}
