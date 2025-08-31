<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servico;

class ServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicos = [
            // Fotografia
            [
                'nome' => 'Sessão de Fotos Básica',
                'descricao' => 'Sessão de fotos com duração de 2 horas, incluindo 50 fotos editadas',
                'categoria' => 'Fotografia',
                'tipo_preco' => 'fixo',
                'preco_base' => 350.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Sessão de Fotos Premium',
                'descricao' => 'Sessão de fotos com duração de 4 horas, incluindo 100 fotos editadas e álbum digital',
                'categoria' => 'Fotografia',
                'tipo_preco' => 'fixo',
                'preco_base' => 650.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Cobertura de Evento',
                'descricao' => 'Cobertura fotográfica completa do evento',
                'categoria' => 'Fotografia',
                'tipo_preco' => 'por_hora',
                'preco_base' => 150.00,
                'ativo' => true,
            ],
            
            // Decoração
            [
                'nome' => 'Decoração Simples',
                'descricao' => 'Decoração básica com balões, painel e mesa principal',
                'categoria' => 'Decoração',
                'tipo_preco' => 'fixo',
                'preco_base' => 280.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Decoração Completa',
                'descricao' => 'Decoração completa com temática personalizada, centro de mesa e painel backdrop',
                'categoria' => 'Decoração',
                'tipo_preco' => 'fixo',
                'preco_base' => 580.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Decoração de Mesa',
                'descricao' => 'Decoração específica para mesa do bolo e doces',
                'categoria' => 'Decoração',
                'tipo_preco' => 'por_pessoa',
                'preco_base' => 15.00,
                'min_pessoas' => 10,
                'max_pessoas' => 200,
                'ativo' => true,
            ],
            
            // Animação
            [
                'nome' => 'Animação Infantil Básica',
                'descricao' => 'Animação com recreação, jogos e brincadeiras por 2 horas',
                'categoria' => 'Animação',
                'tipo_preco' => 'por_pessoa',
                'preco_base' => 25.00,
                'min_pessoas' => 5,
                'max_pessoas' => 50,
                'ativo' => true,
            ],
            [
                'nome' => 'Show de Mágica',
                'descricao' => 'Apresentação de mágica com duração de 45 minutos',
                'categoria' => 'Animação',
                'tipo_preco' => 'fixo',
                'preco_base' => 450.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Personagem Temático',
                'descricao' => 'Personagem caracterizado para interação e fotos',
                'categoria' => 'Animação',
                'tipo_preco' => 'por_hora',
                'preco_base' => 180.00,
                'ativo' => true,
            ],
            
            // Buffet
            [
                'nome' => 'Lanche Simples',
                'descricao' => 'Salgadinhos, refrigerante e bolo simples',
                'categoria' => 'Buffet',
                'tipo_preco' => 'por_pessoa',
                'preco_base' => 18.00,
                'min_pessoas' => 10,
                'max_pessoas' => 500,
                'ativo' => true,
            ],
            [
                'nome' => 'Buffet Completo',
                'descricao' => 'Salgados variados, doces, refrigerantes, sucos e bolo decorado',
                'categoria' => 'Buffet',
                'tipo_preco' => 'por_pessoa',
                'preco_base' => 35.00,
                'min_pessoas' => 15,
                'max_pessoas' => 300,
                'ativo' => true,
            ],
            [
                'nome' => 'Mesa de Doces',
                'descricao' => 'Mesa completa com doces finos e decoração temática',
                'categoria' => 'Buffet',
                'tipo_preco' => 'fixo',
                'preco_base' => 320.00,
                'ativo' => true,
            ],
            
            // Equipamentos
            [
                'nome' => 'Som e Microfone',
                'descricao' => 'Sistema de som com microfone sem fio',
                'categoria' => 'Equipamentos',
                'tipo_preco' => 'por_hora',
                'preco_base' => 80.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Iluminação Básica',
                'descricao' => 'Kit de iluminação colorida para ambiente',
                'categoria' => 'Equipamentos',
                'tipo_preco' => 'fixo',
                'preco_base' => 120.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Projetor e Telão',
                'descricao' => 'Projetor com telão para apresentações ou filmes',
                'categoria' => 'Equipamentos',
                'tipo_preco' => 'por_hora',
                'preco_base' => 100.00,
                'ativo' => true,
            ],
        ];

        foreach ($servicos as $servico) {
            Servico::create($servico);
        }
    }
}
