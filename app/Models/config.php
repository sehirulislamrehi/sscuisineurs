<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class config extends Model
{
    use HasFactory;
    public function run(){
        config::factory()
                        ->times(1)
                        ->hasPost(1)
                        ->create();
    }
    
}
