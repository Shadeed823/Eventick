<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
        $wonAuctions = Bid::where('buyer_id', Auth::id())
            ->where('status', 'accepted')
            ->with(['ticket', 'ticket.seller'])
            ->orderBy('bid_time', 'desc')
            ->get();
        return view('buyer.auctions.won', compact('wonAuctions'));
    }
}
