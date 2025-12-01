@extends('shared.app_user')

@section('content')
    <div class="mb-4">
        <h2>Add New Ticket</h2>
    </div>

    @include('seller.tickets.form', [
        'route' => route('seller.tickets.store'),
        'method' => 'POST',
        'ticket' => null
    ])
@endsection
