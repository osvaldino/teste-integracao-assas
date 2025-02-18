<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'asaas_id'       => $this->asaas_id,
            'status'         => $this->status,
            'payment_method' => $this->payment_method,
            'amount'         => $this->amount,
            'boleto_url'     => $this->boleto_url,
            'pix_qrcode'     => $this->pix_qrcode,
            'pix_copy'       => $this->pix_copy,
            'message'        => $this->message,
        ];
    }
}
