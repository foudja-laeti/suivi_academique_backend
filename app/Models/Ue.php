<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function getRouteKeyName(): string
    {
        return 'code_ue';
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
