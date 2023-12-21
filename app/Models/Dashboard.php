<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AnimalHealthRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Dashboard extends Model
{
    use HasFactory;

   //livestock health chart
    public static function liveStockHealth()
    {
        // Fetch all health records
        $healthRecords = AnimalHealthRecord::all();
    
        // Initialize arrays to store data for the chart
        $timestamps = [];
        $statusCounts = [];
    
        // Iterate through health records and count occurrences
        foreach ($healthRecords as $record) {
            $date = $record->date;
    
            // Add the date to timestamps if not already present
            if (!in_array($date, $timestamps)) {
                $timestamps[] = $date;
            }
    
            // Initialize count for the status on the date
            if (!isset($statusCounts[$date])) {
                $statusCounts[$date] = [];
            }
    
            // Increment the count for the status on the date
            if (!isset($statusCounts[$date][$record->status])) {
                $statusCounts[$date][$record->status] = 0;
            }
    
            $statusCounts[$date][$record->status]++;
        }
    
        // Sort timestamps in ascending order
        sort($timestamps);
    
        // Prepare data for Chart.js
        $datasets = [];
        $uniqueStatuses = array_unique($healthRecords->pluck('status')->toArray());
    
        foreach ($uniqueStatuses as $status) {
            $data = [];
    
            foreach ($timestamps as $date) {
                $count = isset($statusCounts[$date][$status]) ? $statusCounts[$date][$status] : 0;
                $data[] = $count;
            }
    
            $datasets[] = [
                'label' => $status,
                'data' => $data,
                'fill' => false,
            ];
        }
    
        return view('livestock_health_chart', [
            'timestamps' => $timestamps,
            'datasets' => $datasets,
        ]);
    }
    
    //livestock breed chart
    public static function livestockBreed() 
    {
        $data = DB::table('locations')
            ->join('farms', 'locations.id', '=', 'farms.location_id')
            ->join('breed_farm', 'farms.id', '=', 'breed_farm.farm_id')
            ->join('breeds', 'breed_farm.breed_id', '=', 'breeds.id')
            ->select('locations.name as location_name', 'breeds.name as breed_name', DB::raw('COUNT(*) as breed_count'))
            ->groupBy('locations.name', 'breeds.name')
            ->get();
    
        return view('livestock_breed_chart', compact('data'));
    }

    //production metrics chart

    public static function productionMetrics()
    {
        $data = DB::table('production_records')
        ->join('farms', 'production_records.farm_id', '=', 'farms.id')
        ->join('breeds', 'production_records.breed_id', '=', 'breeds.id')
        ->select( 'breeds.name as breed_name', 'farms.name as farm_name', 'production_records.created_at as date', 'production_records.daily_weight_gain as weight')
        ->groupBy( 'breeds.name', 'farms.name', 'production_records.created_at', 'production_records.daily_weight_gain')
        ->get();

        return view('production_metrics_chart', compact('data'));
    }

    //user activity chart
    public static function userMetrics(Request $request)
    {
        //user activity chart
        $filter = $request->input('filter', 'day'); // Default filter is day
        
        $startDate = now()->sub($filter, 1); // Adjust the start date based on the selected filter

        $userCounts = DB::table('admin_operation_log')
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as time"),
                DB::raw('COUNT(DISTINCT user_id) as user_count') // Count distinct user_ids for each day
            )
            ->get();

        return view('user_activity_chart', compact('userCounts', 'filter'));
    }

    //financial summary chart
    public static function financialSummary()
    {
        $financialRecords = FinancialRecord::all();

        // Group financial records by date
        $groupedRecords = $financialRecords->groupBy(function ($record) {
            return $record->created_at->toDateString(); // Assuming Carbon is used
        });

        $timestamps = $groupedRecords->keys()->toArray();

        // Calculate total income and expenses for each day
        $totals = $groupedRecords->map(function ($records) {
            $income = $records->where('transaction_type', 'Income')->sum('amount');
            $expenses = $records->where('transaction_type', 'Expense')->sum('amount');

            return [
                'income' => $income,
                'expenses' => $expenses,
            ];
        });

        $income = $totals->pluck('income')->toArray();
        $expenses = $totals->pluck('expenses')->toArray();

        return view('financial_records_chart', [
            'timestamps' => $timestamps,
            'income' => $income,
            'expenses' => $expenses,
        ]);
    }

    //calendar events
    public function getCalendarEvents(Request $request)
    {
        // Fetch activities from the database
        $activities = FarmActivity::all();

        // Transform activities into the required format for FullCalendar
        $events = [];
        foreach ($activities as $activity) {
            $events[] = [
                'title' => $activity->name,
                'start' => $activity->scheduled_at->format('Y-m-d'),

            ];
        }

        return response()->json($events);
    }

    //function to get the totals
    public static function cards()
    {
        $data = [
            'total_farmers' => Farmer::count(),
            'pending_farmers' => Farmer::where('status', 'pending')->orWhere('status', null)->count(),
            'total_cooperatives' => Cooperative::count(),
            'pending_cooperatives' => Cooperative::where('status', 'pending')->orWhere('status', null)->count(),
            'total_input_providers' => ServiceProvider::count(),
            'pending_input_providers' => ServiceProvider::where('status', 'pending')->orWhere('status', null)->count(),
            'pending_vets' => Vet::where('status', 'pending')->orWhere('status', null)->count(),
            'total_vets' => Vet::count(),
        ];

        return view('user_cards', ['data' => $data]);
    }

    
}
