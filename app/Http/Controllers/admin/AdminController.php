<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;


class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
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
        Session::put('page','update-admin-password');
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


    public function UpdateAdminDetails(Request $request){
        Session::put('page','update-admin-details');

        // $adminDetail = Auth::guard('admin')->user();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            $rules = [
                'admin_name' => 'required | regex:/^[\pL\s-]+$/',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image',
            ];
            $customMessage = [
                'admin_name.required' => 'Name is required',
                'admin_name.alpha' => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid mobile number is required',
                'admin_image.image' => 'Vlid Image is required',
            ];

            $this->validate($request,$rules,$customMessage);
            
            //Upload image

            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    
                    //Generate New Image Name
                    $imageName = rand(111,99999). '.' . $extension; 
                    // echo "<pre>";print_r($imageName);die;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    // echo "<pre>";print_r($imagePath);die;
                    //Upload the Image
                     Image::make($image_tmp)->save($imagePath);
                     $data['admin_image'] = $imageName;
                    // echo "<pre>";print_r($saveImage);die;
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else{
                    $imageName = "";
                }
            }

            // Update Admin Details

            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$data['admin_image']]);
            Session::flash('success_message','Admin Details updated successfully!');
            return redirect()->back();

        }

        return view('admin.update_admin_details');

    }


    public function logout(){

        Auth::guard('admin')->logout();
        return redirect('/admin');

    }

}
