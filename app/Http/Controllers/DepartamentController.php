<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Departament;
use Illuminate\Http\Request;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departament = Departament::all();
        return response()->json($departament);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = ['name' => 'required|string|min:1|max:100'];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' =>$validator->errors()->all()
            ],400);
        }
        $departament = new Departament($request->input());
        $departament->save();
        return response()->json([
            'status' => true,
            'messagge' =>'Departament created successfully'
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Departament $departament)
    {
        return response()->json(['status'=> true,'data' => $departament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departament $departament)
    {
        $rules = ['name' => 'required|string|min:1|max:100'];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' =>$validator->errors()->all()
            ],400);
        }
        $departament->update($request->input());
        return response()->json([
            'status' => true,
            'messagge' =>'Departament update successfully'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departament $departament)
    {
        $departament->delete();
        return response()->json([
            'status' => true,
            'messagge' =>'Departament deleted successfully'
        ],200);
    }
}
