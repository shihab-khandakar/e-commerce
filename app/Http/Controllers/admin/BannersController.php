<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

class BannersController extends Controller
{
    
    public function banners(){

        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        // dd($banners);die;
        return view('admin.banners.banners',compact('banners'));

    }


    public function updateBannerStatus(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($data['status']== 'Active'){
                $status= 0;
            }else{
                $status = 1;
            }

            Banner::where('id', $data['banner_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);

        }

    }


    public function addEditBanner(Request $request, $id=null){

        if($id==""){
            $title = "Add Banner";
            $banner = new Banner;
            $message = "Banner added successfully";
        }else{
            $title = "Edit Banner";
            $banner = Banner::find($id);
            $message = "Banner updated successfully";
        }


        if($request->isMethod("POST")){
            $data = $request->all();
            // echo '<pre>';print_r($data);die;

            //Upload Image
            
            if($request->hasFile('image')){

                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    //get original image extentions
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Genarate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    //image path
                    $banner_image_path = 'images/banner_images/'.$imageName;
                    //image resize
                    Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);
                    $data['image'] = $imageName;
                    //Save main image in the banner table
                    $banner->image = $imageName;

                }

            }

            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->status = 1;
            $banner->save();

            Session::flash('success_message',$message);
            return redirect('admin/banners');
        }


        return view('admin.banners.add_edit_banner',compact('title','banner',));

    }


    public function deleteBanner($id){
        // Get Banner images
        $bannerImage = Banner::where('id', $id)->first();
        // banner image path
        $banner_image_path = 'images/banner_images/';
        // Delete images if exists in banners folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        //delete Banner from banner table
        Banner::where('id', $id)->delete();

        $message = 'Banner has been deleted';
        Session::flash('success_message',$message);
  
          return redirect()->back();

    }


}
