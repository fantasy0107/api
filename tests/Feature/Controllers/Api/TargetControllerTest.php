<?php

namespace Tests\Feature\Controllers\Api;



use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserToken;

class TargetControllerTest extends TestCase
{
    

    private $bearerToken = 'Bearer eyJpdiI6Ii9jRk9YeWw1K0VXakRSSlRBMTBtbEE9PSIsInZhbHVlIjoieUtIaldQbTBjc3ZWNG44UnJLSkxFUT09IiwibWFjIjoiNmIyYWQ2OTJkNGI0OWEwNmEwNWJkOGVmNDQ5ZTdjNGM5NWQwNzA0YTc0ZjliYzNlNmY0ZmU3Y2JhOTU2YTMxYiJ9';

    private $token = 'eyJpdiI6Ii9jRk9YeWw1K0VXakRSSlRBMTBtbEE9PSIsInZhbHVlIjoieUtIaldQbTBjc3ZWNG44UnJLSkxFUT09IiwibWFjIjoiNmIyYWQ2OTJkNGI0OWEwNmEwNWJkOGVmNDQ5ZTdjNGM5NWQwNzA0YTc0ZjliYzNlNmY0ZmU3Y2JhOTU2YTMxYiJ9';


    public function test_index()
    {
        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->json('get', 'api/targets')->assertStatus(200);
    }

    public function test_store()
    {
        $faker = \Faker\Factory::create();

        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->json('post', 'api/targets', [
            'name' =>  $faker->name
        ])->assertStatus(201);
    }

    public function test_store_fail_for_no_name()
    {
        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->json('post', 'api/targets')->assertStatus(422);
    }

    public function test_update()
    {
        $faker = \Faker\Factory::create();
        $userToken = UserToken::where('value', $this->token)->first();
        $user = User::find($userToken->user_id);

        $target = $user->targets()->first();

        $name = $faker->name;

        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->patch('api/targets/' . $target->id, [
            'name' => $name
        ])->assertStatus(200)->assertSeeText($name);
    }
}
