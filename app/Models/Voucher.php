<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
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
        'insurance_id',
        'insurance_name',
        'name',
        'code',
        'type',
        'value',
        'max_discount',
        'start_date',
        'end_date',
        'created_by',
    ];
}
