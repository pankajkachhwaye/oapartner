@extends('app')

@section('main-content')

<section class="content">
        <div class="loading-custom preloader pl-size-xs">
            <div class="spinner-layer pl-red-grey">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>

    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>

        <!-- Widgets -->
  
        <!-- #END# Widgets -->
        <!-- CPU Usage -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-6">
                                <h2>Current Pending Orders</h2>
                            </div>
                            <div class="col-xs-12 col-sm-6 align-right">
                                <div class="switch panel-switch-btn">
                                    <span class="m-r-10 font-12">Restaurant Open/Close</span>
                                    <label>OFF<input type="checkbox" id="realtime" checked><span class="lever switch-col-cyan"></span>ON</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body">

                            <ul class="list-group">
                                @foreach($orders as $key_ord => $value_ord)
                                    <li class="list-group-item">
                                            <?php
                                            $temp_array = [];
                                            foreach ($value_ord['product_detail'] as $key => $value){
                                                array_push($temp_array,$value['itm_name']);
                                          }
                                            $itm = implode(",",$temp_array);

                                        ?>
                                        <div class="col-md-6">
                                            {{$itm}}
                                            <span class="badge bg-pink">{{$value_ord['total']}}</span>
                                        </div>


                                                <div class="text-center">
                                                    <a href="javascript:void(0)" data-react="{{$value_ord['id']}}" class="order-details text-right">View Details</a>
                                                </div>
                                    </li>
                                @endforeach


                            </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal" id="order-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>



</section>

    @endsection
