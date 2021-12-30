<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    protected $guarded = [];

    public function Company(){
        return $this->belongsTo(company::class,'company_id','id');
    }

    public function WOC(){
        return $this->belongsTo(workofcompany::class);
    }
}
