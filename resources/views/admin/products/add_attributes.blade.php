@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-wrapper-before"></div>
      <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
          <h3 class="content-header-title">Attributes Tables</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
          <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Attributes Tables
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
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
          @if(Session::has('error_message'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top:10px;">
              {{Session::get('error_message')}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
      <form name="attributeForm" id="attributeForm" method="post" action="{{ url('admin/add-attributes/'.$productdata['id']) }}">@csrf

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
                    <label for="product_name">Product Name : </label>&nbsp;{{$productdata['product_name']}}
                  </div>

              
                    <div class="form-group">
                        <label for="product_code">Product Code : </label>&nbsp;{{$productdata['product_code']}}
                    </div>
                    <div class="form-group">
                        <label for="product_color">Product Color : </label>&nbsp;{{$productdata['product_color']}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <img style="width:120px; margin-top:5px;" src="{{asset('images/product_images/small/'.$productdata['main_image'])}}">
                    </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <div class="field_wrapper">
                        <div>
                            <input id="size" type="text" name="size[]" value="" placeholder="Size" style="width:120px;" required=""/>
                            <input id="sku" type="text" name="sku[]" value="" placeholder="SKU" style="width:120px;"required=""/>
                            <input id="price" type="number" name="price[]" value="" placeholder="Price" style="width:120px;"required=""/>
                            <input id="stock" type="number" name="stock[]" value="" placeholder="Stock" style="width:120px;"required=""/>
                            <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Attributes</button>
          </div>
        </div>
        </form>
      <div class="content-body">
        <!-- Bordered table start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Bordered table</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">
                <form name="editAttributeForm" id="editAttributeForm" method="post" action="{{url('admin/edit-attributes/'.$productdata['id'])}}">@csrf
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Size</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Stock</th> 
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($productdata['attributes'] as $attribute)
                      <input type="hidden" name="attrId[]" value="{{ $attribute['id']}}">
                      <tr>
                        <th scope="row">{{ $attribute['id'] }}</th>
                        <td>{{ $attribute['size'] }}</td>
                        <td>{{ $attribute['sku'] }}</td>
                        <td>
                            <input type="number" name="price[]" value="{{ $attribute['price'] }}" required="">
                        </td>
                        <td>
                            <input type="number" name="stock[]" value="{{ $attribute['stock'] }}" required="">
                        </td>
                        <td>
                            @if($attribute['status']==1)
                                <a class="updateAttributeStatus" id="attribute-{{ $attribute['id']}}" attribute_id="{{ $attribute['id'] }}" href="javascript:void(0)">Active</a>
                            @else
                                <a class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}" attribute_id="{{ $attribute['id'] }}" href="javascript:void(0)">Inactive</a>
                            @endif
                            &nbsp;&nbsp;
                            <a title="Delete Attribute" href="javascript:void(0)" class="confirmDelete" record="attribute" recordid="{{$attribute['id']}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
              
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Attributes</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <!-- Bordered table end -->
      </div>

    </div>
 </div>
@endsection