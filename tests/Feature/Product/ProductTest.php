<?php

use App\Models\User;

use App\Models\Product;
use function Pest\Laravel\get;
use function Pest\Faker\fake;
use function Pest\Laravel\actingAs;

describe('testing product endpoint', function() {
    
    it('ensure authentication works', function() {
        get('/api/v1/product/create', [
            'Accept' => 'Application/json'
        ])->assertUnauthorized();
    });

    it('ensure validation works', function() {
        $user = User::factory()->create();
        $data = [
            "name" => "Jordan Sneakers",
            "description" => "Affordable sneakers(white)",
            "product_category_id" => 2,
            "stock_quantity" => 11
        ];

        actingAs($user)->post('/api/v1/product/create', $data, [
            'Accept' => 'Application/json'
        ])->assertUnprocessable()
        ->assertJsonValidationErrorFor('price');
    });

    it('ensure user can create a product', function() {
        $user = User::factory()->create();
        $data = [
            "name" => fake()->name(),
            "description" => fake()->text(),
            "product_category_id" => 2,
            "price" => 22.33,
            "stock_quantity" => 11
        ];

        actingAs($user)->post('/api/v1/product/create', $data, [
            'Accept' => "Application/json"
        ])->assertCreated()
        ->assertJsonStructure(['data']);
    });

    it('ensure user can fetch a product', function() {
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);

        actingAs($user)->get('/api/v1/product/' . $product->id, [
            'Accept' => 'Application/json'
        ])->assertOk()
        ->assertJsonStructure(['data']);
    });

    it('ensure product authorization works', function() {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        actingAs($user)->get('/api/v1/product/' . $product->id, [
            'Accept' => 'Application/json'
        ])->assertForbidden();
    });

    it('ensure authorized user can retrieve a product', function() {
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);

        actingAs($user)->get('/api/v1/product/' . $product->id, [
            'Accept' => 'Application/json'
        ])->assertOk()
        ->assertJsonStructure(['data']);
    });

    it('ensure unauthorized user cannot update a product', function() {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $data = [
            "name" => fake()->name(),
            "description" => fake()->text(),
            "product_category_id" => 2,
            "price" => 22.33,
            "stock_quantity" => 11
        ];

        actingAs($user)->patch('/api/v1/product/' . $product->id, $data, [
            'Accept' => 'Application/json'
        ])->assertForbidden();
    });

    it('ensure authorized user can update a product', function() {
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);

        $data = [
            "name" => fake()->name(),
            "description" => fake()->text(),
            "product_category_id" => 2,
            "price" => 22.33,
            "stock_quantity" => 11
        ];

        actingAs($user)->patch('/api/v1/product/' . $product->id, $data, [
            'Accept' => 'Application/json'
        ])->assertOk()
        ->assertJsonStructure(['data']);
    });

    it('ensure unauthorized user cannot delete a product', function(){
        $user = User::factory()->create();
        $product = Product::factory()->create();

        actingAs($user)->delete('/api/v1/product/' . $product->id, [
            'Accept' => 'Application/json'
        ])->assertForbidden();
    });

    it('ensure authorized user can delete a product', function() {
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);

        actingAs($user)->delete('/api/v1/product/' . $product->id, [
            'Accept' => 'Application/json'
        ])->assertOk()
        ->assertJsonStructure(['data']);
    });

    it('ensure product listing can be retrieved', function() {
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);

        actingAs($user)->get('/api/v1/product/', [
            'Accept' => 'Application/json'
        ])->assertOk()
        ->assertJsonStructure(['data']);
    });
});