@extends('layout.app')

@section('context')
<a href="/attendance/{{$id}}" class="btn btn-primary" style="margin: 10px"> Go Back</a>
    <div class="content">
        <h1>Date: {{$date}}</h1>
        <h3>{{$data[0]->department_name}}</h3>
    </div>
    <table class="table table-striped table-hover customTable">
        <thead  style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Employee Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Employee ID</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->employee_id }}</td>
                    <td style="background-color:#50c572">Present</td>
                </tr>
            @endforeach
        </tbody>

        <tbody>
            @foreach ($absent as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->employee_id }}</td>
                    <td style="background-color:#c54c67">Absent</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
