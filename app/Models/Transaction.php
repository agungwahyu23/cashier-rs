<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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
        'user_id',
        'invoice_number',
        'insurance_id',
        'insurance_name',
        'voucher_id',
        'subtotal',
        'total_discount',
        'grand_total',
        'status',
        'paid_at',
        'created_by',
        'updated_by',
    ];

    public function details() 
    {
        return $this->hasMany(DetailTransaction::class);    
    }
}
