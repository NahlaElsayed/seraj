<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers';
    protected $fillable = ['fname','email','lname',
    'phone','age','exprience','password','year_graduate','about','country_id','skill_id','user_id'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

  public function skill()
  {
    return $this->hasOne(Skill::class);
  }
   
  public function country()
  {
      return $this->hasOne(Country::class);
  }
  
  
}