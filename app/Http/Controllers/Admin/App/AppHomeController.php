<?php

namespace App\Http\Controllers\Admin\App;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Offers;
use App\Models\Frontend\Banner;
use Cache;
use Illuminate\Http\Request;

class AppHomeController extends Controller
{
    public function index()
    {
        $categories = Cache::rememberForever('categories', function () {
            return Category::where('parent_id', 0)->where('is_active', 1)->with('childrenCategories')->get();
        });

        $brands = Cache::rememberForever('brands', function () {
            return Brand::where('is_active', 1)->get();
        });
        $offers = Cache::rememberForever('app_offers', function () {
            return Offers::where('status', 1)->get();
        });

        $banners = Banner::where('status', 1)->get();

        return view('backend.app.index', compact('categories', 'brands', 'banners','offers'));
    }


    public function updateBanners(Request $request)
    {
        dd($request);
    }
}
