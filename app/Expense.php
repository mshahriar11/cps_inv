<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $dates = [
        'date'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
