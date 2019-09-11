<?php

namespace Tests;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

class PassportTestCase extends TestCase
{
    use RefreshDatabase;

    protected $headers = [];
    protected $scopes = [];
    protected $user;

    public function setUp():void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', '/'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]); 
    }

    public function signIn($user = null)
    {
        $user = $user ?: create('App\User');

        $token = $user->createToken('TestToken', $this->scopes)->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;

        $this->actingAs($user, 'api'); 

        return $this;
    }

    protected function signInAdmin($admin = null)
    {
        $admin = $admin ?: create('App\User');

        $token = $admin->createToken('TestToken', $this->scopes)->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;

        config(['liblab.administrators' => [$admin->email]]);

        $this->actingAs($admin, 'api');

        return $this;
    }

    public function get($uri, array $headers = [])
    {
        return parent::get($uri, array_merge($this->headers, $headers));
    }
  
    public function getJson($uri, array $headers = [])
    {
        return parent::getJson($uri, array_merge($this->headers, $headers));
    }
    public function post($uri, array $data = [], array $headers = [])
    {
        return parent::post($uri, $data, array_merge($this->headers, $headers));
    }
    
    public function postJson($uri, array $data = [], array $headers = [])
    {
        return parent::postJson($uri, $data, array_merge($this->headers, $headers));
    }
    
    public function put($uri, array $data = [], array $headers = [])
    {
        return parent::put($uri, $data, array_merge($this->headers, $headers));
    }
        
    public function putJson($uri, array $data = [], array $headers = [])
    {
        return parent::putJson($uri, $data, array_merge($this->headers, $headers));
    }
        
    public function patch($uri, array $data = [], array $headers = [])
    {
        return parent::patch($uri, $data, array_merge($this->headers, $headers));
    }
        
    public function patchJson($uri, array $data = [], array $headers = [])
    {
        return parent::patchJson($uri, $data, array_merge($this->headers, $headers));
    }
        
    public function delete($uri, array $data = [], array $headers = [])
    {
        return parent::delete($uri, $data, array_merge($this->headers, $headers));
    }
        
    public function deleteJson($uri, array $data = [], array $headers = [])
    {
        return parent::deleteJson($uri, $data, array_merge($this->headers, $headers));
    }
}