<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Departament;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::select('employees.*','departaments.name as departaments'
        )->join('departaments','departaments.id','=','employees.departaments_id')->paginate(10);
        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15',
            'departament_id' => 'required|numeric'
        ];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' =>$validator->errors()->all()
            ],400);
        }
        $employee = new Employee($request->input());
        $employee->save();
        return response()->json([
            'status' => true,
            'messagge' =>'Employee created successfully'
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json(['status'=> true,'data' => $employee]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'email' => 'required|email|max:80',
            'phone' => 'required|max:15',
            'departament_id' => 'required|numeric'
        ];
        $validator = Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' =>$validator->errors()->all()
            ],400);
        }
        $employee->update($request->input());
        return response()->json([
            'status' => true,
            'messagge' =>'Employee updated successfully'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'status' => true,
            'messagge' =>'Employee deleted successfully'
        ],200);
    }

    public function EmployeeByDepartament()
{
    $employees = Employee::select(DB::raw('count(employees.id) as count , departaments.name'))
        ->join('departaments', 'departaments.id', '=', 'employees.departaments_id')
        ->groupBy('departaments.name')
        ->get();
    return response()->json($employees);
}
    public function all(){
        $employees = Employee::select('employees.*','departaments.name as departaments'
        )->join('departaments','departaments.id','=','employees.departaments_id')->get();
        return response()->json($employees);
    }
}
