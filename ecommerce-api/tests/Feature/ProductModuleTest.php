<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModuleTest extends TestCase
{
    use RefreshDatabase; // يمسح الداتابيز الوهمية بعد كل اختبار

    public function test_can_create_product_with_variants(): void
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/v1/products', [
            'name'        => 'قميص قطني',
            'price'       => 200,
            'sku'         => 123456,
            'stock'       => 50,
            'category_id' => $category->id,
            'variants'    => [
                ['attributes' => ['color' => 'Red', 'size' => 'XL'], 'price' => 210, 'stock' => 20, 'sku' => 123457]
            ]
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('status', 'success');

        $this->assertDatabaseHas('products', ['name' => 'قميص قطني']);
    }

    public function test_prevents_negative_stock_adjustment(): void
    {
        $product = Product::factory()->create(['stock' => 10]);

        // محاولة خفض المخزون بـ 15 (أكبر من المتوفر 10)
        $response = $this->postJson("/api/v1/products/{$product->id}/adjust-stock", [
            'change' => -15
        ]);

        // يجب أن يرجع الخطأ ولا ينهار السيرفر
        $response->assertStatus(500); 
        $this->assertEquals(10, $product->fresh()->stock); // المخزون يظل 10 كما هو
    }
}

?> 
