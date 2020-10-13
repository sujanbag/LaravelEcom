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
              <li class="breadcrumb-item active">{{$title}}</li>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content-body"><!-- Basic Inputs start -->
      
        <section class="basic-inputs">
          <form name="categoryForm" id="CategoryForm" 
            @if(empty($categorydata['id'])) action="{{ url('admin/add-edit-product')}}" 
            @else action="{{url('admin/add-edit-product/'.$categorydata['id'])}}" @endif 
            method="post" enctype="multipart/form-data">@csrf
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
                        <label>Select Category </label>
                        <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                          <option value="0">Select</option>
                          @foreach($categories as $section)
                            <optgroup label="{{ $section['name']}}">
                            </optgroup>
                            @foreach($section['categories'] as $category)
                                <option value="{{ $category['id']}}" @if(!empty(@old('category_id'))
                                && $category['id']==@old('category_id')) selected=""
                                @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$category['id']) selected=""
                                @endif>&nbsp;&nbsp;&nbsp;&nbsp;
                                {{ $category['category_name'] }}</option>
                                @foreach($category['subcategories'] as $subcategory)
                                    <option value="{{ $subcategory['id']}}" @if(!empty(@old('category_id'))
                                    && $subcategory['id']==@old($subcategory['id'])) selected=""
                                    @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$subcategory['id']) selected=""
                                    @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--{{ $subcategory['category_name']}}</option>
                                @endforeach
                            @endforeach
                          @endforeach
                        </select>
                      </div>
                      
                      <div class="form-group">
                        <label>Select Brand </label>
                        <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          
                          @foreach($brands as $brand)
                            <option value="{{ $brand['id']}}"  @if(!empty($productdata['brand_id']) && $productdata['brand_id']==$brand['id']) selected="" @endif>{{ $brand['name'] }}</option>
                          @endforeach
                          
                        </select>
                      </div>

                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter product Name"
                        @if(!empty($productdata['product_name'])) 
                        value="{{$productdata['product_name']}}" @else value="{{old('product_name')}}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="text" name="product_price" class="form-control" id="product_price" placeholder="Enter product Price" @if(!empty($productdata['product_price'])) 
                        value="{{$productdata['product_price']}}" @else value="{{old('product_price')}}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_discount">Product Discount (%)</label>
                        <input type="text" name="product_discount" class="form-control" id="product_discount" placeholder="Enter product Discount" @if(!empty($productdata['product_discount'])) 
                        value="{{$productdata['product_discount']}}" @else value="{{old('product_discount')}}" @endif>
                    </div>

                    <div class="form-group">
                        <label for="product_video">Product Video</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="product_video" name="product_video">
                            <label class="custom-file-label" for="product_video">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div> 
                        </div>
                        @if(!empty($productdata['product_video']))
                        <div>
                          <a href="{{url('videos/product_videos/'.$productdata['product_video'])}}" download>Download</a>
                          &nbsp;
                          <a class="confirmDelete" href="javascript:void(0)" record="product-video" recordid="{{$productdata['id']}}">Delete Video</a>
                        </div>
                        @endif
                      </div>
                    <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter ...">
                          @if(!empty($productdata['description'])){{
                          $productdata['description'] }} @else {{old('description')}} @endif 
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_name">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter ...">
                          @if(!empty($categorydata['meta_description'])) 
                          {{$categorydata['meta_description']}} 
                          @else {{old('meta_description')}}
                          @endif
                        </textarea>
                    </div>
                    <div class="col-md-6">
                      

                    </div>
                    <div class="col-md-6">


                    </div>
                    {{--
                    <div class="form-group" id="appendProductdsLevel">
                        @include('admin.categories.append_categories_level')

                    </div>
                    --}}
                


                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_code">Product Code</label>
                        <input type="text" name="product_code" class="form-control" id="product_code" placeholder="Enter product Code" @if(!empty($productdata['product_code'])) 
                        value="{{$productdata['product_code']}}" @else value="{{old('product_code')}}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_color">Product Color</label>
                        <input type="text" name="product_color" class="form-control" id="product_color" placeholder="Enter product Color" @if(!empty($productdata['product_color'])) 
                        value="{{$productdata['product_color']}}" @else value="{{old('product_color')}}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_weight">Product Weight</label>
                        <input type="text" name="product_weight" class="form-control" id="product_weight" placeholder="Enter product Weight" @if(!empty($productdata['product_weight'])) 
                        value="{{$productdata['product_weight']}}" @else value="{{old('product_weight')}}" @endif>
                    </div>
                      <div class="form-group">
                        <label for="main_image">Product Main Image</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="main_image" name="main_image">
                            <label class="custom-file-label" for="main_image">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div> 
                        </div>
                        @if(!empty($productdata['main_image']))
                        <div>
                        <img style="width:80px; margin-top:5px;" src="{{asset('images/product_images/small/'.$productdata['main_image'])}}">
                        &nbsp;
                        <a class="confirmDelete" href="javascript:void(0)" record="product-image" recordid="{{$productdata['id']}}">Delete Image</a>
                        </div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="wash_care">Wash Care</label>
                        <textarea class="form-control" id="wash_care" name="wash_care" rows="3" placeholder="Enter ...">
                          @if(!empty($productdata['wash_care'])){{
                          $productdata['wash_care'] }} @else {{old('wash_care')}} @endif 
                        </textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Select Fabric </label>
                        <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          
                          @foreach($fabricArray as $fabric)
                            <option value="{{ $fabric}}" @if(!empty($productdata['fabric']) && $productdata['fabric']==$fabric) selected="" @endif>{{ $fabric }}</option>
                          @endforeach
                          
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Select Sleeve </label>
                        <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          
                          @foreach($sleeveArray as $sleeve)
                            <option value="{{ $sleeve}}"  @if(!empty($productdata['sleeve']) && $productdata['sleeve']==$sleeve) selected="" @endif>{{ $sleeve }}</option>
                          @endforeach
                          
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Select Pattern </label>
                        <select name="pattern" id="pattern" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          
                          @foreach($patternArray as $pattern)
                            <option value="{{ $pattern}}"   @if(!empty($productdata['pattern'])&&
                            $productdata['pattern']==$pattern) selected="" @endif>{{ $pattern }}</option>
                          @endforeach
                          
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Select Fit </label>
                        <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          
                          @foreach($fitArray as $fit)
                            <option value="{{ $fit}}">{{ $fit }}</option>
                          @endforeach
                          
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Select Occasion </label>
                        <select name="occasion" id="occasion" class="form-control select2" style="width: 100%;">
                          <option value="">Select</option>
                          
                          @foreach($occasionArray as $occasion)
                            <option value="{{ $occasion}}">{{ $occasion }}</option>
                          @endforeach
                          
                        </select>
                      </div>
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <textarea class="form-control" id="meta_title" name="meta_title" rows="3" placeholder="Enter ..."> 
                        @if(!empty($productdata['meta_title'])) 
                        {{$productdata['meta_title']}} 
                        @else {{old('meta_title')}}
                        @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_name">Meta Keywords</label>
                        <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3" placeholder="Enter ...">
                          @if(!empty($productdata['meta_keywords'])) 
                          {{$productdata['meta_keywords']}} 
                          @else {{old('meta_keywords')}}
                          @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_name">Featured Item</label>
                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                        @if(!empty($productdata['is_featured'])&& $productdata['is_featured']=="Yes") checked="" @endif>
                      
                    </div>
                    <!-- /.form-group -->

                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row">
                  <div class="col-12 col-sm-6">
                    


                    
                  
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                  <div class="col-12 col-sm-6">

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