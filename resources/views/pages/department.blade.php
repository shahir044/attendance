@extends('layout.app')

@section('context')  
{{-- <a href="javascript:window.history.back();"  class="btn btn-primary" style="margin: 10px"> Go Back</a> --}}
    <div class="content">
        <h1>Date: {{\Carbon\Carbon::parse($date)->format('d-M-Y')}}</h1>
        <h1>{{$total[0]->building_name}}: {{$total[0]->Total}}</h1>
    </div>
    <table class="table table-striped table-hover customTable">
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
          <tr>
            <th scope="col">Department Name</th>
            <th scope="col">Total Present</th>
            <th scope="col">Total Manpower</th>
            
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr>
            <td><a href="/attendance/{{$item->building_id}}/{{$item->shop_id}}/{{$date}}">{{$item->department}}</a></td>
            <td>{{$item->Total}}</td>
            @foreach ($total_manpower as $manpower)
              @if ($manpower->department == $item->department)
              <td>{{$manpower->Total}}</td>
              @endif
            @endforeach    
          </tr>
          @endforeach  
        </tbody>
      </table>

@endsection