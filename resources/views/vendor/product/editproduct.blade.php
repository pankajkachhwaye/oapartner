@extends('app')

@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>EDIT MENU ITEMS</h2>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{$product['product_name']}}
                            </h2>
                        </div>
                        <div class="body">
                            <form method="POST" id="add_attribute" action="{{ url('/product/update-product')  }}">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-sm-6 ">
                                        <label class="form-label">Item Name</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="hidden" value="{{$product['id']}}"
                                                       name="product_id" class="form-control">
                                                <input type="text" value="{{$product['product_name']}}"
                                                       name="product_name" required class="form-control">

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-6 ">
                                        <label class="form-label">Category Name</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" disabled="disabled" name="category_name"
                                                       value="{{$product['category']}}" required=""
                                                       class="form-control">
                                                <input name="cat_id" type="hidden" value="{{$product['cat_id']}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    @if(isset($product['atribute_pricing']))
                                        <div class="col-sm-4">
                                            <label class="form-label">Variant Name</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">

                                                    <input type="text" readonly name="attribute_name"
                                                           value="{{$product['atribute_pricing']['product_attribute_name']}}"
                                                           required="" class="form-control">
                                                    <input type="hidden" name="attribute_pricing_id"
                                                           value="{{$product['atribute_pricing']['id']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label class="form-label">Item Price As Per This Variant</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type='text'
                                                           value="{{$product['atribute_pricing']['product_attribute_price']}}"
                                                           required name='procuctpriceattr' class='form-control'>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label class="form-label">Item Description</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <textarea rows='0' required class='form-control no-resize'
                                                              name='procuctdescription'>{{$product['atribute_pricing']['product_attribute_discription']}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    @else

                                        <div class="col-sm-6">
                                            <label class="form-label">Item Price</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type='text' value="{{$product['product_price']}}" required
                                                           name='procuctprice' class='form-control'>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label">Item Description</label>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <textarea rows='0' required class='form-control no-resize'
                                                              name='procuctdescription'>{{$product['product_description']}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    @endif

                                </div>


                                <div class="row extra_add_form">
                                    @if(count($product['product_extra']) > 0 )
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 removablehook">
                                        <div class="card">
                                            <div class="header bg-blue-grey">
                                                <h2>Extra Items
                                                    <small>Define Extra item related to Above Item</small>
                                                </h2>
                                            </div>
                                            <div class="body remove_optional">
                                                @foreach($product['product_extra'] as $key_extra => $value_extra)
                                                <div class="row clearfix" data-react="{{$value_extra['id']}}">
                                                    <div class="col-sm-5"><label class="form-label">Extra Item
                                                            Name</label>
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" value="{{$value_extra['extra_name']}}" name="extra_item_name[]" class="form-control double-index">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5"><label class="form-label">Extra Item
                                                            Price</label>
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <input type="text" value="{{$value_extra['extra_price']}}" name="extra_item_price[]" class="form-control double-index">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="extra_itm_delete btn bg-red waves-effect">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforeach

                                                <div id="extra_controls" class="row clearfix icon-button-demo text-right" data-trace="{{count($product['product_extra'])}}">
                                                    <input type="hidden" id="item_counter" name="counter_optional" value="{{count($product['product_extra'])}}">
                                                    <button type="button" id="add_extra_item"
                                                            class="btn bg-grey btn-circle waves-effect waves-circle waves-float">
                                                        <i class="material-icons">add</i></button>
                                                    <button type="button" id="remove_extra_item"
                                                            class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float">
                                                        <i class="material-icons">remove</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row text-right button-demo">
                                    <input type="hidden" name="counter_bucket" value="{{count( $product['product_extra']) > 0 ? '1' : '0'}}">
                                    <button type="button"
                                            id="{{count( $product['product_extra']) > 0 ? 'edit_add_extra' : 'add_extra'}}"
                                            class="btn bg-teal waves-effect">Add Item Extra
                                    </button>
                                    <button type="button"
                                            id="{{count( $product['product_extra']) > 0 ? 'edit_remove_extra' : 'remove_extra'}}"
                                            class="btn bg-light-blue waves-effect">Remove Item Extra
                                    </button>
                                </div>


                                <button type="submit" id="submit_pro" class="btn btn-primary m-t-15 waves-effect">
                                    Update Item
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vertical Layout | With Floating Label -->

            {{--<div class="row clearfix">--}}
            {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
            {{--<div class="card">--}}
            {{--<div class="header">--}}
            {{--<h2>--}}
            {{--ALL ATTRIBUTE--}}
            {{--</h2>--}}
            {{--</div>--}}
            {{--<div class="body">--}}

            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}

        </div>
    </section>
    {{--<script src="{{ URL::asset('public/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>--}}
@endsection
