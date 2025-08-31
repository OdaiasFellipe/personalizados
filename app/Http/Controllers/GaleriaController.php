<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeria;
use App\Models\Depoimento;

class GaleriaController extends Controller
{
    // Página pública da galeria
    public function index(Request $request)
    {
        $categoria = $request->get('categoria');
        $tag = $request->get('tag');

        $galeria = Galeria::ativo()->orderBy('ordem')->orderBy('created_at', 'desc');

        if ($categoria) {
            $galeria->where('categoria', $categoria);
        }

        if ($tag) {
            $galeria->whereJsonContains('tags', $tag);
        }

        $galeria = $galeria->paginate(12);
        $destaques = Galeria::ativo()->destaque()->orderBy('ordem')->take(6)->get();
        $categorias = Galeria::getCategorias();
        
        return view('galeria.index', compact('galeria', 'destaques', 'categorias', 'categoria', 'tag'));
    }

    // Visualização individual
    public function show(Galeria $galeria)
    {
        if (!$galeria->ativo) {
            abort(404);
        }

        // Itens relacionados da mesma categoria
        $relacionados = Galeria::ativo()
            ->where('categoria', $galeria->categoria)
            ->where('id', '!=', $galeria->id)
            ->take(6)
            ->get();

        // Depoimentos da mesma categoria
        $depoimentosCategoria = Depoimento::aprovado()
            ->where('evento_tipo', $galeria->categoria)
            ->take(4)
            ->get();

        return view('galeria.show', compact('galeria', 'relacionados', 'depoimentosCategoria'));
    }

    // Página de depoimentos
    public function depoimentos()
    {
        $depoimentos = Depoimento::aprovado()->orderBy('created_at', 'desc')->paginate(12);
        $destaques = Depoimento::aprovado()->destaque()->take(4)->get();
        $tiposEvento = Depoimento::getTiposEvento();
        
        // Estatísticas
        $totalDepoimentos = Depoimento::aprovado()->count();
        $mediaAvaliacoes = Depoimento::aprovado()->avg('avaliacao') ?? 0;
        $satisfacao = Depoimento::aprovado()->where('avaliacao', '>=', 4)->count();
        $satisfacao = $totalDepoimentos > 0 ? round(($satisfacao / $totalDepoimentos) * 100) : 0;
        $eventosRealizados = $totalDepoimentos; // Simplificado para o exemplo
        
        return view('galeria.depoimentos', compact(
            'depoimentos', 
            'destaques', 
            'tiposEvento',
            'totalDepoimentos',
            'mediaAvaliacoes',
            'satisfacao',
            'eventosRealizados'
        ));
    }

    // Formulário para adicionar depoimento
    public function storeDepoimento(Request $request)
    {
        $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'depoimento' => 'required|string|min:10',
            'avaliacao' => 'required|integer|between:1,5',
            'evento_tipo' => 'nullable|string',
            'data_evento' => 'nullable|date',
            'foto_cliente' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_cliente')) {
            $foto = $request->file('foto_cliente');
            $nomeArquivo = time() . '_depoimento.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('images/depoimentos'), $nomeArquivo);
            $fotoPath = 'images/depoimentos/' . $nomeArquivo;
        }

        Depoimento::create([
            'nome_cliente' => $request->nome_cliente,
            'depoimento' => $request->depoimento,
            'avaliacao' => $request->avaliacao,
            'evento_tipo' => $request->evento_tipo,
            'data_evento' => $request->data_evento,
            'foto_cliente' => $fotoPath,
            'aprovado' => false // Precisa ser aprovado pelo admin
        ]);

        return back()->with('success', 'Obrigado pelo seu depoimento! Ele será analisado e publicado em breve.');
    }
}
