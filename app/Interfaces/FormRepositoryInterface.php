<?php

namespace App\Interfaces;

use App\Models\{Form, FormField};

interface FormRepositoryInterface
{
    public function getAllForms();
    public function find($id);
    public function create(array $data);
    public function updateForm(Form $form, array $data);
    public function deleteForm(Form $form);
    public function deleteFormField(FormField $formField);


    
}
