<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;


class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'precio', 'stock', 'categoria_id'];

    //Relacion con la tabla categorias
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
