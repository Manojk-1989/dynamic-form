<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;   

    protected $table = 'forms';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
}
