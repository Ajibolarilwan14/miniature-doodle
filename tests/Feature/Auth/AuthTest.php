<?php
use function Pest\Laravel\{get, post};
use App\Models\User;


describe('testing authentication endpoint', function() {


    it('ensure login validation works', function() {
        post('/api/v1/auth/login', [], [
            'Accept' => 'Application/json'
        ])->assertStatus(422);
    });

    it('ensure email validation works', function() {
        post('api/v1/auth/login', ['password' => 'password'], [
            'Accept' => 'Application/json'
        ])->assertStatus(422);
    });

    it('ensure password validation works', function() {
        post('/api/v1/auth/login', ['email' => 'jibbsjunior@yahoo.com'], [
            'Accept' => 'Application/json'
        ])->assertStatus(422);
    });

    it('ensure only existing user can login', function() {
        post('/api/v1/auth/login', ['email' => 'jibbsjunior@yahoo.com', 'password' => 'password'], [
            'Accept' => 'Application/json'
        ])->assertStatus(400);
    });

    it('ensure user can login', function() {
        $user = User::factory(1)->create();

        $data = [
            'email' => $user[0]->email,
            'password' => 'password'
        ];
        
        post('/api/v1/auth/login', $data, [
            'Accept' => 'Application/json'
        ])->assertStatus(200);
    });

    it('ensure token is received after login', function() {
        $user = User::factory(1)->create();

        $data = [
            'email' => $user[0]->email,
            'password' => 'password'
        ];

        post('/api/v1/auth/login', $data, [
            'Accept' => 'Application/json'
        ])->assertJsonStructure(['data']);
    });
});