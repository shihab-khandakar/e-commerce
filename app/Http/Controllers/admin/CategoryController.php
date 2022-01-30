<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $Categories = Category::with(['section','parentCategory'])->get();
        // $Categories = json_decode(json_encode($Categories));
        // echo '<pre>'; print_r($Categories);die;
        return view('admin.category.category',compact('Categories'));
    }


    public function updateCategoryStatus(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($data['status']== 'Active'){
                $status= 0;
            }else{
                $status = 1;
            }

            Category::where('id', $data['category_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);

        }

    }


    public function addEditCategory(Request $request, $id=null){

        if($id==""){
            // Add Category Function
            $title = "Add Category";
            $category = new Category;
            $categorydata = array();
            $getCategory = array();
            $message ="Category Added Successfully!";
        }else{
            // Edit Category Function
            $title = "Edit Category";

            $categorydata = Category::where('id',$id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);
            $getCategory = Category::with('subcategories')->where(['parent_id'=>0, 'section_id'=>$categorydata['section_id']])->get();
            $getCategory = json_decode(json_encode($getCategory),true);
            // echo "<pre>";print_r($getCategories);die;

            $category = Category::find($id);
            $message ="Category Updated Successfully!";


        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            // Category Validation
            $rules = [
                'category_name' => 'required | regex:/^[\pL\s-]+$/',
                'section_id' => 'required',
                'url' => 'required',
                'category_image' => 'image',
            ];
            $customMessage = [
                'category_name.required' => 'Category Name is required',
                'category_name.regex' => 'Valid name is required',
                'section_id.required' => 'Section is required',
                'url.required' => 'Category Url is required',
                'category_image.image' => 'Vlid Image is required',
            ];

            $this->validate($request,$rules,$customMessage);

            //Upload Category image
            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    
                    //Generate New Image Name
                    $imageName = rand(111,99999). '.' . $extension; 
                    // echo "<pre>";print_r($imageName);die;
                    $imagePath = 'images/category_images/'.$imageName;
                    // echo "<pre>";print_r($imagePath);die;
                    //Upload the Image
                     Image::make($image_tmp)->save($imagePath);
                     $data['category_image'] = $imageName;
                    // echo "<pre>";print_r($saveImage);die;
                    $category->category_image = $imageName;
                }
            }

            if(empty($data['category_discount'])){
                $data['category_discount'] =0;
            }
            if(empty($data['description'])){
                $data['description'] ="";
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] ="";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] ="";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] ="";
            }


            $category->	parent_id = $data['parent_id'];
            $category->	section_id = $data['section_id'];
            $category->	category_name = $data['category_name'];
            $category->	category_discount = $data['category_discount'];
            $category->	description = $data['description'];
            $category->	url = $data['url'];
            $category->	meta_title = $data['meta_title'];
            $category->	meta_description = $data['meta_description'];
            $category->	meta_keywords = $data['meta_keywords'];
            $category->status =1;
            $category->save();
            Session::flash('success_message',$message);
            return redirect('admin/categories');
        }

        //Get All Section
        $getSection = Section::get();

        return view('admin.category.add_edit_category',compact('title','getSection','categorydata','getCategory'));

    }

    public function appendCategoryLavel(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";print_r($data);die;

            $getCategory = Category::with('subcategories')->where(['section_id'=>$data['section_id'], "parent_id"=>0, 'status'=>1])->get();
            $getCategory = json_decode(json_encode($getCategory), true);
            // echo "<pre>";print_r($getCategory);die;
            return view('admin.category.append_category_level',compact('getCategory'));

        }


    }


    public function deleteCategoryImage($id) {
        //get category image
        $categoryImage = Category::select('category_image')->where('id',$id)->first();
        //get category image path
        $category_image_path = 'images/category_images/';

        //delete category image from category_images folders

        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        //delete category image from category table

        Category::where('id',$id)->update(['category_image'=>""]);

        $message = 'Category image has been deleted';
        Session::flash('success_message',$message);

        return redirect()->back();

    }

    public function deleteCategory($id){
        Category::where('id',$id)->delete();
        $message = 'Category has been deleted successfully';
        Session::flash('success_message',$message);

        return redirect()->back();
    }



}
