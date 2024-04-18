<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'ward_name', 'description'
    ];

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }
}
