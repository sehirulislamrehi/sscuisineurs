<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    use HasFactory;

    public function bookingTransation(){
        return $this->hasOne(BookingTransaction::class);
    }

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function bogo(){
        return $this->hasMany(Bogo::class);
    }
}
