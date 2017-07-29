@extends('app')

@section('main-content')

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>COUPON</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Add New Discount
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" id="add_attribute" action="{{url('/add-new-coupon')}}" novalidate="novalidate">
                                {{csrf_field()}}
                                <label class="form-label">Coupon Code</label>
                                <div class="form-group form-float">
                                    <div class="form-line">

                                        <input type="text" name="coupon_code" required class="form-control">
                                        @if(session('status') && session('status') == 102)
                                        <label id="coupon_code-error" class="error" for="coupon_code">{{session('message')}}</label>
                                         @endif
                                    </div>
                                </div>
                                <label class="form-label">Discount</label>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="discount" required class="form-control">

                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Add Discount</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                All Coupons
                            </h2>
                        </div>
                        <div class="body">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                <tr>

                                    <th>Coupon Code</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($coupons as $key_coupon => $value_coupon)
                                    <tr>

                                        <td>{{$value_coupon['coupon_code']}}</td>
                                        <td>{{$value_coupon['discount']}}</td>
                                        <td>
                                            <button data-react-id="{{$value_coupon['id']}}" data-status="{{$value_coupon['status']}}" type="submit" class="change_coupon_status btn {{ ($value_coupon['status'] == 'active' ? 'bg-blue' : 'bg-brown') }} m-t-15 waves-effect">{{ ($value_coupon['status'] == 'active' ? 'Active' : 'Deactive') }}</button>
                                        </td>
                                        <td>
                                            <button data-react-id="{{$value_coupon['id']}}" type="submit" class="delete_coupon btn btn-warning m-t-15 waves-effect">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
