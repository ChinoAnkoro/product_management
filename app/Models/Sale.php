<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
    ];

    // 売上の新規作成
    public static function createSale($product_id, $quantity)
    {
        return self::create([
            'product_id' => $product_id,
            'quantity' => $quantity,
        ]);
    }

    /**
     * Get the product associated with the sale.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}