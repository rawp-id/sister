<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/transactions",
     *     tags={"Transactions"},
     *     summary="Get List of Transactions",
     *     description="Retrieve a list of transactions for a specific wallet.",
     *     operationId="getTransactions",
     *     @OA\Parameter(
     *         name="wallet_id",
     *         in="query",
     *         required=true,
     *         description="ID of the wallet to get transactions for."
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="List of transactions retrieved successfully",
     *         @OA\JsonContent(
     *             type="default"
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid wallet ID provided"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Wallet not found"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $walletId = $request->wallet_id;

        $transactions = Transaction::where('wallet_id', $walletId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Transaction retrieved successfully',
            'data' => $transactions
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/transactions",
     *     tags={"Transactions"},
     *     summary="Create a new transaction",
     *     description="Store a new transaction in the system.",
     *     operationId="createTransaction",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Transaction data to be created",
     *         @OA\JsonContent(
     *             required={"wallet_id", "type", "amount", "date", "status"},
     *             @OA\Property(property="wallet_id", type="integer", description="ID of the wallet", example=1),
     *             @OA\Property(property="type", type="string", description="Type of transaction", example="deposit"),
     *             @OA\Property(property="amount", type="integer", description="Amount of the transaction", example=100),
     *             @OA\Property(property="date", type="string", format="date", description="Date of the transaction", example="2024-09-01"),
     *             @OA\Property(property="description", type="string", description="Description of the transaction", example="Payment for service"),
     *             @OA\Property(property="recipient_wallet_id", type="integer", description="ID of the recipient wallet (for transfers)", example=2),
     *             @OA\Property(property="status", type="string", description="Status of the transaction", example="completed"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transaction created successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Transaction"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'type' => 'required|in:deposit,withdraw,transfer,payment',
            'amount' => 'required|integer',
            'date' => 'required|date',
            'status' => 'required|in:pending,completed,failed'
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
                if ($transaction->type == 'deposit') {
                    $wallet->balance += $transaction->amount;
                } elseif ($transaction->type == 'withdraw' || $transaction->type == 'payment') {
                    if ($wallet->balance < $transaction->amount) {
                        return response()->json(['error' => 'Insufficient balance'], 400);
                    }
                    $wallet->balance -= $transaction->amount;
                }
                // Handle transfer logic
                if ($transaction->type == 'transfer' && $transaction->recipient_wallet_id) {
                    $recipientWallet = Wallet::find($transaction->recipient_wallet_id);
                    $recipientWallet->balance += $transaction->amount;
                    $recipientWallet->save();
                }
            }

            $wallet->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction successful',
                'transaction' => $transaction->id
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Transaction failed', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     tags={"Transactions"},
     *     summary="Get transaction details",
     *     description="Retrieve the details of a specific transaction by ID.",
     *     operationId="getTransaction",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction to retrieve",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction details retrieved successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Transaction"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    /**
     * @OA\Put(
     *     path="/api/transactions/{id}",
     *     tags={"Transactions"},
     *     summary="Update an existing transaction",
     *     description="Update the details of an existing transaction.",
     *     operationId="updateTransaction",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction to be updated",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated transaction data",
     *         @OA\JsonContent(
     *             required={"status", "date"},
     *             @OA\Property(property="status", type="string", description="Status of the transaction", example="completed"),
     *             @OA\Property(property="description", type="string", description="Description of the transaction", example="Updated payment details"),
     *             @OA\Property(property="date", type="string", format="date", description="Updated date of the transaction", example="2024-09-02"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Transaction"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'in:pending,completed,failed',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::findOrFail($id);

        // Begin Transaction Update
        DB::beginTransaction();
        try {
            $transaction->status = $request->status ?? $transaction->status;
            $transaction->description = $request->description ?? $transaction->description;
            $transaction->date = $request->date ?? $transaction->date;

            // Update the balance only if the status is changed to completed
            if ($transaction->status === 'completed' && $transaction->getOriginal('status') !== 'completed') {
                $wallet = Wallet::findOrFail($transaction->wallet_id);
                if ($transaction->type == 'deposit') {
                    $wallet->balance += $transaction->amount;
                } elseif ($transaction->type == 'withdraw' || $transaction->type == 'payment') {
                    if ($wallet->balance < $transaction->amount) {
                        return response()->json(['error' => 'Insufficient balance'], 400);
                    }
                    $wallet->balance -= $transaction->amount;
                } elseif ($transaction->type == 'transfer' && $transaction->recipient_wallet_id) {
                    $recipientWallet = Wallet::find($transaction->recipient_wallet_id);
                    $recipientWallet->balance += $transaction->amount;
                    $recipientWallet->save();
                }
                $wallet->save();
            }

            $transaction->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction updated successfully', 
                'transaction' => $transaction->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Transaction update failed', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/transactions/{id}",
     *     tags={"Transactions"},
     *     summary="Delete a transaction",
     *     description="Delete an existing transaction from the system.",
     *     operationId="deleteTransaction",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction to be deleted",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Begin Transaction Deletion
        DB::beginTransaction();
        try {
            if ($transaction->status === 'completed') {
                $wallet = Wallet::findOrFail($transaction->wallet_id);
                if ($transaction->type == 'deposit') {
                    $wallet->balance -= $transaction->amount;
                } elseif ($transaction->type == 'withdraw' || $transaction->type == 'payment') {
                    $wallet->balance += $transaction->amount;
                } elseif ($transaction->type == 'transfer' && $transaction->recipient_wallet_id) {
                    $recipientWallet = Wallet::find($transaction->recipient_wallet_id);
                    $recipientWallet->balance -= $transaction->amount;
                    $recipientWallet->save();
                }
                $wallet->save();
            }

            $transaction->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,-
                'error' => 'Transaction deletion failed', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
