<?php
namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patner extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number', 'pin', 'token'
    ];

    protected $keyType = 'uuid'; // Set the key type for UUIDs

    public $incrementing = false; // Disable auto-increment for the primary key

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}

