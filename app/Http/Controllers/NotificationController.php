<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Notifications');
    }

    /**
     * Get all the Notifications
     * 
     * @return \App\Models\Notification array
     */
    public function list(Request $request)
    {
        return Notification::paginate($request->get('limit', 25));
    }
}
