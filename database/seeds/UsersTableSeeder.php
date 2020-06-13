<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::truncate();

        DB::table('users')->insert(
            [
            'account_id' => 'superuser',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'last_name' => '田中',
            'first_name' => '太郎',
            'last_name_kana' => 'たなか',
            'first_name_kana' => 'たろう',
             ]
        );

         factory(User::class, 10)->create();
    }
}
