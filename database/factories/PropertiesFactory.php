<?php

use Faker\Generator as Faker;

$factory->define(App\Property::class, function (Faker $faker) {

    $streetNumber = $faker->randomNumber(5);
    $streetName = $faker->streetName;
    $city = $faker->city;
    $postalCode = $faker->randomNumber(5);
    $fullAddress = "$streetNumber $streetName, $city, $postalCode ";

    return [
        'area' => $faker->randomNumber(4),
        'bathrooms' => $faker->randomNumber(1),
        'bedrooms' => $faker->randomNumber(1),
        'parking_description' => $faker->text(),
        'terms' => $faker->text(),
        'street_number' => $streetNumber,
        'street_name' => $streetName,
        'city' => $city,
        'postal_code' => $postalCode,
        'full_address' => $fullAddress,
        'elementary_school' => $faker->text(20),
        'middle_school' => $faker->text(20),
        'high_school' => $faker->text(20),
        'photos' => $faker->imageUrl()
    ];
});
