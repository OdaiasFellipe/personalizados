<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicos = Servico::orderBy('categoria')->orderBy('nome')->paginate(15);
        return view('admin.servicos.index', compact('servicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Servico::select('categoria')->distinct()->pluck('categoria')->filter()->toArray();
        return view('admin.servicos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'categoria' => 'required|string|max:100',
            'tipo_preco' => 'required|in:fixo,por_pessoa,por_hora,personalizado',
            'preco_base' => 'required|numeric|min:0',
            'preco_por_pessoa' => 'nullable|numeric|min:0',
            'preco_por_hora' => 'nullable|numeric|min:0',
            'pessoas_minimas' => 'nullable|integer|min:1',
            'pessoas_maximas' => 'nullable|integer|min:1',
            'tempo_estimado' => 'nullable|integer|min:1',
            'opcoes_extras' => 'nullable|json',
            'ativo' => 'boolean',
        ]);

        $servico = Servico::create($request->all());

        return redirect()->route('admin.servicos.index')
            ->with('success', 'Serviço criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Servico $servico)
    {
        return view('admin.servicos.show', compact('servico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servico $servico)
    {
        $categorias = Servico::select('categoria')->distinct()->pluck('categoria')->filter()->toArray();
        return view('admin.servicos.edit', compact('servico', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servico $servico)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'categoria' => 'required|string|max:100',
            'tipo_preco' => 'required|in:fixo,por_pessoa,por_hora,personalizado',
            'preco_base' => 'required|numeric|min:0',
            'preco_por_pessoa' => 'nullable|numeric|min:0',
            'preco_por_hora' => 'nullable|numeric|min:0',
            'pessoas_minimas' => 'nullable|integer|min:1',
            'pessoas_maximas' => 'nullable|integer|min:1',
            'tempo_estimado' => 'nullable|integer|min:1',
            'opcoes_extras' => 'nullable|json',
            'ativo' => 'boolean',
        ]);

        $servico->update($request->all());

        return redirect()->route('admin.servicos.index')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servico $servico)
    {
        try {
            $nome = $servico->nome;
            $servico->delete();
            
            return redirect()->route('admin.servicos.index')
                ->with('success', "Serviço '{$nome}' removido com sucesso!");
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover serviço. Verifique se não há orçamentos associados.');
        }
    }

    /**
     * Toggle status ativo/inativo.
     */
    public function toggleStatus(Servico $servico)
    {
        $servico->update(['ativo' => !$servico->ativo]);
        
        $status = $servico->ativo ? 'ativado' : 'desativado';
        return back()->with('success', "Serviço {$status} com sucesso!");
    }
}
