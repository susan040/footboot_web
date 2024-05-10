@extends('adminlte::page')

@section('title', 'Add ' . $title)

@section('content_header')
    <h1>Add {{ $title }}</h1>
@stop

@section('css')
    @stack('styles')
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form repeater" id="form" name="myForm" action="{{ route($route . 'store') }}"
                            method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
                                @yield('form_content')

                            </div>
                            <div class="card-footer">
                                <button type="submit" id="button_submit" class="button_submit btn btn-primary">Submit
                                </button>
                                @if (isset($addMoreButton))
                                    <button type="submit" id="button_submit_add" class="button_submit btn btn-primary">
                                        Submit & Add new
                                    </button>
                                @endif
                                <a href="javascript:history.back();" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('js')
    @stack('scripts')
@stop
