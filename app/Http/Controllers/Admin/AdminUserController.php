<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Search by name, email, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $users = $query->withCount(['bookings', 'reviews'])
            ->orderByDesc('created_at')
            ->paginate(25);
        
        $userCounts = [
            'all' => User::count(),
            'customer' => User::where('role', 'customer')->count(),
            'shop_owner' => User::where('role', 'shop_owner')->count(),
            'freelancer' => User::where('role', 'freelancer')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'userCounts'));
    }
    
    public function show(User $user)
    {
        $user->load(['bookings.bookable', 'reviews', 'shop', 'freelancerProfile']);
        return view('admin.users.show', compact('user'));
    }
    
    public function suspend(User $user)
    {
        $user->update([
            'is_suspended' => true,
            'suspended_at' => now(),
        ]);
        
        ActivityLogger::log('user_suspended', $user);
        
        return back()->with('success', 'User suspended successfully.');
    }
    
    public function reactivate(User $user)
    {
        $user->update([
            'is_suspended' => false,
            'suspended_at' => null,
        ]);
        
        ActivityLogger::log('user_reactivated', $user);
        
        return back()->with('success', 'User reactivated successfully.');
    }
    
    public function destroy(User $user)
    {
        $user->delete(); // Soft delete
        
        ActivityLogger::log('user_deleted', $user);
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:suspend,reactivate,delete',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);
        
        $users = User::whereIn('id', $request->user_ids)->get();
        $count = 0;
        
        foreach ($users as $user) {
            switch ($request->action) {
                case 'suspend':
                    $user->update(['is_suspended' => true, 'suspended_at' => now()]);
                    break;
                case 'reactivate':
                    $user->update(['is_suspended' => false, 'suspended_at' => null]);
                    break;
                case 'delete':
                    $user->delete();
                    break;
            }
            $count++;
        }
        
        ActivityLogger::log("bulk_{$request->action}_users", null, ['count' => $count]);
        
        return back()->with('success', "{$count} users {$request->action}ed successfully.");
    }
}
