<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Merchant extends JsonResource
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
            'merchant_code'  => $this->merchant_code,
            'merchant_id' => $this->merchant_id,
            'merchant_secret' => $this->merchant_secret,
            'institution_code'  => $this->institution_code,
            'status'=> "Success",
        ];
    }
}
