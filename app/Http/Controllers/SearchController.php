<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //
    public function index()
    {
        $data = DB::table('people')->paginate(10);
        return view('admin.search', compact('data'));
    }

    public function simple(Request $request)
    {
        $data = DB::table('people');
        if ($request->input('search')) {
            $data = $data->where('name', 'LIKE', "%" . $request->search . "%");
        }

        $data = $data->paginate(10);
        return view('admin.search', compact('data'));
    }

    public function advance(Request $request)
    {
        $data = DB::table('people');
        if ($request->name) {
            $data = $data->where('name', 'LIKE', "%" . $request->name . "%");
        }
        if ($request->address) {
            $data = $data->where('address', 'LIKE', "%" . $request->address . "%");
        }
        if ($request->min_age && $request->max_age) {
            $data = $data->where('age', '>=', $request->min_age)
                ->where('age', '<=', $request->max_age);
        }
        $data = $data->paginate(10);
        return view('admin.search', compact('data'));
    }

    public function searchDate(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $search = DB::table('')->select()
                ->where('date_of_start', '>=', $fromDate)
                ->where('date_of_end', '<=', $toDate)->get();

        return view('', compact('search'));
    }
}
