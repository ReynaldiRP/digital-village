<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistanceRecipient extends Model
{
    use UUID, SoftDeletes;

    protected $fillable = [
        'social_assistance_id',
        'head_of_family_id',
        'amount',
        'reason',
        'bank',
        'account_number',
        'proof',
        'status',
    ];

    public function scopeSearch($query, $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('reason', 'like', "%{$search}%")
                ->orWhere('bank', 'like', "%{$search}%")
                ->orWhere('account_number', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
        })->orWhereHas('headOfFamily', function ($query) use ($search) {
            $query->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        })->orWhereHas('socialAssistance', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('provider', 'like', "%{$search}%");
        });
    }

    public function socialAssistance(): BelongsTo
    {
        return $this->belongsTo(SocialAssistance::class, 'social_assistance_id');
    }

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class, 'head_of_family_id');
    }
}
