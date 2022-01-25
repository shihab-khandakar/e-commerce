<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function section(){
        Session::put('page','sections');
        $sections = Section::all();
        return view('admin.section.section',compact('sections'));
    }


    public function updateSectionStatus(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($data['status']== 'Active'){
                $status= 0;
            }else{
                $status = 1;
            }

            Section::where('id', $data['section_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);

        }

    }

}
