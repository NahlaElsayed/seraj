<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Exame;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Mail;
use App\Models\Student;

class ExameController extends BaseController{
 
    public function index(){
     
             // Fetch all clients from the database
             $exames = Exame::with('leacture','teacher')->get();
             // Pass the clients data to the index view
             if ($exames) {
                 return $this->sendResponse($exames, ' show all exames successfully.');
             } else {
                 return $this->sendError(' show all exames not successfully.');
             }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'ans1' => 'required',
            'ans2' => 'required',
            'ans3' => 'required',
            'ans4' => 'required',
            'correct' => 'required',
            'time' => 'required',
            'leacture_id' => 'required',
       
        ]);
          
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = auth()->id();
        $teacher = Teacher::where('user_id',$user_id)->first();
        if(!$teacher){
            return $this->sendError( 'teacher Not Found..');
        }
       
            $exame= new Exame();
            $exame->question = $request->input('question');
            $exame->ans1 = $request->input('ans1');
            $exame->ans2 = $request->input('ans2');
            $exame->ans3 = $request->input('ans3');
            $exame->ans4 = $request->input('ans4');
            $exame->correct = $request->input('correct');
            $exame->time = $request->input('time');
            $exame->leacture_id = $request->input('leacture_id');
            $exame->teacher_id = $teacher->id;
            $exame->save();
            return $this->sendResponse($exame, 'exame creatred successfully.');     
      
    }

    

    }