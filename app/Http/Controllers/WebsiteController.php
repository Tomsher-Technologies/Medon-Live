<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\HeaderMenus;
use App\Models\Prescriptions;
use App\Models\Frontend\HomeSlider;
use Cache;
use Harimayco\Menu\Models\MenuItems;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
	public function header(Request $request)
	{
		$menus = HeaderMenus::orderBy('id','asc')->get();
		$categories = Category::select('id','name')->where('parent_id',0)->where('is_active', 1)->orderBy('name', 'ASC')->get();
		$brands =  Brand::select('id','name')->orderBy('name','asc')->where('is_active', 1)->get();
		return view('backend.website_settings.web_header',compact('categories','brands','menus'));
	}

	public function storeHeader(Request $request)
	{
		$categories = $request->category;
		$brands = $request->brands;
		$data = [];
		HeaderMenus::truncate();
		foreach($categories as $key => $categ){
			if($categ != ''){
				$data[] = array(
					'category_id' => $categ,
					'brands' => json_encode($brands[$key]),
					'created_at' => date('Y-m-d H:i:s')
					);
			}
		}
		HeaderMenus::insert($data);
		Cache::forget('header_menus');
		Cache::forget('header_brands');
		flash(translate('Header menus updated successfully'))->success();
        return back();
	}

	public function footer(Request $request)
	{
		$lang = $request->lang;
		return view('backend.website_settings.footer', compact('lang'));
	}
	public function pages(Request $request)
	{
		return view('backend.website_settings.pages.index');
	}
	public function appearance(Request $request)
	{
		return view('backend.website_settings.appearance');
	}
	public function menu(Request $request)
	{
		return view('backend.website_settings.menu');
	}

	public function menuUpdate(Request $request)
	{
		// return response()->json(  , 200);

		$brands = NULL;
		if ($request->brands) {
			$brands = implode(',', $request->brands);
		}

		MenuItems::where('id', $request->id)->update([
			'img_1' => $request->img_1,
			'img_2' => $request->img_2,
			'img_3' => $request->img_3,

			'img_1_link' => $request->img_1_link,
			'img_2_link' => $request->img_2_link,
			'img_3_link' => $request->img_3_link,

			'brands' => $brands
		]);


		Cache::forget('menu_' . $request->menu_id);

		return response()->json('completed', 200);
	}

	public function prescriptions(){
		
		$prescription = Prescriptions::with(['user'])->orderBy('id','desc')->paginate(15);
		return view('backend.website_settings.prescriptions',compact('prescription'));
	}
}
