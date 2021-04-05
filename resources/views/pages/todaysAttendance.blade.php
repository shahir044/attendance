@extends('layout.app')

@section('context')

    <div class="content">
        
        <h1>Date: {{$date}}</h1>
        <h3>Total Present: {{$total[0]->Total}}</h3>
    </div>
    <table class="table table-striped table-hover customTable">
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Building Name</th>
                <th scope="col">Total Present</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td><a href="/attendance/{{ $item->building_id }}">{{ $item->building_name }}</a></td>
                    <td>{{ $item->Total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
