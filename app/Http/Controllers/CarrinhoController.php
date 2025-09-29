<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    /**
     * Exibe os produtos adicionados no carrinho.
     */
    public function index()
    {
        $itens = collect(session()->get('cart', []))->map(function ($item) {
            $item['subtotal'] = $item['quantidade'] * $item['preco'];
            return $item;
        });

        $total = $itens->sum('subtotal');

        return view('carrinho.index', [
            'itens' => $itens,
            'total' => $total,
        ]);
    }

    /**
     * Adiciona um produto ao carrinho.
     */
    public function adicionar(Request $request)
    {
        $dados = $request->validate([
            'produto_id' => ['required', 'exists:produtos,id'],
            'quantidade' => ['required', 'integer', 'min:1', 'max:1000'],
        ], [
            'quantidade.min' => 'Informe ao menos uma unidade.',
            'quantidade.max' => 'Quantidade máxima permitida é de 1000 unidades.',
        ]);

        $produto = Produto::findOrFail($dados['produto_id']);
        $quantidade = $dados['quantidade'];

        $cart = session()->get('cart', []);

        if (isset($cart[$produto->id])) {
            $cart[$produto->id]['quantidade'] += $quantidade;
        } else {
            $cart[$produto->id] = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'preco' => (float) $produto->preco,
                'imagem' => $produto->imagem,
                'quantidade' => $quantidade,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->back()
            ->with('success', 'Produto "' . $produto->nome . '" adicionado ao carrinho!');
    }

    /**
     * Atualiza a quantidade de um produto no carrinho.
     */
    public function atualizar(Request $request, Produto $produto)
    {
        $dados = $request->validate([
            'quantidade' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        $cart = session()->get('cart', []);

        if (! isset($cart[$produto->id])) {
            return redirect()
                ->route('carrinho.index')
                ->with('error', 'Produto não encontrado no carrinho.');
        }

        $cart[$produto->id]['quantidade'] = $dados['quantidade'];
        session()->put('cart', $cart);

        return redirect()
            ->route('carrinho.index')
            ->with('success', 'Quantidade atualizada com sucesso.');
    }

    /**
     * Remove um produto do carrinho.
     */
    public function remover(Produto $produto)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$produto->id])) {
            unset($cart[$produto->id]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('carrinho.index')
            ->with('success', 'Produto removido do carrinho.');
    }

    /**
     * Limpa todos os itens do carrinho.
     */
    public function limpar()
    {
        session()->forget('cart');

        return redirect()
            ->route('carrinho.index')
            ->with('success', 'Carrinho esvaziado com sucesso.');
    }
}
