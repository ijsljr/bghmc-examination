<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'suffix_name', 'address', 'birthdate', 'status'
    ];

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }
}
