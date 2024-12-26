<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use Cache;

class Category extends Model
{

    protected $fillable = [
        'parent_id',
        'level',
        'name',
        'order_level',
        'banner',
        'icon',
        'featured',
        'top',
        'slug',
        'is_active',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'twitter_title',
        'twitter_description',
        'meta_keyword',
        'footer_title',
        'footer_content',
    ];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $category_translation = $this->category_translations->where('lang', $lang)->first();
        return $category_translation != null ? $category_translation->$field : $this->$field;
    }

    public function category_translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function classified_products()
    {
        return $this->hasMany(CustomerProduct::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }
    public function child()
    {
        // return $this->hasMany(Category::class,'parent_id')->with('child','icon')->select('id','parent_id','name','level','slug','icon');
        return $this->hasMany(Category::class, 'parent_id')
        ->with('child')
        ->selectRaw('categories.id, categories.parent_id, categories.name, categories.level, categories.slug, IFNULL(CONCAT("'.url('/storage/').'/", uploads.file_name), "'.app('url')->asset('admin_assets/assets/img/placeholder.jpg').'") as icon')
        ->leftJoin('uploads', 'categories.icon', '=', 'uploads.id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function banner()
    {
        return $this->hasOne(Upload::class, 'id', 'banner');
    }
    public function icon()
    {
        return $this->hasOne(Upload::class, 'id', 'icon');
    }
    public function iconName()
    {
        return $this->hasOne(Upload::class, 'id', 'icon')->select('file_name');
    }

    public function iconImage()
    {
        return $this->hasOne(Upload::class, 'id', 'icon');
    }
   
   
    public function getMainCategory()
    {
        $parent = $this->parentCategory;
        while($parent->parent_id != 0) {
            $parent = $parent->parentCategory;
        }
        return $parent->id;
    }

    public static function boot()
    {
        static::creating(function ($model) {
            Cache::forget('categories');
            Cache::forget('categoriesTree');
            Cache::forget('trending_categories');
            Cache::forget('app.featured_categories');
            Cache::forget('app.home_categories');
            Cache::forget('app.home_categories');
            Cache::forget('app.top_categories');
        });

        static::updating(function ($model) {
            Cache::forget('categories');
            Cache::forget('categoriesTree');
            Cache::forget('trending_categories');
            Cache::forget('app.featured_categories');
            Cache::forget('app.home_categories');
            Cache::forget('app.home_categories');
            Cache::forget('app.top_categories');
        });

        static::deleting(function ($model) {
            Cache::forget('categories');
            Cache::forget('categoriesTree');
            Cache::forget('trending_categories');
            Cache::forget('app.featured_categories');
            Cache::forget('app.home_categories');
            Cache::forget('app.home_categories');
            Cache::forget('app.top_categories');
        });

        parent::boot();
    }
}
