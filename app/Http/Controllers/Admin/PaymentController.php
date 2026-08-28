<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::with(['user', 'course']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $payments = $query->latest()->paginate(20);

        $summary = [
            'total' => Payment::count(),
            'success' => Payment::where('status', 'success')->count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'revenue' => Payment::where('status', 'success')->sum('amount'),
        ];

        return view('admin.payments', compact('payments', 'summary'));
    }
}