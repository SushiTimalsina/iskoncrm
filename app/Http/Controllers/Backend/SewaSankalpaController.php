<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SewaSankalpa;

class SewaSankalpaController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:sewa-sankalpa-list|sewa-sankalpa-create|sewa-sankalpa-edit|sewa-sankalpa-delete', ['only' => ['index','show']]);
         $this->middleware('permission:sewa-sankalpa-create', ['only' => ['create','store']]);
         $this->middleware('permission:sewa-sankalpa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sewa-sankalpa-delete', ['only' => ['destroy', 'download', 'delete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
