<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentApplicant extends Model
{
    use UUID, SoftDeletes, HasFactory;

    protected $fillable = [
        'development_id',
        'user_id',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        })->orWhereHas('development', function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('person_in_charge', 'like', "%$search%")
                ->orWhere('start_date', 'like', "%$search%")
                ->orWhere('end_date', 'like', "%$search%")
                ->orWhere('amount', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%");
        });
    }

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class, 'development_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
