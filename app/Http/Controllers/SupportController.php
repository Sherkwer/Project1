<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user->getRoleName() ?? '';

        if (in_array($role, ['Super Administrator', 'Administrator'])) {
            $tickets = SupportTicket::latest()->paginate(20);
        } else {
            $tickets = SupportTicket::where('user_id', $user->id)->latest()->paginate(20);
        }

        return view('Support.index', compact('tickets'));
    }

    public function create()
    {
        return view('Support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return redirect()->route('support.show', $ticket->id)->with('success', 'Support ticket created.');
    }

    public function show($id)
    {
        $ticket = SupportTicket::with('messages.user')->findOrFail($id);
        $user = Auth::user();
        $role = $user->getRoleName() ?? '';

        if ($ticket->user_id !== $user->id && !in_array($role, ['Super Administrator', 'Administrator'])) {
            abort(403);
        }

        return view('Support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);
        $ticket = SupportTicket::findOrFail($id);
        $user = Auth::user();
        $role = $user->getRoleName() ?? '';

        if ($ticket->user_id !== $user->id && !in_array($role, ['Super Administrator', 'Administrator'])) {
            abort(403);
        }

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        if (in_array($role, ['Super Administrator', 'Administrator'])) {
            $ticket->status = 'responded';
        } else {
            $ticket->status = 'waiting';
        }
        $ticket->save();

        return redirect()->route('support.show', $ticket->id)->with('success', 'Reply added.');
    }

    public function close(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $user = Auth::user();
        $role = $user->getRoleName() ?? '';

        if ($ticket->user_id !== $user->id && !in_array($role, ['Super Administrator', 'Administrator'])) {
            abort(403);
        }

        $ticket->status = 'closed';
        $ticket->save();

        return redirect()->route('support.show', $ticket->id)->with('success', 'Ticket closed.');
    }

    function showUserHelp()
    {
        return view('userhelp&support');
    }
}
