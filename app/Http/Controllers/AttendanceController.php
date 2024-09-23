<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
// use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //employee_id, date, check_in, check_out
    public function index(){
        $attendance = Attendance::with('employee')->get();

        return response()->json($attendance);
    }
    
    public function store(Request $request){
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required',
            'check_in' => 'required',
            'check_out' => 'required'
        ]);

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,  
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
        ]);

        return response()->json($attendance, 201);
    }

    public function show($id){
        $attendance = Attendance::find($id)->with('employee');

        if(!$attendance){
            return response()->json(['message' => 'attendance not found'], 404);
        }

        return response()->json([
            'attendance' => $attendance,            
        ], 200);
    }

    public function update(Request $request, $id){
        $attendance = Attendance::find($id);

        if(!$attendance){
            return response()->json(['message' => 'attendance not found'], 404);
        }

        $request->validate([
            'employee_id' => 'nullable',
            'date' => 'nullable',
            'check_in' => 'nullable',
            'check_out' => 'nullable'
        ]);

        $attendance->update([
            'employee_id' => $request->employee_id ?? $attendance->employee_id,
            'date' => $request->date ?? $attendance->date,  
            'check_in' => $request->check_in ?? $attendance->check_in,
            'check_out' => $request->check_out ?? $attendance->check_out,
        ]);

        return response()->json($attendance, 200);
    }

    public function destroy($id){
        $attendance = Attendance::destroy($id);

        return response()->json(['message' => 'attendance deleted'], 200);
    }
}
