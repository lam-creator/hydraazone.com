<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Banner;
use App\Models\Trust;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WebsiteSettings;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{

    public function index()
    {

        $AllSlider = Slider::where('status','active')
                    ->latest('id')  // Orders by 'id' in descending order to get the latest products
                    ->get();

        $AllCategoryProduct = Category::with([
            'products' => fn($q) => $q->where('status', 'active')  // Ensure only active products
                ->whereIn('show_as', ['general', 'featured'])
                ->orderBy('id')
                // ->take(4)
        ])
        ->where('show_in_homepage', 'active') // Filter categories by show_in_homepage
        ->orderBy('id')
        ->get();

        $AllFeaturedProduct = Product::with('category', 'unit:id,name')
                    ->where('status', 'active')
                    ->where('show_as', 'featured')
                    ->orderBy('id', 'ASC')
                    ->take(5)       // Limits the result to 5 products
                    ->get();

        $AllBanner = Banner::where('status', 'active')
                    ->orderBy('id', 'ASC')
                    // ->take(2)       // Limits the result to 2 products
                    ->get();

        $AllTrust = Trust::where('status', 'active')
                    ->orderBy('id', 'ASC')
                    // ->take(2)       // Limits the result to 2 products
                    ->get();

        $AllFeature = Feature::where('status', 'active')
                    ->orderBy('id', 'ASC')
                    // ->take(2)       // Limits the result to 2 products
                    ->get();

        $AllUpcomingProduct = Product::with('category', 'unit:id,name')
                    ->where('status', 'active')
                    ->where('show_as', 'upcoming')
                    ->orderBy('id', 'ASC')
                    ->take(5)       // Limits the result to 5 products
                    ->get();

        $SeoData = WebsiteSettings::select('meta_title', 'meta_description', 'meta_keywords', 'logo', 'company_name')->first();

        return view('front-end.index', compact('SeoData','AllSlider', 'AllCategoryProduct','AllFeaturedProduct','AllUpcomingProduct','AllBanner','AllTrust','AllFeature'));

    }

    public function featuredProducts()
    {
        $AllFeaturedProductLink = Product::with('category', 'unit:id,name')
            ->where('status', 'active')
            ->where('show_as', 'featured')
            ->orderBy('id', 'ASC')
            ->paginate(12); // Paginate 12 per page

        $SeoData = WebsiteSettings::select('meta_title', 'meta_description', 'meta_keywords', 'logo', 'company_name')->first();

        return view('front-end.featured-products', compact('AllFeaturedProductLink','SeoData'));
    }

    public function upcomingProducts()
    {
        $AllUpcomingProductLink = Product::with('category', 'unit:id,name')
            ->where('status', 'active')
            ->where('show_as', 'upcoming')
            ->orderBy('id', 'ASC')
            ->paginate(12); // Paginate 12 per page

        $SeoData = WebsiteSettings::select('meta_title', 'meta_description', 'meta_keywords', 'logo', 'company_name')->first();

        return view('front-end.upcoming-products', compact('AllUpcomingProductLink','SeoData'));
    }


    public function ProductDetails($category, $name, $id)
    {

        $OtherProducts = Product::where('status', 'active')
            ->whereIn('show_as', ['general', 'featured'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        $product = Product::with('category', 'unit:id,name')
            ->where('id', $id)
            ->firstOrFail();

        $correctCategory = $product->category->category_slug;
        $correctName = $product->product_slug;

        if ($correctCategory !== $category || $correctName !== $name) {
            return redirect()->route('product-details', [
                'category' => $correctCategory,
                'name' => $correctName,
                'id' => $id
            ]);
        }

        return view('front-end.product', compact('product','OtherProducts'));
    }

    public function CategoryWiseProduct($name,$id)
    {
        $AllCategoryProduct = Product::where('category_id',$id)
                ->where('status', 'active')
                ->where('show_as', '!=', 'upcoming') // Exclude "upcoming"
                ->paginate(12);

        $SeoData = WebsiteSettings::select('meta_title', 'meta_description', 'meta_keywords', 'logo', 'company_name')->first();

        return view('front-end.category-products',compact('AllCategoryProduct','SeoData'));
    }


    // End

}
