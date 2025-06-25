<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;


class FormViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showUserForm(Form $forms)
    {
        $forms = Form::withCount('fields')->latest()->get();
        return view('user.form-list', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showSelectedUserForm(Form $form)
    {
        $form->load('fields');
        return view('user.form',compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submitUserForm(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
