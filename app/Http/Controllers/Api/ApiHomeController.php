<?php

namespace App\Http\Controllers\Api;

use App\Models\AddressModel;
use App\Models\AdminDetailsModel;
use App\Models\BucketProductModel;
use App\Models\CouponModel;
use App\Models\DeliveryInformationModel;
use App\Models\DiscountModel;
use App\Models\ProductModel;
use App\Models\TimingModel;
use App\Models\OrderModel;
use App\Models\CustomerModel;
use App\Models\TranscationModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderAppOrderConfirmed;
use App\Http\Facades\Timing;

class ApiHomeController extends Controller
{

    /**
     * All Categories
     * @return mixed
     */
    public function allCategories(){

         $status =  Timing::getRestaurantStatus();

        $datacategory = CategoryModel::all()->toArray();
        if(count($datacategory) > 0){
        	$data = [
                'status' => true,
                'message'=>'Data Found',
                'restaurant_open' => $status,
                'data'=>$datacategory

            ];
        }
        else{
        	$data = [
                'status' => false,
                'message'=>'Data Found',
                'restaurant_open' => $status,
                'data'=>$datacategory

            ];
        }
           return Response::json($data);
    }


    /**
     * Products By Categories
     * @param Request $request
     * @return mixed
     */
    public function productByCategory(Request $request){
        $status =  Timing::getRestaurantStatus();
        $buk_id = $request->input('bucket_cat');
        $cat_id = $request->input('cat_id');

        if($buk_id == 1){
            $buc_pro = BucketProductModel::BuckProByCategory($cat_id)->get();
            //dd($buc_pro);
            $products = [];
               foreach ($buc_pro as $key_bukpro => $value_bukpro){
                   $pushitm = $value_bukpro->toArray();
                   $buk_itm = $value_bukpro->relatedProducts()->get();
                   $pushitm['items'] = $value_bukpro->relatedProducts()->get()->toArray();

                       foreach ($buk_itm as $key_itm => $value_itm) {
                           $pushitm['items'][$key_itm]['related_items'] = $value_itm->itemRelatedProducts()->get()->toArray();

                       }


                array_push($products,$pushitm);
                }
        }
        else{
           // dd('into');
            $products = [];
            $data = ProductModel::ProductsByCategory($cat_id)->get();

            foreach ($data as $key_data => $value_data){
                $temp_pro = $value_data->toArray();
                $temp_pro['attribute_pricing'] =  $value_data->productAttributePricing()->get()->toArray();
                $temp_pro['item_extras'] =  $value_data->productExtras()->get()->toArray();
                array_push($products,$temp_pro);
            }

        }

        if(count($products) > 0){
        	$data = [
                'status' => true,
                'message'=>'Data Found',
                'restaurant_open' => $status,
                'data'=>$products
            ];
        }
        else{
        	$data = [
                'status' => false,
                'message'=>'Data Found',
                'restaurant_open' => $status,
                'data'=>$products
            ];
        }

        return Response::json($data);
    }

    /**
     * About Us
     * @return mixed
     */
    public function aboutUsInfo(){
        $address = AddressModel::all()->toArray();
        $address[0]['latitude'] = 51.5199;
        $address[0]['longitude'] = -.0917;
        $post_info = DeliveryInformationModel::all()->toArray();
        $timing = TimingModel::all()->toArray();
        $discount = DiscountModel::all()->toArray();
        $trascation_fee = TranscationModel::all()->toArray();


        $returnArray =[
            'address_contact_no'=>$address,
            'delivery_info'=>$post_info,
            'opening_closing_time'=>$timing,
            'delivery_time'=> 45,
            'collection_time'=> 15,
            'discount'=> (string)$discount[0]['discount'],
            'currency_code'=>'\u00A3',
            'transcation_fee' => $trascation_fee[0]['transcation_fee']
        ];

        if(count($returnArray) > 0){
            $data = [
                'status' => true,
                'message'=>'Data Found',
                'data'=>$returnArray
            ];
        }
        else{
            $data = [
                'status' => false,
                'message'=>'Data Not Found',
                'data'=>$returnArray
            ];
        }

        return Response::json($data);
    }

    /**
     * Place New Order
     * @param Request $request
     * @return mixed
     */
    public function newOrder(Request $request){

        try{

            $data = Input::all();
            $temp_data = json_encode($data);

            Storage::append('newfile.txt', $temp_data);


        $customer = CustomerModel::whereEmail($data['email'])->first();
       // dd($customer);

           if($customer == null){
               $customerArray = [
                   'customer_name'=>$data['full_name'],
                   'email'=>$data['email'],
                   'customer_mobile'=>$data['phone_no'],
                   'created_at'=>Carbon::now(),
               ];

               $customer_id = CustomerModel::insertGetId($customerArray);
           }
           else{
               $customer_id = $customer->id;
           }
      

        $pro_detail_tem = $data['product_detail'];

        unset($data['product_detail']);
        $pro_detail = json_encode($pro_detail_tem);
        $data['product_detail'] =$pro_detail;
        $data['created_at'] = Carbon::now();
         $data['customer_id'] = $customer_id;

       
        $insert = OrderModel::insert($data);
        $return_array = [
            'status'=>true,
            'message'=>'Order Added successfully'
        ];
        return Response::json($return_array);
          }
        catch(\Exception $ex)
        {
            return Response::json(['status'=>false,'message'=>$ex->getMessage()]);
        }


    }


    /**
     * All Pending Order
     * @return mixed
     */
    public function pendingOrders(Request $request){
        $temp_data =  $request->all();
        $updateArray = [
            'admin_email' =>$temp_data['admin_email'],
            'device_token' =>$temp_data['device_token'],
            'updated_at' => Carbon::now()
        ];

        $update = AdminDetailsModel::where('admin_email',$temp_data['admin_email'])->update($updateArray);


        $temp_orders = OrderModel::AllPendingOrders()->orderBy('created_at','desc')->get()->toArray();
        $orders = [];
        foreach ($temp_orders as $key_ord => $value_ord){
            $product_detail = json_decode($value_ord['product_detail'],true);
            unset($value_ord['product_detail']);
            $value_ord['product_detail'] = $product_detail;
            array_push($orders,$value_ord);
        }
        $admin_detail = AdminDetailsModel::where('admin_email',$temp_data['admin_email'])->first();
        if(count($orders) > 0){
            $data = [
                'status' => true,
                'message'=>'Data Found',
                'admin_details' => $admin_detail,
                'data'=>$orders

            ];
        }
        else{
            $data = [
                'status' => false,
                'message'=>'Data Not Found',
                'admin_details' => $admin_detail,
                'data'=>$orders

            ];
        }
        return Response::json($data);
    }

    /**
     * All Confirme
     * @return mixed
     */
    public function getAllconfirmedOrders(){
        $temp_orders = OrderModel::AllConfirmedOrders()->orderBy('created_at','desc')->get()->toArray();
        $orders = [];
        foreach ($temp_orders as $key_ord => $value_ord){
            $product_detail = json_decode($value_ord['product_detail'],true);
            unset($value_ord['product_detail']);
            $value_ord['product_detail'] = $product_detail;
            array_push($orders,$value_ord);
        }
        if(count($orders) > 0){
            $data = [
                'status' => true,
                'message'=>'Data Found',
                'data'=>$orders
            ];
        }
        else{
            $data = [
                'status' => false,
                'message'=>'Data Not Found',
                'data'=>$orders
            ];
        }
        return Response::json($data);
    }


    public function confirmOrder(Request $request){
        $data = $request->all();
        $order = OrderModel::find($data['id']);
        if($data != ''){
            $order->delayed_this_order = $data['any_delayed'];
        }
        $order->status = 'confirmed';
        $order->updated_at = Carbon::now();
        $order->save();
        $order_detail = $order->toArray();
        $product_detail = json_decode($order_detail['product_detail'],true);
        $order_detail['product_detail'] = $product_detail;
        Mail::to($order->email)->send(new OrderAppOrderConfirmed($order_detail));

        if(count(Mail::failures()) == 0){
            $data = [
                'status'=> true,
                'message'=> 'Order confirmed Successfully'
            ];
        }
        else{
            $data = [
                'status'=> false,
                'message'=> 'Internal Server Error'
            ];
        }
        return Response::json($data);
    }

    public function getCoupon(Request $request){
        $data = $request->all();

        $coupon = CouponModel::GetCouponByName($data['coupon_code'])->first();
        if($coupon == null){
            $data = [
                'status'=> false,
                'message'=> 'Coupon Not Found'
            ];
        }
        else{
            $x = $coupon->toArray();
            $data = [
                'status'=> true,
                'message'=> 'Coupon Found',
                'data' => $x
            ];
        }


        return Response::json($data);
    }

}
