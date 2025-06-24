<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;   
    // Table name (optional if it matches "forms")
    protected $table = 'forms';

    protected $primaryKey = 'id';

    // Mass assignable attributes
    protected $fillable = [
        'title',
        'description',  // assuming you have this in your migration
    ];

    protected $dates = ['deleted_at'];

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
}
