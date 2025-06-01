<?php

namespace App\Http\Controllers\Controlls;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Pobierz dane z bazy
        $userCount = User::count();
        $orderCount = Order::count();
        $transactionCount = Transaction::count();
        $failedTransactions = Transaction::where('status', 'failed')->count();

        // Przekaż dane do widoku
        return view('dashboard', compact('userCount', 'orderCount', 'transactionCount', 'failedTransactions'));
    }
}