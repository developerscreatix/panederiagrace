<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_disabled_products_are_hidden_from_public_catalog(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Panes']);

        $enabledProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Baguette',
            'description' => 'Disponible',
            'price' => 1000,
            'discount' => 0,
            'is_enabled' => true,
        ]);

        $disabledProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Ciabatta',
            'description' => 'No disponible',
            'price' => 1200,
            'discount' => 0,
            'is_enabled' => true,
        ]);

        $this->actingAs($user)
            ->patch(route('admin.products.toggle', $disabledProduct))
            ->assertRedirect(route('admin.products'));

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($enabledProduct->name)
            ->assertDontSee($disabledProduct->name);

        $this->post(route('cart.add'), [
            'product_id' => $disabledProduct->id,
            'quantity' => 1,
        ])->assertNotFound();
    }

    public function test_admin_can_edit_product_details_and_ingredients(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Sandwiches']);
        $otherCategory = Category::create(['name' => 'Postres']);

        $oldIngredient = Ingredient::create([
            'name' => 'Jamón',
            'is_special' => false,
        ]);

        $newIngredient = Ingredient::create([
            'name' => 'Pan integral',
            'is_special' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Club sandwich',
            'description' => 'Original',
            'price' => 3200,
            'discount' => 0,
            'is_enabled' => true,
        ]);

        $product->productIngredients()->create([
            'ingredient_id' => $oldIngredient->id,
        ]);

        $this->actingAs($user)
            ->put(route('admin.products.update', $product), [
                'category_id' => $otherCategory->id,
                'name' => 'Club sandwich deluxe',
                'description' => 'Actualizado',
                'price' => 4500,
                'discount' => 10,
                'ingredients' => [$newIngredient->id],
            ])
            ->assertRedirect(route('admin.products'));

        $product->refresh();

        $this->assertSame($otherCategory->id, $product->category_id);
        $this->assertSame('Club sandwich deluxe', $product->name);
        $this->assertSame('Actualizado', $product->description);
        $this->assertSame(4500.0, (float) $product->price);
        $this->assertSame(10, $product->discount);
        $this->assertEquals([$newIngredient->id], $product->productIngredients()->pluck('ingredient_id')->all());
    }
}