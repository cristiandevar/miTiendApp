<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(1)->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345')
        ])->each(
            function ( User $user ) {
                $user->assignRole('admin');
            }
        );    

        // ])->each(function(User $user) {
        //     $user->assignRole('admin');
        // });

        User::factory(1)->create([
            'name' => 'seller',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('12345')
        ])->each(
            function ( User $user ) {
                $user->assignRole('seller');
            }
        );
        // ->each(function(User $user) {
        //     $user->assignRole('seller');
        // });
           
        User::factory(1)->create([
            'name' => 'boss',
            'email' => 'boss@gmail.com',
            'password' => Hash::make('12345')
        ])->each(
            function ( User $user ) {
                $user->assignRole('boss');
            }
        );
        // ->each(function(User $user) {
        //     $user->assignRole('client');
        // });

    }
}
