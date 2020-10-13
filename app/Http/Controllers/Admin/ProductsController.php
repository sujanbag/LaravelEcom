<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Section;
use App\Brand;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Order;
use App\User;
use Session;
use Image;
class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $products=Product::with(['category','section'])->get();
        //$products=json_decode(json_encode($products));
        //echo "<pre";print_r($products);die;
        return view('admin.products.products')->with(compact('products'));
    }
    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status =0;

            }else{
                $status=1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
      }
      public function deleteProduct($id){
        Product::where('id',$id)->delete();
        $message='Product has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function addEditProduct(Request $request,$id=null){

        if($id==""){
            $title="Add Product";
            $product=new Product;
            $productdata=array();
            //mychange
           // $categorydata=array();
            //mychange end
            $message="Product added Successfully!";

        }else{
            $title="Edit Product";
            $productdata=Product::find($id);
            $product=Product::find($id);
            //mychange
            //$categorydata=Category::where('id',$id)->first();
            //$categorydata=json_decode(json_encode($categorydata),true);
            //mychange end
            $message="Product updated Successfully!";


        }
        //echo $title;die;

        if($request->isMethod('post'))
        {

            $data=$request->all();
            //echo "<pre>"; echo $message; print_r($data);die;
             //Category Validation
             $rules=[
                'category_id'=>'required',
                //'brand_id'=>'required',
                'product_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'product_code'=>'required|regex:/^[\w-]*$/',
                'product_price'=>'required|numeric',
                //'product_color'=>'required|regex:/^[\pL\s\-]+$/u'

            ];
            $customMessages=[
                'category_id.required'=>'Category is required',
                //'brand_id.required'=>'Brand is required',
                'product_name.required'=>'Product name is required',
                'product_name.regex'=>'Valid Product Name is required',
                'product_code.required'=>'Product Code is required',
                'product_code.regex'=>'Valid Product Code is required',
                'product_price.required'=>'Product Price is required',
                'product_price.regex'=>'Valid Product Price is required',
                //'product_color.required'=>'Product Color is required',
                //'product_color.regex'=>'Valid Product Color is required',

            ];
            $this->validate($request,$rules,$customMessages);
            //Save Product details in product table
            if(empty($data['is_featured'])){
                $is_featured="No";
            }else{
                $is_featured="Yes";
            }
            if(empty($data['brand_id'])){
                $data['brand_id']=0;
            }
            if(empty($data['fabric'])){
                $data['fabric']="";
            }
            if(empty($data['product_color'])){
                $data['product_color']="";
            }
            if(empty($data['pattern'])){
                $data['pattern']="";
            }
            if(empty($data['sleeve'])){
                $data['sleeve']="";
            }
            if(empty($data['fit'])){
                $data['fit']="";
            }
            if(empty($data['occasion'])){
                $data['occasion']="";
            }
            if(empty($data['meta_title'])){
                $data['meta_title']="";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }
            if(empty($data['meta_description'])){
                $data['meta_description']="";
            }
            if(empty($data['product_video'])){
                $data['product_video']="";
            }
            if(empty($data['main_image'])){
                $data['main_image']="";
            }
            if(empty($data['product_discount'])){
                $data['product_discount']=0;
            }
            if(empty($data['product_weight'])){
                $data['product_weight']=0;
            }
            if(empty($data['description'])){
                $data['description']="";
            }
            if(empty($data['wash_care'])){
                $data['wash_care']="";
            }

            if($request->hasFile('main_image')){
                $image_tmp=$request->file('main_image');
                if($image_tmp->isValid()){
                    $image_name=$image_tmp->getClientOriginalName();
                    $extension=$image_tmp->getClientOriginalExtension();
                    $imageName=$image_name;//.'-'.rand(111,99999).'.'.$extension;
                    $large_image_path='images/product_images/large/'.$imageName;
                    $medium_image_path='images/product_images/medium/'.$imageName;
                    $small_image_path='images/product_images/small/'.$imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    //echo "<pre>";print_r($image_name);die;
                    $product->main_image=$imageName;
                }
            }else{
                $product->main_image="";
            }

            if($request->hasFile('product_video')){
                $video_tmp=$request->file('product_video');
                if($video_tmp->isValid()){
                    $video_name=$video_tmp->getClientOriginalName();
                    $extension=$video_tmp->getClientOriginalExtension();
                    $videoName=$video_name.'-'.rand().'.'.$extension;
                    $video_path='videos/product_videos/';
                    $video_tmp->move($video_path,$videoName);
                    $product->product_video=$videoName;
                }
            }else{
                $product->product_video="";
            }

            $categoryDetails=Category::find($data['category_id']);
            $product->section_id=$categoryDetails['section_id'];
            $product->brand_id=$data['brand_id'];
            $product->category_id=$data['category_id'];
            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            $product->product_price=$data['product_price'];
            //$product->product_video=$data['product_video'];
            //$product->main_image=$data['main_image'];
            $product->product_discount=$data['product_discount'];
            $product->product_weight=$data['product_weight'];
            $product->description=$data['description'];
            $product->wash_care=$data['wash_care'];
            $product->fabric=$data['fabric'];
            $product->pattern=$data['pattern'];
            $product->sleeve=$data['sleeve'];
            $product->fit=$data['fit'];
            $product->occasion=$data['occasion'];
            $product->meta_title=$data['meta_title'];
            $product->meta_keywords=$data['meta_keywords'];
            $product->meta_description=$data['meta_description'];
            $product->is_featured=$is_featured;
            $product->status=1;
            $product->save();
            session::flash('success_message',$message);
            return redirect('admin/products');
        }

        $productFilters=Product::productFilters();
        //echo "<pre>";print_r($productFilters);die;
        $fabricArray=$productFilters['fabricArray'];
        $sleeveArray=$productFilters['sleeveArray'];
        $patternArray=$productFilters['patternArray'];
        $fitArray=$productFilters['fitArray'];
        $occasionArray=$productFilters['occasionArray'];


        $categories=Section::with('categories')->get();
        //$categories=json_decode(json_encode($categories),true);
        //echo "<pre>";print_r($categories);die;
        $brands=Brand::where('status',1)->get();
        $brands=json_decode(json_encode($brands),true);
        return view('admin.products.add_edit_product')->with(compact('title','fabricArray','sleeveArray','fitArray','occasionArray','patternArray','categories','productdata','brands'));
    }
    public function deleteProductImage($id){
        $productImage=Product::select('main_image')->where('id',$id)->first();
        $small_image_path='images/product_images/small/';
        $medium_image_path='images/product_images/medium/';
        $large_image_path='images/product_images/large/';
        if(file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path.$productImage->main_image);
        }
        if(file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path.$productImage->main_image);
        }
        if(file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path.$productImage->main_image);
        }
        Product::where('id',$id)->update(['main_image'=>'']);
        $message='Product image has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function deleteProductVideo($id){
        $productVideo=Product::select('product_video')->where('id',$id)->first();
        $product_video_path='videos/product_videos/';
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }
        Product::where('id',$id)->update(['product_video'=>'']);
        $message='Product Video has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function addAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data=$request->all();
            foreach($data['sku'] as $key=>$value){
                if(!empty($value)){
                    $attrCountSKU=ProductsAttribute::where(['sku'=>$value])->count();
                    if($attrCountSKU>0){
                        $message='SKU already exists. Please add another SKU';
                        session::flash('error_message',$message);
                        return redirect()->back();
                    }
                    $attrCountSize=ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($attrCountSize>0){
                        $message='Size already exists. Please add another Size';
                        session::flash('error_message',$message);
                        return redirect()->back();
                    }
                    $attribute=new ProductsAttribute;
                    $attribute->product_id=$id;
                    $attribute->sku=$value;
                    $attribute->size=$data['size'][$key];
                    $attribute->price=$data['price'][$key];
                    $attribute->stock=$data['stock'][$key];
                    $attribute->status=1;
                    $attribute->save();
                }
            }
            $success_message='Product Attributes has been added successfully!';
            session::flash('success_message',$success_message);
            return redirect()->back();
        }
        $productdata=Product::select('id','product_name','product_code','product_color','main_image')->with('attributes')->find($id);
        $productdata=json_decode(json_encode($productdata),true);

        $title="Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata','title'));
    }
    public function editAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['attrId'] as $key=>$attr){
                if(!empty($attr)){
                    ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            $message='Product attributes has been updated successfully!';
            session::flash('success_message',$message);
            return redirect()->back();
        }
    }
    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status =0;

            }else{
                $status=1;
            }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }
    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status =0;

            }else{
                $status=1;
            }
            ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }
    public function deleteAttribute($id){
        ProductsAttribute::where('id',$id)->delete();
        $message='Product Attribute has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function addImages(Request $request,$id){
        if($request->isMethod('post')){
            //$data=$request->all();
           // echo "<pre>";print_r($data);die;
            if($request->hasFile('images')){
                $images=$request->file('images');
                //echo "<pre>";print_r($images);die;
                foreach($images as $key=>$image){
                    $productImage=new ProductsImage;
                    $image_tmp=Image::make($image);
                    //$originalName=$image->getClientOriginalName();
                    $extension=$image->getClientOriginalExtension();
                    $imageName=rand(111,999999).time().".".$extension;
                    $large_image_path='images/product_images/large/'.$imageName;
                    $medium_image_path='images/product_images/medium/'.$imageName;
                    $small_image_path='images/product_images/small/'.$imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    //echo "<pre>";print_r($imageName);die;
                    $productImage->image=$imageName;
                    $productImage->product_id=$id;
                    $productImage->status=1;
                    $productImage->save();
                }
                $message='Product Images has been added successfully!';
                session::flash('success_message',$message);
                return redirect()->back();

            }
        }
        $productdata=Product::with('images')->select('id','product_name','product_code','product_color','main_image')->find($id);
        $productdata=json_decode(json_encode($productdata),true);
        $title="Product Images";
        return view('admin.products.add_images')->with(compact('title','productdata'));
    }
    public function deleteImage($id){
        $productImage=ProductsImage::select('image')->where('id',$id)->first();
        $small_image_path='images/product_images/small/';
        $medium_image_path='images/product_images/medium/';
        $large_image_path='images/product_images/large/';
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        ProductsImage::where('id',$id)->delete();
        $message='Product images has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function viewOrders(){
        Session::put('page','view-orders');
        $orders=Order::with('orders')->orderBy('id','Desc')->get();
        $orders=json_decode(json_encode($orders));
        //echo "<pre>"; print_r($orders);
        return view('admin.orders.view_orders')->with(compact('orders'));
    }
    public function viewOrderDetails($order_id){
        $orderDetails =Order::with('orders')->where('id',$order_id)->first();
        $orderDetails=json_decode(json_encode($orderDetails));
        $user_id=$orderDetails->user_id;
        $userDetails=User::where('id',$user_id)->first();
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }
    public function updateOrderStatus(Request $request){
         if($request->isMethod('post')){
             $data=$request->all();
             Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
             return redirect()->back()->with('success_message','Order Status has been deleted successfully!');
         }
    }
    public function viewOrderInvoice($order_id){
        $orderDetails =Order::with('orders')->where('id',$order_id)->first();
        $orderDetails=json_decode(json_encode($orderDetails));
        $user_id=$orderDetails->user_id;
        $userDetails=User::where('id',$user_id)->first();
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }
}
