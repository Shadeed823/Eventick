<?php

namespace App\Http\Controllers;

use App\Constants\TicketStatus;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $tickets = Ticket::where('status', TicketStatus::AVAILABLE)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('tickets'));
    }
    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }



}
