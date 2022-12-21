<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
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
            'account_code'  => $this->account_code,
            'account_number' => $this->account_number,
            'merchant_code'  => $this->merchant_code,
            'status'=> "Success",
        ];
    }
}
