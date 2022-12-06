<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Facturation\HorsCatalogue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(HorsCatalogue::class, function (Faker $faker) {
        return [
            'parent_user_msisdn'=>$faker->parent_user_msisdn,
            'transaction_amount'=>$faker->transaction_amount,
            'date_transaction'=>$faker->date_transaction,
            'date_transaction'=>$faker->date_transaction,
            'created_at'=>now(),
            'updated_at'=>null,
        ];
    });