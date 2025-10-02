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
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'identify_number' => $this->identify_number,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'phone_number' => $this->phone_number,
            'occupation' => $this->occupation,
            'profile_picture' => $this->profile_picture ? asset('storage/' . $this->profile_picture) : null,
            'marital_status' => $this->marital_status,
            'created_at' => $this->created_at->format('d F Y H:i'),
            'family_members' => FamilyMemberResource::collection($this->whenLoaded('familyMembers')),
        ];
    }
}
