<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
        protected $guarded = [];

        public function job(){
            return $this->hasMany(job::class);
        }
        public function Work(){
            return $this->belongsTo(work::class,'work_id','id');
        }
}
