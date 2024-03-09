<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Models\Suport;

class StudentController extends BaseController{

    public function index(){

        // Fetch all clients from the database
        // $students = Student::all();

        $students = Student::orderByDesc('age')
        ->orderByDesc('country_id')
        ->get();
        // Pass the clients data to the index view
        if ($students) {
            return $this->sendResponse($students, ' show all students successfully.');
        } else {
            return $this->sendError(' show all students not successfully.');
        }
}

    // public function adminCheckTeacher(Request $request,$id){
    // $approve = Teacher::find($id);
    //     $approve->status = $request->status;
    //     if($request->status == "approved") {
    //         $approve->save();
    //         return $this->sendResponse($approve, 'Admin  Approved phone Teacher Successfully.');
    //         } else {
    //         return $this->sendError('Admin Pendding doctor  not found.');
    //     }
    // }

    public function updateStudent(Request $request){
        $validator = Validator::make($request->all(), [
            'fname' => 'nullable',
            'lname' => 'nullable',
            'email' => 'nullable|email',
            'age' => 'nullable|numeric',
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
        $student= Student::where('user_id',$user_id)->first();

 
        if ($student) {
        $student->fname = $request->fname;
        $student->email = $request->email;
        $student->image = $path;
        $student->lname = $request->lname;
        $student->age = $request->age;
        $student->save();
            return $this->sendResponse($student, 'student Update Profile successfully.');
        } else {
            return $this->sendError('student  not found.');
        }

    }

    public function destroy($id){
        
        $student = Student::find($id);
        $user = User::find($student->user_id);
        $suport = Suport::where('user_id',$user->id)->delete();
        $record = Record::where('user_id',$user->id)->delete();
        // $user->delete();
        $student->delete();
        $user->delete();
        
        if ($student) {
            return $this->sendResponse($student, 'student Log Out successfully.');
        } else {
            return $this->sendError('student  not found.');
        }
    }
}