<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Admin;
use Hash;
use Session;
use Image;
use App\User;
class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        return view('admin.admin_dashboard');
    }
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $adminCount=Admin::where(['name'=>$data['username'],'password'=>md5($data['password']),'status'=>1])->count();
            /*$validateData=$request->validate(
                ['email'=>'required|email|max:255', 'password'=>'required']

            );*/

            if($adminCount>0){
                Session::put('adminSession',$data['username']);
                return redirect('/admin/dashboard');
            }else{
                return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
            }

            /*if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                return redirect('admin/dashboard');
            }else{
                $request->session()->flash('error_message', 'Invalid Email or Password');
                return redirect()->back();
            }*/
        }
        return view('admin.admin_login');
    }
    public function logout(){
        Session::flush();//Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function settings(){
        //Auth::guard('admin')->user()->id;
        Session::put('page','settings');
        $title="Update Password";
        $adminDetails=Admin::where(['name'=>Session::get('adminSession')])->first();
        return view('admin.admin_settings')->with(compact('adminDetails','title'));
    }
    public function chkCurrentPassword(Request $request){
        $data=$request->all();
        //$check_password=Admin::where(['name'=>Session::get('adminSession')])->first();
        $Count=Admin::where(['name'=>Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();
        if($Count==1){
            echo "true";
        }
        else
        {
            echo "false";
        }
    }
    public function updateCurrentPassword(Request $request)
    {
        if($request->isMethod('post')){
            $data=$request->all();
            $Count=Admin::where(['name'=>Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();
            if($Count==1){
                if($data['new_pwd']==$data['confirm_pwd']){
                    Admin::where('name',Session::get('adminSession'))->update(['password'=>md5($data['new_pwd'])]);
                    Session::flash('success_message','Password has been updated successfully!');

                }else{
                    Session::flash('error_message','New Password does not match with Confirm Password');

                }
            }else{
                Session::flash('error_message','Your current password is incorrect');

            }
            return redirect()->back();
            //echo "<pre>";print_r($data);die;

        }

    }
    public function updateAdminDetails(Request $request){
        Session::put('page','update-admin-details');
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            $rules =[
                'admin_name' =>'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'=>'required|numeric',
                'admin_image' =>'image',
            ];
            $customMessage =[
                'admin_name.required' =>'Name is required',
                'admin_name.alpha'=>'Valid Name is required',
                'admin_mobile.required' =>'Mobile is required',
                'admin_mobile.numeric'=>'Mobile Number should be numeric',
                'admin_image.image' =>'Valid Image is required',
            ];
            $this->validate($request,$rules,$customMessage);

            //upload image
            if($request->hasFile('admin_image')){
                $image_tmp=$request->file('admin_image');
                if($image_tmp->isValid()){
                    $extension=$image_tmp->getClientOriginalExtension();

                    $imageName=rand(111,99999).'.'.$extension;
                    $imagePath='images/admin_images/admin_photos/'.$imageName;
                   // echo "<pre>";print_r($imagePath);die;
                    Image::make($image_tmp)->resize(300,400)->save($imagePath);
                }
                else if(!empty($data['current_admin_image'])){
                    $imageName=$data['current_admin_image'];

                }else{
                    $imageName="";
                }
            }

            //Update admin Details
            Admin::where('email',Auth::guard('admin')->user()->email)->update([
                'name' =>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName
            ]);
            session::flash('success_message','Admin details updated successfully!');
            return redirect()->back();


        }
        $title="Update Admin Details";
        $adminDetails=Admin::where(['name'=>Session::get('adminSession')])->first();
        return view('admin.update_admin_details')->with(compact('adminDetails','title'));
    }
    public function viewUsers(){
        Session::put('page','view-user');
        $users=User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }





}
