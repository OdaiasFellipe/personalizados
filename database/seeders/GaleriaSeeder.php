<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Galeria;
use App\Models\Depoimento;

class GaleriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar itens de galeria de exemplo
        $galeriaItems = [
            [
                'titulo' => 'Festa Infantil Tema Unicórnio',
                'descricao' => 'Uma festa mágica com decoração completa em tons de rosa e dourado, com unicórnios encantados para uma menina especial de 5 anos.',
                'categoria' => 'Festa Infantil',
                'imagem' => 'images/galeria/festa-unicornio.jpg',
                'tags' => ['unicórnio', 'festa infantil', 'rosa', 'dourado', 'mágica'],
                'destaque' => true,
                'ativo' => true,
                'ordem' => 1
            ],
            [
                'titulo' => 'Casamento Romântico',
                'descricao' => 'Cerimônia elegante com decoração clássica em tons de branco e verde, flores naturais e ambiente romântico para o grande dia.',
                'categoria' => 'Casamento',
                'imagem' => 'images/galeria/casamento-romantico.jpg',
                'tags' => ['casamento', 'romântico', 'elegante', 'flores', 'branco'],
                'destaque' => true,
                'ativo' => true,
                'ordem' => 2
            ],
            [
                'titulo' => 'Aniversário 30 Anos Elegante',
                'descricao' => 'Comemoração sofisticada para aniversário de 30 anos com decoração moderna, cores neutras e detalhes dourados.',
                'categoria' => 'Aniversário Adulto',
                'imagem' => 'images/galeria/aniversario-30.jpg',
                'tags' => ['aniversário', '30 anos', 'elegante', 'moderno', 'dourado'],
                'destaque' => false,
                'ativo' => true,
                'ordem' => 3
            ],
            [
                'titulo' => 'Festa Super-Heróis',
                'descricao' => 'Aventura épica com tema de super-heróis, decoração colorida e atividades temáticas para um aniversário inesquecível.',
                'categoria' => 'Festa Infantil',
                'imagem' => 'images/galeria/festa-super-herois.jpg',
                'tags' => ['super-heróis', 'aventura', 'colorido', 'festa infantil', 'ação'],
                'destaque' => false,
                'ativo' => true,
                'ordem' => 4
            ],
            [
                'titulo' => 'Formatura Medicina',
                'descricao' => 'Celebração especial de formatura em medicina com decoração temática, cores institucionais e ambiente solene.',
                'categoria' => 'Formatura',
                'imagem' => 'images/galeria/formatura-medicina.jpg',
                'tags' => ['formatura', 'medicina', 'solene', 'conquista', 'família'],
                'destaque' => false,
                'ativo' => true,
                'ordem' => 5
            ],
            [
                'titulo' => 'Festa Tropical',
                'descricao' => 'Evento vibrante com tema tropical, cores vivas, frutas decorativas e ambiente descontraído para uma festa de verão.',
                'categoria' => 'Festa Temática',
                'imagem' => 'images/galeria/festa-tropical.jpg',
                'tags' => ['tropical', 'verão', 'frutas', 'vibrante', 'descontraído'],
                'destaque' => true,
                'ativo' => true,
                'ordem' => 6
            ]
        ];

        foreach ($galeriaItems as $item) {
            Galeria::create($item);
        }

        // Criar depoimentos de exemplo
        $depoimentos = [
            [
                'nome_cliente' => 'Maria Silva',
                'depoimento' => 'Simplesmente perfeito! A festa da minha filha ficou exatamente como sonhamos. A equipe foi super atenciosa e cuidou de cada detalhe. Todos os convidados elogiaram a decoração. Super recomendo!',
                'avaliacao' => 5,
                'evento_tipo' => 'Festa Infantil',
                'data_evento' => '2024-07-15',
                'destaque' => true,
                'aprovado' => true
            ],
            [
                'nome_cliente' => 'João Santos',
                'depoimento' => 'Nosso casamento ficou um sonho! A decoração estava impecável e a organização foi perfeita. Recebemos muitos elogios dos nossos convidados. Muito obrigado por tornar nosso dia ainda mais especial!',
                'avaliacao' => 5,
                'evento_tipo' => 'Casamento',
                'data_evento' => '2024-06-20',
                'destaque' => true,
                'aprovado' => true
            ],
            [
                'nome_cliente' => 'Ana Carolina',
                'depoimento' => 'Contratei para meu aniversário de 30 anos e foi uma excelente escolha! A decoração ficou moderna e elegante, exatamente o que eu queria. Parabéns pelo trabalho!',
                'avaliacao' => 5,
                'evento_tipo' => 'Aniversário Adulto',
                'data_evento' => '2024-08-10',
                'destaque' => false,
                'aprovado' => true
            ],
            [
                'nome_cliente' => 'Roberto Lima',
                'depoimento' => 'A festa do meu filho ficou incrível! O tema super-heróis foi executado perfeitamente. As crianças se divertiram muito e os pais ficaram impressionados com os detalhes.',
                'avaliacao' => 4,
                'evento_tipo' => 'Festa Infantil',
                'data_evento' => '2024-05-25',
                'destaque' => false,
                'aprovado' => true
            ],
            [
                'nome_cliente' => 'Fernanda Costa',
                'depoimento' => 'Minha formatura ficou linda! A decoração estava elegante e a organização foi impecável. Momento muito especial da minha vida que ficará para sempre na memória.',
                'avaliacao' => 5,
                'evento_tipo' => 'Formatura',
                'data_evento' => '2024-12-18',
                'destaque' => false,
                'aprovado' => true
            ],
            [
                'nome_cliente' => 'Carlos Mendes',
                'depoimento' => 'Serviço de qualidade! A festa tropical ficou muito animada e colorida. Todos se divertiram bastante. Recomendo para quem quer uma festa diferente e cheia de energia.',
                'avaliacao' => 4,
                'evento_tipo' => 'Festa Temática',
                'data_evento' => '2024-03-12',
                'destaque' => true,
                'aprovado' => true
            ]
        ];

        foreach ($depoimentos as $depoimento) {
            Depoimento::create($depoimento);
        }
    }
}
