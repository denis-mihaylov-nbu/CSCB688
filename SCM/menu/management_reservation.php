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

            function loadReservations(){
                $.ajax({
                    url: '../reservation/load_reservations.php',
                    type: 'GET',
                    success: function(data) {
                        reservations = JSON.parse(data);
                        fillTable(reservations);
                    }
                });
            }

            function fillTable(reservations){
                $('#reservations').html('');
                for (var i in reservations){
                    $('#reservations').append('<div class="row"><div class="col-8">' + JSON.stringify(reservations[i]) + '</div></div>');
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
        <div id="reservations" class="col-8">
        </div>
    </div>
</div>
</body>
</html>