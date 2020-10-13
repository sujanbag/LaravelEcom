<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use App\Mail\registrationemail;
use Mail;
use Illuminate\Support\Str;
//require_once '/path/to/vendor/autoload.php';
class UsersController extends Controller
{
    public function userLoginRegister(){
        return view('users.login_register');
    }
    public function register(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            $usersCount=User::where('email',$data['email'])->count();
            if($usersCount>0){
                return redirect()->back()->with('flash_message_error','Email already exists');
            }else{
                $user=new User;
                $user->name=$data['name'];
                $user->email=$data['email'];
                $user->password=bcrypt($data['password']);
                $user->save();

                //Send Register Email
                //echo$email=$data['email'];
                $messageData=['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($data['email'])];
                
               //\Mail::to($data['email'])->send(new \App\Mail\registrationemail($messageData));
               \Mail::to($data['email'])->send(new \App\Mail\Confirmemail($messageData));
               return redirect()->back()->with('flash_message_success','Please confirm your email to activate your account!');
                //echo"okay";die;
                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    //echo"okay";die;
                    Session::put('frontSession',$data['email']); 
                    if(!empty(Session::get('session_id'))){
                        $session_id=Session::get('session_id');
                        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$data['email']]);
                    }
                    return redirect('/cart' );
                }else{
                    //echo "else";die;
                    return redirect()->back();
                }
            }
        }
    }
    public function confirmAccount($email){
        $email=base64_decode($email);
        //echo $email;die;
        $userCount=User::where('email',$email)->count();
        //echo $userCount;die;
        if($userCount>0){
            $userDetails=User::where('email',$email)->first();
            if($userDetails->status==1){
                return redirect('login-register')->with('flash_message_success','Your Email account is already activated.You can login now.');
            }else{
                User::where('email',$email)->update(['status'=>1]);
                $messageData=['email'=>$email,'name'=>$userDetails->name];
                
                \Mail::to($email)->send(new \App\Mail\Welcome($messageData));
                return redirect('login-register')->with('flash_message_success','Your Email account is activated.You can login now.');
            }
        }else{
            abort(404);
        }
    }
    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        return redirect('/');
    }
    public function checkEmail(Request $request){
        $data=$request->all();
        $usersCount=User::where('email',$data['email'])->count();
        if($usersCount>0){
            echo "false";
        }else{
            echo "true";die;
        }
    }
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status' =>'1'])){
                $userStatus=User::where('email',$data['email'])->first();
                if($userStatus->status==0){
                    return redirect()->back()->with('flash_message_error','Your account is not activated. Please confirm your email to activate your account!');
                }
                Session::put('frontSession',$data['email']);
                if(!empty(Session::get('session_id'))){
                    $session_id=Session::get('session_id');
                    DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$data['email']]);
                }
                
                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error','Invalid email or password');
            }
        }
    }

    public function forgotPassword(Request $request){
        if($request->isMethod('post'))
        {
            $data=$request->all();
            $userCount=User::where('email',$data['email'])->count();
            if($userCount==0){
                return redirect()->back()->with('flash_message_error','Email does not exist!');
            }
            $userDetails=User::where('email',$data['email'])->first();
            $random_password= Str::random(8);
            $new_password=bcrypt($random_password);
            User::where('email',$data['email'])->update(['password'=>$new_password]);
            $email=$data['email'];
            $name=$userDetails->name;
            $messageData=['email'=>$email,'name'=>$name,'password'=>$random_password];
            \Mail::to($email)->send(new \App\Mail\ForgotPassword($messageData));

            return redirect('login-register')->with('flash_message_success','Please check your email for new password');

        }
        return view('users.forgot_password');
    } 

    public function account(Request $request){
        $user_id=Auth::user()->id;
        $userDetails=User::find($user_id);

        if($request->isMethod('post')){

            $data=$request->all();
            if(empty($data['name'])){
                return redirect()->back()->with('flash_message_error','Please enter Your Name to update your account details!');
            }
            if(empty($data['address'])){
                $data['address']='';
            }
            if(empty($data['city'])){
                $data['city']='';
            }
            if(empty($data['state'])){
                $data['state']='';
            }
            if(empty($data['pincode'])){
                $data['pincode']='';
            }
            if(empty($data['mobile'])){
                $data['mobile']='';
            }
            $user=User::find($user_id);
            $user->name=$data['name'];
            $user->address=$data['address'];
            $user->city=$data['city'];
            $user->state=$data['state'];
            $user->pincode=$data['pincode'];
            $user->mobile=$data['mobile'];
            $user->save();
            return redirect()->back()->with('flash_message_success','Your account details has been updated successfully!');
        }
        return view('users.account')->with(compact('userDetails'));
    }
    public function chkUserPassword(Request $request){
        $data = $request->all();
        $current_password =$data['current_pwd'];
        $user_id=Auth::User()->id;
        $check_password =User::where('id',$user_id)->first();
        if(Hash::check($current_password,$check_password->password)){
            echo "true";die;
        }else{
            echo "false";die;
        }
    }
    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $old_pwd=User::where('id',Auth::user()->id)->first();
            $current_pwd=$data['current_pwd'];
            if(Hash::check($current_pwd,$old_pwd->password)){
                $new_pwd=bcrypt($data['new_pwd']);
                User::where('id',Auth::user()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success','Password updated successfully');

            }else{
                return redirect()->back()->with('flash_message_error','Current Password is incorrect');
            }
        }
    }
}
