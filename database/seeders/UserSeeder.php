<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Petugas utama
        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        // Pengguna utama
        User::create([
            'name' => 'Pengguna',
            'email' => 'pengguna@gmail.com',
            'password' => Hash::make('pengguna123'),
            'role' => 'pengguna',
        ]);

        // User tambahan (default pengguna)
        $users = [
            ['Melati', 'melati@gmail.com'],
            ['Bunga', 'bunga@gmail.com'],
            ['Mawar', 'mawar@gmail.com'],
            ['Anggrek', 'anggrek@gmail.com'],
            ['Tulip', 'tulip@gmail.com'],
            ['Dahlia', 'dahlia@gmail.com'],
            ['Kenanga', 'kenanga@gmail.com'],
            ['Seruni', 'seruni@gmail.com'],
            ['Kamelia', 'kamelia@gmail.com'],

            // Lavender → Role petugas (nanti di-handle di bawah)
            ['Lavender', 'lavender@gmail.com'],

            ['Sakura', 'sakura@gmail.com'],
            ['Lily', 'lily@gmail.com'],
            ['Anyelir', 'anyelir@gmail.com'],
            ['Cempaka', 'cempaka@gmail.com'],
            ['Teratai', 'teratai@gmail.com'],
            ['Rafflesia', 'rafflesia@gmail.com'],
            ['Flora', 'flora@gmail.com'],
            ['Fauna', 'fauna@gmail.com'],
            ['Seroja', 'seroja@gmail.com'],
            ['Gardenia', 'gardenia@gmail.com'],
        ];

        foreach ($users as $user) {

            // Jika Lavender → role petugas
            $role = ($user[0] === 'Lavender') ? 'petugas' : 'pengguna';

            User::create([
                'name' => $user[0],
                'email' => $user[1],
                'password' => Hash::make('12345678'),
                'role' => $role,
            ]);
        }
    }
}
