<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    
    public function brands(){
        Session::put('page','brands');
        $brands = Brand::get();
        return view('admin.brands.brands',compact('brands'));
    }


    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($data['status']== 'Active'){
                $status= 0;
            }else{
                $status = 1;
            }

            Brand::where('id', $data['brand_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);

        }

    }


    public function addEditBrand(Request $request, $id=null){

        if($id==""){
            $title = "Add Brand";
            $brand = new Brand;
            $message = 'Brand added Successfully!';
        }else{
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = 'Brand Updated Successfully!';
        }


        if($request->isMethod('post')){
            $data = $request->all();
            // echo '<pre>';print_r($data);die;
            // Brand Validation
            $rules = [
                'name' => 'required | regex:/^[\pL\s-]+$/',
            ];
            $customMessage = [
                'name.required' => 'Brand Name is required',
                'name.regex' => 'Valid name is required',
            ];

            $this->validate($request,$rules,$customMessage);

            //save brand name in database table
            $brand->name = $data['name'];
            $brand->status = 1;
            $brand->save();

            Session::flash('success_message',$message);
            return redirect('admin/brands');

        }

        return view('admin.brands.add_edit_brand',compact('title','brand'));

    }

    public function deleteBrand($id){
        Brand::where('id',$id)->delete();
        $message = 'Brand has been deleted successfully';
        Session::flash('success_message',$message);

        return redirect()->back();
    }


}
