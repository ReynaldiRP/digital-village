<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeadOfFamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'identify_number' => $this->identify_number,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'phone_number' => $this->phone_number,
            'occupation' => $this->occupation,
            'marital_status' => $this->marital_status
        ];
    }
}
