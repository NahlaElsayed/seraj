<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Leacture;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Models\Student;

class RecordController extends BaseController{
 
    public function index(){

             // Fetch all records from the database
             $records = Record::with('leacture')->get();
             // Pass the records data to the index view
             if ($records) {
                 return $this->sendResponse($records, ' show all records successfully.');
             } else {
                 return $this->sendError(' show all records not successfully.');
             }
    }


    public function store(Request $request,$id){
      
        $leacture = Leacture::find($id);

        $user_id = auth()->id();
        $student = Student::where('user_id',$user_id)->first();

        if(!$student){
            return $this->sendError( 'student Not Found..');
        }

        $leacture->status = $request->status;

        if($request->status == "follow") {
            $record= new Record();
            $record->leacture_id = $leacture->id;
            $record->student_id = $student->id;
            $record->status = $leacture->status;
            $record->save();
            return $this->sendResponse($record, 'follow course successfully.');
       
        }
        else{
            return $this->sendError('student unfollow course');
        }
   
    }

    }
  