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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\ConsultantRegistration::class, function (Faker\Generator $faker) {
    $faker = \Faker\Factory::create();

    return [
        'first_name' => $faker->firstName($gender = null|'male'|'female'),
        'last_name' => $faker->lastName ,
        'gender' => $faker->randomElement($array = array ('M','F')),
        'email' => $faker->email,
        'idAdmin_notified' => $faker->randomNumber(5),
        'idCountry_nationality' => $faker->randomNumber(5),
        'idCountry_residential' => $faker->randomNumber(5),
        'about' => $faker->text($maxNbChars = 3000)    ,
        'mobile_number' => $faker->e164PhoneNumber ,
        'comments_by_admin' => $faker->text($maxNbChars = 1000)    ,

    ];
});


$factory->define(App\Admin::class, function (Faker\Generator $faker) {
    $faker = \Faker\Factory::create();

    return [
        'username' => $faker->name,
        'email' => $faker->email,
        'idUser' => $faker->numberBetween(1 , 9),
        'role' => $faker->numberBetween(1 , 4),
        'thumbnail' =>  $faker->imageUrl($width = 640, $height = 480, 'cats', true, 'Faker', true),
        'last_login_date' => $faker->date(\Carbon\Carbon::now()),
        'first_name' => $faker->firstName($gender = null|'male'|'female'),
        'last_name' => $faker->lastName ,
        'mobile_number' => $faker->e164PhoneNumber ,
        'profile_path' =>  $faker->imageUrl($width = 640, $height = 480, 'cats', true, 'Faker', true),
        'gender' => $faker->randomElement($array = array ('M','F'))

    ];
});