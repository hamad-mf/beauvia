<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminActivityLog::with('admin');
        
        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        // Filter by admin
        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $activities = $query->orderByDesc('created_at')->paginate(50);
        
        // Get admins and actions for filters
        $admins = User::admins()->get();
        $actions = AdminActivityLog::distinct()->pluck('action');
        
        return view('admin.activity.index', compact('activities', 'admins', 'actions'));
    }
}
