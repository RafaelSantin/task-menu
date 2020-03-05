<?php

namespace Tests\Feature;

use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetItem()
    {
        $response = $this->get('/api/items/1');

        $response->assertStatus(200);
    }    

    public function testPostItem()
    {
        $response = $this->json('POST', '/api/items',   [
                                                          "field"=> "item112",
                                                        ]);

        $response
            ->assertStatus(200)
            ->assertJson( [
                              "field"=> "item112"
                            ]);
    }

    public function testUpdateItem()
    {
        $post = factory(Item::class)->create();

        $data = [
            "field"=> $this->faker->name
        ];
        $this->put('/api/items/'.$post->item_id , $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function testDeleteItem()
    {
        $post = factory(Item::class)->create();
        $post = factory(Item::class)->state('children')->create($post->item_id);

        $this->delete('/api/items/'.$post->item_id )
            ->assertStatus(200);
    }
}
