<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depoimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_cliente',
        'depoimento',
        'avaliacao',
        'foto_cliente',
        'evento_tipo',
        'data_evento',
        'destaque',
        'aprovado'
    ];

    protected $casts = [
        'data_evento' => 'date',
        'destaque' => 'boolean',
        'aprovado' => 'boolean'
    ];

    // Scope para depoimentos aprovados
    public function scopeAprovado($query)
    {
        return $query->where('aprovado', true);
    }

    // Scope para depoimentos em destaque
    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    // Accessor para foto do cliente
    public function getFotoUrlAttribute()
    {
        return $this->foto_cliente ? asset($this->foto_cliente) : asset('images/avatar-default.png');
    }

    // Accessor para estrelas
    public function getEstrelas()
    {
        $estrelas = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->avaliacao) {
                $estrelas .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $estrelas .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $estrelas;
    }

    // Tipos de evento disponíveis
    public static function getTiposEvento()
    {
        return [
            'aniversario_infantil' => 'Aniversário Infantil',
            'aniversario_adulto' => 'Aniversário Adulto',
            'cha_bebe' => 'Chá de Bebê',
            'cha_revelacao' => 'Chá de Revelação',
            'formatura' => 'Formatura',
            'casamento' => 'Casamento',
            'outros' => 'Outros'
        ];
    }
}
