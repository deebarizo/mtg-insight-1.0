<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\Set::class, function ($faker) {
    
    return [
        
        'name' => $faker->name,
        'code' => str_random(3),
        'release_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'created_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'updated_at' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});

$factory->define(App\Models\Card::class, function ($faker) {
    
    return [
        
        'name' => $faker->name,
        'mana_cost' => '{4}{C}',
        'cmc' => 5,
        'middle_text' => 'Creature — Eldrazi',
        'rules_text' => '({C} represents colorless mana.) Trample, haste Whenever Reality Smasher becomes the target of a spell an opponent controls, counter that spell unless its controller discards a card.',
        'layout_id' => 1, 
        'created_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'updated_at' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});

$factory->define(App\Models\Layout::class, function ($faker) {
    
    return [
        
        'layout' => $faker->name,
        'created_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'updated_at' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
