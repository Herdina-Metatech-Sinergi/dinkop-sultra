<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Acara;
use App\Models\IdentitasKoperasi;
use App\Models\Pasangan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        $roles = [
            'Admin Dinkop',
            'Admin Koperasi',
            'Bendahara Pemasukan Koperasi',
            'Bendahara Pengeluaran',
            'Atasan Koperasi',
            'Viewer Dinkop',
        ];

        foreach ($roles as $roleName) {
            Role::updateOrCreate([
                'name' => $roleName,
            ], [
                'name' => $roleName,
                'guard_name' => config('auth.defaults.guard'),
            ]);
        }

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('Admin Dinkop');

        $user = User::factory()->create([
            'name' => 'Admin Koperasi',
            'email' => 'admin_koperasi@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('Admin Koperasi');

        // $this->call(IdentitasKoperasiSeeder::class);

        $this->call(MasterCOASeeder::class);
        $this->call(KonfigurasiCoaSeeder::class);

    }
}
