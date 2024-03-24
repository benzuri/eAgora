<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'procedure_id',
        'card'
    ];

    /**
     * Get the brand record associated with the Procedure.
     */
    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
