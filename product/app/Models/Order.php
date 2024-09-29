<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_id', // Include custom_id
        'purchaser', 
        'address',   
        'product_id',
        'quantity',
        'total_price',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Hook into the model's creating event to generate the custom_id
        static::creating(function ($order) {
            $order->custom_id = self::generateCustomId();
        });
    }

    // Method to generate the custom ID in the format ord-xx-xxxx
    public static function generateCustomId()
    {
        // Generate a random string for 'xx' part and random numbers for 'xxxx' part
        $randomString = strtoupper(substr(md5(uniqid()), 0, 2)); // Generate two random letters
        $randomNumber = rand(1000, 9999); // Generate four random numbers
        
        return 'ord-' . $randomString . '-' . $randomNumber;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
