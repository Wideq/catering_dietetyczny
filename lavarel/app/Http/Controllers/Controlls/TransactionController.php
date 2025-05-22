<?php

namespace App\Http\Controllers\Controlls;

use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(TransactionRequest $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->update($request->validated());

        return redirect()->route('transactions.index')->with('success', 'Transakcja została zaktualizowana.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transakcja została usunięta.');
    }
}