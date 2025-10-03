<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Development extends Model
{
    use UUID, SoftDeletes, HasFactory;

    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'person_in_charge',
        'start_date',
        'end_date',
        'amount',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('person_in_charge', 'like', '%' . $search . '%')
            ->orWhere('start_date', 'like', '%' . $search . '%')
            ->orWhere('end_date', 'like', '%' . $search . '%')
            ->orWhere('amount', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%');
    }

    public function developmentApplicants(): HasMany
    {
        return $this->hasMany(DevelopmentApplicant::class, 'development_id', 'id');
    }
}
