<?php

namespace App\Http\Controllers;

use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        $carrinho = session()->get('cart', []);

        return view('catalogo', [
            'produtos' => $produtos,
            'carrinho' => $carrinho,
        ]);
    }
}
