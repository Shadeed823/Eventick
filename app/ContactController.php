<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required_if:user_id,null|string|max:255',
            'email' => 'required_if:user_id,null|email|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'terms' => 'accepted',
        ]);

        try {
            $complaintData = [
                'subject' => $validated['subject'],
                'description' => $validated['description'],
                'status' => 'Pending',
            ];
            if (Auth::check()) {
                $complaintData['user_id'] = Auth::id();
            } else {
                $complaintData['name'] = $validated['name'];
                $complaintData['email'] = $validated['email'];
            }

            $complaint = Complaint::create($complaintData);

            return redirect()->back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }
}
