@extends('templates.index')

@push('styles')
@endpush

@section('index_content')
    <div class=" container py-5">

        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">

                        <img src="{{ $item->getImage() ? asset($item->getImage()) : asset('images/user-placeholder.png') }}"
                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-3">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-4">{{ auth()->user()->email }}</p>
                        <div class="d-flex justify-content-center mb-2">
                            <a href="{{ route('vendor.profile.edit', auth()->user()->id) }} "> <button type="button"
                                    class="btn btn-primary">Edit</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ auth()->user()->phone ?: 'N/A' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Address</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ auth()->user()->address ?: 'N/A' }}</p>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
