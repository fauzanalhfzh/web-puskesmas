<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftaran';

    protected $guarded = [];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }
}
