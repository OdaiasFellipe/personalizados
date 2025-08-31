<?php

require_once 'vendor/autoload.php';

// Carregar o ambiente Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    // Verificar se o usuário já existe
    $user = User::where('email', 'admin@nepersonalizados.com')->first();
    
    if (!$user) {
        // Criar o usuário
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@nepersonalizados.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
        
        echo "✅ Usuário administrador criado com sucesso!\n";
        echo "📧 Email: admin@nepersonalizados.com\n";
        echo "🔑 Senha: admin123\n";
        echo "🌐 Acesse: http://127.0.0.1:8000/login\n";
    } else {
        echo "ℹ️  Usuário administrador já existe!\n";
        echo "📧 Email: admin@nepersonalizados.com\n";
        echo "🔑 Senha: admin123\n";
        echo "🌐 Acesse: http://127.0.0.1:8000/login\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}
