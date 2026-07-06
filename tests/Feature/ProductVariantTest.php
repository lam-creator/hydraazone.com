<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductVariantTest extends TestCase
{
    public function test_product_can_store_dynamic_variants(): void
    {
        $request = new Request([
            'name' => 'Variant Test Product',
            'category_id' => 1,
            'unit_id' => 1,
            'sale_price' => 100,
            'discount_price' => 10,
            'status' => 'active',
            'show_as' => 'general',
            'variants' => [
                [
                    'type' => 'Color',
                    'value' => 'Red',
                    'price_adjustment' => 5,
                    'stock' => 10,
                    'sku' => 'RED-01',
                ],
                [
                    'type' => 'Size',
                    'value' => 'M',
                    'price_adjustment' => 0,
                    'stock' => 5,
                    'sku' => 'M-01',
                ],
            ],
            'image' => UploadedFile::fake()->image('product.jpg'),
        ]);

        $controller = new ProductController();
        $response = $controller->ProductInsert($request);

        $this->assertSame('success', data_get($response->getData(true), 'status'));

        $product = Product::where('name', 'Variant Test Product')->latest()->first();
        $this->assertNotNull($product);
        $this->assertCount(2, $product->variants);
    }
}
