<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialIngredientCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_with_special_ingredients_requires_selection(): void
    {
        [$product] = $this->createProductWithSpecialIngredients();

        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertSessionHasErrors('special_ingredient_id');
    }

    public function test_same_product_with_different_special_ingredients_creates_separate_cart_lines(): void
    {
        [$product, $whiteBread, $wholeWheatBread] = $this->createProductWithSpecialIngredients();

        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
            'special_ingredient_id' => $whiteBread->id,
        ])->assertRedirect(route('home'));

        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
            'special_ingredient_id' => $wholeWheatBread->id,
        ])->assertRedirect(route('home'));

        $cart = session('cart');

        $this->assertCount(2, $cart);
        $this->assertSame(1, $cart[$product->id . ':' . $whiteBread->id]['quantity']);
        $this->assertSame(2, $cart[$product->id . ':' . $wholeWheatBread->id]['quantity']);
    }

    public function test_checkout_persists_selected_special_ingredient(): void
    {
        [$product, $whiteBread] = $this->createProductWithSpecialIngredients();

        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 3,
            'special_ingredient_id' => $whiteBread->id,
        ])->assertRedirect(route('home'));

        $this->post(route('order.store'), [
            'client_name' => 'Cliente Test',
            'phone_number' => '8888-0000',
            'payment_method' => 'efectivo',
        ])->assertRedirect();

        $orderProduct = OrderProduct::first();

        $this->assertNotNull($orderProduct);
        $this->assertSame($product->id, $orderProduct->product_id);
        $this->assertSame($whiteBread->id, $orderProduct->special_ingredient_id);
        $this->assertSame(3, $orderProduct->quantity);
    }

    private function createProductWithSpecialIngredients(): array
    {
        $category = Category::create([
            'name' => 'Panes',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sandwich especial',
            'description' => 'Producto de prueba',
            'price' => 2500,
            'discount' => 0,
        ]);

        $whiteBread = Ingredient::create([
            'name' => 'Pan blanco',
            'is_special' => true,
        ]);

        $wholeWheatBread = Ingredient::create([
            'name' => 'Pan integral',
            'is_special' => true,
        ]);

        ProductIngredient::create([
            'product_id' => $product->id,
            'ingredient_id' => $whiteBread->id,
        ]);

        ProductIngredient::create([
            'product_id' => $product->id,
            'ingredient_id' => $wholeWheatBread->id,
        ]);

        return [$product, $whiteBread, $wholeWheatBread];
    }
}