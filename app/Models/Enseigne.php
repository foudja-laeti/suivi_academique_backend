<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Enseigne extends Model
{
    use HasFactory;

    protected $table = 'enseignes';

    protected $primaryKey = ['code_pers', 'code_ec'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
    'id',        // ✅ ajoute ça
    'code_pers',
    'code_ec',
    'date_ens',
];

    public $timestamps = true;

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'code_pers', 'code_pers');
    }

    public function ec()
    {
        return $this->belongsTo(Ec::class, 'code_ec', 'code_ec');
    }
}
