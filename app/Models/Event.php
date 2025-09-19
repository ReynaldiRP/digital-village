<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use UUID, SoftDeletes, HasFactory;

    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'price',
        'date',
        'time',
        'is_active',
    ];


    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%')
            ->orWhere('date', 'like', '%' . $search . '%')
            ->orWhere('time', 'like', '%' . $search . '%')
            ->orWhere('is_active', 'like', '%' . $search . '%');
    }


    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class, 'event_id');
    }
}
