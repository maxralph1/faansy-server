<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create([
            'bio' => fake()->text(100),
            'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
            'dark_mode' => fake()->boolean(),
            'user_id' => User::where('username', 'faansy')->first()->id,
        ]);

        Profile::create([
            'bio' => fake()->text(100),
            'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
            'dark_mode' => fake()->boolean(),
            'user_id' => User::where('username', 'faansy1')->first()->id,
        ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'admin1')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator1')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator2')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator3')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator4')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator5')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator6')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator7')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator8')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator9')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator10')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator11')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator12')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator13')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator14')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'creator15')->first()->id,
        // ]);

        // Profile::create([
        //     'bio' => fake()->text(100),
        //     'website_url' => fake()->url(),
        //     'twitter_account' => fake()->url(),
        //     'google_account' => fake()->url(),
        //     'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
        //     'dark_mode' => fake()->boolean(),
        //     'user_id' => User::where('username', 'user1')->first()->id,
        // ]);
    }
}
