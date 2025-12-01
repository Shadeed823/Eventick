@extends('shared.app_user')

@section('content')
    <div class="mb-4">
        <h2>Edit Ticket</h2>
    </div>

    @include('seller.tickets.form', [
        'route' => route('seller.tickets.update', $ticket->ticket_id),
        'method' => 'PUT',
        'ticket' => $ticket
    ])
@endsection
