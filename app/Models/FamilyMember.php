<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use UUID, SoftDeletes;

    protected $fillable = [
        'head_of_family_id',
        'user_id',
        'profile_picture',
        'identify_number',
        'gender',
        'birth_date',
        'phone_number',
        'occupation',
        'marital_status',
        'relation',
    ];


    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class, 'head_of_family_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
