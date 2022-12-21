<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'merchant_code'=> $this->merchant_code,
            'customer_number'=> $this->customer_number,
            'amount'=> $this->amount,
            'currency'=> $this->currency,
            'action'=> $this->action,
            'method'=> $this->method,
            'transaction_id'=> $this->transaction_id,
            'ref_emala'=> $this->ref_emala,
            'status'=> $this->status,
            'callback_url'=> $this->callback_url,
        ];
    }
}
