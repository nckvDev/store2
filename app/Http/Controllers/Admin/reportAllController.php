<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportDayExport;
use App\Exports\ReportMonthExport;
use App\Exports\ReportTermExport;
use Carbon\Carbon;
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

    public function reportDays(Request $request)
    {
        $fromDay = $request->input('fromDay');
        $report_days = Borrow::whereDate('created_at', $fromDay)->get();
        return view('admin.reportAll.reportDay', compact('report_days', 'fromDay'));
    }

    public function reportMonths(Request $request)
    {
        $fromMonth = $request->input('fromMonth');
//        dd($fromMonth);
        $regMonth = preg_replace("/^\d+-/", '', $fromMonth);
        $report_months = Borrow::whereMonth('created_at', $regMonth)->get();
        return view('admin.reportAll.reportMonth', compact('report_months', 'regMonth'));
    }

    public function reportTerms(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $report_terms = Borrow::whereBetween('created_at', [$fromDate, $toDate])->get();
        return view('admin.reportAll.reportTerm', compact('report_terms', 'fromDate', 'toDate'));
    }

    public function exportDay(Request $request)
    {
        $fromDay = $request->input('fromDay');
        $nowDay = Carbon::now();
        return (new ReportDayExport)->forDate($fromDay)->download("report_day_{$nowDay}.xlsx");
    }

    public function exportMonth(Request $request)
    {
        $regMonth = $request->input('regMonth');
//        dd($regMonth);
        $nowDay = Carbon::now();
        return (new ReportMonthExport)->forMonth($regMonth)->download("report_month_{$nowDay}.xlsx");
    }

    public function exportTerm(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $nowDay = Carbon::now();
        return (new ReportTermExport)->forTerm($fromDate ,$toDate)->download("report_term_{$nowDay}.xlsx");
    }
}
