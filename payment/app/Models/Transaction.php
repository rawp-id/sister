<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Transaction",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="Transaction ID",
 *         example="12345"
 *     ),
 *     @OA\Property(
 *         property="wallet_id",
 *         type="integer",
 *         description="ID of the wallet associated with the transaction",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type of transaction",
 *         example="deposit"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="integer",
 *         description="Amount of money involved in the transaction",
 *         example=100
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date of the transaction",
 *         example="2024-09-01"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Current status of the transaction",
 *         example="completed"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the transaction",
 *         example="Payment for service"
 *     ),
 *     @OA\Property(
 *         property="recipient_wallet_id",
 *         type="integer",
 *         description="ID of the recipient wallet (for transfers)",
 *         example=2
 *     )
 * )
 */

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $keyType = 'uuid'; // Set the key type for UUIDs

    public $incrementing = false; // Disable auto-increment for the primary key

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the recipient wallet for the transaction.
     */
    public function recipientWallet()
    {
        return $this->belongsTo(Wallet::class, 'recipient_wallet_id');
    }
}
