<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function employeeReport(){
        $employees = Employee::orderBy('date');

        $pdf = PDF::loadView('reports.employees', ['employees' => $employees]);

        return $pdf->download('employee_report_'.date('Ymd_His').'.pdf');
    }
    
    public function anttendanceReport(){
        $attendances = Attendance::all();

        $pdf = PDF::loadView('reports.attendance', ['attendances' => $attendances]);

        return $pdf->download('employee_report_'.date('Ymd_His').'.pdf');
    }   
}
