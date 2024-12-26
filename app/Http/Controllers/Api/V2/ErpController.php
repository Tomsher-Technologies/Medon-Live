<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\UserCollection;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Utility\SendSMSUtility;
use Laravel\Sanctum\PersonalAccessToken;


class ErpController extends Controller
{
    public function updateProduct(Request $request)
    {
        $product_code = $request->product_code ?? NULL;
        $quantity = $request->quantity ?? NULL;
        $price = $request->price ?? NULL;
        
        if($product_code != NULL){
            $product = Product::where('sku', $product_code)->first();
       
            if(!empty($product)){
                $stock = ProductStock::where('product_id', $product->id)->first();
                if($quantity != NULL){
                    $stock->qty = $quantity;
                }
                if($price != NULL){
                    $stock->price = $price;
                    $product->unit_price = $price;
                }
                $stock->save();
                $product->save();
                
                return response()->json([
                    'status' => true,
                    'message' => 'Product updated'
                ],200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ],200);
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Please provide product code'
            ],200);
        }

    }

    public function checkOTP(Request $request){
        $phone = $request->phone ?? NULL;
        if($phone != NULL){
            $message = "Hi User, Greetings from Medon Pharmacy! Your OTP: 12345 Treat this as confidential. Sharing this with anyone gives them full access to your Account.";
            $status = SendSMSUtility::sendSMS($phone, $message);

            return response()->json([
                'status' => true,
                'message' => 'OTP has been sent to your phone'
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Please provide phone number'
            ],200);
        }
       
    }
}
