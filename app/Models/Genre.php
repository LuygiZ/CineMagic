<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'custom',
    ];

    public $timestamps = false;

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class, 'genre_code', 'code')->withTrashed();;
    }

}
