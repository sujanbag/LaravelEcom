<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CmsPage;
use Session;
use App\Category;
use Mail;
class CmsController extends Controller
{
    public function addCmsPage($id=null,Request $request){

        if($id==""){
            $title="Add CMS";
            $cmspage=new CmsPage;
            $message="CMS added successfully!";
        }else{
            $title="Edit CMS";
            $cmspage=CmsPage::find($id);
            $message="CMS Page edited successfully!";
        }


        if($request->isMethod('post')){
            $data=$request->all();
            //echo "<pre>";print_r($data);die;
            $cmspage->title=$data['title'];
            $cmspage->url=$data['link'];
            $cmspage->description=$data['description'];
            if(empty($data['status'])){
                $status=0;
            }else{
                $status=1;
            }
            $cmspage->status=$status;
            $cmspage->save();
            session::flash('success_message',$message);
            return redirect('admin/view-cms-page');
        }

        return view('admin.pages.add_cms_page')->with(compact('title','cmspage'));

    }
    public function viewCmsPages(){
        Session::put('page','view-cms-page');
        $cmsPages=CmsPage::get();
        return view('admin.pages.view_cms_pages')->with(compact('cmsPages'));

    }
    public function updateCmsStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status =0;

            }else{
                $status=1;
            }
            CmsPage::where('id',$data['cms_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'cms_id'=>$data['cms_id']]);
        }
    }
    public function deleteCms($id){
        $bannerImage=CmsPage::where('id',$id)->first();
        CmsPage::where('id',$id)->delete();
        $message='Cms Page has been deleted successfully!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function cmsPage($url){
        $cmsPageCount=CmsPage::where(['url'=>$url,'status'=>1])->count();
        if($cmsPageCount>0){
            $cmsPageDetails=CmsPage::where('url',$url)->first();
        }else{
            abort(404);
        }
        $categories=Category::with('categories')->where(['parent_id'=>0,'status'=>1])->get();

        return view('pages.cms_page')->with(compact('cmsPageDetails','categories'));
    }
    public function contact(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            //send contact email
            $email="sujanbag58@gmail.com";
            $messageData=['name'=>$data['name'],
                        'email'=>$data['email'],
                        'subject'=>$data['subject'],
                        'message'=>$data['message']
                    ];
           /* Mail::send('emails.enquery',$messageData,function($message)use($email){
                $meesage->to($email)->subject('Enquery from E-Com');
                }*/


        }
        $categories=Category::with('categories')->where(['parent_id'=>0,'status'=>1])->get();
        return view('pages.contact')->with(compact('categories'));
    }
}
