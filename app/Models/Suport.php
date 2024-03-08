<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suport extends Model
{
    use HasFactory;
    protected $table = 'supports';
    protected $fillable = ['subject','detail','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}