<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leacture extends Model
{
    use HasFactory;
    protected $table = 'leactures';
    protected $fillable = ['name','day','hour','teacher_id'];

    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class , 'teacher_id');
    }
public function record(){
    return $this->belongsTo(Record::class);
}
}