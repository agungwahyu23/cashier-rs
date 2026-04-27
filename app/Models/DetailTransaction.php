<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasUuids;

    protected $primaryKey = "id";
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_id',
        'procedure_id',
        'procedure_name',
        'price_id',
        'price',
        'price_start_date',
        'price_end_date',
        'qty',
        'discount_per_item',
        'subtotal',
    ];

    public function transaction() 
    {
        return $this->belongsTo(Transaction::class);    
    }
}
