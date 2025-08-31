<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Verificar se o usuário já existe
        $adminUser = User::where('email', 'admin@nepersonalizados.com')->first();
        
        if (!$adminUser) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@nepersonalizados.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
            ]);
            
            echo "Usuário administrador criado com sucesso!\n";
            echo "Email: admin@nepersonalizados.com\n";
            echo "Senha: admin123\n";
        } else {
            echo "Usuário administrador já existe!\n";
        }
    }
}
