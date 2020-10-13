<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Banner;
class IndexController extends Controller
{
    public function index(){
        /*
        $featuredItemsCount=Product::where('is_featured','Yes')->where('status',1)->count();
        $featuredItems=Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
        $featuredItemsChunk=array_chunk($featuredItems,4);
        //echo "<pre>"; print_r($featuredItemsChunk);die;
        $newProducts=Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();
        $page_name="index";
        return view('front.index')->with(compact('page_name','featuredItemsChunk','featuredItemsCount','newProducts'));
        */
        $productsAll=Product::get();
        //In Descending order
        $productsAll=Product::orderBy('id','DESC')->get();
        $productsAll=Product::inRandomOrder()->where('status',1)->where('is_featured','Yes')->paginate(3);
        $categories=Category::with('categories')->where(['parent_id'=>0,'status'=>1])->get();
        //$categories=json_decode(json_encode($categories));
        //echo "<pre>";print_r($categories);die;
        //echo "<pre>";print_r($categories);die;
        /*$categories_menu="";
        foreach($categories as $cat){
            //echo $cat->name;echo "<br>";
            $categories_menu.="<div class='panel-heading'>
                                <h4 class='panel-title'>
                                    <a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
                                        <span class='badge pull-right'><i class='fa fa-plus'></i></span>
                                        ".$cat->category_name."
                                    </a>
                                </h4>
                            </div>
                            <div id='".$cat->id."' class='panel-collapse collapse'>
                                <div class='panel-body'>
                                    <ul>";
                                        $sub_categories=Category::where(['parent_id'=>$cat->id])->get();
                                        foreach($sub_categories as $subcat){
                                            $categories_menu .="<li><a href='".$subcat->url."'>".$subcat->category_name."</a></li>";
                                        }
                                        
                                        $categories_menu.="</ul>
                                </div>
                            </div>";

        }*/
        $banners=Banner::where('status','1')->get();
        return view('index')->with(compact('productsAll','categories','banners'));
    }
}
