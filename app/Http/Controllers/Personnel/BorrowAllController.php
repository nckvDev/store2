<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Disposable;
use App\Models\Prefix;
use App\Models\Stock;
use App\Models\Type;
use Illuminate\Http\Request;
use DataTables;

class BorrowAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = Type::all();
        $stocks = Stock::all();
        $devices = Device::all();
        $prefixs = Prefix::all();
        $disposables = Disposable::all();
        return view('users.personnel.borrowAll', compact('stocks', 'prefixs' , 'types' , 'devices' , 'disposables'));

        if($request->ajax()){
            $data = Device::all();
            
            return Datatables::make($data)
            ->addIndexColumn()
            ->addColumn('name', function($data){
                return $data['name'];
            })
            ->rawColumns(['name'])
            ->make(true);
        }

        return view('users.personnel.borrowAll');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.personnel.borrowAll');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $devices = new Device();
        $device->name = $request->name;


        if($device->save()){
            // Alert::success('บันทึก');
            return view('users.personnel.borrowAll');
        }else{
            echo 'failed';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $models = Device::WhereId($id)->first();
        $models = Stock::WhereId($id)->first();
        $models = Disposable::WhereId($id)->first();
        $models->delete();
    }
}