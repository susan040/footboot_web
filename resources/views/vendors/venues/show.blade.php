@extends('templates.show')
@push('styles')
@endpush
@section('form_content')
    <div class="row">
        @if($item->image_url)
            <div class="col-md-6">
                <label>Image: </label><br>
                <img class="img-fluid" style="width: 200px; height: 150px"
                     src="{{$item->image_url}}"
                     alt="Venue Image">
            </div>
        @endif
    </div>
    <div class="row my-4">
        <div class="col-md-6">
            <label for=""><span class="show-text">Name:</span></label> {{ $item->name }}<br>
        </div>
        <div class="col-md-6">
            <label for=""><span class="show-text">Status:</span></label>
            @if($item->status == 'Available')
                <span class="badge badge-success">Available</span>
            @elseif($item->status == 'Not Available')
                <span class="badge badge-secondary">Not Available</span>
            @endif
        </div>
        <div class="col-md-6 my-2">
            <label for=""><span class="show-text">Open Time:</span></label> {{ $item->open_time ?: 'N/A' }}<br>
        </div>
        <div class="col-md-6 my-2">
            <label for=""><span class="show-text">Close Time:</span></label> {{ $item->close_time ?: 'N/A' }}<br>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-12">
            <label for=""><span class="show-text">Rules:</span></label>
            <hr>
            {{ $item->rules }}
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-12">
            <label for=""><span class="show-text">Description:</span></label>
            <hr>
            {{ $item->description }}
        </div>
    </div>

@endsection
