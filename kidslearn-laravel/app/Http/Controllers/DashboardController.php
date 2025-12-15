<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $progress = $user->getOrCreateProgress();

        return view('dashboard', compact('user', 'progress'));
    }
}
