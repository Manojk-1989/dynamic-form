<?php

namespace App\Repositories;

use App\Models\{Form, FormField};
use App\Interfaces\FormRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FormRepository implements FormRepositoryInterface
{
    // public function all()
    // {
    //     return Form::all();
    // }
    public function getAllForms()
    {
        return Form::withCount('fields')->latest()->paginate(10);
    }

    public function find($id)
    {
        return Form::findOrFail($id);
    }

    public function create(array $data): Form
    {
        return DB::transaction(function () use ($data) {
            // Create the Form first
            $form = Form::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
            ]);

            // Prepare arrays for bulk insert
            $labels     = $data['label'] ?? [];
            $names      = $data['name'] ?? [];
            $types      = $data['field_type'] ?? [];
            $requireds  = $data['required'] ?? [];
            $optionsArr = $data['options_or_values'] ?? [];

            $fieldsToInsert = [];

            foreach ($labels as $index => $label) {
                $options = null;

                if (!empty($optionsArr[$index]) && strtolower($optionsArr[$index]) !== 'null') {
                    $decoded = json_decode($optionsArr[$index], true);
                    $options = is_array($decoded) ? $decoded : null;
                }

                $fieldsToInsert[] = [
                    'form_id'        => $form->id,
                    'label'          => $label,
                    'name_attribute' => $names[$index] ?? null,
                    'element_type'   => $types[$index] ?? null,
                    'required'       => isset($requireds[$index]) && $requireds[$index] == '1',
                    'options'        => $options ? json_encode($options) : null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            // Single query to insert all fields
            if (count($fieldsToInsert) > 0) {
                FormField::insert($fieldsToInsert);
            }

            return $form;
        });
    }

    // public function create(array $data)
    // {dd($data);
    //     return Form::create($data);
    // }
    public function updateForm(Form $form, array $data)
    {
    return DB::transaction(function () use ($form, $data) {
        // Update form title/description
        $form->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        // Delete existing form fields
        $form->fields()->delete();

        // Prepare bulk insert data
        $labels     = $data['label'] ?? [];
        $names      = $data['name'] ?? [];
        $types      = $data['field_type'] ?? [];
        $requireds  = $data['required'] ?? [];
        $optionsArr = $data['options_or_values'] ?? [];

        $fieldsToInsert = [];

        foreach ($labels as $index => $label) {
            $options = null;

            if (!empty($optionsArr[$index]) && strtolower($optionsArr[$index]) !== 'null') {
                $decoded = json_decode($optionsArr[$index], true);
                $options = is_array($decoded) ? $decoded : null;
            }

            $fieldsToInsert[] = [
                'form_id'        => $form->id,
                'label'          => $label,
                'name_attribute' => $names[$index] ?? null,
                'element_type'   => $types[$index] ?? null,
                'required'       => isset($requireds[$index]) && $requireds[$index] == '1',
                'options'        => $options ? json_encode($options) : null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        // Batch insert new fields
        if (!empty($fieldsToInsert)) {
            FormField::insert($fieldsToInsert);
        }

        return $form->fresh('fields');
    });
}



    public function deleteForm(Form $form)
    {
        return DB::transaction(function () use ($form) {
        // Soft delete related form fields
        $form->fields()->delete();

        // Soft delete the form itself
        return $form->delete();
    });
    }
}
