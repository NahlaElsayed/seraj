<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Country;
use App\Models\Skill;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Validator;

class CountryController extends BaseController{

    public function index(){
        $countrys = Country::all();
        // Pass the clients data to the index view
        if ($countrys) {
            return $this->sendResponse($countrys, ' show all country successfully.');
        } else {
            return $this->sendError(' country not found successfully.');
        }
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required', 
        ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
        }

      
        $country = new Country();
        $country->name=$request->name;
        $country->save();

        if ($country) {
            return $this->sendResponse($country, 'country creatred successfully.');
        } else {
            return $this->sendError('country  not successfully.');
        }
    }
}