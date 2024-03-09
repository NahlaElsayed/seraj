<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends BaseController{

    public function index(){
        $skills = Skill::all();
        // Pass the clients data to the index view
        if ($skills) {
            return $this->sendResponse($skills, ' show all skill successfully.');
        } else {
            return $this->sendError(' skill not found successfully.');
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

      
        $skill = new Skill();
        $skill->name=$request->name;
        $skill->save();

        if ($skill) {
            return $this->sendResponse($skill, 'skill creatred successfully.');
        } else {
            return $this->sendError('skill  not creatred successfully.');
        }
    }
}