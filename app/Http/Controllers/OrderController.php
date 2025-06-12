<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('orderItems.product')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    public function previewInvoice(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('user', 'orderItems.product');

        $data = [
            'order' => $order,
            'items' => $order->orderItems,
            'user' => $order->user,
            'total_price' => $order->total_price,
            'date' => now()->format('d F Y H:i'),
        ];

        return view('orders.invoice', $data);
    }

    public function previewPDF(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('user', 'orderItems.product');
        $data = [
            'order' => $order,
            'items' => $order->orderItems,
            'user' => $order->user,
            'total_price' => $order->total_price,
            'date' => now()->format('d F Y H:i'),
        ];

        $html = view('orders.invoice', $data)->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'DejaVuSans',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'I'), 200)
            ->header('Content-Type', 'application/pdf');
    }
}