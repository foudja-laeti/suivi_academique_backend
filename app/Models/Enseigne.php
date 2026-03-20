<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Enseigne extends Model
{
    use HasFactory;

    protected $table = 'enseignes';
    protected $primaryKey = 'id'; // ✅ clé primaire = id
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'code_pers',
        'code_ec',
        'date_ens',
    ];

    public $timestamps = true;

    // ✅ Génère l'UUID automatiquement à la création
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'code_pers', 'code_pers');
    }

    public function ec()
    {
        return $this->belongsTo(Ec::class, 'code_ec', 'code_ec');
    }
}
