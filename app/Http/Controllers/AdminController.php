<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProdutos = Produto::count();
        $produtosRecentes = Produto::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalProdutos', 'produtosRecentes'));
    }

    // Produtos
    public function produtos()
    {
        $produtos = Produto::latest()->paginate(12);
        return view('admin.produtos.index', compact('produtos'));
    }

    public function createProduto()
    {
        return view('admin.produtos.create');
    }

    public function storeProduto(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeImagem = time() . '_' . Str::slug($request->nome) . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('images/produtos'), $nomeImagem);
            $imagemPath = 'images/produtos/' . $nomeImagem;
        }

        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'imagem' => $imagemPath
        ]);

        return redirect()->route('admin.produtos')->with('success', 'Produto criado com sucesso!');
    }

    public function editProduto(Produto $produto)
    {
        return view('admin.produtos.edit', compact('produto'));
    }

    public function updateProduto(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagemPath = $produto->imagem;
        if ($request->hasFile('imagem')) {
            // Deletar imagem antiga
            if ($produto->imagem && file_exists(public_path($produto->imagem))) {
                unlink(public_path($produto->imagem));
            }

            $imagem = $request->file('imagem');
            $nomeImagem = time() . '_' . Str::slug($request->nome) . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('images/produtos'), $nomeImagem);
            $imagemPath = 'images/produtos/' . $nomeImagem;
        }

        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'imagem' => $imagemPath
        ]);

        return redirect()->route('admin.produtos')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroyProduto(Produto $produto)
    {
        // Deletar imagem
        if ($produto->imagem && file_exists(public_path($produto->imagem))) {
            unlink(public_path($produto->imagem));
        }

        $produto->delete();
        return redirect()->route('admin.produtos')->with('success', 'Produto excluído com sucesso!');
    }

    // Configurações do site
    public function configuracoes()
    {
        return view('admin.configuracoes');
    }

    public function updateConfiguracoes(Request $request)
    {
        $request->validate([
            'nome_site' => 'required|string|max:255',
            'descricao_site' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|email',
            'endereco' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'whatsapp' => 'nullable|string'
        ]);

        // Salvar configurações em arquivo ou banco
        $configuracoes = $request->only([
            'nome_site', 'descricao_site', 'telefone', 'email', 
            'endereco', 'instagram', 'facebook', 'whatsapp'
        ]);

        file_put_contents(
            storage_path('app/configuracoes.json'), 
            json_encode($configuracoes, JSON_PRETTY_PRINT)
        );

        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    // Upload de imagens
    public function uploadImagem(Request $request)
    {
        $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeImagem = time() . '_' . $imagem->getClientOriginalName();
            $imagem->move(public_path('images'), $nomeImagem);
            
            return response()->json([
                'success' => true,
                'url' => asset('images/' . $nomeImagem)
            ]);
        }

        return response()->json(['success' => false]);
    }

    // Galeria
    public function galeria()
    {
        $galeria = \App\Models\Galeria::latest()->paginate(12);
        return view('admin.galeria.index', compact('galeria'));
    }

    public function createGaleria()
    {
        $categorias = \App\Models\Galeria::getCategorias();
        return view('admin.galeria.create', compact('categorias'));
    }

    public function storeGaleria(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tags' => 'nullable|string',
            'destaque' => 'boolean',
            'ordem' => 'integer|min:0'
        ]);

        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeImagem = time() . '_galeria_' . \Illuminate\Support\Str::slug($request->titulo) . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('images/galeria'), $nomeImagem);
            $imagemPath = 'images/galeria/' . $nomeImagem;
        }

        // Processar tags
        $tags = null;
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        \App\Models\Galeria::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'categoria' => $request->categoria,
            'imagem' => $imagemPath,
            'tags' => $tags,
            'destaque' => $request->has('destaque'),
            'ordem' => $request->ordem ?? 0,
            'ativo' => true
        ]);

        return redirect()->route('admin.galeria')->with('success', 'Item adicionado à galeria com sucesso!');
    }

    public function editGaleria(\App\Models\Galeria $galeria)
    {
        $categorias = \App\Models\Galeria::getCategorias();
        return view('admin.galeria.edit', compact('galeria', 'categorias'));
    }

    public function updateGaleria(Request $request, \App\Models\Galeria $galeria)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tags' => 'nullable|string',
            'destaque' => 'boolean',
            'ordem' => 'integer|min:0'
        ]);

        $imagemPath = $galeria->imagem;
        if ($request->hasFile('imagem')) {
            // Deletar imagem antiga
            if ($galeria->imagem && file_exists(public_path($galeria->imagem))) {
                unlink(public_path($galeria->imagem));
            }

            $imagem = $request->file('imagem');
            $nomeImagem = time() . '_galeria_' . \Illuminate\Support\Str::slug($request->titulo) . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('images/galeria'), $nomeImagem);
            $imagemPath = 'images/galeria/' . $nomeImagem;
        }

        // Processar tags
        $tags = null;
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $galeria->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'categoria' => $request->categoria,
            'imagem' => $imagemPath,
            'tags' => $tags,
            'destaque' => $request->has('destaque'),
            'ordem' => $request->ordem ?? 0
        ]);

        return redirect()->route('admin.galeria')->with('success', 'Item da galeria atualizado com sucesso!');
    }

    public function destroyGaleria(\App\Models\Galeria $galeria)
    {
        // Deletar imagem
        if ($galeria->imagem && file_exists(public_path($galeria->imagem))) {
            unlink(public_path($galeria->imagem));
        }

        $galeria->delete();
        return redirect()->route('admin.galeria')->with('success', 'Item da galeria excluído com sucesso!');
    }

    // Depoimentos
    public function depoimentos()
    {
        $depoimentos = \App\Models\Depoimento::latest()->paginate(12);
        return view('admin.depoimentos.index', compact('depoimentos'));
    }

    public function aprovarDepoimento(\App\Models\Depoimento $depoimento)
    {
        $depoimento->update(['aprovado' => !$depoimento->aprovado]);
        $status = $depoimento->aprovado ? 'aprovado' : 'reprovado';
        return back()->with('success', "Depoimento {$status} com sucesso!");
    }

    public function destacarDepoimento(\App\Models\Depoimento $depoimento)
    {
        $depoimento->update(['destaque' => !$depoimento->destaque]);
        $status = $depoimento->destaque ? 'destacado' : 'removido do destaque';
        return back()->with('success', "Depoimento {$status} com sucesso!");
    }

    public function destroyDepoimento(\App\Models\Depoimento $depoimento)
    {
        // Deletar foto se existir
        if ($depoimento->foto_cliente && file_exists(public_path($depoimento->foto_cliente))) {
            unlink(public_path($depoimento->foto_cliente));
        }

        $depoimento->delete();
        return back()->with('success', 'Depoimento excluído com sucesso!');
    }
}
