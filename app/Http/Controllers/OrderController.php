<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'total_bayar' => 'required|integer',
            'items' => 'required|array',
        ]);

        // 1. Create Order
        $order = Order::create([
            'id_pengguna' => Auth::user()->id,
            'total_harga' => $request->total_bayar,
            'status_pesanan' => 'Pesanan diterima',
            'tanggal_pesanan' => now(),
        ]);

        // 2. Create Order Details
        foreach ($request->items as $item) {
            OrderDetail::create([
                'id_pesanan' => $order->id,
                'id_produk' => $item['id'],
                'jumlah' => $item['qty'],
                'harga' => $item['harga'],
            ]);
        }
        
        // 3. Create Payment
        Payment::create([
            'id_pesanan' => $order->id,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_pembayaran' => $request->total_bayar,
            'status_pembayaran' => 'Lunas', // or Pending depending on logic, let's say Lunas for simplicity
        ]);

        return response()->json([
            'success' => true,
            'id' => $order->id,
            'id_transaksi' => $order->id
        ]);
    }

    public function showTracking($id = null)
    {
        // If no ID is passed, fetch the latest order for this user
        if (!$id) {
            $tracking = Order::with(['orderDetails.product', 'payment', 'user'])
                ->where('id_pengguna', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$tracking) {
                return redirect()->route('menu')->with('alert_success', 'Silakan belanja terlebih dahulu untuk melihat pelacakan.');
            }
            return redirect()->route('tracking', ['id' => $tracking->id]);
        }

        // Fetch order by id
        $tracking = Order::with(['orderDetails.product', 'payment', 'user'])
            ->where('id', $id)
            ->first();

        if (!$tracking) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        return view('tracking', compact('tracking'));
    }
}
