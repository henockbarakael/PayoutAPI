<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Institution extends JsonResource
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
            'institution_name'  => $this->institution_name,
            'institution_email' => $this->institution_email,
            'institution_phone' => $this->institution_phone,
            'institution_website' => $this->institution_website,
            'institution_code'  => $this->institution_code,
            'status'=> "Success",
        ];
    }
}
