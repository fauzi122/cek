<?php

namespace App\Http\Controllers\adminbti;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Log;
use Carbon\Carbon;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(['permission:Fron Menu']);
    }

    public function index()
    {
        // Get the current date and time
        $currentDateTime = Carbon::now();
        
        // Calculate the date 30 days ago
        $thirtyDaysAgo = $currentDateTime->subDays(30);
        
        // Retrieve logs with old_properties within the last 30 days
        $logs = Log::where('created_at', '>=', $thirtyDaysAgo)
                   ->orderBy('created_at', 'desc')
                   ->get();
        
        // Parse the JSON in old_properties and add it to each log
        foreach ($logs as $log) {
            $log->old_properties = json_decode($log->old_properties, true);
        }
        
        return view('adminbti.log.index', compact('logs'));
    }
    

}

