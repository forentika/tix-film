<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class PaymentController extends Controller
{
    public function __construct()
    {
        // CARA BARU (Versi 7+): Menggunakan Configuration
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    }

    public function createInvoice(Request $request)
    {
        $transaction = Transaction::where('booking_code', $request->booking_code)
            ->where('status', 'pending')
            ->firstOrFail();

        // Siapkan API Instance
        $apiInstance = new InvoiceApi();
        
        // Siapkan Request Object (Sesuai format SDK baru)
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $transaction->booking_code,
            'amount' => (float)$transaction->total_price, // Pastikan float/number
            'description' => 'Tiket Bioskop ' . $transaction->booking_code,
            'invoice_duration' => 900,
            'currency' => 'IDR',
            'payer_email' => Auth::user()->email,
            'success_redirect_url' => route('payment.finish', ['booking_code' => $transaction->booking_code]),
        ]);

        try {
            // Panggil API Xendit untuk buat Invoice
            $result = $apiInstance->createInvoice($create_invoice_request);

            // Ambil Invoice URL dan redirect user
            return redirect($result->getInvoiceUrl());

        } catch (\Exception $e) {
            // Tampilkan error jika gagal (berguna untuk debugging)
            return back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    public function finishCb(Request $request)
    {
        $bookingCode = $request->query('booking_code');

        $transaction = Transaction::where('booking_code', $bookingCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Update status jadi success (Khusus Testing Lokal)
        if ($transaction->status == 'pending') {
            $transaction->update(['status' => 'success']);
        }

        return redirect()->route('user.home')->with('success', 'Pembayaran Berhasil! Tiket Anda telah terbit.');
    }
}