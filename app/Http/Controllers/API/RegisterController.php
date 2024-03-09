<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Mail;
use App\Models\Student;

class RegisterController extends BaseController{

    public function registerTeacher(Request $request){
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
            'exprience' => 'required|numeric',
            'year_graduate' => 'required|numeric|max:2024' ,
            'about' => 'required',
            'password' => 'required',
            'phone' => 'required|numeric|digits:10',
            'country_id' => 'required',
            'skill_id' => 'required',
        ]);

          
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            $teacher = new Teacher();
            $teacher->fname = $request->input('fname');
            $teacher->lname = $request->input('lname');
            $teacher->email = $request->input('email');
            $teacher->age = $request->input('age');
            $teacher->exprience = $request->input('exprience');
            $teacher->password = $request->input('password');
            $teacher->about = $request->input('about');
            $teacher->country_id = $request->input('country_id');
            $teacher->skill_id = $request->input('skill_id');
            $teacher->year_graduate = $request->input('year_graduate');
            $teacher->phone = $request->input('phone');
            $teacher->save();
    
            // Create a new user associated with the teacher
            $user = new User();
            $user->name = $teacher->fname;
            $user->username = "teach_" . $teacher->id;
            $user->email = $teacher->email;
            $user->phone = $teacher->phone;
            $user->password = Hash::make('password');
            $user->save();
            $teacher->user_id = $user->id;
            $teacher->save();
            $user->generateOtpCode();
       
        $otp = rand(1000, 9999); // Generate 4-digit OTP
        $user->code = $otp;
        $user->expire_at = now()->addMinutes(5); // OTP expires in 5 minutes
        $user->save();


            $details = [
                'title' => 'Mail from Seraj.com',
                'body' => 'Welcome To Seraj! You will receive an email with details when your Seraj is approved.',
                'code' => 'otp is: ' . $otp
            ];
        // Mail::to($user->email)->send(new OTPMail( $details));
           
            return response()->json(['teacher'=>$teacher,'user'=>$user,'emailOTP'=>$details]);
          
      
        }
            
        
            
         catch (\Exception $e) {
            // Handle other exceptions
            return $this->sendError('Error.', $e->getMessage());
        }
        

    }
    public function registerStudent(Request $request){
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
            'password' => 'required',
            'phone' => 'required|numeric|digits:10',
            'country_id' => 'required',
           
        ]);
          
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            $student = new Student();
            $student->fname = $request->input('fname');
            $student->lname = $request->input('lname');
            $student->email = $request->input('email');
            $student->age = $request->input('age');
            $student->password = $request->input('password');
            $student->country_id = $request->input('country_id');
            $student->phone = $request->input('phone');
            $student->save();
    
            // Create a new user associated with the teacher
            $user = new User();
            $user->name = $student->fname;
            $user->username = "stud_" . $student->id;
            $user->email = $student->email;
            $user->phone = $student->phone;
            $user->password = Hash::make('password');
            $user->save();
               $student->user_id = $user->id;
               $student->save();
        $user->generateOtpCode();
       
        $otp = rand(1000, 9999); // Generate 4-digit OTP
        $user->code = $otp;
        $user->expire_at = now()->addMinutes(5); // OTP expires in 5 minutes
        $user->save();


            $details = [
                'title' => 'Mail from Seraj.com',
                'body' => 'Welcome To Seraj! You will receive an email with details when your Seraj is approved.',
                'code' => 'otp seraj is: ' . $otp
            ];
        // Mail::to($user->email)->send(new OTPMail( $details));
           
            return response()->json(['student'=>$student,'user'=>$user,'emailOTP'=>$details]);
          
      
        } 
         catch (\Exception $e) {
            // Handle other exceptions
            return $this->sendError('Error.', $e->getMessage());
        }
        

    }


    public function teacherEmail(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        if($user){
            $user->generateOtpCode();
            $details = [
                'code' => 'Seraj OTP Code is: ' . $user->code
            ];
     
            // Mail::to($user->email)->send(new OTPMail( $details));


            return $this->sendResponse($user, 'OTP sent successfully.');
        }else{
            $teacher = Teacher::where('email', $request->email)->first();
            if ($teacher) {
                return $this->sendResponse('User Error', 'email is registered and wait to activate.');
            }
            return $this->sendError('Validation Error.', "User Not found");
        }
    }

    public function studentEmail(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        if($user){
            $user->generateOtpCode();
            $details = [
                'code' => 'Seraj OTP Code is: ' . $user->code
            ];

            // Mail::to($user->email)->send(new OTPMail( $details));
            return $this->sendResponse($user, 'OTP sent successfully.');
        }else{
            $teacher = Student::where('email', $request->email)->first();
            if ($teacher) {
                return $this->sendResponse('User Error', 'email is registered and wait to activate.');
            }
            return $this->sendError('Validation Error.', "User Not found");
        }
    }
    
    public function teacherVerifyOTP(Request $request )
    {
        $validator =Validator::make($request->all(), [
            'email' => 'nullable|email',
            'otp' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = User::where('email', $request->email)->first();

        $enteredOTP = (int) $request->input('otp');
        $correctOTP = (int) $user->code; // correct OTP value
        if ($enteredOTP === $correctOTP) {
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            return $this->sendResponse($success, 'User verfiy successfully.');
        } else {
            return $this->sendError( 'Invalid OTP.');
        }
    }

    public function studentVerifyOTP(Request $request )
    {
        $validator =Validator::make($request->all(), [
            'email' => 'nullable|email',
            'otp' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = User::where('email', $request->email)->first();

        $enteredOTP = (int) $request->input('otp');
        $correctOTP = (int) $user->code; // correct OTP value
        if ($enteredOTP === $correctOTP) {
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            return $this->sendResponse($success, 'User verfiy successfully.');
        } else {
            return $this->sendError( 'Invalid OTP.');
        }
    }

    public function loginTeacher(Request $request )
    {
        $validator =Validator::make($request->all(), [
            'email' => 'nullable|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
 
        $teacher = Teacher::where([
            ['email',$request->email],
            ['password', $request->password],
            ])->get();;

        if($teacher){
            return $this->sendResponse($teacher, 'teacher verfiy successfully.');
        } else {
            return $this->sendError( 'teacher not verfiy successfully..');
        }
    }

    public function loginStudent(Request $request )
    {
        $validator =Validator::make($request->all(), [
            'email' => 'nullable|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
 
        $student = Student::where([
            ['email',$request->email],
            ['password', $request->password],
            ])->get();;

        if($student){
            return $this->sendResponse($student, 'student verfiy successfully.');
        } else {
            return $this->sendError( 'student not verfiy successfully..');
        }
    }


    public function changePasswordStudent(Request $request ){
        $validator =Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required',
            'confrim_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // $user= $request->user();
        $user_id = auth()->id();
        $student = Student::where('user_id',$user_id)->first();
        // $user = Auth::user();
        // if(Hash::check($request->current_password , $user->password)){
            $currentPassword = $request->current_password;
            $hashedPassword = $student->password;
        
            if ($currentPassword == $hashedPassword) {
            $student->update([
                'password' => $request->password
            ]);
            return $this->sendResponse($student, ' change password successfully.');
        }
        else{
            return $this->sendError( 'old password does not match ..');
        }

    }

    public function changePasswordTeacher(Request $request)
    {
        $validator =Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required',
            'confrim_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user_id = auth()->id();
        $teacher = Teacher::where('user_id',$user_id)->first();
            $currentPassword = $request->current_password;
            $hashedPassword = $teacher->password;
        
            if ($currentPassword == $hashedPassword) {
            $teacher->update([
                'password' => $request->password
            ]);
            return $this->sendResponse($teacher, ' change password successfully.');
        }
        else{
            return $this->sendError( 'old password does not match ..');
        }
    }

    
}


