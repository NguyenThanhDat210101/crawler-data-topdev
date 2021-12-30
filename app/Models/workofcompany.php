<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workofcompany extends Model
{
    protected $guarded = [];

    public function Jobs(){
        return $this->hasOne(job::class,'job_id','id');
    }
}
