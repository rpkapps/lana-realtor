<?php

use Faker\Generator as Faker;

$factory->define(App\Property::class, function (Faker $faker) {

    $streetNumber = $faker->randomNumber(5);
    $streetName = $faker->streetName;
    $city = $faker->city;
    $postalCode = $faker->randomNumber(5);
    $fullAddress = "$streetNumber $streetName, $city, $postalCode ";

    return [
        'listPrice' => $faker->randomNumber(4),
        'area' => $faker->randomNumber(4),
        'bathrooms' => $faker->randomNumber(1),
        'bedrooms' => $faker->randomNumber(1),
        'parkingDescription' => $faker->text(),
        'terms' => $faker->text(),
        'streetNumber' => $streetNumber,
        'streetName' => $streetName,
        'city' => $city,
        'state' => 'Alaska',
        'postalCode' => $postalCode,
        'elementarySchool' => $faker->text(20),
        'middleSchool' => $faker->text(20),
        'highSchool' => $faker->text(20),
        'photos' => $faker->imageUrl()
    ];
});
