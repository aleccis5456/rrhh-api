<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(){
        $department = Department::all();

        return response()->json($department, 200);
    }

    //index, store, show, update, destroy

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string'
        ]);

        $department = Department::create([
            'name' => ucfirst($request->name)
        ]);

        return response()->json($department, 201);
    }

    public function show($id){  
        $department = Department::find($id);

        if(!$department){
            return response()->json(['message' => 'department not found'], 404);
        }

        return response()->json($department, 200);
    }

    public function update(Request $request, $id){
        $department = Department::find($id);

        if(!$department){
            return response()->json(['message' => 'department not found'], 404);
        }

        $request->validate([
            'name' => 'nullable',            
        ]);

        $department->update([
            'name' => $request->name ?? $department->name,
        ]);

        return response()->json($department, 200);
    }

    public function destroy($id){
        $department = Department::destroy($id);

        return response()->json(['message' => 'department deleted'], 200);
    }

}
