<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Session;
use Image;
class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get();
        //$categories=json_decode($categories=json_encode($categories));
        //echo "<pre>"; print_r($categories);die;
        return view('admin.categories.categories')->with(compact('categories'));
    }
    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status =0;
  
            }else{
                $status=1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }  
      }
    public function addEditCategory(Request $request,$id=null){
        
        
        if($id==""){
            $title="Add Category";
            $category=new Category;
            $categorydata=array();
            $getCategories=array();
            $message="Category added successfully";
        }else{
            $title="Edit Category";
            $categorydata=Category::where('id',$id)->first();
            $categorydata=json_decode(json_encode($categorydata),true);
            $getCategories=Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getCategories=json_decode(json_encode($getCategories),true);
            $category=Category::find($id);
            $message="Category updated successfully";
            //echo "<pre>";print_r($categorydata);die;
        }
        if($request->isMethod('post')){
           
            $data=$request->all();
            

            //Category Validation
            $rules=[

                'category_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'section_id'=>'required',
                'url'=>'required',
                'category_image'=>'image',
            ];
            $customMessages=[
                'category_name.required'=>'Category Name is required',
                'category_name.regex'=>'Valid Category Name is required',
                'section_id.required'=>'Section is required',
                'url.required'=>'Category URL is required',
                'category_image.image'=>'Valid Category Image is required',
            ];
            $this->validate($request,$rules,$customMessages);


            //Upload Category Image
            if($request->hasFile('category_image')){
                $image_tmp=$request->file('category_image');
                if($image_tmp->isValid()){
                    $extension=$image_tmp->getClientOriginalExtension();
                    $imageName=rand(111,9999).'.'.$extension;
                    $imagePath='images/category_images/'.$imageName;
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image=$imageName;
                }
            }
            if(empty($data['category_discount'])){
                $data['category_discount']=0;
            }
            if(empty($data['description'])){
                $data['description']="";
            }
            if(empty($data['meta_title'])){
                $data['meta_title']="";
            }
            if(empty($data['meta_description'])){
                $data['meta_description']="";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }
            $category->parent_id=$data['parent_id'];
            $category->section_id=$data['section_id'];
            $category->category_name=$data['category_name'];
            $category->category_discount=$data['category_discount'];
            $category->description=$data['description'];
            $category->url=$data['url'];
            $category->meta_title=$data['meta_title'];
            $category->meta_description=$data['meta_description'];
            $category->meta_keywords=$data['meta_keywords'];
            $category->status=1;
            $category->save();
            session::flash('success_message',$message);
            return redirect('admin/categories');
        }
        //get all section
        $getSection=Section::get();
        return view('admin.categories.add_edit_category')->with(compact('title','getSection','categorydata','getCategories'));
 
    }
    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data=$request->all();
            //echo "<pre>";print_r($data);die;
            $getCategories=Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,'status'=>1])->get();
            $getCategories=json_decode(json_encode($getCategories),true);
            //echo "<pre>";print_r($getCategories);die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }
    public function deleteCategoryImage($id){
        $categoryImage=Category::select('category_image')->where('id',$id)->first();
        $category_image_path='images/category_images/';
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }
        Category::where('id',$id)->update(['category_image'=>'']);
        $message='Category image has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function deleteCategory($id){
        Category::where('id',$id)->delete();
        $message='Category has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
        


    }
}
