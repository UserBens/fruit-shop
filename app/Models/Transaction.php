<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    
    protected $table = 'transaction';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
