<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use SoftDeletes;
    
    protected $table = 'form_fields';

    // Specify primary key (optional because it's 'id' by default)
    protected $primaryKey = 'id';

    // Mass assignable attributes
    protected $fillable = [
        'form_id',
        'label',
        'name_attribute',
        'id_attribute',
        'element_type',
        'required',
        'options',
    ];

    // Cast 'options' JSON column to array automatically
    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
    ];

    protected $dates = ['deleted_at'];


    // Relationship to Form
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
