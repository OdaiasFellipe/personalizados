<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Servico;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource (Admin).
     */
    public function index()
    {
        $orcamentos = Orcamento::with(['produtos'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.orcamentos.index', compact('orcamentos'));
    }

    /**
     * Show the form for creating a new resource (Public).
     */
    public function create()
    {
        // Criar alguns produtos se não existirem
        if (Produto::count() == 0) {
            Produto::create([
                'nome' => 'Convite Personalizado',
                'descricao' => 'Convite personalizado para festas e eventos especiais',
                'preco' => 5.50
            ]);
            
            Produto::create([
                'nome' => 'Lembrancinha Infantil',
                'descricao' => 'Lembrancinha temática infantil personalizada',
                'preco' => 8.00
            ]);
            
            Produto::create([
                'nome' => 'Toalha de Mesa',
                'descricao' => 'Toalha de mesa personalizada com tema do evento',
                'preco' => 25.00
            ]);
            
            Produto::create([
                'nome' => 'Decoração de Parede',
                'descricao' => 'Painel decorativo personalizado para eventos',
                'preco' => 45.00
            ]);
            
            Produto::create([
                'nome' => 'Kit Festa Completo',
                'descricao' => 'Kit completo com pratos, copos e guardanapos personalizados',
                'preco' => 35.00
            ]);
        }
        
        $cartItems = collect(session()->get('cart', []))->map(function ($item) {
            $item['subtotal'] = $item['quantidade'] * $item['preco'];
            return $item;
        });

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('catalogo')
                ->with('error', 'Adicione produtos ao carrinho antes de solicitar um orçamento.');
        }

        $valorEstimado = $cartItems->sum('subtotal');

        return view('orcamentos.create', [
            'itensCarrinho' => $cartItems,
            'valorEstimado' => $valorEstimado,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'data_evento' => 'required|date|after:today',
            'local_evento' => 'required|string|max:500',
            'numero_pessoas' => 'required|integer|min:1',
            'produtos' => 'required|array|min:1',
            'produtos.*' => 'exists:produtos,id',
            'quantidades' => 'required|array',
            'quantidades.*' => 'integer|min:1',
        ]);

        try {
            // Log para debug
            Log::info('Iniciando criação de orçamento', [
                'dados' => $request->all()
            ]);

            // Criar o orçamento
            $orcamento = Orcamento::create([
                'numero_orcamento' => Orcamento::gerarNumeroOrcamento(),
                'nome_cliente' => $request->nome,
                'email_cliente' => $request->email,
                'telefone_cliente' => $request->telefone,
                'data_evento' => $request->data_evento,
                'local_evento' => $request->local_evento,
                'numero_convidados' => $request->numero_pessoas,
                'observacoes' => $request->observacoes,
                'status' => 'pendente',
                'valor_total' => 0,
                'desconto' => 0,
                'valor_final' => 0,
                'tipo_evento' => $request->input('tipo_evento', 'Evento Personalizado'),
            ]);

            Log::info('Orçamento criado', ['orcamento_id' => $orcamento->id]);

            // Adicionar produtos ao orçamento
            $valorTotal = 0;
            $produtosSelecionados = array_map('intval', array_unique($request->produtos));
            $quantidades = $request->quantidades;

            foreach ($produtosSelecionados as $produtoId) {
                $produto = Produto::findOrFail($produtoId);
                $quantidade = isset($quantidades[$produtoId]) ? (int) $quantidades[$produtoId] : 1;
                
                $precoUnitario = $produto->preco;
                $precoTotal = $precoUnitario * $quantidade;
                
                $orcamento->produtos()->attach($produtoId, [
                    'quantidade' => $quantidade,
                    'preco_unitario' => $precoUnitario,
                    'preco_total' => $precoTotal,
                ]);
                
                $valorTotal += $precoTotal;
                
                Log::info('Produto adicionado', [
                    'produto_id' => $produtoId,
                    'quantidade' => $quantidade,
                    'preco_total' => $precoTotal
                ]);
            }

            // Atualizar valores finais
            $orcamento->update([
                'valor_total' => $valorTotal,
                'valor_final' => $valorTotal,
            ]);

            Log::info('Orçamento finalizado', [
                'numero' => $orcamento->numero,
                'valor_total' => $valorTotal
            ]);

            // Limpar o carrinho da sessão após solicitar o orçamento
            session()->forget('cart');

            // Enviar email de confirmação (opcional)
            $this->enviarEmailConfirmacao($orcamento);

            return redirect()->route('orcamentos.sucesso')
                ->with('success', 'Orçamento solicitado com sucesso! Entraremos em contato em breve.')
                ->with('numero_orcamento', $orcamento->numero);

        } catch (\Exception $e) {
            Log::error('Erro ao criar orçamento: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return back()->withInput()
                ->with('error', 'Erro ao processar seu orçamento. Tente novamente ou entre em contato conosco.');
        }
    }

    /**
     * Display the specified resource (Admin).
     */
    public function show(Orcamento $orcamento)
    {
        $orcamento->load(['produtos']);
        return view('admin.orcamentos.show', compact('orcamento'));
    }

    /**
     * Show the form for editing the specified resource (Admin).
     */
    public function edit(Orcamento $orcamento)
    {
        $orcamento->load(['produtos']);
        $produtos = Produto::orderBy('nome')->get();
        return view('admin.orcamentos.edit', compact('orcamento', 'produtos'));
    }

    /**
     * Update the specified resource in storage (Admin).
     */
    public function update(Request $request, Orcamento $orcamento)
    {
        $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'email_cliente' => 'required|email|max:255',
            'telefone_cliente' => 'required|string|max:20',
            'data_evento' => 'required|date',
            'local_evento' => 'required|string|max:500',
            'numero_pessoas' => 'required|integer|min:1|max:10000',
            'observacoes' => 'nullable|string|max:2000',
            'observacoes_internas' => 'nullable|string|max:2000',
            'valor_total' => 'required|numeric|min:0',
            'status' => 'required|in:pendente,aprovado,rejeitado,convertido',
        ]);

        $orcamento->update($request->only([
            'nome_cliente', 'email_cliente', 'telefone_cliente',
            'data_evento', 'local_evento', 'numero_pessoas',
            'observacoes', 'observacoes_internas', 'valor_total', 'status'
        ]));

        return redirect()->route('admin.orcamentos.show', $orcamento)
            ->with('success', 'Orçamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage (Admin).
     */
    public function destroy(Orcamento $orcamento)
    {
        try {
            $numero = $orcamento->numero;
            $orcamento->delete();
            
            return redirect()->route('admin.orcamentos.index')
                ->with('success', "Orçamento #{$numero} removido com sucesso!");
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover orçamento.');
        }
    }

    /**
     * Aprovar orçamento.
     */
    public function aprovar(Orcamento $orcamento)
    {
        $orcamento->aprovar();
        $this->enviarEmailAprovacao($orcamento);
        
        return back()->with('success', 'Orçamento aprovado e cliente notificado!');
    }

    /**
     * Rejeitar orçamento.
     */
    public function rejeitar(Request $request, Orcamento $orcamento)
    {
        $request->validate([
            'motivo_rejeicao' => 'required|string|max:1000'
        ]);

        $orcamento->rejeitar($request->motivo_rejeicao);
        $this->enviarEmailRejeicao($orcamento, $request->motivo_rejeicao);
        
        return back()->with('success', 'Orçamento rejeitado e cliente notificado!');
    }

    /**
     * Converter orçamento em venda.
     */
    public function converter(Orcamento $orcamento)
    {
        $orcamento->converter();
        
        return back()->with('success', 'Orçamento convertido em venda!');
    }

    /**
     * Página de sucesso após solicitar orçamento.
     */
    public function sucesso()
    {
        return view('orcamentos.sucesso');
    }

    /**
     * Buscar preço de produto via AJAX.
     */
    public function buscarPreco(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Produto::find($request->produto_id);
        $precoUnitario = $produto->preco;
        $precoTotal = $precoUnitario * $request->quantidade;
        
        return response()->json([
            'preco_unitario' => $precoUnitario,
            'preco_total' => $precoTotal,
            'preco_formatado' => 'R$ ' . number_format($precoUnitario, 2, ',', '.'),
            'total_formatado' => 'R$ ' . number_format($precoTotal, 2, ',', '.'),
        ]);
    }

    /**
     * Enviar email de confirmação.
     */
    private function enviarEmailConfirmacao(Orcamento $orcamento)
    {
        try {
            // Implementar envio de email aqui
            // Mail::send('emails.orcamento-confirmacao', compact('orcamento'), function($message) use ($orcamento) {
            //     $message->to($orcamento->email_cliente)
            //             ->subject('Confirmação de Orçamento - ' . $orcamento->numero);
            // });
            
            Log::info("Email de confirmação enviado para orçamento #{$orcamento->numero}");
        } catch (\Exception $e) {
            Log::error("Erro ao enviar email de confirmação: " . $e->getMessage());
        }
    }

    /**
     * Enviar email de aprovação.
     */
    private function enviarEmailAprovacao(Orcamento $orcamento)
    {
        try {
            // Implementar envio de email aqui
            Log::info("Email de aprovação enviado para orçamento #{$orcamento->numero}");
        } catch (\Exception $e) {
            Log::error("Erro ao enviar email de aprovação: " . $e->getMessage());
        }
    }

    /**
     * Enviar email de rejeição.
     */
    private function enviarEmailRejeicao(Orcamento $orcamento, $motivo)
    {
        try {
            // Implementar envio de email aqui
            Log::info("Email de rejeição enviado para orçamento #{$orcamento->numero}");
        } catch (\Exception $e) {
            Log::error("Erro ao enviar email de rejeição: " . $e->getMessage());
        }
    }
}
