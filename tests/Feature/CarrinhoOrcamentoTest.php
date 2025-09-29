<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CarrinhoOrcamentoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_pode_adicionar_produto_ao_carrinho()
    {
        $produto = Produto::create([
            'nome' => 'Convite Especial',
            'descricao' => 'Convite personalizado com acabamento premium',
            'preco' => 15.50,
        ]);

        $response = $this
            ->from(route('catalogo'))
            ->post(route('carrinho.adicionar'), [
                'produto_id' => $produto->id,
                'quantidade' => 2,
            ]);

        $response->assertRedirect(route('catalogo'))
                 ->assertSessionHas('success');

        $this->assertEquals(2, session('cart')[$produto->id]['quantidade'] ?? 0);

        $carrinho = $this->get(route('carrinho.index'));
        $carrinho->assertStatus(200)
                 ->assertSee('Convite Especial')
                 ->assertSee('R$');
    }

    /** @test */
    public function cliente_consegue_solicitar_orcamento_utilizando_itens_do_carrinho()
    {
        $produto = Produto::create([
            'nome' => 'Kit Festa',
            'descricao' => Str::random(40),
            'preco' => 35.00,
        ]);

        $cartData = [
            $produto->id => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'preco' => (float) $produto->preco,
                'imagem' => null,
                'quantidade' => 3,
            ],
        ];

        $this->withSession(['cart' => $cartData])
            ->get(route('orcamentos.create'))
            ->assertStatus(200)
            ->assertSee($produto->nome);

        $payload = [
            'nome' => 'Cliente Teste',
            'email' => 'cliente@example.com',
            'telefone' => '(11) 99999-9999',
            'data_evento' => now()->addDays(15)->format('Y-m-d'),
            'local_evento' => 'Buffet Central',
            'numero_pessoas' => 80,
            'observacoes' => 'Preferência por tema tropical',
            'produtos' => [$produto->id],
            'quantidades' => [
                $produto->id => 3,
            ],
        ];

        $response = $this->withSession(['cart' => $cartData])
            ->post(route('orcamentos.store'), $payload);

        $response->assertRedirect(route('orcamentos.sucesso'))
                 ->assertSessionHas('success')
                 ->assertSessionHas('numero_orcamento')
                 ->assertSessionMissing('cart');

        $this->assertDatabaseHas('orcamentos', [
            'nome_cliente' => 'Cliente Teste',
            'numero_convidados' => 80,
        ]);

        $this->assertDatabaseHas('orcamento_produtos', [
            'produto_id' => $produto->id,
            'quantidade' => 3,
        ]);
    }
}
