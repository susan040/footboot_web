@extends('templates.index')

@section('title', 'Vendors')

@section('content_header')
    <h1>Venues</h1>


@stop

@section('ext_css')
@stop

@section('index_content')
    <div class="table-responsive">
        <table class="table w-100" id="data-table">
            <thead>
            <tr class="text-left text-capitalize">
                <th>#id</th>
                <th>venue name</th>
                <th>status</th>
                <th>open time</th>
                <th>close time</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($venues as $item)
                <tr>
                    <td> {{ $item->id }}</td>
                    <td> {{ $item->name }}</td>
                    <td> {{ $item->status }}</td>
                    <td> {{ $item->open_time ?: 'N/A' }}</td>
                    <td> {{ $item->close_time ?: 'N/A' }}</td>
                    <td>@include('templates.index_actions', ['id' => $item->id])</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
