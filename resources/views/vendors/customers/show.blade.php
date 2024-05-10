@extends('templates.show')

@push('styles')
@endpush

@section('form_content')
    <div class="form-group row">
        <div class="col-md-6 mb-3">
            <label>Name </label>
            <input type="text" class="form-control" id="input1" value="{{ $item->name }}" placeholder="Name" required
                name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Email </label>
            <input type="text" class="form-control" id="input1" value="{{ $item->email }}" placeholder="Name" required
                name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Phone </label>
            <input type="text" class="form-control" id="input1" value="{{ $item->phone }}"
                placeholder="Name" required name="name" disabled readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label>Address </label>
            <input type="text" class="form-control" id="input1"
                value="{{ $item->address ?: 'N/A' }}" placeholder="Name" required
                name="name" disabled readonly>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
