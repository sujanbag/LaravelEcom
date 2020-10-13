@extends('layouts.admin_layout.admin_layout')
@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-dark">Order  {{$orderDetails->id}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
            {{Session::get('success_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-6">
            
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Order Details</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
        
                            <tbody>
                                <tr>
                                <td><span class="badge badge-warning">Order Date</span></td>
                                <td><span class="badge badge-success">{{$orderDetails->created_at}}</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-warning">Order Status</span></td>
                                    <td><span class="badge badge-success">{{$orderDetails->order_status}}</span></td>
                                </tr>
                                <tr>
                                <td><span class="badge badge-warning">Order Total</span></td>
                                <td><span class="badge badge-success">{{$orderDetails->grand_total}}</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-warning">Shipping Charges</span></td>
                                    <td><span class="badge badge-success">{{$orderDetails->shipping_charges}}</span></td>
                                </tr>
                                <tr>
                                <td><span class="badge badge-warning">Coupon Code</span></td>
                                <td><span class="badge badge-success">{{$orderDetails->coupon_code}}</span></td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-warning">Coupon Amount</span></td>
                                    <td><span class="badge badge-success">{{$orderDetails->coupon_amount}}</span></td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    
                </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header border-transparent">
                    <h3 class="card-title">Customer Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                        <td><span class="badge badge-warning">Customer Name</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->name}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Customer Email</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->user_email}}</span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border-transparent">
                    <h3 class="card-title">Update Order Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        {{--<div class="table-responsive">
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                        <td><span class="badge badge-warning">Customer Name</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->name}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Customer Email</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->user_email}}</span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>--}}
                        <form action="{{url('admin/update-order-status')}}" method="post">@csrf
                            <input type="hidden" name="order_id" value="{{$orderDetails->id}}">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <select name="order_status" id="order_status" class="form-control form-control-lg" required>
                                            <option value="" selected="">Select</option>
                                            <option value="New" @if($orderDetails->order_status=="New") selected @endif>New</option>
                                            <option value="Pending" @if($orderDetails->order_status=="Pending") selected @endif>Pending</option>
                                            <option value="Canceled" @if($orderDetails->order_status=="Canceled") selected @endif>Canceled</option>
                                            <option value="In Process" @if($orderDetails->order_status=="In Process") selected @endif>In Process</option>
                                            <option value="Shipped" @if($orderDetails->order_status=="Shipped") selected @endif>Shipped</option>
                                            <option value="Delivered" @if($orderDetails->order_status=="Delivered") selected @endif>Delivered</option>
                                            <option value="Paid" @if($orderDetails->order_status=="Paid") selected @endif>Paid</option>

                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" value="Update Status">
                                    </td>
                                </tr>
                                
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">          
            <div class="col-md-6">
            
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Billing Address</h3>
                    </div>
                
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                    <td><span class="badge badge-warning">Name</span></td>
                                    <td><span class="badge badge-success">{{$userDetails->name}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Address</span></td>
                                        <td><span class="badge badge-success">{{$userDetails->address}}</span></td>
                                    </tr>
                                    <tr>
                                    <td><span class="badge badge-warning">City</span></td>
                                    <td><span class="badge badge-success">{{$userDetails->city}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">State</span></td>
                                        <td><span class="badge badge-success">{{$userDetails->state}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Pincode</span></td>
                                        <td><span class="badge badge-success">{{$userDetails->pincode}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Mobile No</span></td>
                                        <td><span class="badge badge-success">{{$userDetails->mobile}}</span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                </div>
            
            </div>
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Shipping Address</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                        <td><span class="badge badge-warning">Name</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->name}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Address</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->address}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">City</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->city}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">State</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->state}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Pincode</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->pincode}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge badge-warning">Mobile No</span></td>
                                        <td><span class="badge badge-success">{{$orderDetails->mobile}}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
    <section id="do_action">
        <div class="content-body">
            <!-- Bordered table start -->
            <div class="row">
              <div class="col-12">
                @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                    {{Session::get('success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Users table</h4>
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
                    
                    <div class="table-responsive">
                      <table class="table table-bordered mb-0">
                        <thead>
                          <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Price</th>
                            <th>Product Qty</th>
                            
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($orderDetails->orders as $pro)
                          <tr>
                            <th scope="row">{{ $pro->product_code }}</th>
                            <td>{{$pro->product_name}}</td>
                            <td>{{$pro->product_size}}</td>
                            <td>{{$pro->product_price}}</td>
                            <td>{{$pro->product_qty}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <!-- Bordered table end -->
          </div>
    </section>
  </div>


@endsection