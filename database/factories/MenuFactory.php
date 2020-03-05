<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
          "menu_name"=> $faker->name,
          "menu_max_depth"=> rand(1,99),
          "menu_max_children"=> rand(1,99)
    ];
});
