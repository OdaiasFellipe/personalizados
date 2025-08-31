<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galeria';

    protected $fillable = [
        'titulo',
        'descricao',
        'categoria',
        'imagem',
        'imagem_thumb',
        'tags',
        'destaque',
        'ativo',
        'ordem'
    ];

    protected $casts = [
        'tags' => 'array',
        'destaque' => 'boolean',
        'ativo' => 'boolean'
    ];

    // Scope para itens ativos
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    // Scope para itens em destaque
    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    // Scope por categoria
    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    // Accessor para URL da imagem
    public function getImagemUrlAttribute()
    {
        return asset($this->imagem);
    }

    // Accessor para URL do thumbnail
    public function getThumbUrlAttribute()
    {
        return $this->imagem_thumb ? asset($this->imagem_thumb) : $this->imagem_url;
    }

    // Categorias disponíveis
    public static function getCategorias()
    {
        return [
            'convites' => 'Convites',
            'decoracoes' => 'Decorações',
            'lembrancinhas' => 'Lembrancinhas',
            'bolos' => 'Bolos Personalizados',
            'festa_completa' => 'Festa Completa',
            'temas' => 'Temas Especiais'
        ];
    }
}
