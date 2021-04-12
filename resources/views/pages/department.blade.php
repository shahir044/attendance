@extends('layout.app')

@section('context')  
{{-- <a href="javascript:window.history.back();"  class="btn btn-primary" style="margin: 10px"> Go Back</a> --}}
    <div class="content">
        <h1>Date: {{$date}}</h1>
        <h1>{{$total[0]->building_name}}: {{$total[0]->Total}}</h1>
    </div>
    <table class="table table-striped table-hover customTable">
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
          <tr>
            <th scope="col">Department Name</th>
            <th scope="col">Total Present</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr>
            <td><a href="/attendance/{{$item->building_id}}/{{$item->shop_id}}/{{$date}}">{{$item->department}}</a></td>
            <td>{{$item->Total}}</td>
          </tr>
          @endforeach  
        </tbody>
      </table>

@endsection