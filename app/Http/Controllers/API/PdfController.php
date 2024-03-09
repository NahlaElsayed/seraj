<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Pdf;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Mail;
use App\Models\Student;

class PdfController extends BaseController{
 
    public function index(){

             // Fetch all clients from the database
             $pdfs = Pdf::with('teacher')->get();
             // Pass the clients data to the index view
             if ($pdfs) {
                 return $this->sendResponse($pdfs, ' show all pdfs successfully.');
             } else {
                 return $this->sendError(' show all pdfs not successfully.');
             }
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'link' => 'required',
        ]);
          
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user_id = auth()->id();
        $teacher = Teacher::where('user_id',$user_id)->first();

        if(!$teacher){
            return $this->sendError( 'teacher Not Found..');
        }
     
            $pdf= new Pdf();
            $pdf->link = $request->input('link');
            $pdf->teacher_id = $teacher->id;
            $pdf->save();
            return $this->sendResponse($pdf, 'pdf creatred successfully.');
       
        }
     

    }


    