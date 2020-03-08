<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Faker\Generator as Faker;
use App\Menu;
use App\Item;

class MenuTest extends TestCase
{
     use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetMenu()
    {
        $response = $this->get('/api/menus/1');

        $response->assertStatus(200);
    }    

    public function testPostMenu()
    {
        $response = $this->json('POST', '/api/menus',   [
                                                          "field"=> "value21312",
                                                          "max_depth"=> 5,
                                                          "max_children"=> 5
                                                        ]);

        $response
            ->assertStatus(200)
            ->assertJson( [
                              "field"=> "value21312",
                              "max_depth"=> 5,
                              "max_children"=> 5
                            ]);
    }

    public function testUpdateMenu()
    {
        $post = factory(Menu::class)->create();

        $data = [
            "field"=> $this->faker->name,
            "max_depth"=> rand(1,99),
            "max_children"=> rand(1,99)
        ];
        $this->put('/api/menus/'.$post->menu_id , $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function testDeleteMenu()
    {
        $post = factory(Menu::class)->create();

        $this->delete('/api/menus/'.$post->menu_id )
            ->assertStatus(200);
    }

     public function testPostMenuItems()
    {
        $post = factory(Menu::class)->create();

        $response = $this->json('POST', '/api/menus/'.$post->menu_id.'/items',   [
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

    public function testGetMenuItems()
    {

        $post = factory(Menu::class)->create();
        $post2 = factory(Item::class)->state('menuItems')->create(['menu_id' => $post->menu_id]);


        $this->get('/api/menus/'.$post->menu_id.'/items' )
            ->assertStatus(200)
            ->assertJson( [
                            [
                                "field" => "menu22"
                            ]
                        ]);
    }

    public function testDeleteItemChild()
    {

        $post = factory(Menu::class)->create();
        $post2 = factory(Item::class)->state('menuItems')->create(['menu_id' => $post->menu_id]);

        Log::info($post);
        Log::info($post2);
        $this->delete('/api/menus/'.$post->menu_id.'/items' )
            ->assertStatus(200);
    }

     public function testMenuDepth()
    {

        $post = factory(Menu::class)->create();
        $post2 = factory(Item::class)->state('menuItems')->create(['menu_id' => $post->menu_id]);

        
        $this->get('/api/menus/'.$post->menu_id.'/depth' )
            ->assertStatus(200)
            ->assertJson( [                            
                            "field" => 2                            
                        ]);
    }
}
