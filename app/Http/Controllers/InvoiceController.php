<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        // Authorization: Ensure user is admin OR the order belongs to the user
        if (auth()->user()->role !== 'admin' && auth()->id() !== $order->user_id) {
            abort(403);
        }

        $order->load(['user', 'orderItems.package', 'orderItems.addon', 'partnership']);

        $pdf = Pdf::loadView('pdf.invoice', compact('order'));

        return $pdf->download('invoice-tahukrax-' . $order->id . '.pdf');
    }
}
