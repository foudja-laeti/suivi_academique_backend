<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ue extends Model
{
    use HasFactory;

    protected $table = 'ues';
    protected $primaryKey = 'code_ue';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code_ue',
        'label_ue',
        'desc_ue',
        'code_niveau',
    ];

    public $timestamps = true;

    // ✅ Force le route model binding sur code_ue
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('code_ue', $value)->firstOrFail();
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'code_niveau', 'code_niveau');
    }

    public function ecs()
    {
        return $this->hasMany(Ec::class, 'code_ue', 'code_ue');
    }
}
