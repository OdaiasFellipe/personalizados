<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'imagem', 'preco'];

    protected $casts = [
        'preco' => 'decimal:2'
    ];

    // Relacionamentos
    public function orcamentos(): BelongsToMany
    {
        return $this->belongsToMany(Orcamento::class, 'orcamento_produtos')
                    ->withPivot(['quantidade', 'preco_unitario', 'preco_total', 'observacoes'])
                    ->withTimestamps();
    }

    // Acessores
    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }
}
