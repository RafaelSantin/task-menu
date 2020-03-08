<?php

namespace Tests\Feature;

use App\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

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

     /**
     * Test Post items.
     *
     * @return void     
     */  

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

     /**
     * Test update items.
     *
     * @return void
     */

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

     /**
     * Test delete items.
     *
     * @return void
     */

    public function testDeleteItem()
    {

        $post = factory(Item::class)->create();

        $this->delete('/api/items/'.$post->item_id )
            ->assertStatus(200);
    }


    /**
     * Test Post items.
     *
     * @return void     
     */  

    public function testPostItemsChild()
    {
        $post = factory(Item::class)->create();
        $response = $this->json('POST', '/api/items/'.$post->item_id.'/children',   [
                                                            [
                                                                "field" => "value",
                                                                "children" => [
                                                                    [
                                                                        "field" => "value"
                                                                    ],
                                                                    [
                                                                        "field" => "value"
                                                                    ]
                                                                ]
                                                            ],
                                                            [
                                                                "field" => "value"
                                                            ]
                                                        ]);
 
        $response
            ->assertStatus(200)
            ->assertJson( [
                            [
                                "field" => "value",
                                "children" => [
                                    [
                                        "field" => "value"
                                    ],
                                    [
                                        "field" => "value"
                                    ]
                                ]
                            ],
                            [
                                "field" => "value"
                            ]
                        ]);
    }

    public function testGetItemChild()
    {

        $post = factory(Item::class)->create();
        $post2 = factory(Item::class)->state('children')->create(['item_children_of' => $post->item_id]);

        Log::info($post);
        Log::info($post2);
        $this->get('/api/items/'.$post->item_id.'/children' )
            ->assertStatus(200)
            ->assertJson( [
                            [
                                "field" => "value11"
                            ]
                        ]);
    }

    public function testDeleteItemChild()
    {

        $post = factory(Item::class)->create();
        $post2 = factory(Item::class)->state('children')->create(['item_children_of' => $post->item_id]);

        Log::info($post);
        Log::info($post2);
        $this->delete('/api/items/'.$post->item_id.'/children' )
            ->assertStatus(200);
    }
}
