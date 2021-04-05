@extends('layout.app')

@section('context')
<a href="/attendance/" class="btn btn-success" style="margin: 10px"> Go Back</a>
    <div class="content">
        <h1>Search Result</h1>
        <h3>{{$date}}</h3>
    </div>
    <table class="table table-striped table-hover customTable">
        <thead  style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Employee Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Department Name</th>
                <th scope="col">Employee ID</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->department_name }}</td>
                    <td>{{ $item->employee_id }}</td>
                    <td style="background-color:#50c572">Present</td>
                </tr>
            @endforeach
            @foreach ($absent as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->department_name }}</td>
                    <td>{{ $item->employee_id }}</td>
                    <td style="background-color:#c54c67">Absent</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
