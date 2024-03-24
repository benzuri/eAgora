<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type_id',
        'state_id',
        'is_featured',
        'ended_at'
    ];

    /**
     * Get the brand record associated with the Type.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the brand record associated with the State.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * The procedure has a hasMany relationship with booking model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
