<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MntEmployee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Trae todos los empleados
        $employees = MntEmployee::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Empleados',
            'data' => $employees
        ], 200);
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
