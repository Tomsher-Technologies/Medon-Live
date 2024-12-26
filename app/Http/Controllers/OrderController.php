<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\OTPVerificationController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClubPointController;
use App\Models\Order;
use App\Models\Shops;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\CommissionHistory;
use App\Models\Color;
use App\Models\OrderDetail;
use App\Models\CouponUsage;
use App\Models\Coupon;
use App\Models\OrderDeliveryBoys;
use App\OtpConfiguration;
use App\Models\User;
use App\Models\BusinessSetting;
use App\Models\CombinedOrder;
use App\Models\SmsTemplate;
use App\Models\Wallets;
use App\Models\OrderTracking;
use App\Models\RefundRequest;
use App\Models\ShopNotifications;
use App\Models\LiveLocations;
use Auth;
use Session;
use DB;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Utility\NotificationUtility;
use App\Mail\Admin\OrderAssign;
use App\Mail\Admin\ReturnAssign;
// use CoreComponentRepository;
use App\Utility\SmsUtility;
use App\Utility\SendSMSUtility;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderReturnRequest;
use App\Notifications\OrderCancelRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            //->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('seller_id', Auth::user()->id)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = \App\Models\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }

        return view('frontend.user.seller.orders', compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }

    // All Orders
    public function all_orders(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();
        $request->session()->put('last_url', url()->full());

        $shop_search    = ($request->has('shop_search')) ? $request->shop_search : '';
        
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = Order::where('order_success', 1)->orderBy('id', 'desc');
        if(Auth::user()->user_type == 'staff' && Auth::user()->shop_id != NULL){
            $orders->where('shop_id', Auth::user()->shop_id);
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($shop_search) {
            $orders = $orders->where('shop_id', $shop_search);
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        $orders = $orders->paginate(15);
        return view('backend.sales.all_orders.index', compact('orders', 'sort_search', 'delivery_status', 'date','shop_search'));
    }

    public function all_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));

        return view('backend.sales.all_orders.show', compact('order'));
    }

    public function return_orders_show($id)
    {
        $order = RefundRequest::with(['order'])->findOrFail(decrypt($id));
        return view('backend.sales.return_orders_show', compact('order'));
    }

    public function cancel_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        return view('backend.sales.cancel_orders_show', compact('order'));
    }


     // All Orders
     public function allReturnRequests(Request $request)
     {
        $request->session()->put('last_url', url()->full());
        $date           = ($request->has('date')) ? $request->date : ''; //
        $search         = ($request->has('search')) ? $request->search : '';
        $shop_search    = ($request->has('shop_search')) ? $request->shop_search : '';
        $ra_search      = ($request->has('ra_search')) ? $request->ra_search : '';
        $da_search      = ($request->has('da_search')) ? $request->da_search : '';
        $refund_search  = ($request->has('refund_search')) ? $request->refund_search : '';
        $agent_search   = ($request->has('agent_search')) ? $request->agent_search : '';
        $sort_search = null;
        
        $orders = RefundRequest::with(['order'])->orderBy('id', 'desc');

        if(Auth::user()->user_type == 'staff' && Auth::user()->shop_id != NULL){
            $orders->where('shop_id', Auth::user()->shop_id);
        }
         if ($search) {
            $orders = $orders->whereHas('order', function ($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%');
            });
         }

        if ($shop_search) {
            $orders = $orders->where('shop_id', $shop_search);
        }

        if ($agent_search) {
            $orders = $orders->where('delivery_boy', $agent_search);
        }

        if ($ra_search) {
            $ra_search = ($ra_search == 10) ? 0 : $ra_search;
            $orders = $orders->where('admin_approval', $ra_search);
        }

        if ($da_search) {
            $da_search = ($da_search == 10) ? 0 : $da_search;
            $orders = $orders->where('delivery_approval', $da_search);
        }

        if ($refund_search) {
            $orders = $orders->where('refund_type', $refund_search);
        }
         
        if ($date != null) {
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
         $orders = $orders->paginate(15);
         return view('backend.sales.return_requests', compact('orders', 'search','shop_search','ra_search','da_search','refund_search','date','agent_search'));
     }

     public function allCancelRequests(Request $request){
        $request->session()->put('last_url', url()->full());
        $search         = ($request->has('search')) ? $request->search : '';
        $ca_search      = ($request->has('ca_search')) ? $request->ca_search : '';
        $date           = ($request->has('date')) ? $request->date : ''; //
        $refund_search  = ($request->has('refund_search')) ? $request->refund_search : '';

        $orders = Order::where('order_success', 1)->where('cancel_request',1)->orderBy('cancel_request_date','DESC');
        if($search){
            $orders = $orders->where('code', 'like', '%' . $search . '%');
        }
        if($ca_search){
            $ca_search = ($ca_search == 10) ? 0 : $ca_search;
            $orders = $orders->where('cancel_approval', $ca_search);
        }

        if ($date != null) {
            $orders = $orders->whereDate('cancel_request_date', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('cancel_request_date', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        if ($refund_search) {
            $orders = $orders->where('cancel_refund_type', $refund_search);
        }

        $orders = $orders->paginate(15);
        // echo '<pre>';
        // print_r($orders);
        // die;
        return view("backend.sales.cancel_requests",compact('orders', 'search', 'ca_search', 'date', 'refund_search'));
     }

     public function returnRequestStatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        $type = $request->type;
        
        $refund_request = RefundRequest::findOrFail($id);
        if($type == 'admin'){
            $refund_request->update([
                'admin_approval' => $status,
            ]);
        }elseif($type == 'delivery'){
            $refund_request->update([
                'delivery_approval' => $status,
            ]);
        }
     }

     public function cancelRequestStatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        
        $cancel_request = Order::findOrFail($id);
        if($cancel_request->cancel_request == 1 ){

            $message = getOrderStatusMessageTest($cancel_request->user->name, $cancel_request->code);
            $userPhone = $cancel_request->user->phone ?? '';

            $cancel_request->cancel_approval = $status;
            if($status == 1){
                $cancel_request->delivery_status = 'cancelled';

                foreach ($cancel_request->orderDetails as $key => $orderDetail) {
                    $orderDetail->delivery_status = 'cancelled';
                    $orderDetail->save();

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->first();
                
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }
                }

                $track              = new OrderTracking;
                $track->order_id    = $id;
                $track->status      = 'cancelled';
                $track->description = null;
                $track->status_date = date('Y-m-d H:i:s');
                $track->save();
                
                OrderDeliveryBoys::where('order_id',$id)->delete();
                if($userPhone != '' && isset($message['cancelled']) && $message['cancelled'] != ''){
                    SendSMSUtility::sendSMS($userPhone, $message['cancelled']);
                }
            }else{
                if($userPhone != '' && isset($message['cancel_reject']) && $message['cancel_reject'] != ''){
                    SendSMSUtility::sendSMS($userPhone, $message['cancel_reject']);
                }
            }
            $cancel_request->cancel_approval_date = date('Y-m-d H:i:s');
            $cancel_request->save(); 
            
            echo 1;
        }else{
            echo 0;
        }
     }

     public function returnPaymentType(Request $request){
        $id = $request->id;
        $type = $request->type;

        $refund_request = RefundRequest::findOrFail($id);
        if($type == 'cash'){
            $refund_request->update([
                'refund_type' => $type,
            ]);
        }elseif($type == 'wallet'){
            $user = User::findOrFail($refund_request->user_id);
            if($user){
                $user->wallet +=  $refund_request->refund_amount;
                $user->save();
                $wallet = new Wallets;
                $wallet->user_id=$refund_request->user_id;
                $wallet->amount = $refund_request->refund_amount;
                $wallet->order_id  =$request->order_id;
                $wallet->save();
            }
            $refund_request->update([
                'refund_type' => $type,
            ]);
        } 
     }

     public function cancelPaymentType(Request $request){
        $id = $request->id;
        $type = $request->type;

        $order = Order::findOrFail($id);
        if($order){
            if($type == 'wallet'){
                $user = User::findOrFail($order->user_id);
                if($user){
                    $user->wallet +=  $order->grand_total;
                    $user->save();
                    
                    $wallet = new Wallets;
                    $wallet->user_id=$order->user_id;
                    $wallet->amount = $order->grand_total;
                    $wallet->order_id  =$request->order_id;
                    $wallet->save();
                }
            } 
            $order->cancel_refund_type = $type;
            $order->cancel_refund_status = 1;
            $order->save();
        } 
     }
    // Inhouse Orders
    public function admin_orders(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = Order::orderBy('id', 'desc')
                        ->where('seller_id', $admin_user_id);

        if ($request->payment_type != null) {
            $orders = $orders->where('payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.inhouse_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'date'));
    }

    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order_shipping_address = json_decode($order->shipping_address);
        $delivery_boys = User::where('city', $order_shipping_address->city)
            ->where('user_type', 'delivery_boy')
            ->get();

        $order->viewed = 1;
        $order->save();
        return view('backend.sales.inhouse_orders.show', compact('order', 'delivery_boys'));
    }

    // Seller Orders
    public function seller_orders(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $seller_id = $request->seller_id;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = Order::orderBy('code', 'desc')
            ->where('orders.seller_id', '!=', $admin_user_id);

        if ($request->payment_type != null) {
            $orders = $orders->where('payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        if ($seller_id) {
            $orders = $orders->where('seller_id', $seller_id);
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.seller_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'seller_id', 'date'));
    }

    public function seller_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('backend.sales.seller_orders.show', compact('order'));
    }


    // Pickup point orders
    public function pickup_point_order_index(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $orders = Order::query();
        if (Auth::user()->user_type == 'staff' && Auth::user()->staff->pick_up_point != null) {
            $orders->where('shipping_type', 'pickup_point')
                    ->where('pickup_point_id', Auth::user()->staff->pick_up_point->id)
                    ->orderBy('code', 'desc');

            if ($request->has('search')) {
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        } else {
            $orders->where('shipping_type', 'pickup_point')->orderBy('code', 'desc');

            if ($request->has('search')) {
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        }
    }

    public function pickup_point_order_sales_show($id)
    {
        if (Auth::user()->user_type == 'staff') {
            $order = Order::findOrFail(decrypt($id));
            $order_shipping_address = json_decode($order->shipping_address);
            $delivery_boys = User::where('city', $order_shipping_address->city)
                ->where('user_type', 'delivery_boy')
                ->get();

            return view('backend.sales.pickup_point_orders.show', compact('order', 'delivery_boys'));
        } else {
            $order = Order::findOrFail(decrypt($id));
            $order_shipping_address = json_decode($order->shipping_address);
            $delivery_boys = User::where('city', $order_shipping_address->city)
                ->where('user_type', 'delivery_boy')
                ->get();

            return view('backend.sales.pickup_point_orders.show', compact('order', 'delivery_boys'));
        }
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)
            ->get();

        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        $address = Address::where('id', $carts[0]['address_id'])->first();

        $shippingAddress = [];
        if ($address != null) {
            $shippingAddress['name']        = Auth::user()->name;
            $shippingAddress['email']       = Auth::user()->email;
            $shippingAddress['address']     = $address->address;
            $shippingAddress['country']     = $address->country->name;
            $shippingAddress['state']       = $address->state->name;
            $shippingAddress['city']        = $address->city->name;
            $shippingAddress['postal_code'] = $address->postal_code;
            $shippingAddress['phone']       = $address->phone;
            if ($address->latitude || $address->longitude) {
                $shippingAddress['lat_lang'] = $address->latitude . ',' . $address->longitude;
            }
        }

        $combined_order = new CombinedOrder;
        $combined_order->user_id = Auth::user()->id;
        $combined_order->shipping_address = json_encode($shippingAddress);
        $combined_order->save();

        $seller_products = array();
        foreach ($carts as $cartItem){
            $product_ids = array();
            $product = Product::find($cartItem['product_id']);
            if(isset($seller_products[$product->user_id])){
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem);
            $seller_products[$product->user_id] = $product_ids;
        }

        foreach ($seller_products as $seller_product) {
            $order = new Order;
            $order->combined_order_id = $combined_order->id;
            $order->user_id = Auth::user()->id;
            $order->shipping_address = $combined_order->shipping_address;
            $order->shipping_type = $carts[0]['shipping_type'];
            if ($carts[0]['shipping_type'] == 'pickup_point') {
                $order->pickup_point_id = $cartItem['pickup_point'];
            }
            $order->payment_type = $request->payment_option;
            $order->delivery_viewed = '0';
            $order->payment_status_viewed = '0';
            $order->code = date('Ymd-His') . rand(10, 99);
            $order->date = strtotime('now');
            $order->save();

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            $coupon_discount = 0;

            //Order Details Storing
            foreach ($seller_product as $cartItem) {
                $product = Product::find($cartItem['product_id']);

                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $coupon_discount += $cartItem['discount'];

                $product_variation = $cartItem['variation'];

                $product_stock = $product->stocks->where('variant', $product_variation)->first();
                if ($product->digital != 1 && $cartItem['quantity'] > $product_stock->qty) {
                    flash(translate('The requested quantity is not available for ') . $product->name)->warning();
                    $order->delete();
                    return redirect()->route('cart')->send();
                } elseif ($product->digital != 1) {
                    $product_stock->qty -= $cartItem['quantity'];
                    $product_stock->save();
                }

                $order_detail = new OrderDetail;
                $order_detail->order_id = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->shipping_type = $cartItem['shipping_type'];
                $order_detail->product_referral_code = $cartItem['product_referral_code'];
                $order_detail->shipping_cost = $cartItem['shipping_cost'];

                $shipping += $order_detail->shipping_cost;
                //End of storing shipping cost

                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();

                $product->num_of_sale += $cartItem['quantity'];
                $product->save();

                $order->seller_id = $product->user_id;

                if ($product->added_by == 'seller' && $product->user->seller != null){
                    $seller = $product->user->seller;
                    $seller->num_of_sale += $cartItem['quantity'];
                    $seller->save();
                }

                if (addon_is_activated('affiliate_system')) {
                    if ($order_detail->product_referral_code) {
                        $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
                    }
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping;

            if ($seller_product[0]->coupon_code != null) {
                // if (Session::has('club_point')) {
                //     $order->club_point = Session::get('club_point');
                // }
                $order->coupon_discount = $coupon_discount;
                $order->grand_total -= $coupon_discount;

                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = Auth::user()->id;
                $coupon_usage->coupon_id = Coupon::where('code', $seller_product[0]->coupon_code)->first()->id;
                $coupon_usage->save();
            }

            $combined_order->grand_total += $order->grand_total;

            $order->save();
        }

        $combined_order->save();

        $request->session()->put('combined_order_id', $combined_order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                try {

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->save();
                    }

                } catch (\Exception $e) {

                }

                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }

        return 1;
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->save();
        return view('frontend.user.seller.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $product_ids = $request->has('product_ids') ? $request->product_ids : [];
       
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        if($order->delivery_status != 'partial_delivered' && $order->delivery_status != 'partial_pick_up'){
            $order->delivery_status = $request->status;
        }
        $order->save();

        $track              = new OrderTracking;
        $track->order_id    = $order->id;
        $track->status      = $request->status;
        $track->description = null;
        $track->status_date = date('Y-m-d H:i:s');
        $track->save();
        
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ($request->status == 'partial_pick_up' && in_array($orderDetail->id,  $product_ids)) {
                $orderDetail->delivery_status = 'picked_up';
                $orderDetail->save();
            }elseif ($request->status == 'partial_delivery' && in_array($orderDetail->id,  $product_ids)) {
                $orderDetail->delivery_status = 'delivered';
                $orderDetail->save();
            }else{
                if($request->status != 'partial_pick_up' && $request->status != 'partial_delivery'){
                    if($orderDetail->delivery_status != 'picked_up' && $orderDetail->delivery_status != 'delivered'){
                        $orderDetail->delivery_status = $request->status;
                        $orderDetail->save();
                    }
                }
            }

            if ($request->status == 'cancelled') {
                $variant = $orderDetail->variation;
                if ($orderDetail->variation == null) {
                    $variant = '';
                }

                $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                    ->where('variant', $variant)
                    ->first();

                if ($product_stock != null) {
                    $product_stock->qty += $orderDetail->quantity;
                    $product_stock->save();
                }
            }
        }
        
        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        $message = getOrderStatusMessageTest($order->user->name, $order->code);
        $userPhone = $order->user->phone ?? '';
        
        if($userPhone != '' && isset($message[$request->status]) && $message[$request->status] != ''){
            SendSMSUtility::sendSMS($userPhone, $message[$request->status]);
        }

        return 1;
    }

   public function update_tracking_code(Request $request) {
        $order = Order::findOrFail($request->order_id);
        $order->tracking_code = $request->tracking_code;
        $order->save();

        return 1;
   }

    public function update_estimated_date(Request $request) {
        
        $order = Order::findOrFail($request->order_id);
        $order->estimated_delivery = ($request->deliveryDate != '') ? date('Y-m-d', strtotime($request->deliveryDate)) : NULL;
        $order->save();
     
        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ($orderDetail->payment_status != 'paid') {
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();


        if ($order->payment_status == 'paid' && $order->commission_calculated == 0) {
            // calculateCommissionAffilationClubPoint($order);
        }

        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->payment_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;

            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
            try {
                SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {

            }
        }
        return 1;
    }

    public function assign_delivery_boy(Request $request)
    {
        if (addon_is_activated('delivery_boy')) {

            $order = Order::findOrFail($request->order_id);
            $order->assign_delivery_boy = $request->delivery_boy;
            $order->delivery_history_date = date("Y-m-d H:i:s");
            $order->save();

            $delivery_history = \App\Models\DeliveryHistory::where('order_id', $order->id)
                ->where('delivery_status', $order->delivery_status)
                ->first();

            if (empty($delivery_history)) {
                $delivery_history = new \App\Models\DeliveryHistory;

                $delivery_history->order_id = $order->id;
                $delivery_history->delivery_status = $order->delivery_status;
                $delivery_history->payment_type = $order->payment_type;
            }
            $delivery_history->delivery_boy_id = $request->delivery_boy;

            $delivery_history->save();

            if (env('MAIL_USERNAME') != null && get_setting('delivery_boy_mail_notification') == '1') {
                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('You are assigned to delivery an order. Order code') . ' - ' . $order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;

                try {
                    Mail::to($order->delivery_boy->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }

            if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'assign_delivery_boy')->first()->status == 1) {
                try {
                    SmsUtility::assign_delivery_boy($order->delivery_boy->phone, $order->code);
                } catch (\Exception $e) {

                }
            }
        }

        return 1;
    }

    public function assign_shop_order(Request $request){
        $shop_id = $request->shop_id;
        $order_id = $request->order_id;

        
        $order = Order::find($order_id);
        $order->shop_id = $shop_id;
        $order->shop_assigned_date = date('Y-m-d');
        $order->save();

        if( $shop_id != ''){
            //send notification to shop about the order
            $shop = Shops::find($shop_id);
    
            $not = new ShopNotifications;
            $not->shop_id = $shop_id;
            $not->order_id = $order_id;
            $not->is_read = 0;
            $not->message ="A new order has been assigned. Order code : <b>".$order->code ?? ''."</b>";
            $not->type = 'order_assign';
            $not->save();
    
            Mail::to($shop->email)->queue(new OrderAssign($order));
            
            // Notify the staffs
            $staffsNot = User::where('user_type', 'staff')->where('shop_id', $shop_id)->get();  // or however you identify the staffs
            $staffsNot->each(function ($staffsNot) use ($order) {
                $staffsNot->notify(new NewOrderNotification($order));
            });
        }
    }

    public function assign_shop_refund(Request $request){
        $shop_id = $request->shop_id;
        $refund_id = $request->refund_id;
        
        $refund = RefundRequest::find($refund_id);
        $refund->shop_id = $shop_id;
        $refund->save();
        if( $shop_id != ''){
            //send notification to shop about the order
            $shop = Shops::find($shop_id);

            $not = new ShopNotifications;
            $not->shop_id = $shop_id;
            $not->order_id = null;
            $not->is_read = $refund->order->id;
            $not->message ="A new order return request has been assigned. Order code : <b>".$refund->order->code ?? ''."</b>";
            $not->type = 'return_assign';
            $not->save();

            Mail::to($shop->email)->queue(new ReturnAssign($refund->order));
            
            $order_id = $refund->order->id;
            $order = Order::find($order_id);
            // Notify the staffs
            $staffsNot = User::where('user_type', 'staff')->where('shop_id', $shop_id)->get();  // or however you identify the staffs
            $staffsNot->each(function ($staffsNot) use ($order) {
                $staffsNot->notify(new OrderReturnRequest($order));
            });
        }
    }
    public function test(){
        return view('emails.admin.order_assign');
    }

    public function getNearByDeliveryAgents($id){
        $order_id = decrypt($id);
        LiveLocations::where('order_id',$order_id)->delete();
        $orderDetails = Order::find($order_id);
        $shop_id = $orderDetails->shop_id;
        if($shop_id){
            $deviceTokens = User::where('user_type','delivery_boy')
                                ->where('shop_id', $shop_id)
                                ->where('banned',0)
                                ->whereNotNull('device_token')->pluck('device_token')->all();
            
            if(!empty($deviceTokens)){
                $data['device_tokens'] = $deviceTokens;
                $data['title'] = 'Live Location Request';
                $data['body'] = $orderDetails->code. ',order';
                $report = sendPushNotification($data);
                return view('backend.sales.assign_agent', compact('order_id'));
            }else{
                flash(translate('No Active Delivery Agents Found'))->error();
                return redirect()->route('all_orders.index');
            }             
        }
    }

    public function getOrderDeliveryBoys(Request $request){
        $order_id = $request->order_id;
        $locs = LiveLocations::where('order_id',$order_id)->orderBy('distance','asc')->get();
        
        $rows = '';
        foreach ($locs as $key => $loc) {
            $checkAssigned = checkDeliveryAssigned($order_id,$loc->user_id);
            $rows .= '<tr>
                        <td>'. ($key+1) .'</td>
                        <td>'. $loc->user->name .'</td>
                        <td>'. $loc->user->phone .'</td>
                        <td class="text-center"><span class="badge badge-inline badge-success">'. $loc->distance .' KM</span></td>
                        <td class="text-center">';
                        if($checkAssigned == 0){
                            $rows .='<button class="btn btn-sm btn-success d-innline-block assignDelivery" data-agentid="'.$loc->user_id.'" data-orderid="'.$loc->order_id.'" data-status="1">Assign Delivery</button>';
                        }else{
                            $rows .= '<span class="text-danger">Delivery Assigned</span>';
                        }
                        $rows .=  '</td>
                    </tr>';
        }
        
        return $rows;
    }

    public function assignDeliveryAgent(Request $request){

        $order = Order::findOrFail($request->order_id);
        $order->assign_delivery_boy = $request->agent_id;
        $order->save();

        $check = OrderDeliveryBoys::where('order_id', $request->order_id)->where('status',0)->count();
        if($check > 0){
            $odb = OrderDeliveryBoys::where('order_id', $request->order_id)->where('status', 0)->delete();
        }
           
        $odc = new OrderDeliveryBoys;
        $odc->order_id = $request->order_id;
        $odc->delivery_boy_id = $request->agent_id;
        $odc->status = 0;
        $odc->save();

        $message = getOrderStatusMessageTest($odc->deliveryBoy->name, $odc->order->code);
        $userPhone = $odc->deliveryBoy->phone ?? '';
        if($userPhone != '' && $message['order_assign'] != ''){
            SendSMSUtility::sendSMS($userPhone, $message['order_assign']);
        }
        
    }

    public function getNearByReturnDeliveryAgents($id){
        $return_id = decrypt($id);
        LiveLocations::where('return_id',$return_id)->delete();
       
        $deviceTokens = User::where('user_type','delivery_boy')
                            ->where('shop_id', Auth::user()->shop_id)
                            ->where('banned',0)
                            ->whereNotNull('device_token')->pluck('device_token')->all();
        
        if(!empty($deviceTokens)){
            $data['device_tokens'] = $deviceTokens;
            $data['title'] = 'Live Location Request';
            $data['body'] = (string)$return_id. ',return';
            $report = sendPushNotification($data);
            return view('backend.sales.assign_return_agent', compact('return_id'));
        }else{
            flash(translate('No Active Delivery Agents Found'))->error();
            return redirect()->route('return_requests.index');
        }   
    }

    public function getOrderReturnDeliveryBoys(Request $request){
        $return_id = $request->return_id;
        $locs = LiveLocations::where('return_id',$return_id)->orderBy('distance','asc')->get();
        
        $rows = '';
        foreach ($locs as $key => $loc) {
            $checkAssigned = checkReturnDeliveryAssigned($return_id,$loc->user_id);
            $rows .= '<tr>
                        <td>'. ($key+1) .'</td>
                        <td>'. $loc->user->name .'</td>
                        <td>'. $loc->user->phone .'</td>
                        <td class="text-center"><span class="badge badge-inline badge-success">'. $loc->distance .' KM</span></td>
                        <td class="text-center">';
                        if($checkAssigned == 0){
                            $rows .='<button class="btn btn-sm btn-success d-innline-block assignDelivery" data-agentid="'.$loc->user_id.'" data-return_id="'.$loc->return_id.'" data-status="1">Assign Delivery</button>';
                        }else{
                            $rows .= '<span class="text-danger">Delivery Assigned</span>';
                        }
                        $rows .=  '</td>
                    </tr>';
        }
        
        return $rows;
    }

    public function assignReturnDeliveryAgent(Request $request){

        $refund = RefundRequest::findOrFail($request->return_id);
        if($refund){
            if($refund->delivery_status == 0){
                $refund->delivery_boy = $request->agent_id;
                $refund->delivery_assigned_date = date('Y-m-d H:i:s');
                $refund->save();

                $message = getOrderStatusMessageTest($refund->deliveryBoy->name, $refund->order->code);
                $userPhone = $refund->deliveryBoy->phone ?? '';
                if($userPhone != '' && $message['return_assign'] != ''){
                    SendSMSUtility::sendSMS($userPhone, $message['return_assign']);
                }
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 2;
        }
    }
}
