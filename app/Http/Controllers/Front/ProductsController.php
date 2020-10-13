<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductsImage;
use App\ProductsAttribute;
use App\Coupon;
use App\User;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;
use App\Banner;
use DB;
use Str;
use Session;
use Auth;
class ProductsController extends Controller
{
    public function listing($url,Request $request){

        if($request->ajax()){
            $data=$request->all();
            $url=$data['url'];
            $categoryCount=Category::where(['url'=>$url,'status'=>1])->count();

            if($categoryCount>0){
                $categoryDetails=Category::catDetails($url);
                //echo "<pre>"; print_r($categoryDetails);die;
                $categoryProducts=Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
                ->where('status',1);//simplePaginate(3);

                if(isset($data['sort'])&& !empty($data['sort'])){
                    if($data['sort']=="product_latest"){
                        $categoryProducts->orderBy('id','Desc');
                    }
                    if($data['sort']=="product_name_a_z"){
                        $categoryProducts->orderBy('product_name','Asc');
                    } 
                    if($data['sort']=="product_name_z_a"){
                        $categoryProducts->orderBy('product_name','Desc');
                    }
                    if($data['sort']=="price_lowest"){
                        $categoryProducts->orderBy('product_price','Asc');
                    }
                    if($data['sort']=="price_highest"){
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                }else{
                    $categoryProducts->orderBy('id','Desc'); 
                } 

                $categoryProducts=$categoryProducts->paginate(3);

                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
                //echo "<pre>"; print_r($categoryProducts);die;
            }else{ 
                abort(404);
            }

        }else{
            //echo $url;
            $categoryCount=Category::where(['url'=>$url,'status'=>1])->count();
              //echo $categoryCount;
            if($categoryCount>0){
                $categoryDetails=Category::catDetails($url);
                //echo "<pre>"; print_r($categoryDetails);die;
                $categoryProducts=Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
                ->where('status',1);//simplePaginate(3);

                

                $categoryProducts=$categoryProducts->paginate(3);
                $productFilters=Product::productFilters();
                $fabricArray=$productFilters['fabricArray'];
                $sleeveArray=$productFilters['sleeveArray'];
                $patternArray=$productFilters['patternArray'];
                $fitArray=$productFilters['fitArray'];
                $occasionArray=$productFilters['occasionArray'];
                $page_name="listing";
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','page_name'));
                //echo "<pre>"; print_r($categoryProducts);die;
            }else{ 
                abort(404);
            }
        }
    }
    public function products($url=null){
        $countCategory=Category::where(['url'=>$url,'status'=>1])->count();
        if($countCategory==0){
            abort(404);
        }
        $categoryDetails=Category::where(['url'=>$url])->first();
        //echo $categoryDetails->id;die;
        $categories=Category::with('categories')->where(['parent_id'=>0,'status'=>1])->get();
       
        if($categoryDetails->parent_id==0){
            //if url is main category url
            $subCategories=Category::where(['parent_id'=>$categoryDetails->id])->get();
            
            foreach($subCategories as $subcat){
                $cat_ids[]=$subcat->id;
            }
            $productsAll=Product::whereIn('category_id',$cat_ids)->where('status',1)->paginate(3);
        }else{
            //if url is sub category url
            $productsAll=Product::where(['category_id'=>$categoryDetails->id])->where('status',1)->paginate(3); 
        }
        $banners=Banner::where('status','1')->get();
        return view('products.listing')->with(compact('categories','productsAll', 'categoryDetails','banners'));
    }
    public function product($id=null){
        $productCount = Product::where(['id' => $id,'status' =>1])->count();
        if($productCount==0){
            abort(404);
        }
        $productDetails=Product::with('attributes')->where('id',$id)->first();
        $productDetails=json_decode(json_encode($productDetails));

        $relatedProducts=Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->get();
        //echo "<pre>";print_r($relatedProducts);die;
        /*$relatedProducts=json_decode(json_encode($relatedProducts));

        foreach ($relatedProducts->chunk(3) as $chunk) {
            foreach ($chunk as $item) {

            }
        }*/

        //echo "<pre>"; print_r($productDetails);die;
        $categories=Category::with('categories')->where(['parent_id'=>0,'status'=>1])->get();
        $productAltImages=ProductsImage::where('product_id',$id)->get();
        /*$productAltImages=json_decode(json_encode($productAltImages));
        echo "<pre>";print_r($productAltImages);die;*/
        $total_stock=ProductsAttribute::where('product_id',$id)->sum('stock');
        return view('products.detail')->with(compact('productDetails','categories','productAltImages','total_stock','relatedProducts'));
    }
    public function getProductPrice(Request $request){
        $data=$request->all();
        //echo "<pre>"; print_r($data);die;
        $proArr=explode('-',$data['idSize']);
        
        $proAttr=ProductsAttribute::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
        echo "<pre>";print_r($proAttr);die;
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }
    public function addtocart(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
        //echo "<pre>";print_r($data);die;
        /*if(empty($data['user_email'])){
            $data['user_email'] ='';
        }*/
        //Check Product Stock is available or not

        $product_size=explode("-",$data['size']);
        $getProductStock=ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$product_size[1]])->first();

        if($getProductStock->stock<$data['quantity']){
            return redirect()->back()->with('flash_message_error','Required Quantity is not available.');
        }

        if(empty(Auth::user()->email)){
            $data['user_email'] ='';
        }else{
            $data['user_email'] =Auth::user()->email;
        }
        $session_id=Session::get('session_id');
        if(empty($session_id)){
            $session_id = Str::random(40);
            Session::put('session_id', $session_id);        
        }
        

        
        if(empty($data['product_color'])){
            $data['product_color'] ='';
        }
        if(empty($data['size'])){
            $data['size'] ='';

        }else{
            $sizeArr=explode('-', $data['size']);
            $data['size'] = $sizeArr[1];
        }

        if(empty(Auth::check())){
            $countProducts=DB::table('cart')->where(['product_id'=>$data['product_id'],'product_color'=>$data['product_color'],'size'=>$data['size'],'session_id'=>$session_id])->count();

            if($countProducts>0){
                return redirect()->back()->with('flash_message_error','Product already in Cart!');
            }
        }else{
            $countProducts=DB::table('cart')->where(['product_id'=>$data['product_id'],'product_color'=>$data['product_color'],'size'=>$data['size'],'user_email'=>$data['user_email']])->count();

            if($countProducts>0){ 
                return redirect()->back()->with('flash_message_error','Product already in Cart!');
            }

        }
       
        $countProducts=DB::table('cart')->where(['product_id'=>$data['product_id'],'product_color'=>$data['product_color'],'size'=>$data['size'],'session_id'=>$session_id])->count();

        if($countProducts>0){
            return redirect()->back()->with('flash_message_error','Product already in Cart!');
        }else{
            $getSKU=ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'],'size'=>$sizeArr[1]])->first();
            DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'price'=>$data['price'],'size'=>$data['size'],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
        }
        return redirect('cart')->with('flash_message_success','Product has been added in Cart!');
    }
    public function cart(){
        
        
        if(Auth::check()){
            $user_email=Auth::user()->email;
            $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
            $session_id=Session::get('session_id');
            $userCart=DB::table('cart')->where(['session_id'=>$session_id])->get();
        }
        
        foreach($userCart as $key=>$product){
            $productDetails=Product::where('id',$product->product_id)->first();
            $userCart[$key]->image=$productDetails->main_image;
        }
        //echo "<pre>";print_r($userCart);die;
        return view('products.cart')->with(compact('userCart'));
    }
    public function deleteCartProduct($id=null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success','Product has been deleted from Cart!');
    }
    public function updateCartQuantity($id=null,$quantity=null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $getCartDetails=DB::table('cart')->where('id',$id)->first();
        $getAttributeStock=ProductsAttribute::where('sku',$getCartDetails->product_code)->first();
        $updated_quantity=$getCartDetails->quantity+$quantity;
        //echo "<pre>"; print_r($getCartDetails);die;
        //echo "<pre>"; print_r($updated_quantity);die;
       // echo "<pre>"; print_r($getAttributeStock);die;
        if($getAttributeStock->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
            return redirect('cart')->with('flash_message_success','Product quantity has been updated Successfully!');
        }else{
            return redirect('cart')->with('flash_message_error','Required Product quantity is not available!');

        }
       
    }
    public function applyCoupon(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        //echo "<pre>";print_r($data);die;
        $couponeCount=Coupon::where('coupon_code',$data['coupon_code'])->count();
        if($couponeCount==0){
            return redirect()->back()->with('flash_message_error','This Coupon does not exists!');
        }else{
            $couponDetails=Coupon::where('coupon_code',$data['coupon_code'])->first();
            if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error','This Coupon is not active!');
            }
            $expiry_date=$couponDetails->expiry_date;
            $current_date=date('Y-m-d');
            if($expiry_date<$current_date){
                return redirect()->back()->with('flash_message_error','This Coupon is expired!');
            }

            $session_id=Session::get('session_id');
                      
            if(Auth::check()){
                $user_email=Auth::user()->email;
                $userCart=DB::table('cart')->where(['session_id'=>$session_id])->get();
            }else{
                $session_id=Session::get('session_id');
                $userCart=DB::table('cart')->where(['session_id'=>$session_id])->get();
            }

            $total_amount=0;
            foreach($userCart as $item){
                $total_amount=$total_amount+($item->price * $item->quantity);
            }

            if($couponDetails->amount_type=="Fixed"){
                $couponAmount = $couponDetails->amount;

            }else{
                $couponAmount=$total_amount*($couponDetails->amount/100);
            }
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode',$data['coupon_code']);
            return redirect()->back()->with('flash_message_success','Coupon code successfully applied. You are availing discount!');
        }
    }
    public function checkout(Request $request){
        $user_id=Auth::user()->id;
        $user_email=Auth::user()->email;
        $userDetails=User::find($user_id);
        $shippingCount=DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails=array();
        if($shippingCount>0){
            $shippingDetails=DeliveryAddress::where('user_id',$user_id)->first();
        }
        $session_id=Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
        if($request->isMethod('post')){
            $data=$request->all();
            //echo "<pre>";print_r($data);die;
            if(empty($data['billing_name'])||empty($data['billing_address'])||empty($data['billing_city'])||empty($data['billing_state'])||empty($data['billing_pincode'])||empty($data['billing_mobile'])||
            empty($data['shipping_name'])||empty($data['shipping_address'])||empty($data['shipping_city'])||empty($data['shipping_state'])||empty($data['shipping_pincode'])||empty($data['shipping_mobile'])){
                return redirect()->back()->with('flash_message_error','Please fill all fields to Checkout!');
            }
            User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'pincode'=>$data['billing_pincode'],'mobile'=>$data['billing_mobile']]);
            if($shippingCount>0){
                DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],'mobile'=>$data['shipping_mobile']]);
            }else{
                $shipping=new DeliveryAddress;
                $shipping->user_id=$user_id;
                $shipping->user_email=$user_email;
                $shipping->name=$data['shipping_name'];
                $shipping->address=$data['shipping_address'];
                $shipping->city=$data['shipping_city'];
                $shipping->state=$data['shipping_state'];
                $shipping->pincode=$data['shipping_pincode'];
                $shipping->mobile=$data['shipping_mobile'];
                $shipping->save();
            }
            return redirect('/order-review');//->action('ProductsController@orderReview');

        }

        return view('products.checkout')->with(compact('userDetails','shippingDetails'));
    }
    public function orderReview(){
        $user_id=Auth::user()->id; 
        $user_email=Auth::user()->email;
        $userDetails=User::where('id',$user_id)->first();
        $shippingDetails=DeliveryAddress::where('user_id',$user_id)->first();
        $shippingDetails=json_decode(json_encode($shippingDetails));
        //echo "<pre>";print_r($shippingDetails);die;

        $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
        foreach($userCart as $key=>$product){
            $productDetails=Product::where('id',$product->product_id)->first();
            $userCart[$key]->image=$productDetails->main_image;
        }
        //echo "<pre>";print_r($userCart);die;

        return view('products.order_review')->with(compact('userDetails','shippingDetails','userCart'));
    }
    public function placeOrder(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $user_id=Auth::user()->id;
            $user_email=Auth::user()->email;
            
            if(empty(Session::get('CouponCode'))){
                $coupon_code="";
            }else{
                $coupon_code=Session::get('CouponCode');
            }
            if(empty(Session::get('CouponAmount'))){
                $coupon_amount =0;
            }else{
                $coupon_amount=Session::get('CouponAmount');
            }

            $shippingDetails=DeliveryAddress::where(['user_email'=>$user_email])->first();
            $order=new Order;
            $order->user_id=$user_id;
            $order->user_email=$user_email;
            $order->name=$shippingDetails->name;
            $order->address=$shippingDetails->address;
            $order->city=$shippingDetails->city;
            $order->state=$shippingDetails->state;
            $order->pincode=$shippingDetails->pincode;
            $order->mobile=$shippingDetails->mobile;
            $order->shipping_charges=0;
            $order->coupon_code=$coupon_code;//$data['coupon_code'];
            $order->coupon_amount=$coupon_amount;//$data['coupon_amount'];
            $order->order_status="New";
            $order->payment_method=$data['payment_method'];
            $order->grand_total=$data['grand_total'];
            $order->save();
            $order_id=DB::getPdo()->lastInsertId();
            $cartProducts=DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach($cartProducts as $pro){
                $cartPro=new OrdersProduct;
                $cartPro->order_id=$order_id;
                $cartPro->user_id=$user_id;;
                $cartPro->product_id=$pro->product_id;
                $cartPro->product_code=$pro->product_code;
                $cartPro->product_name=$pro->product_name;
                $cartPro->product_size=$pro->size;
                $cartPro->product_price=$pro->price;
                $cartPro->product_qty=$pro->quantity;
                $cartPro->save();
            }
            Session::put('order_id',$order_id);
            Session::put('grand_total',$data['grand_total']);
            /* Code for order Email Start*/
            $email=$user_email;
            $messageData=[
                'email'=>$email,
                'name'=>$shippingDetails->name,
                'order_id'=>$order_id
            ];
            \Mail::to($email)->send(new \App\Mail\order($messageData));
            /* Code for order Email End*/

            return redirect('/thanks'); 
        }
    }
    public function thanks(Request $request){
        $user_email=Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.thanks');
    }
    public function userOrders(){
        $user_id=Auth::user()->id;
        $orders=Order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();

        return view('orders.user_orders')->with(compact('orders'));
    }
    public function userOrderDetails($order_id){
        $user_id=Auth::user()->id;
        $orderDetails=Order::with('orders')->where('id',$order_id)->first();
        return view('orders.user_order_details')->with(compact('orderDetails'));

    }
    public function paypal(Request $request){
       
        return view('orders.paypal');
    }

    public function searchProducts(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            //echo $categoryDetails->id;die;
            
            $search_product=$data['product'];

            $categories=Category::with('categories')->where(['parent_id'=>0,'status'=>1])->get();
           
            $productsAll=Product::where('product_name','like','%'.$search_product.'%')->orwhere('product_code',$search_product)->where('status',1)->get();
            return view('products.listing')->with(compact('productsAll','categories','search_product'));

        }
    }

}
