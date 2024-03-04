<?php
use function Pest\Laravel\{get, post};
use App\Models\User;


describe('testing authentication endpoint', function() {


    it('ensure login validation works', function() {
        post('/api/v1/auth/login', [], [
            'Accept' => 'Application/json'
        ])->assertUnprocessable();
    });

    it('ensure email validation works', function() {
        post('api/v1/auth/login', ['password' => 'password'], [
            'Accept' => 'Application/json'
        ])->assertUnprocessable();
    });

    it('ensure password validation works', function() {
        post('/api/v1/auth/login', ['email' => 'jibbsjunior@yahoo.com'], [
            'Accept' => 'Application/json'
        ])->assertUnprocessable();
    });

    it('ensure only existing user can login', function() {
        post('/api/v1/auth/login', ['email' => 'jibbsjunior@yahoo.com', 'password' => 'password'], [
            'Accept' => 'Application/json'
        ])->assertBadRequest();
    });

    it('ensure user can login', function() {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];
        
        post('/api/v1/auth/login', $data, [
            'Accept' => 'Application/json'
        ])->assertOk(200);
    });

    it('ensure token is received after login', function() {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        post('/api/v1/auth/login', $data, [
            'Accept' => 'Application/json'
        ])->assertJsonStructure(['data']);
    });
});