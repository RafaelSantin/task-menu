<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Item;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;

$factory->define(Item::class, function (Faker $faker) {
    return [
         "item_description"=> "value",
         "item_layer" => 1
    ];
});

$factory->state(Item::class, 'children', function (Faker $faker,$teste) {
	Log::info($teste);
  return [
    'item_children_of' => 1,
  ];
});
