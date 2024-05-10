@extends('templates.show')
@push('styles')
@endpush
@section('form_content')
    <div class="row">
        @if($item->image_url)
            <div class="col-md-6">
                <label>Image: </label><br>
                <img class="img-fluid img-circle" style="width: 200px; height: 150px"
                     src="{{$item->image_url}}"
                     alt="Vendor Image">
            </div>
        @endif
    </div>

    <div class="row my-4">
        <div class="col-md-6">
            <label for=""><span class="show-text">Name:</span></label> {{ $item->name }}<br>
        </div>
        <div class="col-md-6">
            <label for=""><span class="show-text">Email:</span></label> {{ $item->email}}<br>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-md-6">
            <label for=""><span class="show-text">Phone:</span></label> {{ $item->phone ?: '---'}}<br>
        </div>
        <div class="col-md-6">
            <label for=""><span class="show-text">Address:</span></label> {{ $item->address ?: '---' }}<br>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-md-6">
            <label for=""><span class="show-text">Status:</span></label>
            @if($item->status == 'Active')
                <span class="badge badge-success">Active</span>
            @elseif($item->status == 'Inactive')
                <span class="badge badge-secondary">Inactive</span>
            @endif
            <br>
        </div>
    </div>
@endsection
