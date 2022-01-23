<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.admin_dashboard');
    }

    public function login(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;

            $validated = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);


            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){

                return redirect('admin/dashboard');

            }else{
                Session::flash('error_message','Invalid Gamil or Password');
                return redirect()->back();
            }

        }

        return view('admin.admin_login');
    }


    public function settings(){
        // echo '<pre>';print_r( Auth::guard('admin')->user());die;
        // $adminDetail = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        $adminDetail = Auth::guard('admin')->user();
        return view('admin.admin_settings', compact('adminDetail'));
    }

    public function CurrentPwd(Request $request){
        $data = $request->all();
        // echo "<pre>";print_r($data);die;
        // echo '<pre>';print_r( Auth::guard('admin')->user()->password);die;

        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            echo 'true';
        }else{
            echo 'false';
        }

    }

    public function UpdateCurrentPwd(Request $request){

        if($request->isMethod('POST')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            // check if Current password is correct;
            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                // check if new and confirm password is match;
                if($data['new_pwd']==$data['confirm_pwd']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message','Password has been updated successfully!');
                }else{
                    Session::flash('error_message','New Password and Confirm Password not match');
                    return redirect()->back();
                }
                
            }else{
                Session::flash('error_message','Your Current Password is incorrect');
                
            }
            return redirect()->back();
        }

    }


    public function logout(){

        Auth::guard('admin')->logout();
        return redirect('/admin');

    }

}
