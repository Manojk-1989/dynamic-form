<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\FormRepositoryInterface;

class DashboardController extends Controller
{

    protected $formRepo;

    public function __construct(FormRepositoryInterface $formRepo)
    {
        $this->formRepo = $formRepo;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = $this->formRepo->getAllForms();
        return view('admin.pages.dashboard', compact('forms'));
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
    public function store(Request $request)
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
