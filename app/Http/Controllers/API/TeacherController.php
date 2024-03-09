<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Exame;
use App\Models\Leacture;
use App\Models\Pdf;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Suport;
use App\Models\Video;

class TeacherController extends BaseController{

    public function index(){

        // Fetch all clients from the database
        $teachers = Teacher::all();
        // Pass the clients data to the index view
        if ($teachers) {
            return $this->sendResponse($teachers, ' show all teachers successfully.');
        } else {
            return $this->sendError(' show all teachers not successfully.');
        }
    }

    public function adminCheckTeacher(Request $request,$id){
    $approve = Teacher::find($id);
        $approve->status = $request->status;
        if($request->status == "approved") {
            $approve->save();
            return $this->sendResponse($approve, 'Admin  Approved phone Teacher Successfully.');
            } else {
            return $this->sendError('Admin Pendding teacher phone.');
        }

    }


    public function updateTeacher(Request $request){
        $validator = Validator::make($request->all(), [
            'fname' => 'nullable',
            'lname' => 'nullable',
            'email' => 'nullable|email',
            'age' => 'nullable|numeric',
            'exprience' => 'nullable|numeric',
            'year_graduate' => 'nullable|numeric|max:2024' ,
            'about' => 'nullable',
            'password' => 'nullable',
            'phone' => 'nullable|numeric|digits:10',
            'image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            
        ]);

          
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');
        }
        $user_id = auth()->id();
        $teacher= Teacher::where('user_id',$user_id)->first();

 
        if ($teacher) {
        $teacher->fname = $request->fname;
        $teacher->email = $request->email;
        $teacher->image = $path;
        $teacher->lname = $request->lname;
        $teacher->age = $request->age;
        $teacher->save();
            return $this->sendResponse($teacher, 'teacher Update Profile successfully.');
        } else {
            return $this->sendError('teacher  not found.');
        }

    }

    public function destroy($id){
        
        $teacher = Teacher::find($id);
        $user = User::find($teacher->user_id);
        $pdf= Pdf::where('teacher_id',$teacher->id)->delete();
        $video= Video::where('teacher_id',$teacher->id)->delete();
        $exame= Exame::where('teacher_id',$teacher->id)->delete();
        $suport =Suport::where('user_id',$user->id)->delete();
        $leacture= Leacture::where('teacher_id',$teacher->id)->delete();
        // $user->delete();
        $teacher->delete();
        $user->delete();
        if ($teacher) {
            return $this->sendResponse($teacher, 'teacher Log Out successfully.');
        } else {
            return $this->sendError('teacher  not found.');
        }
    }


}