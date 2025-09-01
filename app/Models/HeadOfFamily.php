<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOfFamily extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'identify_number',
        'gender',
        'birth_date',
        'phone_number',
        'occupation',
        'marital_status',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'head_of_family_id', 'id');
    }

    public function socialAssistanceRecipients(): HasMany
    {
        return $this->hasMany(SocialAssistanceRecipient::class, 'head_of_family_id', 'id');
    }

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class, 'head_of_family_id', 'id');
    }
}
