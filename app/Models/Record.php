<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $table = 'records';
    protected $fillable = ['student_id' ,'leacture_id'];

  public function student()
    {
        return $this->belongsTo(Student::class , 'student_id');
    }
    
  public function leacture()
  {
      return $this->belongsTo(Leacture::class , 'leacture_id');
  }
}