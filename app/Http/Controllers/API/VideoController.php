<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Video;
class VideoController extends BaseController{
 
    public function index(){

             // Fetch all clients from the database
             $videos = Video::with('teacher')->get();
             // Pass the clients data to the index view
             if ($videos) {
                 return $this->sendResponse($videos, ' show all videos successfully.');
             } else {
                 return $this->sendError(' show all videos not successfully.');
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
     
            $video= new Video();
            $video->link = $request->input('link');
            $video->teacher_id = $teacher->id;
            $video->save();
            return $this->sendResponse($video, 'teacher creatred successfully.');
       
        }
     
        public function getTeacherVideo(){
          
    
            $user_id = auth()->id();
            $teacher = Teacher::where('user_id',$user_id)->first();
    
            if(!$teacher){
                return $this->sendError( 'teacher Not Found..');
            }
            $video = Video::where('teacher_id',$teacher->id)->get();
            if($video)
            {
                return $this->sendResponse($video, 'get videos teacher successfully.');
            }
            else{
                return $this->sendError( 'video Not Found..');
            }
            }
    }


    