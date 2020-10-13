@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-wrapper-before"></div>
    <div class="content-header row">
      <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">Add CMS Page</h3>
      </div>
      <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
          <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
              </li>
              <li class="breadcrumb-item active">Add CMS Page
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content-body"><!-- Basic Inputs start -->
      
        <section class="basic-inputs">
          @if ($errors->any())
          <div class="alert alert-danger" style="margin-top:10px;">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>

          @endif
          @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                {{Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form name="add_cms_page" id="add_cms_page" 
            @if(empty($cmspage->id)) action="{{ url('admin/add-cms-page')}}" 
            @else action="{{url('admin/add-cms-page/'.$cmspage->id)}}" @endif 
            method="post" >@csrf 
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
    
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter CMS Page Title" @if(!empty($cmspage->title)) 
                        value="{{$cmspage->title}}" @else value="{{old("title")}}" @endif>
                    </div>
                      
                      <div class="form-group">
                         <label for="link">CMS Page Link</label>
                         <input type="text" name="link" class="form-control" id="link" placeholder="Enter Banner Link" @if(!empty($cmspage->url)) 
                         value="{{$cmspage->url}}" @else value="{{old("link")}}" @endif>
                       </div>
                       
                        <div class="form-group">
                            <label for="description">Descriptions</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Enter Banner Descriptions" @if(!empty($cmspage->description)) 
                            value="{{$cmspage->description}}" @else value="{{old("description")}}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="status">Enable</label>
                        <input type="checkbox" name="status" id="status" value="1" @if($cmspage->status==1) checked="checked" @endif>
                        </div>
    
                  </div>
    
                  <!-- /.col -->
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
            </form>
        </section>
        <!-- Basic Inputs end -->
     
   
      
    </div>
  </div>
</div>

@endsection