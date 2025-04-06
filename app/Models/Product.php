<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'price',
        'unit',
        'image',
    ];

    public function category() {
        return $this->belongsTo( Category::class );
    }
    public function user() {
        return $this->belongsTo( User::class );
    }

    public function invoiceProduct() {
        return $this->hasMany( InvoiceProduct::class );
    }

}
