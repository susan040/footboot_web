@extends('templates.index')

@push('styles')
@endpush

@section('index_content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"> ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Order By</th>
                    <th scope="col">Customer </th>
                    <th scope="col">Venue </th>
                    <th scope="col">Booking Date </th>
                    <th scope="col">Start Time </th>
                    <th scope="col">End Time </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <td>
                        <td> {{ $item->id }}</td>
                        <td> {{ $item->status ?: 'N/A' }}</td>
                        <td>
                            @if ($item->customer)
                                <a target="_blank"
                                    href="{{ route('vendor.customers.show', $item->customer->id) }}">{{ $item->customer->name }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td> {{$item->category->name ?: 'N/A'}} </td>
                        <td> {{$item->venue_name ?: 'N/A'}} </td>
                        <td> {{\Carbon\Carbon::parse($item->start_date)->toDateString()}} </td>
                        <td> {{\Carbon\Carbon::parse($item->start_date)->format('H:i')}} </td>
                        <td> {{\Carbon\Carbon::parse($item->end_date)->format('H:i')}} </td>
                        <td>@include('templates.index_actions', ['id' => $item->id])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
