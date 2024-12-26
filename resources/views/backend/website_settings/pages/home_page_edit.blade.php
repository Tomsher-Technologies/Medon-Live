@extends('backend.layouts.app')
@section('content')

    <div class="row">
        <div class="col-xl-10 mx-auto">
            <h6 class="fw-600">Home Page Settings</h6>

            {{-- Home Banner 1 --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Home Side Banner</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="home_banner">
                        <input type="hidden" name="name" value="home_banner">

                        @error('home_banner')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <label>Status</label>
                            <div class="home-banner1-target">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="status"
                                        {{ get_setting('home_banner_status') == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        @php
                            $small_banners = json_decode($current_banners['home_banner']->value);
                        @endphp
                        <div class="form-group">
                            <label>Banner 1</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]" data-live-search="true">
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($small_banners[0]) && $banner->id == $small_banners[0] ? 'selected' : '' }}>
                                                {{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Banner 2</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]" data-live-search="true">
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($small_banners[1]) && $banner->id == $small_banners[1] ? 'selected' : '' }}>
                                                {{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Home Ads Banner</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="home_banner">
                        <input type="hidden" name="name" value="home_ads_banner">

                        @error('home_ads_banner')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        @php
                            $ads_banner = json_decode($current_banners['home_ads_banner']->value);
                        @endphp

                        <div class="form-group">
                            <label>Status</label>
                            <div class="home-banner1-target">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="status"
                                        {{ get_setting('home_ads_banner_status') == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Banner 1</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]" data-live-search="true">
                                        <option value="">Empty</option>
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($ads_banner[0]) && $banner->id == $ads_banner[0] ? 'selected' : '' }}>
                                                {{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Banner 2</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]" data-live-search="true">
                                        <option value="">Empty</option>
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($ads_banner[1]) && $banner->id == $ads_banner[1] ? 'selected' : '' }}>
                                                {{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Banner 3</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]" data-live-search="true">
                                        <option value="">Empty</option>
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($ads_banner[2]) && $banner->id == $ads_banner[2] ? 'selected' : '' }}>
                                                {{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div> --}}

            {{-- Home categories --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Top Categories (Max 10)</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Categories</label>
                            <div class="home-categories-target">
                                <input type="hidden" name="types[]" value="home_categories">
                                @if (get_setting('home_categories') != null)
                                    @foreach (json_decode(get_setting('home_categories'), true) as $key => $value)
                                        <div class="row gutters-5">
                                            <div class="col">
                                                <div class="form-group">
                                                    <select class="form-control aiz-selectpicker" name="home_categories[]"
                                                        data-live-search="true" data-selected={{ $value }}
                                                        required>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                            @foreach ($category->childrenCategories as $childCategory)
                                                                @include('categories.child_category', [
                                                                    'child_category' => $childCategory,
                                                                ])
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button"
                                                    class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                    data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-soft-secondary btn-sm" data-toggle="add-more" data-max="10"
                                data-content='<div class="row gutters-5">
								<div class="col">
									<div class="form-group">
										<select class="form-control aiz-selectpicker" name="home_categories[]" data-live-search="true" required>
											@foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @foreach ($category->childrenCategories as $childCategory)
                                                    @include('categories.child_category', [
                                                        'child_category' => $childCategory,
                                                    ])
                                                @endforeach
                                            @endforeach
										</select>
									</div>
								</div>
								<div class="col-auto">
									<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
										<i class="las la-times"></i>
									</button>
								</div>
							</div>'
                                data-target=".home-categories-target">
                                Add New
                            </button>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>


            {{-- Home Banner 3 --}}

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Home Banner 1</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="home_banner">
                        <input type="hidden" name="name" value="home_banner_1">

                        @error('home_banner_1')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        @php
                            $home_banner_1 = json_decode($current_banners['home_banner_1']->value);
                            // print_r($home_banner_1);

                            // die;
                        @endphp

                        <div class="form-group">
                            <label>Banner</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]"
                                        data-live-search="true">
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($home_banner_1[0]) && $banner->id == $home_banner_1[0] ? 'selected' : '' }}>
                                                {{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Top Brands (Max 10)</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Brands</label>
                            <div class="home-brands-target">
                                <input type="hidden" name="types[]" value="home_brands">
                                @if (get_setting('home_brands') != null)
                                    @foreach (json_decode(get_setting('home_brands'), true) as $key => $value)
                                        <div class="row gutters-5">
                                            <div class="col">
                                                <div class="form-group">
                                                    <select class="form-control aiz-selectpicker" name="home_brands[]"
                                                        data-live-search="true" data-selected={{ $value }}
                                                        required>
                                                        @foreach ($brands as $key => $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button"
                                                    class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                    data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-soft-secondary btn-sm" data-toggle="add-more" data-max="10"
                                data-content='<div class="row gutters-5">
								<div class="col">
									<div class="form-group">
										<select class="form-control aiz-selectpicker" name="home_brands[]" data-live-search="true" required>
											@foreach ($brands as $key => $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
										</select>
									</div>
								</div>
								<div class="col-auto">
									<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
										<i class="las la-times"></i>
									</button>
								</div>
							</div>'
                                data-target=".home-brands-target">
                                Add New
                            </button>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Home Banner 2</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="home_banner">
                        <input type="hidden" name="name" value="home_banner_2">

                        @error('home_banner_2')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        @php
                            $home_banner_2 = json_decode($current_banners['home_banner_2']->value);
                        @endphp

                        <div class="form-group">
                            <label>Banner</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]"
                                        data-live-search="true">
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($home_banner_2[0]) && $banner->id == $home_banner_2[0] ? 'selected' : '' }}>
                                                {{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Best Selling Products (Max 10)</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-12 col-from-label">{{ translate('Best Selling') }}</label>
                            <div class="col-md-12">
                                <input type="hidden" name="types[]" value="best_selling">
                                <select name="best_selling[]" class="form-control aiz-selectpicker" multiple
                                    data-live-search="true" data-selected="{{ get_setting('best_selling') }}" data-max-options="10">
                                    @foreach ($products as $key => $prod)
                                        <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Home Banner 3</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="home_banner">
                        <input type="hidden" name="name" value="home_banner_3">

                        @error('home_banner_3')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        @php
                            $home_banner_3 = json_decode($current_banners['home_banner_3']->value);
                        @endphp

                        <div class="form-group">
                            <label>Banner</label>
                            <div class="home-banner1-target">
                                @if ($banners)
                                    <select class="form-control aiz-selectpicker" name="banner[]"
                                        data-live-search="true">
                                        @foreach ($banners as $banner)
                                            <option value="{{ $banner->id }}"
                                                {{ isset($home_banner_3[0]) && $banner->id == $home_banner_3[0] ? 'selected' : '' }}>{{ $banner->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Top 10 --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Offers (Max 10)</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-from-label">{{ translate('Offers') }}</label>
                            <div class="col-md-10">
                                <input type="hidden" name="types[]" value="home_offers">
                                <select name="home_offers[]" class="form-control aiz-selectpicker" multiple
                                    data-live-search="true" data-selected="{{ get_setting('home_offers') }}">
                                    @foreach ($offers as $key => $off)
                                        <option value="{{ $off->id }}">{{ $off->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>


            {{-- <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Top 10</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-from-label">{{ translate('Top Categories (Max 10)') }}</label>
                            <div class="col-md-10">
                                <input type="hidden" name="types[]" value="top10_categories">
                                <select name="top10_categories[]" class="form-control aiz-selectpicker" multiple
                                    data-max-options="10" data-live-search="true"
                                    data-selected="{{ get_setting('top10_categories') }}">
                                    @foreach (\App\Models\Category::where('parent_id', 0)->with('childrenCategories')->get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}
                                        </option>
                                        @foreach ($category->childrenCategories as $childCategory)
                                            @include('categories.child_category', [
                                                'child_category' => $childCategory,
                                            ])
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-from-label">{{ translate('Top Brands (Max 10)') }}</label>
                            <div class="col-md-10">
                                <input type="hidden" name="types[]" value="top10_brands">
                                <select name="top10_brands[]" class="form-control aiz-selectpicker" multiple
                                    data-max-options="10" data-live-search="true"
                                    data-selected="{{ get_setting('top10_brands') }}">
                                    @foreach (\App\Models\Brand::all() as $key => $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div> --}}

            <div class="card">
                <form class="p-4 repeater" action="{{ route('custom-pages.update', $page->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="card-header px-0">
                        <h6 class="fw-600 mb-0">Seo Fields</h6>
                    </div>
                    <div class="card-body px-0">
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Meta Title') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="{{ translate('Title') }}" name="meta_title"
                                    value="{{ $page->meta_title }}">
                                <input type="hidden" name="type" value="{{ $page->type }}">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Meta Description') }}</label>
                            <div class="col-sm-10">
                                <textarea class="resize-off form-control" placeholder="{{ translate('Description') }}" name="meta_description">{!! $page->meta_description !!}</textarea>
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Keywords') }}</label>
                            <div class="col-sm-10">
                                <textarea class="resize-off form-control" placeholder="{{ translate('Keyword, Keyword') }}" name="keywords">{!! $page->keywords !!}</textarea>
                                <small class="text-muted">Separate with coma</small>
                            </div>
                        </div>
        
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('OG Title') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="{{ translate('OG Title') }}"
                                    name="og_title" value="{{ $page->og_title }}">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('OG Description') }}</label>
                            <div class="col-sm-10">
                                <textarea class="resize-off form-control" placeholder="{{ translate('OG Description') }}" name="og_description">{!! $page->og_description !!}</textarea>
                            </div>
                        </div>
        
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Twitter Title') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="{{ translate('Twitter Title') }}"
                                    name="twitter_title" value="{{ $page->twitter_title }}">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Twitter Description') }}</label>
                            <div class="col-sm-10">
                                <textarea class="resize-off form-control" placeholder="{{ translate('Twitter Description') }}"
                                    name="twitter_description">{!! $page->twitter_description !!}</textarea>
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Meta Image') }}</label>
                            <div class="col-sm-10">
                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="meta_image" class="selected-files"
                                        value="{{ $page->meta_image }}">
                                </div>
                                <div class="file-preview">
                                </div>
                            </div>
                        </div>
        
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Page</button>
                            <button  class="btn btn-warning"><a href="{{ route('website.pages') }}">Cancel</a></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .bootstrap-select .dropdown-menu li, .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
            white-space: normal !important;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            AIZ.plugins.bootstrapSelect('refresh');
        });
    </script>
@endsection
