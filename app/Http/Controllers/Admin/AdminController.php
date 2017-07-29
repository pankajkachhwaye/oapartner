<?php

namespace App\Http\Controllers\Admin;

use App\Http\Repository\CrudRepository;
use App\Http\Repository\CategoryRepository;
use App\Models\AddressModel;
use App\Models\CouponModel;
use App\Models\DeliveryInformationModel;
use App\Models\DiscountModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\BucketProductModel;
use App\Models\TimingModel;
use App\Models\TranscationModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Response;
use App\Models\CategoryAttributeModel;
use App\Models\CategoryModel;
use App\Models\CustomerModel;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page = 'dashboard';
        $temp_orders = OrderModel::GetPendingOrder()->orderBy('created_at','desc')->get()->toArray();
        $orders = [];
        foreach ($temp_orders as $key_ord => $value_ord){
            $product_detail = json_decode($value_ord['product_detail'],true);
            unset($value_ord['product_detail']);
            $value_ord['product_detail'] = $product_detail;
            array_push($orders,$value_ord);
        }
        //dd($orders);
        return view('vendor.admin.dashboard', compact('page','orders'));
    }

    /**
     * Show the application About Us Information.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function aboutUs()
    {
        $timing = TimingModel::all()->toArray();
        $address = AddressModel::all()->toArray();
        $delivery = DeliveryInformationModel::all()->toArray();
        $transcation = TranscationModel::all()->toArray();
        $page = 'aboutus';

        return view('vendor.admin.aboutus', compact('page', 'timing', 'address','delivery','transcation'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show all Category
     */
    public function categoryIndex()
    {
        // $cateAttribute = CategoryAttributeModel::all()->toArray();
        $page = 'categories';
        $sub_page = 'add-category';
        return view('vendor.category.category', compact('page', 'sub_page'));
    }

    /**
     * @param Request $req
     * @param CrudRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     * Add new Category
     */
    public function categoryAdd(Request $req, CategoryRepository $repo)
    {
        if ($repo->createNew($req->all(), new CategoryModel()))
            return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Category Added successfully');

    }

    /**
     * view all Category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewCategory()
    {
        $page = 'categories';
        $sub_page = 'view-category';
        $category = CategoryModel::all()->toArray();
        return view('vendor.category.viewcategory', compact('category', 'page', 'sub_page'));
    }

    /**
     * Edit Category View.
     * @param $cat_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCategoryView($cat_id){
        $page = 'categories';
        $sub_page = 'view-category';
        $temp_cat = CategoryModel::GetCategoryById($cat_id)->get();
        $category = $temp_cat[0]->toArray();
        $cate_attri = $temp_cat[0]->categoryAttributes()->get()->toArray();
            if(count($cate_attri) > 0)
                $category['category_attribute'] = $cate_attri;

           // dd($category);

             return view('vendor.category.editcategory', compact('category', 'page', 'sub_page'));
    }

    /**
     * @param Request $req
     * @param CategoryRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editedCategoryPost(Request $req, CategoryRepository $repo){
          if($repo->updateCategory($req->all())){
              return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Category Updated successfully');
          }
    }
    /**
     * View category product
     * @param $buk_id
     * @param $cat_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewCategoryProducts($buk_id,$cat_id){
        $page = 'categories';
        $sub_page = 'view-category';
        $products = [];
        if($buk_id == 0){
            $data = ProductModel::ProductsByCategory($cat_id)->get();
            foreach ($data as $key_pro => $value_pro){
                $temp_pro = $value_pro->toArray();
                $temp_pro['category'] = $value_pro->productCategory->category_name;
                $pro_attr = $value_pro->productAttributePricing()->get()->toArray();
                if(count($pro_attr) > 0){
                    $temp_pro['product_attr_pricing'] = $pro_attr;
                }
                array_push($products,$temp_pro);
                }
            }
        else{

            $buc_pro = BucketProductModel::BuckProByCategory($cat_id)->get();
            foreach ($buc_pro as $key_bukpro => $value_bukpro){
                $pushitm = $value_bukpro->toArray();
                $pushitm['category'] = $value_bukpro->productCategory->category_name;
                $buk_itm = $value_bukpro->relatedProducts()->get();
                $pushitm['items'] = $value_bukpro->relatedProducts()->get()->toArray();

                foreach ($buk_itm as $key_itm => $value_itm) {
                    $pushitm['items'][$key_itm]['related_items'] = $value_itm->itemRelatedProducts()->get()->toArray();

                }


                array_push($products,$pushitm);
            }

        }

        if(count($products) > 0){
            return view('vendor.category.catrgoryproduct',compact('page','sub_page','products','buk_id'));
        }
        else{
            return back()->with('returnStatus', true)->with('status', 101)->with('message', 'No item found in this category');
        }
    }

    /**
     * Update Timing
     * @param Request $req
     * @param CrudRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTiming(Request $req, CrudRepository $repo)
    {
        if ($repo->updateTiming($req->all())) {
            return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Timing Update successfully');
        }
    }

    /**
     * Update Contact Information.
     * @param Request $req
     * @param CrudRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateContact(Request $req, CrudRepository $repo)
    {
       if($repo->updateAboutContact($req->all())){
           return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Contact Information Update successfully');
       }
    }

    /**
     * Add new Delivery.
     * @param Request $req
     * @param CrudRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addDeliveryInformation(Request $req, CrudRepository $repo){
        if ($repo->createNewDelivery($req->all())){
            return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Delivey added successfully');
        }
    }

    /**
     * Edit Delivery Details
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editDeliveryInfo($id){
        $delivery_inf = DeliveryInformationModel::find($id)->toArray();
        $page = 'aboutus';
        return view('vendor.admin.editdeliveryinfo',compact('delivery_inf','page'));
    }

    /**
     * Update Delivery Details
     * @param Request $req
     * @param CrudRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateDeliveryInfo(Request $req, CrudRepository $repo){
        $save =   $repo->updateDeliveryInfo($req->all());
        if($save['code'] == 101){
            return redirect('about-us')->with('returnStatus', true)->with('status', 101)->with('message',$save['message']);
        }
    }

    /**
     * Delete Delivery Detail.
     * @param $id
     * @return mixed
     */
    public function deleteDeliveryInfo($id){
        try{

            $delivery = DeliveryInformationModel::find($id);
            $delete = $delivery->delete();
            return Response::json(['status'=>true,'message'=>'Delivery Details Delete Successfully']);
        }
        catch (\Exception $exception){
            return Response::json(['status'=>false,'message'=>$exception->getMessage()]);
        }
    }

    /*
     * Update Transcation Fees
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateTranscationFees(Request $req, CrudRepository $repo){
        $save = $repo->updateTranscationFee($req->all());
        if($save['code'] == 101){
            return back()->with('returnStatus', true)->with('status', 101)->with('message',$save['message']);
        }
    }

    /**
     * Discounts
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function discount(){
        $discount = DiscountModel::all()->toArray();
        $page ='discount';
        return view('vendor.admin.discount',compact('page','discount'));
    }

    /**
     * Add New Discount
     * @param Request $req
     * @param CrudRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addNewDiscount(Request $req,CrudRepository $repo){
        if ($repo->updateDiscount($req->all()))
            return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Discount Update successfully');
    }

    /**
     * Coupons
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function coupon(){
        $page = 'coupon';
        $coupons = CouponModel::all()->toArray();
        return view('vendor.admin.coupon',compact('page','coupons'));
    }

    /**
     * Add New Coupon
     * @param Request $req
     * @param CrudRepository $repo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addNewCoupon(Request $req,CrudRepository $repo){
        if(strlen($req->coupon_code) != 5)
            return back()->with('returnStatus', true)->with('status', 102)->with('message', 'Coupon Code should only be 5 characters');

        $save = $repo->addCoupon($req->all());

        if($save['code'] == 101)
            return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Coupon Added successfully');

        if($save['code'] == 503)
            return back()->with('returnStatus', true)->with('status', 101)->with('message', 'Already Exist Coupon it should be Unique');
    }

    /**
     * Delete Coupon
     * @param $id
     * @return mixed
     */
    public function deleteCoupon($id){
        try{

            $coupon = CouponModel::find($id);
            $delete = $coupon->delete();
            return Response::json(['status'=>true,'message'=>'Coupon Delete Successfully']);
        }
        catch (\Exception $exception){
            return Response::json(['status'=>false,'message'=>$exception->getMessage()]);
        }
    }


    public function changeCouponStatus($id,$status){
        try{

            $coupon = CouponModel::find($id);
            if($status == 'active')
                $coupon->status = 'deactive';

            if($status == 'deactive')
                $coupon->status = 'active';

                $coupon->save();

            return Response::json(['status'=>true,'message'=>'Coupon Status Successfully']);
        }
        catch (\Exception $exception){
            return Response::json(['status'=>false,'message'=>$exception->getMessage()]);
        }
    }

    /**
     * View All Customer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewCustomer(){
        $page = 'customer';
        $customer = CustomerModel::all()->toArray();
        return view('vendor.admin.viewcustomer',compact('page','customer'));
    }

    /**
     * Customer order
     * @param $cust_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewCustomerOrder($cust_id){
        $page = 'customer';
        $tem_orders =  CustomerModel::find($cust_id)->customerOrders()->get()->toArray();
        $orders = [];
        foreach ($tem_orders as $key_ord => $value_ord){
            $product_detail = json_decode($value_ord['product_detail'],true);
            $value_ord['product_detail'] = $product_detail;
            array_push($orders,$value_ord);
        }

        return view('vendor.admin.customerorder',compact('page','orders'));
    }
}
