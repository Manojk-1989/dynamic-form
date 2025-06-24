<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FormBuilderRequest;
use App\Interfaces\FormRepositoryInterface;
use App\Http\Resources\FormResource;
use App\Models\{Form, FormField};

class FormController extends Controller
{
    protected $formRepo;

    public function __construct(FormRepositoryInterface $formRepo)
    {
        $this->formRepo = $formRepo;
    }


    /**
     * Display a listing of the resource.
     */
    public function showCreateForm()
    {
        return view('admin.pages.form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createForm(FormBuilderRequest $request)
    {
        $validated = $request->validated();
        $forms = $this->formRepo->create($validated);
        return response()->json([
            'status' => 'success',
            'message' => 'Form created successfully.',
            'data' => new FormResource($forms),
        ]);
        dd($forms);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editForm(Form $form)
    {
        $form->load('fields');
        // dd($form);
        return view('admin.pages.form', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateForm(FormBuilderRequest $request, Form $form)
    {
        $validated = $request->validated();

        $updatedForm = $this->formRepo->updateForm($form, $validated);
        dd($updatedForm);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteForm(Form $form)
    {
        $this->formRepo->deleteForm($form);
        return response()->json(['message' => 'Form deleted successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function deleteFormElement($fieldId)
    {
        $formField = FormField::findOrFail($fieldId);
        $this->formRepo->deleteFormField($formField);
        return response()->json(['message' => 'Form deleted successfully']);
    }
    
}
