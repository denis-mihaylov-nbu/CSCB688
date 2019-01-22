<?php
    include('../common/session.php');
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    } else if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 0;
    }
?>

<html>
<head>
    <title>Calendar page</title>
    <style>

        .cell {
            width: 100%;
            border-style: solid;
            border-width: 1px 1px 1px 1px;
            border-color: black;
            text-align: center;
        }

        .prev {
            text-align: left;
        }

        .next {
            text-align: right;
        }

        .hidden {
            visibility: : none;
        }

        .no-padding {
            padding: 0px !important;
            margin:0px !important;
        }

        .workday_header {
            background-color: #F6F6F6;
        }

        .weekend_header {
            background-color: #E9E9E9;
        }

        .workday_available {
            background-color: #C3E8A6;
        }

        .weekend_available {
            background-color: #AFDD8A;
        }

        .workday_not_available {
            background-color: #E8A6A6;
        }

        .weekend_not_available {
            background-color: #E29898;
        }

    </style>
    <?php
    include("../common/scripts.html");
    ?>

    <script>

        $(document).ready(function(){

            var clubid = '<?php echo $clubid?>';

            function selectPage(page){
                $.ajax({
                    url: '../calendar/get_number_of_available_courts.php',
                    type: 'POST',
                    data: {page: page},
                    success: function(data) {
                        console.log(data);
                        var calendar = JSON.parse(data);
                        for (var i in calendar){
                            for (var j in calendar[i]){
                                if ((i == 0) && (j > 0)){
                                    calendar[i][j].value = calendar[i][j].value.replace(",", "<br/>");
                                }
                                $('#cell_' + i + '' + j).html(calendar[i][j].value);
                                $('#cell_' + i + '' + j).addClass(calendar[i][j].class);
                            }
                        }
                        $('#calendar_table').removeClass('hidden');
                        $('.workday_available, .weekend_available').on('click', function(){
                            $('#modal_date').html($(this).attr('timeslot'));
                            var timeslot = $(this).attr('timeslot');
                            $.ajax({
                                url: '../calendar/get_available_courts.php',
                                type: 'POST',
                                data: {timeslot:timeslot},
                                success: function(data) {
                                    var courts = JSON.parse(data);
                                    $('#modal_court').html('');
                                    for (var i in courts){
                                        $('#modal_court').append('<option value="' + courts[i].id + '">' + courts[i].number + ', ' + courts[i].name + '</option>');
                                    }

                                    $('#myModal').modal('show');
                                    $('#myModal #modalOk').on('click', function(){
                                        var reservation = {};
                                        reservation.id = -1;
                                        reservation.club = clubid;
                                        reservation.court = $('#modal_court').val();
                                        reservation.timeslot = timeslot;
                                        $.ajax({
                                            url: '../reservation/save_reservation.php',
                                            type: 'POST',
                                            data: {reservation:reservation},
                                            success : function(data) {
                                                location.reload();
                                            }
                                        })
                                    });
                                }
                            });
                        });
                    }
                });
            }

            <?php
                echo 'selectPage('.$page.')';
            ?>

        });

    </script>
</head>
<body>
<?php
include("../menu/menu.php");
?>
<div class="container">
    <div class="card my-8">
        <div id="calendar_table" class="hidden card-body">
            <div class="row">
                <div class="col-1">
                </div>
                <div class="col-1 no-padding prev">
                    <a href="?page=<?php echo $page - 1;?>" class="btn btn-outline-primary"><</a>
                </div>
                <div class="col-4">
                    <?php

                    $date = new DateTime();
                    date_time_set($date ,8, 0, 0);
                    $date->modify('+'.($page*7).' day');
                    echo '<h5 id="table_header" class="card-title text-center">'.$date->format("d/m/Y");
                    $date->modify('+6 day');
                    echo ' - '.$date->format("d/m/Y").'</h5>';
                    $date->modify('-6 day');
                    ?>
                </div>
                <div class="col-1 no-padding next">
                    <a href="?page=<?php echo $page + 1;?>" class="btn btn-outline-primary">></a>
                </div>
            </div>
<?php
    for ($i=0; $i < 15; $i++){
        echo '<div class="row">';
        for ($j=0; $j < 8; $j++){
            echo '<div class="no-padding col-1">';
            echo '<div id="cell_'.$i.''.$j.'" ';
            if (($i > 0)&&($j > 0)){
                echo 'timeslot="'.$date->format('d/m/Y H').':00" ';
            }
            echo 'class="cell"><br/><br/></div>';

            if ($j > 0){
                $date->modify('+1 day');
            }
            echo '</div>';
        }
        if ($i > 0){
            $date->modify('+1 hour');
        }
        $date->modify('-7 day');
        echo '</div>';
    }
?>
        </div>
    </div>
</div>
<?php
include("reservation_dialog.html");
?>
</body>
</html>
