<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Page;

class GenerateSitemap extends Command
{

    // protected $signature = 'app:generate-sitemap';
    // protected $description = 'Command description';

    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap for website';


        public function handle()
    {
        $sitemap = Sitemap::create();

        // Static Pages
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create('/user/login')->setPriority(0.8));
        $sitemap->add(Url::create('/user/register')->setPriority(0.8));
        $sitemap->add(Url::create('/user/forgot-password')->setPriority(0.8));
        $sitemap->add(Url::create('/cart')->setPriority(0.8));
        $sitemap->add(Url::create('/user/checkout')->setPriority(0.8));

        $sitemap->add(Url::create('/contact')->setPriority(0.8));
        // $sitemap->add(Url::create('/shop')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // Dynamic Product Pages
        $products = Product::with('category')->where('status', 'active')->get();

        foreach ($products as $product) {
            $sitemap->add(
                Url::create(route('product-details', [
                    'category' => $product->category->category_slug,
                    'name' => $product->product_slug,
                    'id' => $product->id,
                ]))
                ->setLastModificationDate($product->updated_at ?? Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7)
            );
        }

        // Dynamic Pages
        $pages = Page::where('status', 'active')->get();

        foreach ($pages as $page) {

            // skip homepage if needed
            // if ($page->slug == 'home') {
            //     continue;
            // }

            $sitemap->add(
                Url::create(route('page.details', [
                    'slug' => $page->slug,
                    'id'   => $page->id,
                ]))
                    ->setLastModificationDate($page->updated_at ?? Carbon::now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }


        // Save to public/sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }


}
