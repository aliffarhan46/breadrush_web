<?php

namespace App\Http\Controllers;

use App\Models\PaymentTracking;
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

        // Create the tracking record
        $order = new PaymentTracking([
            'nama_pelanggan' => Auth::user()->nama,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_bayar' => $request->total_bayar,
            'status_tracking' => 'Pesanan diterima',
            'items' => $request->items,
        ]);
        
        $order->save();
        
        // Align id_transaksi with auto-increment ID to match legacy queries (SELECT * WHERE id_transaksi = '$id')
        $order->id_transaksi = (string)$order->id;
        $order->save();

        return response()->json([
            'success' => true,
            'id' => $order->id,
            'id_transaksi' => $order->id_transaksi
        ]);
    }

    public function showTracking($id = null)
    {
        // If no ID is passed, fetch the latest order for this user
        if (!$id) {
            $tracking = PaymentTracking::where('nama_pelanggan', Auth::user()->nama)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$tracking) {
                return redirect()->route('menu')->with('alert_success', 'Silakan belanja terlebih dahulu untuk melihat pelacakan.');
            }
            return redirect()->route('tracking', ['id' => $tracking->id]);
        }

        // Fetch order by id or id_transaksi to support both integer IDs and transaction codes
        $tracking = PaymentTracking::where('id', $id)
            ->orWhere('id_transaksi', $id)
            ->first();

        if (!$tracking) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        return view('tracking', compact('tracking'));
    }
}
