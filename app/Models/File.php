<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class File extends Model
{
    protected $fillable = ['peticione_id', 'name', 'file_path'];

    public function peticione()
    {
        return $this->belongsTo(Peticione::class);
    }
}
