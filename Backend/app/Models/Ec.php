<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ec extends Model
{
    use HasFactory;

    protected $table = 'ecs';

    protected $primaryKey = 'code_ec';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code_ec',
        'label_ec',
        'desc_ec',
        'nbh_ec',
        'nbc_ec',
        'code_ue',
    ];

    public $timestamps = true;

    public function ue()
    {
        return $this->belongsTo(Ue::class, 'code_ue', 'code_ue');
    }

    public function enseignes()
    {
        return $this->hasMany(Enseigne::class, 'code_ec');
    }

    public function programmations()
    {
        return $this->hasMany(programmations::class, 'code_ec');
    }
}
