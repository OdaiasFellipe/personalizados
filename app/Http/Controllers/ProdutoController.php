<?php

namespace App\Http\Controllers;

use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all(); // Busca todos os produtos
        return view('catalogo', compact('produtos'));
    }
}
