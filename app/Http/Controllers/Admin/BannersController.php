<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
use Image;
class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners=Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function addeditBanner($id=null,Request $request){
        if($id==""){
            $banner=new Banner;
            $title="Add Banner Image";
            $message="Banner Added Successfully";
        }else{
            $banner=Banner::find($id);
            $title="Edit Banner Image";
            $message="Banner Updated Successfully";
        }
        if($request->isMethod('post')){
            
            $data=$request->all();
            
            $banner->link=$data['link'];
            $banner->title=$data['title'];
            $banner->alt=$data['alt'];
            if($request->hasFile('image')){
                $image_tmp=$request->file('image');
                if($image_tmp->isValid()){
                    $image_name=$image_tmp->getClientOriginalName();
                    $extension=$image_tmp->getClientOriginalExtension();
                    $imageName=$image_name;//.'-'.rand(111,99999).'.'.$extension;
                    $banner_image_path='images/banner_images/'.$imageName; 
                    Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);
                    //echo "<pre>";print_r($image_name);die;
                    $banner->image=$imageName;
                }
                
            }
            $banner->status=0;

            $banner->save();
            session::flash('success_message',$message);
            return redirect('admin/banners');

        }
        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));

    }


    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status =0;
  
            }else{
                $status=1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }  
    }
    public function deleteBanner($id){
        $bannerImage=Banner::where('id',$id)->first();
        $banner_image_path='images/banner_images/';
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        Banner::where('id',$id)->delete();
        $message='Banner has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

}
