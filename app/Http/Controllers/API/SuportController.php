<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Suport;

class SuportController extends BaseController{
 
    public function index(){

             // Fetch all clients from the database
             $suports = Suport::with('user')->get();
             // Pass the clients data to the index view
             if ($suports) {
                 return $this->sendResponse($suports, ' show all supports successfully.');
             } else {
                 return $this->sendError(' show all supports not successfully.');
             }
    }


    public function store(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'detail' => 'required',
        ]);
          
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::find($id);

        if(!$user){
            return $this->sendError( 'user Not Found..');
        }
     
            $suport= new Suport();
            $suport->subject = $request->input('subject');
            $suport->detail = $request->input('detail');
            $suport->user_id = $user->id;
            $suport->save();
            return $this->sendResponse($suport, 'support creatred successfully.');
       
        }
     

    }


    