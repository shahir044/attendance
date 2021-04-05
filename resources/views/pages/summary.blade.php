@extends('layout.app')

@section('context')

    <table class="table table-striped table-hover customTable">
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                
                <th scope="col">Building Name</th>
                <th scope="col">Date</th>
                <th scope="col">Total Present</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $item)
                <tr>
                    
                    <td>{{ $item->building_name }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->Total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
