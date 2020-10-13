@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top:20px;"><!--form-->
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Check Out</li>
            </ol>
        </div>
        @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <strong>{!! session('flash_message_success')!!}</strong>
            </div>
            @endif
            @if(Session::has('flash_message_error'))
            <div class="alert alert-warning alert-block" style="background-color:#f2d6d0">
                
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <strong>{!! session('flash_message_error')!!}</strong>
            </div>
            @endif
        <form action="{{url('/checkout')}}" method="post">@csrf
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Bill To</h2>
                    
                        
                        <div class="form-group"><input name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{$userDetails->name}}" @endif type="text" class="form-control" placeholder="Billing Name" /></div>
                        <div class="form-group"><input name="billing_address" id="billing_address" @if(!empty($userDetails->address)) value="{{$userDetails->address}}" @endif type="text" class="form-control" placeholder="Billing Address" /></div>
                        <div class="form-group"><input name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{$userDetails->city}}" @endif type="text" class="form-control" placeholder="Billing City" /></div>
                        <div class="form-group"><input name="billing_state" id="billing_state" @if(!empty($userDetails->state))  value="{{$userDetails->state}}" @endif type="text" class="form-control" placeholder="Billing State" /></div>
                        <div class="form-group"><input name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->pincode))  value="{{$userDetails->pincode}}" @endif type="text" class="form-control" placeholder="Billing Pincode" /></div>
                        <div class="form-group"><input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile))  value="{{$userDetails->mobile}}" @endif type="text" class="form-control" placeholder="Billing Mobile" /></div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="billtoship">
                            <label class="form-check-label" for="billtoship">Shipping Address Same as Billing Address</label>
                        </div>

                        
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Ship To</h2>
                    
                    <div class="form-group"><input @if(!empty($shippingDetails->name)) value="{{$shippingDetails->name}}" @endif name="shipping_name" id="shipping_name" type="text" class="form-control" placeholder="Shipping Name" /></div>
                    <div class="form-group"><input @if(!empty($shippingDetails->address)) value="{{$shippingDetails->address}}" @endif name="shipping_address" id="shipping_address" type="text" class="form-control" placeholder="Shipping Address" /></div>
                    <div class="form-group"><input @if(!empty($shippingDetails->city)) value="{{$shippingDetails->city}}" @endif name="shipping_city" id="shipping_city" type="text" class="form-control" placeholder="Shipping City" /></div>
                    <div class="form-group"><input @if(!empty($shippingDetails->state)) value="{{$shippingDetails->state}}" @endif name="shipping_state" id="shipping_state" type="text" class="form-control" placeholder="Shipping State" /></div>
                    <div class="form-group"><input @if(!empty($shippingDetails->pincode)) value="{{$shippingDetails->pincode}}" @endif name="shipping_pincode" id="shipping_pincode" type="text" class="form-control" placeholder="Shipping Pincode" /></div>
                    <div class="form-group"><input @if(!empty($shippingDetails->mobile)) value="{{$shippingDetails->mobile}}" @endif name="shipping_mobile" id="shipping_mobile" type="text" class="form-control" placeholder="Shipping Mobile" /></div>
                    <button type="submit" class="btn btn-success">Checkout</button>
                    
                </div><!--/sign up form-->
            </div>
        </div>
        </form>
    </div>
</section><!--/form-->



@endsection