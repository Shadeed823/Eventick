<form action="{{ $route }}" method="POST">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <!-- Event Name -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Event Name</label>
            <input type="text" name="event_name" class="form-control"
                   value="{{ old('event_name', $ticket->event_name ?? '') }}" required>
            @error('event_name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Event Date -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Event Date</label>
            <input type="date" name="event_date" class="form-control"
                   value="{{ old('event_date', isset($ticket) ? $ticket->event_date->format('Y-m-d') : '') }}" required>
            @error('event_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Seat Number -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Seat Number</label>
            <input type="text" name="seat_number" class="form-control"
                   value="{{ old('seat_number', $ticket->seat_number ?? '') }}">
            @error('seat_number') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Price -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Price (SAR)</label>
            <input type="number" step="0.01" name="price" class="form-control"
                   value="{{ old('price', $ticket->price ?? '') }}" required>
            @error('price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Selling Method -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Selling Method</label>
            <select name="selling_method" id="sellingMethod" class="form-control" required>
                <option value="">-- Select Method --</option>
                <option value="Fixed" {{ old('selling_method', $ticket->selling_method ?? '') == 'Fixed' ? 'selected' : '' }}>Fixed Price</option>
                <option value="Auction" {{ old('selling_method', $ticket->selling_method ?? '') == 'Auction' ? 'selected' : '' }}>Auction</option>
            </select>
            @error('selling_method') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Auction End Date (visible only if Auction) -->
        <div class="col-md-6 mb-3" id="auctionEndDateWrapper"
             style="{{ old('selling_method', $ticket->selling_method ?? '') == 'Auction' ? '' : 'display:none;' }}">
            <label class="form-label">Auction End Date</label>
            <input type="datetime-local" name="auction_end_date" class="form-control"
                   value="{{ old('auction_end_date', isset($ticket) ? $ticket->auction_end_date : '') }}">
            @error('auction_end_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Save Ticket
        </button>
        <a href="{{ route('seller.tickets.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<script>
    document.getElementById('sellingMethod').addEventListener('change', function () {
        document.getElementById('auctionEndDateWrapper').style.display = this.value === 'Auction' ? '' : 'none';
    });
</script>
