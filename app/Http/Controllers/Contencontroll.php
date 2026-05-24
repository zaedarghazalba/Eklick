<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Antrians;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class Contencontroll extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function home()
    {
        // Get all doctors from database
        $doctors = User::where('role', UserRole::DOKTER)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get total statistics
        $totalDoctors = User::where('role', UserRole::DOKTER)->count();
        $totalPatients = User::where('role', UserRole::USER)->count();
        $totalAntrian = Antrians::count();

        return view('patient.home', compact('doctors', 'totalDoctors', 'totalPatients', 'totalAntrian'));
    }

    public function about()
    {
        // Get all doctors from database
        $doctors = User::where('role', UserRole::DOKTER)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get total statistics
        $totalDoctors = User::where('role', UserRole::DOKTER)->count();
        $totalPatients = User::where('role', UserRole::USER)->count();
        $totalAntrian = Antrians::count();

        return view('patient.about', compact('doctors', 'totalDoctors', 'totalPatients', 'totalAntrian'));
    }

    public function contact()
    {
        return view('patient.contact');
    }
}
