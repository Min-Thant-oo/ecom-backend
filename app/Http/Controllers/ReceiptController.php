<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Events\DownloadPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{

    public function viewReceipt($transactionId, Request $request)
    {
        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $order = $request->user()->orders()
            ->where('transaction_id', $transactionId)
            ->with('user', 'products')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'There is no order with this order number'], 404);
        }

        return response()->json(['order' => $order]);
    }



    public function downloadReceipt($transactionId, Request $request)
    {
        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $order = $request->user()->orders()
            ->where('transaction_id', $transactionId)
            ->with('user', 'products')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'There is no order with this order number'], 404);
        }

        $receipt = ['receipt' => $order];
        $pdf = Pdf::loadView('admin.pdf.download_pdf', $receipt);
        $todayDate = Carbon::now()->format('d-m-Y');
        return $pdf->download('solarecom-receipt-' . $transactionId . '-' . $todayDate . '.pdf');

        return response()->json(['message' => 'PDF generation started successfully'], 200);
    }
}
