@extends('templates.show')

@push('styles')
@endpush

@section('form_content')
    <div class="form-group row">
        <div class="col-md-6 mb-3">
            <label>Order Id </label>
            <input type="text" class="form-control" id="input1" value="{{ $item->id }}" placeholder="Name" required
                   name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Order Status </label>
            <input type="text" class="form-control" id="input1" value="{{ $item->status }}" placeholder="Name" required
                   name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Order By </label>
            <input type="text" class="form-control" id="input1" value="{{ $item->user ? $item->user->name : 'N/A' }}"
                   placeholder="Name" required name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Category </label>
            <input type="text" class="form-control" id="input1"
                   value="{{ $item->category ? $item->category->name : 'N/A' }}" placeholder="Name" required
                   name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Venue Name </label>
            <input type="text" class="form-control" id="input1" value="{{ $item->venue_name }}" placeholder="Venue Name"
                   required name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Booking Date </label>
            <input type="text" class="form-control" id="input1" value="{{ \Carbon\Carbon::parse($item->start_date)->toDateString() }}" placeholder="Name"
                   required name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Start Time </label>
            <input type="text" class="form-control" id="input1" value="{{ \Carbon\Carbon::parse($item->start_date)->format('H:i') }}" placeholder="Name"
                   required name="name" disabled readonly>
        </div>

        <div class="col-md-6 mb-3">
            <label>End Time </label>
            <input type="text" class="form-control" id="input1" value="{{ \Carbon\Carbon::parse($item->end_date)->format('H:i') }}" placeholder="Name"
                   required name="name" disabled readonly>
        </div>

        <div class="col-md-6 mb-3">
            <label>Total Amount</label>
            <input type="text" class="form-control" id="input1" value="{{ $item->total_price }}" placeholder="Name"
                   required name="name" disabled readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Description</label>
            <textarea readonly disabled>{{$item->description}}</textarea>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
