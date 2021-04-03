<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh sách chấm công</title>
    <style>
        body {
            font-family: DejaVu Sans
        }
        table, td, th {
            border: 1px solid black;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="height: 500px">
        <caption><h1>Danh sách chấm công {{ $date }}</h1></caption>
        <table id="results" class="table table-bordered">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                    <th>Làm việc</th>
                    <th>Công</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($check_in as $check_in_out)
                    <tr style="
                        <?php 
                            if($check_in_out['special_date_id'] !== null) echo "background-color: #ffe7e7";
                            else if($check_in_out['day_of_week'] == 1 or $check_in_out['day_of_week'] == 7)  echo "background-color: #d3ffd4";
                        ?>
                    ">
                        <td style="width: 100px">
                            {{ $check_in_out['check_in_day'] }}
                            <?php 
                                if($check_in_out['special_date_id'] !== null) {
                                    echo '(Ngày lễ)';
                                }
                            ?>
                        </td>
                        <td>
                            {{ $check_in_out['check_in'] }}
                        </td>
                        <td>
                            {{ $check_in_out['check_out'] }}
                        </td>
                        <td>{{ $check_in_out['time'] }}</td>
                        <td>{{ $check_in_out['number_time'] * $check_in_out['multiply'] }}</td>
                        <td style="width: 260px">
                            <?php
                                if($check_in_out['in_late']){
                                    $date = date_create($check_in_out['in_late']);
                                    echo 'Đi trễ: ' . date_format($date,"H") . ' giờ';
                                    echo ' ' . date_format($date,"i") . ' phút';
                                    echo ' ' . date_format($date,"s") . ' giây';
                                    echo "<br>";
                                }
                                if($check_in_out['out_soon']){
                                    $date = date_create($check_in_out['out_soon']);
                                    echo 'Về sớm: ' . date_format($date,"H") . ' giờ';
                                    echo ' ' . date_format($date,"i") . ' phút';
                                    echo ' ' . date_format($date,"s") . ' giây';
                                    echo "<br>";
                                }
                                if($check_in_out['ot']){
                                    $date = date_create($check_in_out['ot']);
                                    echo 'Tăng ca: ' . date_format($date,"H") . ' giờ';
                                    echo ' ' . date_format($date,"i") . ' phút';
                                    echo ' ' . date_format($date,"s") . ' giây';
                                    echo "<br>";
                                }
                            ?>
                        </td>
                    </tr>
                @endforeach  

                @foreach ($time_leave as $item)
                    @if($item['is_approved'] == 1 && $item['staff_id'] == auth()->user()->id)
                        <tr style="background-color: #ffffe7">
                            <td>
                                <?php
                                    $date = date_create($item['day_time_leave']);
                                    echo date_format($date,"d-m-Y")
                                ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?php 
                                    echo $item['time'] == "08:00:00" ? '1' * $item['multiply'] : '0.5' * $item['multiply']
                                ?>
                            </td>
                            <td><?php echo $item['type'] == "0" ? 'Bổ sung công' : 'Phép năm tính lương' ?></td>
                        </tr>
                    @endif
                @endforeach  
                
                @foreach ($leave_other_table as $item)
                    @if($item['is_approved'] == 1 && $item['staff_id'] == auth()->user()->id)
                        <tr style="background-color: #ffffe7">
                            <td>
                                <?php
                                    $date = date_create($item['day_leave_other']);
                                    echo date_format($date,"d-m-Y");
                                ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?php 
                                    if($item['type_leave'] == 6 or $item['type_leave'] == 7) echo '1';
                                    else echo '0';
                                ?>
                            </td>
                            <td>
                                <?php 
                                    switch ($item['type_leave']) {
                                        case 3:
                                            echo "Phép nghỉ ốm đau ngắn ngày";
                                            break;
                                        case 4:
                                            echo "Phép nghỉ ốm đau dài ngày";
                                            break;
                                        case 5:
                                            echo "Phép thai sản";
                                            break;
                                        case 6:
                                            echo "Phép kết hôn";
                                            break;
                                        case 7:
                                            echo "Phép ma chay";
                                            break;
                                        default:
                                            echo "Phép nghỉ không lương";
                                            break;
                                    }    
                                ?>
                            </td>
                        </tr>
                    @endif
                @endforeach   

                @foreach ($time_special as $item)
                    @if($item['staff_id'] == auth()->user()->id)
                        <tr style="background-color: #ffe7e7">
                            <td>
                                <?php
                                    $date = date_create($item['day_time_special']);
                                    echo date_format($date,"d-m-Y");
                                ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                1
                            </td>
                            <td>
                                Công ngày lễ
                            </td>
                        </tr>
                    @endif
                @endforeach   

                <tr style="background-color: rgb(231, 231, 231)">
                    <td colspan="3">Tổng kết</td>
                    <td>{{ $summary['total_time'] }}</td>
                    <td>{{ $summary['total_number_time_all'] }}</td>
                    <td>
                        Đi trễ: {{ $summary['total_late'] }} <br>
                        Về sớm: {{ $summary['total_soon'] }} <br> 
                        Tăng ca: {{ $summary['total_ot'] }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>