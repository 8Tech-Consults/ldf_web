<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FarmActivity;

class FarmActivityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FarmActivity::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);

            return response()->json($data);
        }

        return view('FarmActivity.index');
    }

    public function store(Request $request)
    {
       
        switch ($request->type) {
            case 'add':
                $event =FarmActivity::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'description' => $request->description,
                    'farm_id' => $request->farm_id,
                    'user_id' => $request->user_id,
                    
                ]);
                return response()->json($event);
                break;

            case 'update':
                $event = FarmActivity::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return response()->json($event);
                break;

            case 'delete':
                $event = FarmActivity::find($request->id)->delete();
                return response()->json($event);
                break;

            default:
                break;
        }
    }
}
