<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    use HasFactory;
    protected $table = 'exames';
    protected $fillable = ['question','ans1','ans2','ans3','ans4','correct','time','leacture_id','teacher_id'];

    
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class , 'teacher_id');
    
    }
    
    public function leacture()
    {
        return $this->belongsTo(Leacture::class , 'leacture_id');
    }
    
}