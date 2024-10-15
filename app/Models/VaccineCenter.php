<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    /** @use HasFactory<\Database\Factories\VaccineCenterFactory> */
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class,'vaccine_center');
    }
}
