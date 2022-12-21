<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Institution_user extends JsonResource
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
            'username'  => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'salt' => $this->salt,
            'institution_code'  => $this->institution_code,
            'status'=> "Success",
        ];
    }
}
