<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    public function menu(){
        return $this->belongsToMany(menu::class);
    }
    public function day(){
        return $this->belongsToMany(Day::class);
    }

    public function reservation(){
        return $this->hasMany(reservation::class);
    }

    public function categoryimage(){
        return $this->hasMany(CategoryImage::class);
    }
}
