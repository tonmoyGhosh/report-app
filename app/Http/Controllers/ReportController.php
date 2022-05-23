<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function reportView()
    {   
       return view('report');
    }

    public function userIdList()
    {
        $userIds = DB::table('report')->groupBy('user_id')
                    ->where('user_id', '!=', null)->pluck('user_id');
        
        if($userIds)
        {
            $response =  array (
                'status' => true,
                'data'   => $userIds
            );
        }
        else 
        {
            $response =  array (
                'status' => false,
                'data'   => null
            );
        }

        return response()->json($response);
    }

    public function reportData(Request $request)
    {   
        $userId = (int)$request->data['userId'];
        $fromDate = $request->data['fromDate'];
        $endDate = $request->data['endDate'];
       
        $reportData = DB::select("SELECT user_id, event, count(id) as total_used 
                                FROM report WHERE user_id = '".$userId."' AND 
                                DATE_FORMAT(created_at, '%Y-%m-%d') >= '".$fromDate."' AND 
                                DATE_FORMAT(created_at, '%Y-%m-%d') <= '".$endDate."' GROUP BY event
                                ORDER BY count(id) DESC");

        if($reportData)
        {
            $response =  array (
                'status' => true,
                'data'   => $reportData
            );
        }
        else 
        {
            $response =  array (
                'status' => false,
                'data'   => null
            );
        }

        return response()->json($response);
    }
}
