<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Parcel",
 *     type="object",
 *     @OA\Property(property="id", type="string", example="uuid"),
 *     @OA\Property(property="name_product", type="string", example="Laptop"),
 *     @OA\Property(property="name_recipient", type="string", example="John Doe"),
 *     @OA\Property(property="address_shipper", type="string", example="123 Ship Lane"),
 *     @OA\Property(property="name_shipper", type="string", example="Jane Smith"),
 *     @OA\Property(property="address_recipient", type="string", example="456 Recieve Rd"),
 *     @OA\Property(property="status", type="string", enum={"pending", "delivered", "cancelled"}, example="pending"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Parcel extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $keyType = 'uuid';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
