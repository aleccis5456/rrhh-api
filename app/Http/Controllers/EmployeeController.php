<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::with(['department', 'attendance'])->get();


        return response()->json($employees);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees',
            'department_id' => 'required|exists:departments,id'
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,  
            'department_id' => $request->department_id,
        ]);

        return response()->json($employee, 201);
    }

    public function show($id){
        $employee = Employee::with(['department', 'attendance'])->find($id);

        if(!$employee){
            return response()->json(['message' => 'employee not found'], 404);
        }        

        return response()->json([
            'employee' => $employee
        ], 200);
    }

    public function update(Request $request, $id){
        $employee = Employee::find($id);

        if(!$employee){
            return response()->json(['message' => 'employee not found'], 404);
        }

        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable', 
            'department_id' => 'nullable'
        ]);

        $employee->update([
            'name' => $request->name ?? $employee->name,
            'email' => $request->email ?? $employee->email,
            'department_id' => $request->department_id ?? $employee->department_id
        ]);

        return response()->json($employee, 200);
    }

    public function destroy($id){
        $employee = Employee::destroy($id);

        return response()->json(['message' => 'employee deleted'], 200);
    }
}
