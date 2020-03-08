<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Item;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;

$factory->define(Item::class, function (Faker $faker) {
    return  
    	[
	        "item_description"=> "value1",
	        "item_layer" => 1	
		];
});

$factory->state(Item::class, 'children', function (Faker $faker) {
  return [
	        "item_description"=> "value11",
	        "item_layer" => 2
		];
});

$factory->state(Item::class, 'menuItems', function (Faker $faker) {
  return [
	        "item_description"=> "menu22",
	        "item_layer" => 2
		];
});
