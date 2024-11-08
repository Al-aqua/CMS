<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
