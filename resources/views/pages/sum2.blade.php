@extends('layout.app')

@section('context')

    <div class="content">

        <h1>Month: {{ $date }}</h1>
        {{-- <h1>TEST: {{$reqDate}}</h1> --}}
        {{-- <>TEST: {{$reqDate}}</> --}}

        <form method="get" class="form-inline my-2 my-lg-0">
            <input type="month" value="$month" required name="selectedMonth" class="form-control mr-sm-2"
                placeholder="Search Month" aria-label="Search">
            <button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>



    <table class="table table-striped table-hover customTable">
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <?php
                    $countDate = 0;
                    $totalBuildings = 0;
                    $id[] = '';
                ?>
                <th scope="col"><b>Day<b></th>
                <th scope="col"><b>Date<b></th>
                @foreach ($buildings as $item)
                    <th><b>{{ $item->building_name }}<b></th>
                    <?php
                        $id[$totalBuildings] = $item->building_name;
                        $totalBuildings++;
                    ?>
                @endforeach
            </tr>
        </thead>
        <tbody>

            @foreach ($datas as $item )
                <?php
                    if($countDate == 0){
                        echo '<tr>';
                        echo '<td><b>' . $item->dayName . "<b></td>";
                        echo '<td><b>' . $item->dayDB . '<b></td>';
                        echo '<td>' . $item->Total . '</td>';
                    }
                    else if($countDate > 0 && $countDate<$totalBuildings){

                        if($id[$countDate] != $item->building_name){
                            while ($countDate<$totalBuildings-1) {
                                
                                echo '<td>';
                                $countDate++;

                                if($id[$countDate] == $item->building_name){
                                    
                                    break;
                                }
                            }
                        }
                        if($countDate==$totalBuildings-1 && $id[$countDate] != $item->building_name){
                            echo '<tr>';
                            echo '<td><b>' . $item->dayName . '<b></td>';
                            echo '<td><b>' . $item->dayDB . '<b></td>';
                            $countDate=0;
                        }
                        echo '<td>' . $item->Total . '</td>';
                        
                    }
                
                    $countDate++;

                    if ($countDate == $totalBuildings) {
                        echo '</tr>';
                        $countDate = 0;
                    }
                ?>
            @endforeach
        </tbody>
    </table>

@endsection
