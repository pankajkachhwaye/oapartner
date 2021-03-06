@extends('app')

@section('main-content')

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ORDERS</h2>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ORDERS HISTORY
                            </h2>
                        </div>
                        <div class="body">
                            <form class="form-inline" method="GET" id="add_attribute" action="{{ url('/order/search-order')  }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="form-label">Start Date</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" value="{{(isset($start_date) && $start_date != '') ? $start_date:''}}" name="start_date" required class="custom-datepicker form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">End Date</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" value="{{(isset($end_date) && $end_date != '') ? $end_date:''}}" name="end_date" class="custom-datepicker form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Search</button>
                                        <a href="{{url('/order/order-history')}}"><button type="button" class="btn btn-info m-t-15 waves-effect">Reset</button></a>
                                    </div>

                                </div>


                            </form>
                            <ul class="list-group">
                                @foreach($orders as $key_ord => $value_ord)
                                    <li class="list-group-item">
                                        {{$value_ord['full_name']}}

                                        <?php
                                        $temp_array = [];
                                        foreach ($value_ord['product_detail'] as $key => $value){
                                            array_push($temp_array,$value['itm_name']);
                                        }
                                        $itm = implode(",",$temp_array);
                                        $string = (strlen($itm) > 50) ? substr($itm,0,45).'...' : $itm;
                                        ?>
                                        <div class="col-md-6">
                                            {{$string}}

                                        </div>


                                        <div class="text-center">
                                            <span class="badge bg-pink">{{ config('app.currency') }}{{$value_ord['total']}}</span>
                                            @if($value_ord['delivery'] == true)
                                                <span class="badge bg-teal">Delivery</span >
                                            @endif
                                            @if($value_ord['collection'] == true)
                                                <span class="badge bg-purple">Collection</span  >
                                            @endif
                                            <a href="javascript:void(0)" data-react="{{$value_ord['id']}}" class="order-details text-right">View Details</a>
                                        </div>
                                    </li>
                                @endforeach


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->



        </div>
    </section>

    {{--<div class="modal" id="order-Modal" tabindex="-1" role="dialog">--}}
        {{--<div class="modal-dialog custom-modal-dialog" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                {{--<h4 class="modal-title" id="defaultModalLabel">Order Detail</h4>--}}
                {{--</div>--}}
                {{--<div class="row clearfix" id="orderDetails">--}}
                    {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                        {{--<div class="card">--}}
                            {{--<div class="header">--}}
                                {{--<div class="row clearfix">--}}
                                    {{--<div class="col-xs-12 col-sm-6">--}}
                                        {{--<h3>Order Details</h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="body">--}}
                                {{--<div class="row clearfix">--}}
                                    {{--<div class="col-md-6 clearfix">--}}
                                        {{--<h4>User Detail</h4>--}}
                                        {{--<li class="list-group-item">--}}
                                            {{--<span >Full Name : </span>--}}
                                            {{--<span id="userName" style="margin-left: 15px"></span>--}}
                                        {{--</li>--}}
                                        {{--<li class="list-group-item">--}}
                                            {{--<span >Contact No. : </span>--}}
                                            {{--<span id="contact_no" style="margin-left: 15px"></span>--}}
                                        {{--</li>--}}
                                        {{--<li class="list-group-item">--}}
                                            {{--<span>Email : </span>--}}
                                            {{--<span id="userEmail" style="margin-left: 15px"></span>--}}
                                        {{--</li>--}}
                                        {{--<li class="list-group-item">--}}
                                            {{--<span >Delivery Post Code :</span>--}}
                                            {{--<span id="deliveryPost" style="margin-left: 15px"></span>--}}
                                        {{--</li>--}}
                                        {{--<li class="list-group-item">--}}
                                            {{--<span >Address Line 1 :</span>--}}
                                            {{--<span id="address1" style="margin-left: 15px"></span>--}}
                                        {{--</li>--}}
                                        {{--<li class="list-group-item">--}}
                                            {{--<span >Address Line 2 :</span>--}}
                                            {{--<span id="address2" style="margin-left: 15px"></span>--}}
                                        {{--</li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-6 clearfix">--}}
                                        {{--<h4>Other Detail</h4>--}}
                                        {{--<ul class="list-group">--}}
                                            {{--<li class="list-group-item">--}}

                                                {{--<span style="">Delivery : </span>--}}
                                                {{--<span id="delivery" style="margin-left: 15px"></span>--}}
                                            {{--</li>--}}
                                            {{--<li class="list-group-item">--}}

                                                {{--<span style="">Collection : </span>--}}
                                                {{--<span id="collection" style="margin-left: 15px">No</span>--}}
                                            {{--</li>--}}
                                            {{--<li class="list-group-item">--}}

                                                {{--<span style="">Request Delivery Time : </span>--}}
                                                {{--<span id="reqDelevTime" style="margin-left: 15px"></span>--}}
                                            {{--</li>--}}
                                            {{--<li class="list-group-item">--}}
                                                {{--<span >Instruction :</span>--}}
                                                {{--<span id="instruction" style="margin-left: 15px"></span>--}}
                                            {{--</li>--}}
                                            {{--<li class="list-group-item">--}}
                                                {{--<span >Discount Code :</span>--}}
                                                {{--<span id="discountCode" style="margin-left: 15px"></span>--}}
                                            {{--</li>--}}
                                            {{--<li class="list-group-item">--}}
                                                {{--<span >Order Timing :</span>--}}
                                                {{--<span id="orderTiming" style="margin-left: 15px"></span>--}}
                                            {{--</li>--}}
                                            {{--<li class="list-group-item">--}}
                                                {{--<span >Status :</span>--}}
                                                {{--<span id="status" style="margin-left: 15px"></span>--}}
                                            {{--</li>--}}

                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="row clearfix">--}}
                                    {{--<h4 style="margin-left: 20px">User Order</h4>--}}
                                    {{--<ul class="list-group" id="userOrder">--}}

                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                {{--<div class="col-md-12">--}}
                {{--<h4>User Deatail</h4>--}}
                {{--</div>--}}


                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" id="printOrder" class="btn btn-info waves-effect">Print</button>--}}
                    {{--<button type="button" class="btn btn-success waves-effect">Confirmed</button>--}}
                    {{--<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="modal" id="order-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog custom-modal-dialog" role="document">
            <div class="modal-content">
                {{--<div class="modal-header">--}}
                {{--<h4 class="modal-title" id="defaultModalLabel">Order Detail</h4>--}}
                {{--</div>--}}
                <div class="row clearfix" id="orderDetails">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="header">
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-6">
                                        <h3>Order Details</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-md-6 clearfix">
                                        <h4>User Detail</h4>
                                        <li class="list-group-item">
                                            <span >Full Name : </span>
                                            <input type="hidden" value="" id="orderId">
                                            <span id="userName" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span >Contact No. : </span>
                                            <span id="contact_no" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span>Email : </span>
                                            <span id="userEmail" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span >Delivery Post Code :</span>
                                            <span id="deliveryPost" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span >Address Line 1 :</span>
                                            <span id="address1" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span >Address Line 2 :</span>
                                            <span id="address2" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span >Transcation ID :</span>
                                            <span id="transcation_id" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span >Customer Key :</span>
                                            <span id="your_customer_key" style="margin-left: 15px"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span >Name Of Card :</span>
                                            <span id="name_of_card" style="margin-left: 15px"></span>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 clearfix">
                                        <h4>Other Detail</h4>
                                        <ul class="list-group">
                                            <li class="list-group-item">

                                                <span style="">Delivery : </span>
                                                <span id="delivery" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">

                                                <span style="">Collection : </span>
                                                <span id="collection" style="margin-left: 15px">No</span>
                                            </li>
                                            <li class="list-group-item">

                                                <span style="">Request Delivery Time : </span>
                                                <span id="reqDelevTime" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >Instruction :</span>
                                                <span id="instruction" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >Discount Code :</span>
                                                <span id="discountCode" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >Order Timing :</span>
                                                <span id="orderTiming" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >Status :</span>
                                                <span id="status" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >Billing Post Code :</span>
                                                <span id="billing_post_code" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >Billing Address :</span>
                                                <span id="billing_address" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >COD :</span>
                                                <span id="cod" style="margin-left: 15px"></span>
                                            </li>
                                            <li class="list-group-item">
                                                <span >Order Delayed :</span>
                                                <span id="delayed_this_order" style="margin-left: 15px"></span>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <h4 style="margin-left: 20px">User Order</h4>
                                    <ul class="list-group" id="userOrder">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="modal-body">--}}
                {{--<div class="col-md-12">--}}
                {{--<h4>User Deatail</h4>--}}
                {{--</div>--}}


                {{--</div>--}}
                <div class="modal-footer">
                    <div class="confirm-loading">
                        <div class="preloader pl-size-xs" >
                            <div class="spinner-layer pl-red-grey">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="printOrder" class="btn btn-info waves-effect">Print</button>
                    {{--<button type="button" id="confirmOrder" class="btn btn-success waves-effect">Confirmed</button>--}}
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
@endsection
