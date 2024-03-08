<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Leacture;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LeactureController extends BaseController{
 
    public function index(){

             // Fetch all clients from the database
             $leactures = Leacture::with('teacher')->get();
             // Pass the clients data to the index view
             if ($leactures) {
                 return $this->sendResponse($leactures, ' show all leactures successfully.');
             } else {
                 return $this->sendError(' show all leactures not successfully.');
             }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'day' => 'required|date',
            'hour' => 'required',
       
        ]);
          
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = auth()->id();
        $teacher = Teacher::where('user_id',$user_id)->first();
        if(!$teacher){
            return $this->sendError( 'teacher Not Found..');
        }
        if($teacher->status =='approved')
        {
            $leacture= new Leacture();
            $leacture->name = $request->input('name');
            $leacture->day = $request->input('day');
            $leacture->hour = $request->input('hour');
            $leacture->teacher_id = $teacher->id;
            $leacture->save();
            return $this->sendResponse($leacture, 'country creatred successfully.');
       
        }
        else{
            return $this->sendError( 'Phone number is not activated..');
        }
    }

    // public function update(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'nullable',
    //         'day' => 'nullable|date',
    //         'hour' => 'nullable',
       
    //     ]);
          
    //     if ($validator->fails()) {
    //         return $this->sendError('Validation Error.', $validator->errors());
    //     }
    //     $user_id = auth()->id();
    //     $teacher = Teacher::where('user_id',$user_id)->first();
    //     if(!$teacher){
    //         return $this->sendError( 'teacher Not Found..');
    //     }

    //     $leacture= Leacture::where('teacher_id',$teacher->id)->first();
    //    if($leacture){
       
    //         $leacture->name = $request->input('name');
    //         $leacture->day = $request->input('day');
    //         $leacture->hour = $request->input('hour');
    //         $leacture->teacher_id = $teacher->id;
    //         $leacture->save();
    //         return $this->sendResponse($leacture, 'country creatred successfully.');
       
    //     }
    //     else{
    //         return $this->sendError( 'Phone number is not activated..');
    //     }
    // }

    }