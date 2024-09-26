<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'street_address',
        'representative_name',
    ];

    /**
     * Get the products associated with the company.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}