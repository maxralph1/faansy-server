<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::create([
            'user_id' => User::where('username', 'superadmin1')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'admin1')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator1')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator2')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator3')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator4')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator5')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator6')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator7')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator8')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator9')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator10')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator11')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator12')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator13')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator14')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'creator15')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);

        Wallet::create([
            'user_id' => User::where('username', 'user1')->first()->id,
            'balance' => fake()->numberBetween($min = 250, $max = 500),
            'total_inflow' => fake()->numberBetween($min = 0, $max = 250),
            'total_expenditure' => fake()->numberBetween($min = -250, $max = 0),
        ]);
    }
}
