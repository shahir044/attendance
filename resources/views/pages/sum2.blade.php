@extends('layout.app')

@section('context')

    <table class="table table-striped table-hover customTable">
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <?php
                $countDate = 0;
                $countD = 0;
                $id[]='';
                ?>
                <th scope="col">Date</th>
                @foreach ($buildings as $item)
                <td>{{  $item->building_name }}</td>
                <?php
                $id[$countD]=$item->building_name;
                $countD ++;
                
                ?>
                @endforeach
            </tr>
        </thead>
        <tbody>
            
            @foreach ($datas as $item)
                
            <?php
                if($countDate == 0 )
                {
                    /* echo ' id '. $id[$countDate] ;
                    echo ' item '. $item->building_name ; */

                    if($id[$countDate] == $item->building_name ){
                        
                        echo '<tr>';
                        echo '<td>' . $item->date . '</td>';
                        echo '<td>' . $item->Total . '</td>';
                    }
                    
                    
                }
                else{
                    if($id[$countDate] == $item->building_name){
                        /* echo $id[$countDate]; */
                        echo '<td>' . $item->Total . '</td>';
                    }
                    else {
                        $countDate++;
                        echo '<td>';
                        echo '<td>' . $item->Total . '</td>';
                        
                    }
                    
                }
                if($countDate == $countD){
                    echo '</td>';
                }
                $countDate++;
                if($countDate == $countD){
                    $countDate = 0;
                }
            ?>
                
            @endforeach
        </tbody>
    </table>

@endsection
