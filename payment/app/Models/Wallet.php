<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $keyType = 'uuid'; // Set the key type for UUIDs

    public $incrementing = false; // Disable auto-increment for the primary key

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the wallet.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

