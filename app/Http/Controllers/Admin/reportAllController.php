<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportDayExport;
use App\Exports\ReportMonthExport;
use App\Exports\ReportTermExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;
use Illuminate\Support\Facades\DB;

class reportAllController extends Controller
{
    public function index(){
        return view('admin.reportAll.index');
    }

    public function reportDays()
    {
        $report_days = Borrow::whereDay('created_at',now()->day)->get();
        return view('admin.reportAll.reportDay', compact('report_days'));
    }

    public function reportMonths()
    {
        $report_months = Borrow::whereYear('created_at',now()->year)
        ->whereMonth('created_at',now()->month)
        ->get();
        return view('admin.reportAll.reportMonth', compact('report_months'));
    }

    public function reportTerms(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $report_terms = Borrow::whereBetween('created_at', [$fromDate, $toDate])->get();
        return view('admin.reportAll.reportTerm', compact('report_terms', 'fromDate', 'toDate'));
    }

    public function exportDay()
    {
        return Excel::download(new ReportDayExport, 'report_day.xlsx');
    }

    public function exportMonth()
    {
        return Excel::download(new ReportMonthExport, 'report_month.xlsx');
    }

    public function exportTerm(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $nowDay = now()->day;
        return (new ReportTermExport)->forTerm($fromDate ,$toDate)->download("report_term_$nowDay.xlsx");
    }

}
