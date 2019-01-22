<?php
include('../common/session.php');
?>
<html>

<head>
    <title>Reserevations</title>
    <?php
    include("../common/scripts.html");
    ?>

    <script>
        $(document).ready(function(){

            var admin = '<?php echo $admin?>';
            var clubid = '<?php echo $clubid?>';

            var selectedCourt = -1;

            var courtsMap = {};

            init();

            function init() {
                loadReservations();
            }

            $('#date').on('change', function(){
                var d = new Date($(this).val());
                loadReservations((d.getDate() <= 9 ? 0 : "") + d.getDate() + "/" + (d.getMonth() < 9 ? 0 : "") + (d.getMonth() + 1) + "/" + d.getFullYear());
            });

            function loadReservations(date){
                var url = '../reservation/load_reservations.php';
                if (date) {
                    url += '?date=' + date;
                }
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        reservations = JSON.parse(data);
                        fillTable(reservations);
                    }
                });
            }

            function fillTable(reservations){
                $('#reservations').html('');
                for (var i in reservations){
                    console.log(reservations[i]);
                    $('#reservations').append($('#reservationRow').html());
                    $('#reservations').find('.col-8').last().html(reservations[i].timeslot + ", court number " + reservations[i].court_number);
                }
            }

            $('button#save').on('click', function (){
                var court = {};
                court.id = selectedCourt;
                court.number = $('#number').val();
                court.type = $('#type').val();
                court.clubid = $('#clubid').val();
                $.ajax({
                    url: '../court/save_court.php',
                    type: 'POST',
                    data: {court: court},
                    success: function(data) {
                        alert(data);
                        location.reload();
                    }
                });
            });

            $('button#delete').on('click', function (){
                var court = {};
                court.id = selectedCourt;
                $.ajax({
                    url: '../court/delete_court.php',
                    type: 'POST',
                    data: {court: court},
                    success: function(data) {
                        location.reload();
                    }
                });
            });
        });
    </script>
</head>

<body>
<?php
include("../menu/menu.php");
?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h3>Reserevations</h3>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col-1">
                    <label for="date">Date</label>
                </div>
                <div class="col-2">
                    <input id="date" type="date" class="form-control"/>
                </div>
            </div>
        </div>
        <div id="reservations" class="col-8">
        </div>
        <div id="reservationRow">
            <div class="row">
                <div class="col-8"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>