<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_orcamento',
        'nome_cliente',
        'email_cliente',
        'telefone_cliente',
        'tipo_evento',
        'data_evento',
        'horario_evento',
        'numero_convidados',
        'local_evento',
        'observacoes',
        'valor_total',
        'desconto',
        'valor_final',
        'status',
        'observacoes_admin',
        'data_aprovacao',
        'data_vencimento',
        'visualizado_cliente',
        'enviado_email',
        'tentativas_contato'
    ];

    protected $casts = [
        'data_evento' => 'date',
        'horario_evento' => 'datetime:H:i',
        'data_aprovacao' => 'datetime',
        'data_vencimento' => 'datetime',
        'valor_total' => 'decimal:2',
        'desconto' => 'decimal:2',
        'valor_final' => 'decimal:2',
        'visualizado_cliente' => 'boolean',
        'enviado_email' => 'boolean'
    ];

    // Relacionamentos
    public function servicos(): BelongsToMany
    {
        return $this->belongsToMany(Servico::class, 'orcamento_servicos')
                    ->withPivot(['quantidade', 'preco_unitario', 'preco_total', 'opcoes_selecionadas', 'observacoes'])
                    ->withTimestamps();
    }

    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'orcamento_produtos')
                    ->withPivot(['quantidade', 'preco_unitario', 'preco_total', 'observacoes'])
                    ->withTimestamps();
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeAprovados($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopeVencidos($query)
    {
        return $query->where('data_vencimento', '<', now())->where('status', 'pendente');
    }

    public function scopeEventosProximos($query, $dias = 30)
    {
        return $query->where('data_evento', '>=', now())
                     ->where('data_evento', '<=', now()->addDays($dias));
    }

    // Acessores
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pendente' => '<span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Pendente</span>',
            'aprovado' => '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Aprovado</span>',
            'rejeitado' => '<span class="badge bg-danger"><i class="fas fa-times me-1"></i>Rejeitado</span>',
            'convertido' => '<span class="badge bg-primary"><i class="fas fa-star me-1"></i>Convertido</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Indefinido</span>';
    }

    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor_final, 2, ',', '.');
    }

    public function getDiasParaEventoAttribute()
    {
        return $this->data_evento ? now()->diffInDays($this->data_evento, false) : null;
    }

    public function getEstaVencidoAttribute()
    {
        return $this->data_vencimento && $this->data_vencimento < now() && $this->status === 'pendente';
    }

    // Métodos estáticos
    public static function gerarNumeroOrcamento()
    {
        $ultimo = self::latest('id')->first();
        $numero = $ultimo ? $ultimo->id + 1 : 1;
        return date('Y') . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    public static function getTiposEvento()
    {
        return [
            'Festa Infantil',
            'Casamento',
            'Aniversário Adulto',
            'Formatura',
            'Festa Corporativa',
            'Chá de Bebê',
            'Chá de Cozinha',
            'Batizado',
            'Festa Temática',
            'Outro'
        ];
    }

    // Métodos de ação
    public function aprovar($observacoes = null)
    {
        $this->update([
            'status' => 'aprovado',
            'data_aprovacao' => now(),
            'observacoes_admin' => $observacoes,
            'data_vencimento' => now()->addDays(15) // 15 dias para aceitar
        ]);
    }

    public function rejeitar($observacoes = null)
    {
        $this->update([
            'status' => 'rejeitado',
            'observacoes_admin' => $observacoes
        ]);
    }

    public function converter()
    {
        $this->update([
            'status' => 'convertido'
        ]);
    }

    public function calcularTotal()
    {
        $total = $this->servicos->sum('pivot.preco_total');
        $valorFinal = $total - $this->desconto;
        
        $this->update([
            'valor_total' => $total,
            'valor_final' => $valorFinal
        ]);

        return $valorFinal;
    }
}
