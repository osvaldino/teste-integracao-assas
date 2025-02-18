<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'asaas_id',
        'payment_method',
        'amount',
        'status',
        'boleto_url',
        'pix_qrcode',
        'pix_copy',
        'expirationDatePix',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_cpf',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expirationDatePix' => 'datetime',
    ];
}
