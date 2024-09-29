<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $walletId = $request->wallet_id;

        // Fetch transactions based on wallet ID
        $transactions = Transaction::where('wallet_id', $walletId)->get();

        // Return the dashboard view with transactions
        return view('dashboard.transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Return the view for creating a new transaction
        return view('dashboard.transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'type' => 'required|in:deposit,withdraw,transfer,payment',
            'amount' => 'required|integer|min:1',
            'date' => 'required|date',
            'status' => 'required|in:pending,completed,failed',
            'recipient_wallet_id' => 'nullable|exists:wallets,id|required_if:type,transfer',
        ]);

        DB::beginTransaction();
        try {
            $wallet = Wallet::findOrFail($request->wallet_id);

            $transaction = new Transaction();
            $transaction->id = (string) \Illuminate\Support\Str::uuid();
            $transaction->wallet_id = $request->wallet_id;
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->date = $request->date;
            $transaction->description = $request->description;
            $transaction->recipient_wallet_id = $request->recipient_wallet_id;
            $transaction->status = $request->status;
            $transaction->save();

            if ($transaction->status === 'completed') {
                $this->handleTransactionType($wallet, $transaction);
            }

            $wallet->save();
            DB::commit();

            // Redirect to the index page with success message
            return redirect()->route('transactions.index')->with('success', 'Transaction successful');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Transaction failed: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Return the view for showing a specific transaction
        return view('dashboard.transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Return the view for editing a specific transaction
        return view('dashboard.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'in:pending,completed,failed',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::findOrFail($id);

        DB::beginTransaction();
        try {
            $transaction->status = $request->status ?? $transaction->status;
            $transaction->description = $request->description ?? $transaction->description;
            $transaction->date = $request->date ?? $transaction->date;

            if ($transaction->status === 'completed' && $transaction->getOriginal('status') !== 'completed') {
                $wallet = Wallet::findOrFail($transaction->wallet_id);
                $this->handleTransactionType($wallet, $transaction);
                $wallet->save();
            }

            $transaction->save();
            DB::commit();

            // Redirect to the index page with success message
            return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Transaction update failed: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($transaction->status === 'completed') {
                $wallet = Wallet::findOrFail($transaction->wallet_id);
                $this->reverseTransaction($wallet, $transaction);
                $wallet->save();
            }

            $transaction->delete();
            DB::commit();

            // Redirect to the index page with success message
            return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Transaction deletion failed: ' . $e->getMessage()]);
        }
    }

    private function handleTransactionType(Wallet $wallet, Transaction $transaction)
    {
        if ($transaction->type == 'deposit') {
            $wallet->balance += $transaction->amount;
        } elseif (in_array($transaction->type, ['withdraw', 'payment'])) {
            if ($wallet->balance < $transaction->amount) {
                throw new \Exception('Insufficient balance');
            }
            $wallet->balance -= $transaction->amount;
        } elseif ($transaction->type == 'transfer' && $transaction->recipient_wallet_id) {
            $recipientWallet = Wallet::findOrFail($transaction->recipient_wallet_id);
            if ($wallet->balance < $transaction->amount) {
                throw new \Exception('Insufficient balance');
            }
            $wallet->balance -= $transaction->amount;
            $recipientWallet->balance += $transaction->amount;
            $recipientWallet->save();
        }
    }

    private function reverseTransaction(Wallet $wallet, Transaction $transaction)
    {
        if ($transaction->type == 'deposit') {
            $wallet->balance -= $transaction->amount;
        } elseif (in_array($transaction->type, ['withdraw', 'payment'])) {
            $wallet->balance += $transaction->amount;
        } elseif ($transaction->type == 'transfer' && $transaction->recipient_wallet_id) {
            $recipientWallet = Wallet::findOrFail($transaction->recipient_wallet_id);
            $recipientWallet->balance -= $transaction->amount;
            $recipientWallet->save();
            $wallet->balance += $transaction->amount;
        }
    }
}
