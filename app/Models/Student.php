<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['fname','email','lname','phone','age','password','country_id','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class);
    }


}