<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'continent',
        'population'
    ];

    /**
     * Get all of the idioms for the Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function idioms()
    {
        return $this->hasMany(Idiom::class, 'countryCode', 'code');
    }
}
