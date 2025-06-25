<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use SoftDeletes;
    
    protected $table = 'form_fields';

    protected $primaryKey = 'id';

    protected $fillable = [
        'form_id',
        'label',
        'name_attribute',
        'id_attribute',
        'element_type',
        'required',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
    ];

    protected $dates = ['deleted_at'];


    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
