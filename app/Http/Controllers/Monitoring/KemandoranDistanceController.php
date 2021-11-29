<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KemandoranDistanceController extends Controller
{
    function index()
    {
        return view('admin.monitoring.kemandoran-distance.index');
    }

    function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $totalRecords = DB::table('kemandoran_with_distance')->select('count(*) as allcount')->count();
        $totalRecordswithFilter = DB::table('kemandoran_with_distance')->select('count(*) as allcount')->where('id_pek', 'like', '%' . $searchValue . '%')->count();

        $records = DB::table('kemandoran_with_distance')
            ->orderBy($columnName, $columnSortOrder)
            ->where('id_pek', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $records
        );

        return response()->json($response);
    }
}
