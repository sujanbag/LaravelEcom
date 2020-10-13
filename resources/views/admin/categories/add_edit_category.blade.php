@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-wrapper-before"></div>
    <div class="content-header row">
      <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{$title}}</h3>
      </div>
      <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
          <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
              </li>
              <li class="breadcrumb-item active">{{$title}}
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content-body"><!-- Basic Inputs start -->
      
        <section class="basic-inputs">
          <form name="categoryForm" id="CategoryForm" 
            @if(empty($categorydata['id'])) action="{{ url('admin/add-edit-category')}}" 
            @else action="{{url('admin/add-edit-category/'.$categorydata['id'])}}" @endif 
            enctype="multipart/form-data" method="post">@csrf
          {{--
            <div class="row match-height">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="card-body">
                              <h4 class="card-title">Category Name</h4>
                                    <input type="text" class="form-control" id="category_name" name="category_name" @if(!empty($categorydata['category_name'])) 
                                    value="{{$categorydata['category_name']}}" @else value="{{old('category_name')}}" @endif>
                            </div>
                        </div>
                      
                        <div class="card-block">
                          <div class="card-body">
                            <h4 class="card-title">Select Section</h4>
                                  <select class="form-control" name="section_id" id="section_id">
                                    <option value="0">Main Category</option>
                                    @foreach($getSection as $section)
                                    <option value="{{ $section->id}}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected  @endif>{{$section->name}}</option>
                                  </select>
                              </fieldset>    
                          </div>
                        </div>
                      
                        <div class="form-group" id="appendCategoriesLevel">
                          @include('admin.categories.append_categories_level')
      
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                  
                  <div class="card">
                    <div class="card-block">
                      <div class="card-body">
                        <h4 class="card-title">Category Image</h4>
                        
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="category_image" name="category_image">
                                <label class="custom-file-label" for="category_image">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                              </div> 
                            </div>
                              @if(!empty($categorydata['category_image']))
                              <div>
                              <img style="width:80px; margin-top:5px;" src="{{asset('images/category_images/'.$categorydata['category_image'])}}">
                              &nbsp;
                              <a class="confirmDelete" href="javascript:void(0)" record="category-image" recordid="{{$categorydata['id']}}">Delete Image</a>
                              </div>
                              @endif
                        
                      </div>
                    </div>
                    <div class="card-block">
                      <div class="card-body">
                        <h4 class="card-title">Category Discount</h4>
                        
                              <input type="text" class="form-control" id="category_discount" name="category_discount" placeholder="Enter Category Discount" @if(!empty($categorydata['category_discount'])) 
                              value="{{$categorydata['category_discount']}}" 
                              @else value="{{old('category_discount')}}" @endif> 
                        
                      </div>
                  </div>
                  <div class="card-block">
                      <div class="card-body">
                        <h4 class="card-title">Category Url</h4>
                          
                              <input type="text" class="form-control" id="url" name="url" placeholder="Enter Category URL"
                              @if(!empty($categorydata['url'])) 
                              value="{{$categorydata['url']}}" 
                              @else value="{{old('url')}}" 
                              @endif >
                        
                      </div>
                  </div>

                  </div>
                </div>
                <div class="col-lg-6 col-md-12">
                  
                  <div class="card">
                      <div class="card-block">
                          <div class="card-body">
                              
                            <h5 class="mt-2">Category Description</h5>
                          
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter ...">
                                  @if(!empty($categorydata['description'])){{
                                  $categorydata['description'] }} @else {{old('description')}} @endif </textarea>
                          
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-12">
                  
                  <div class="card">
                      <div class="card-block">
                          <div class="card-body">
                              
                            <h5 class="mt-2">Meta Description</h5>
                            
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter ...">
                                  @if(!empty($categorydata['meta_description'])) 
                                  {{$categorydata['meta_description']}} 
                                  @else 
                                  {{old('meta_description')}}
                                  @endif</textarea>
                          
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-12">
                  
                  <div class="card">
                      <div class="card-block">
                          <div class="card-body">
                              
                            <h5 class="mt-2">Meta Title</h5>
                            
                                <textarea class="form-control" id="meta_title" name="meta_title" rows="3" placeholder="Enter ..."> 
                                  @if(!empty($categorydata['meta_title'])) 
                                  {{$categorydata['meta_title']}} 
                                  @else 
                                  {{old('meta_title')}}
                                  @endif</textarea>
                          
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-12">
                  
                  <div class="card">
                      <div class="card-block">
                          <div class="card-body">
                              
                            <h5 class="mt-2">Meta Keywords</h5>
                          
                                <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3" placeholder="Enter ...">
                                  @if(!empty($categorydata['meta_keywords'])) 
                                  {{$categorydata['meta_keywords']}} 
                                  @else 
                                  {{old('meta_keywords')}}
                                  @endif</textarea>
                            
                          </div>
                      </div>
                  </div>
                </div>
            </div>
            <button type="button" class="btn btn-success">Add</button>
            --}}
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
                        <label for="category_name">Category Name</label>
                        <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Enter Category Name" @if(!empty($categorydata['category_name'])) 
                        value="{{$categorydata['category_name']}}" @else value="{{old('category_name')}}" @endif>
                    </div>
                    <div class="form-group" id="appendCategoriesLevel">
                        @include('admin.categories.append_categories_level')
    
                    </div>
                    
                    
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label for="category_discount">Category Discount</label>
                        <input type="text" class="form-control" id="category_discount" name="category_discount" placeholder="Enter Category Discount"
                        @if(!empty($categorydata['category_discount'])) 
                        value="{{$categorydata['category_discount']}}" 
                        @else value="{{old('category_discount')}}" @endif>
                    </div>
    
    
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Section </label>
                        <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                          <option value="0">Main Category</option>
                          @foreach($getSection as $section)
                          <option value="{{ $section->id}}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected  @endif>{{$section->name}}</option>
                          @endforeach
                        </select>
                      </div>
      
                      <div class="form-group">
                        <label for="exampleInputFile">Category Image</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="category_image" name="category_image">
                            <label class="custom-file-label" for="category_image">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div> 
                        </div>
                        @if(!empty($categorydata['category_image']))
                        <div>
                        <img style="width:80px; margin-top:5px;" src="{{asset('images/category_images/'.$categorydata['category_image'])}}">
                        &nbsp;
                        <a class="confirmDelete" href="javascript:void(0)" record="category-image" recordid="{{$categorydata['id']}}">Delete Image</a>
                        </div>
                        @endif
                      </div>
    
    
    
                    <div class="form-group">
                        <label for="url">Category URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Enter Category URL"
                        @if(!empty($categorydata['url'])) 
                        value="{{$categorydata['url']}}" 
                        @else value="{{old('url')}}" 
                        @endif>
                    </div>
                    <!-- /.form-group -->
    
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="description">Category Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter ...">
                          @if(!empty($categorydata['description'])){{
                          $categorydata['description'] }} @else {{old('description')}} @endif 
                        </textarea>
                    </div>
    
                    <div class="form-group">
                        <label for="category_name">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter ...">
                          @if(!empty($categorydata['meta_description'])) 
                          {{$categorydata['meta_description']}} 
                          @else 
                          {{old('meta_description')}}
                          @endif
                        </textarea>
                    </div>
                   
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <textarea class="form-control" id="meta_title" name="meta_title" rows="3" placeholder="Enter ..."> 
                        @if(!empty($categorydata['meta_title'])) 
                        {{$categorydata['meta_title']}} 
                        @else 
                        {{old('meta_title')}}
                        @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_name">Meta Keywords</label>
                        <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3" placeholder="Enter ...">
                          @if(!empty($categorydata['meta_keywords'])) 
                          {{$categorydata['meta_keywords']}} 
                          @else 
                          {{old('meta_keywords')}}
                          @endif
                        </textarea>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
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