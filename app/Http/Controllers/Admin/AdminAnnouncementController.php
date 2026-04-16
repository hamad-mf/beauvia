<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('created_at')->paginate(25);
        return view('admin.announcements.index', compact('announcements'));
    }
    
    public function create()
    {
        return view('admin.announcements.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success',
            'target_role' => 'required|in:all,customer,shop_owner,freelancer',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        
        $announcement = Announcement::create($request->all());
        
        ActivityLogger::log('announcement_created', $announcement);
        
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created.');
    }
    
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }
    
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success',
            'target_role' => 'required|in:all,customer,shop_owner,freelancer',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        
        $announcement->update($request->all());
        
        ActivityLogger::log('announcement_updated', $announcement);
        
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated.');
    }
    
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        
        ActivityLogger::log('announcement_deleted', $announcement);
        
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
}
