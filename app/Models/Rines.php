<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Rines extends Model
{
    use HasFactory;
    protected $table = 'rines';

    protected $guarded = [];

    public function getThumbUrlAttribute(): string
    {
        $thumb = dirname($this->imagen) . '/thumbs/' . basename($this->imagen);

        // Las imágenes viejas no tienen miniatura: usa la original
        return Storage::disk('public')->exists($thumb)
            ? Storage::url($thumb)
            : Storage::url($this->imagen);
    }
}
