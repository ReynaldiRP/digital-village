<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use UUID, SoftDeletes, HasFactory;

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

    public function scopeSearch($query, $search): Builder
    {
        return $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '&' . $search . '%');
        })->orWhere('identify_number', 'like', '%' . $search . '%')
            ->orWhere('gender', 'like', '%' . $search . '%')
            ->orWhere('birth_date', 'like', '%' . $search . '%')
            ->orWhere('phone_number', 'like', '%' . $search . '%')
            ->orWhere('occupation', 'like', '%' . $search . '%')
            ->orWhere('marital_status', 'like', '%' . $search . '%')
            ->orWhere('relation', 'like', '%' . $search . '%');
    }

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class, 'head_of_family_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
