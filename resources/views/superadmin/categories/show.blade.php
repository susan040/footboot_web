@extends('templates.show')

@push('styles')
@endpush

@section('form_content')
    <div class="row">
        <div class="col-md-6">
            <label for=""><span class="show-text">Name:</span></label> {{ $item->name }}<br>
        </div>

        <div class="col-md-6">
            <label>Image: </label><br>
            <img class="img-fluid" style="width: 150px; height: 150px"
                 src="{{$item->image_url ?: asset('images/placeholder-image.jpg')}}"
                 alt="Category Image">
        </div>
    </div>
    </div>
@endsection


@push('scripts')
@endpush
