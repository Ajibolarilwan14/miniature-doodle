<?php
use App\Models\User;
use function Pest\Faker\fake;
use App\Models\ProductCategory;
use function Pest\Laravel\{get, post, actingAs};

describe('testing product category endpoint', function() {
    
    it('ensure authentication works', function () {
        post('/api/v1/product/category/create', [], [
            'Accept' => 'Application/json'
        ])->assertUnauthorized();
    
    });

    it('ensure validation works', function() {
        $user = User::factory()->create();

            actingAs($user)->post('/api/v1/product/category/create', [], [
                'Accept' => 'Application/json'
            ])->assertJsonValidationErrors('name')
            ->assertJsonMissingValidationErrors('description');
    });

    it('ensure user can create category', function() {
        $user = User::factory()->create();

        $data = [
            'name' => fake()->name,
        ];

        actingAs($user)->post('/api/v1/product/category/create', $data, [
            'Accept' => 'Application/json'
        ])->assertCreated();
    });

    it('ensure user can fetch a category', function() {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();

        actingAs($user)->get('/api/v1/product/category/' . $category->id)->assertOk();
    });

    it('ensure a category can be fetched', function() {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();

        actingAs($user)->get('/api/v1/product/category/' . $category->id)->assertJsonStructure(['data']);
    });

    it('ensure a category can be updated', function() {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();
        $data = [
            'name' => fake()->name(),
        ];

        actingAs($user)->patch('/api/v1/product/category/' . $category->id, $data, [
            'Accept' => 'Application/json'
        ])->assertOk()
        ->assertJsonStructure(['data']);
    });

    it('ensure user can delete a category', function() {
        $user = User::factory()->create();
        $category = ProductCategory::factory()->create();

        actingAs($user)->delete('/api/v1/product/category/' . $category->id, [
            'Accept' => 'Application/json'
        ])->assertOk();
    });

    it('ensure all category can be fetched', function() {
        $user = User::factory()->create();

        actingAs($user)->get('/api/v1/product/category', [
            'Accept' => 'Application/json'
        ])->assertOk()
        ->assertJsonStructure(['data']);
    });
});