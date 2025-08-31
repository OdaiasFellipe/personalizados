<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'categoria',
        'preco_base',
        'tipo_preco',
        'min_pessoas',
        'max_pessoas',
        'opcoes_extras',
        'ativo',
        'ordem',
        'icone',
        'observacoes'
    ];

    protected $casts = [
        'preco_base' => 'decimal:2',
        'opcoes_extras' => 'array',
        'ativo' => 'boolean'
    ];

    // Relacionamentos
    public function orcamentos(): BelongsToMany
    {
        return $this->belongsToMany(Orcamento::class, 'orcamento_servicos')
                    ->withPivot(['quantidade', 'preco_unitario', 'preco_total', 'opcoes_selecionadas', 'observacoes'])
                    ->withTimestamps();
    }

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }

    // Acessores
    public function getPrecoFormatadoAttribute()
    {
        $preco = 'R$ ' . number_format($this->preco_base, 2, ',', '.');
        
        switch ($this->tipo_preco) {
            case 'por_pessoa':
                return $preco . ' por pessoa';
            case 'por_hora':
                return $preco . ' por hora';
            case 'personalizado':
                return 'Sob consulta';
            default:
                return $preco;
        }
    }

    public function getIconeHtmlAttribute()
    {
        $icone = $this->icone ?: 'fas fa-star';
        return "<i class='{$icone}'></i>";
    }

    // Métodos estáticos
    public static function getCategorias()
    {
        return [
            'Decoração',
            'Fotografia',
            'Catering',
            'Entretenimento',
            'Som e Iluminação',
            'Buffet',
            'Doces e Bolos',
            'Flores',
            'Transporte',
            'Outros'
        ];
    }

    public static function getTiposPreco()
    {
        return [
            'fixo' => 'Preço Fixo',
            'por_pessoa' => 'Por Pessoa',
            'por_hora' => 'Por Hora',
            'personalizado' => 'Personalizado'
        ];
    }

    // Métodos de cálculo
    public function calcularPreco($numeroPessoas = 1, $horas = 1, $extras = [])
    {
        $preco = $this->preco_base;

        switch ($this->tipo_preco) {
            case 'por_pessoa':
                $preco *= $numeroPessoas;
                break;
            case 'por_hora':
                $preco *= $horas;
                break;
            case 'personalizado':
                return 0; // Precisa de cotação manual
        }

        // Adicionar extras
        if ($this->opcoes_extras && !empty($extras)) {
            foreach ($extras as $extra) {
                if (isset($this->opcoes_extras[$extra])) {
                    $preco += $this->opcoes_extras[$extra];
                }
            }
        }

        return $preco;
    }

    public function validarPessoas($numeroPessoas)
    {
        if ($this->min_pessoas && $numeroPessoas < $this->min_pessoas) {
            return false;
        }

        if ($this->max_pessoas && $numeroPessoas > $this->max_pessoas) {
            return false;
        }

        return true;
    }
}
