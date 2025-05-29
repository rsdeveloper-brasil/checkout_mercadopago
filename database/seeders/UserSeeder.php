<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** https://laravel.com/docs/10.x/seeding#using-model-factories */
        User::factory()
            ->count(50)
            ->hasAddresses(1) // cria um endereço para cada usuário (só é possivel por qualsa do relaciomaneto em user (addresses))
            ->create();
    }
}
