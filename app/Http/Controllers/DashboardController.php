<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Get recent announcements
        $announcements = Announcement::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        // Get unread notifications
        $notifications = $user->notifications()
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $data = [
            'announcements' => $announcements,
            'notifications' => $notifications,
        ];

        // Role-specific data
        if ($user->isStudent()) {
            // Student dashboard data
            $data['schedules'] = Schedule::where('class', $user->class)
                ->where('is_active', true)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            $data['recentGrades'] = Grade::where('student_id', $user->id)
                ->where('is_published', true)
                ->orderBy('evaluation_date', 'desc')
                ->limit(5)
                ->get();

            $data['payments'] = Payment::where('student_id', $user->id)
                ->orderBy('due_date', 'desc')
                ->limit(5)
                ->get();

        } elseif ($user->isTeacher()) {
            // Teacher dashboard data
            $data['schedules'] = Schedule::where('teacher_id', $user->id)
                ->where('is_active', true)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

        } elseif ($user->isAdmin()) {
            // Admin dashboard data
            $data['stats'] = [
                'total_students' => \App\Models\User::where('role', 'student')->count(),
                'total_teachers' => \App\Models\User::where('role', 'teacher')->count(),
                'total_announcements' => Announcement::count(),
                'pending_payments' => Payment::whereIn('status', ['pending', 'partial', 'overdue'])->count(),
            ];
        }

        return view('dashboard', $data);
    }
}
