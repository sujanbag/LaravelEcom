<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Session;
class CouponsController extends Controller
{
    public function addCoupon(Request $request,$id=null){
        Session::put('page','coupons');
        if($id==""){
            $title="Add Coupon";
            $coupon=new Coupon;
            $message="Coupon added successfully!";
        }else{
            $title="Edit Coupon";
            $coupon=Coupon::find($id);
            $message="Brand edited successfully!";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            $coupon=new Coupon;
            $coupon->coupon_code=$data['coupon_code'];
            $coupon->amount=$data['amount'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->status=$data['status'];
            $coupon->save();
            session::flash('success_message',$message);
            return redirect('admin/coupons');
        }
        return view('admin.coupons.add_coupon')->with('title', $title,'coupon',$coupon);
    }
    public function updateCouponStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status =0;

            }else{
                $status=1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
    }
    public function deleteCoupon($id){
        Coupon::where('id',$id)->delete();
        $message='Coupon has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function coupons(){
        Session::put('page','coupons');
        $coupons=Coupon::get();
        return view('admin.coupons.coupons')->with('coupons', $coupons);
    }
}
