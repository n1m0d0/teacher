<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\School;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function user()
    {
        return view('pages.user');
    }

    public function department()
    {
        return view('pages.department');
    }

    public function category()
    {
        return view('pages.category');
    }

    public function area()
    {
        return view('pages.area');
    }
    
    public function level()
    {
        return view('pages.level');
    }

    public function sublevel()
    {
        return view('pages.sublevel');
    }

    public function school()
    {
        return view('pages.school');
    }

    public function classroom(School $school)
    {
        return view('pages.classroom', compact('school'));
    }

    public function student(School $school)
    {
        return view('pages.student', compact('school'));
    }

    public function attendance(School $school)
    {
        return view('pages.attendance', compact('school'));
    }

    public function listing(Attendance $attendance)
    {
        return view('pages.listing', compact('attendance'));
    }
}
