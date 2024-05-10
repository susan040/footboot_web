@extends('templates.edit')

@push('styles')
@endpush

@section('form_content')
    <div class="form-group row">
        <div class="col-md-6">
            <label for="inputEmail4">Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Name" value="{{ auth()->user()->name }}"
                required name="name">
        </div>
        <div class="col-md-6">
            <label for="inputEmail4">Email<span class="text-danger">*</span></label>
            <input type="email" class="form-control" placeholder="Name" required name="email"
                value="{{ auth()->user()->email }}">
        </div>
        <div class="col-md-6 my-2">
            <label for="inputEmail4">Phone Number<span class="text-danger">*</span></label>
            <input type="number" class="form-control" placeholder="Phone Number" required
                name="phone_number" value="{{ auth()->user()->phone }}">
        </div>
        <div class="col-md-6 my-2">
            <label for="inputState">Image<span class="text-danger">*</span></label>
            <input type="file" class="form-control" name="image" id="image" style="height:45px;">
            <div>
                <img style="width: 100px; height:100px"
                    src="{{ $item->getImage() ? asset($item->getImage()) : asset('images/user-placeholder.png') }}" class="mt-2">
            </div>
        </div>
        <div class="col-md-6 my-2">
            <label for="inputEmail4">Shop Address<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="input1" placeholder="Shop Address" required
                name="address" value="{{ auth()->user()->address }}">
        </div>
    </div>
@endsection


@push('scripts')
@endpush
