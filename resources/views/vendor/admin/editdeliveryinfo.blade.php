@extends('app')

@section('main-content')

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ABOUT-US</h2>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EDIT DELIVERY DETAIL
                            </h2>
                        </div>
                        <div class="body">

                            <form method="POST" id="add_attribute" action="{{ url('/update-delivery-information')  }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="delivery_id" value="{{$delivery_inf['id']}}" id="cat_id_edit">
                                <label class="form-label">Post Code</label>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="hidden"  name="delivery_id" value="{{$delivery_inf['id']}}">
                                        <input type="text" value="{{(isset($delivery_inf['post_code'])) ? $delivery_inf['post_code']:''}}"  name="post_code" required class="form-control">
                                    </div>
                                </div>
                                <label class="form-label">Minimum Order Value</label>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" value="{{(isset($delivery_inf['min_order_val'])) ? $delivery_inf['min_order_val']:''}}" name="min_order_val" required class="form-control">
                                    </div>
                                </div>
                                <label class="form-label">Delivery Charge</label>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" value="{{(isset($delivery_inf['delivery_charge'])) ? $delivery_inf['delivery_charge']:''}}" name="delivery_charge" required class="form-control">
                                    </div>
                                </div>
                                <label class="form-label">Approx Delivery Timing</label>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" value="{{(isset($delivery_inf['aprrox_delivery_time'])) ? $delivery_inf['aprrox_delivery_time']:''}}" name="aprrox_delivery_time" required class="form-control">
                                    </div>
                                </div>



                                <button type="submit"  class="btn btn-primary m-t-15 waves-effect">Update Delivery Details</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->



        </div>
    </section>

@endsection
