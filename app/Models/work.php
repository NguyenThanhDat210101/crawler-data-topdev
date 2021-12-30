<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    protected $guarded = [];

    public function Company(){
        return $this->hasMany(work::class);
    }
}
