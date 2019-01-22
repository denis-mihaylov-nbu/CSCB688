<?php
include('../common/session.php');
?>
<html>

<head>
    <title>Personal information page</title>
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
            loadClubs();
            loadCourts();
            loadCourtTypes();
        }

        function loadCourts(){
            $.ajax({
                url: '../court/load_courts.php',
                type: 'GET',
                success: function(data) {
                    courts = JSON.parse(data);
                    fillDropdown(courts);
                }
            });
        }

        function fillDropdown(courts){
            for (var i in courts) {
                courtsMap[courts[i].id] = courts[i];
                $('#selectedCourt').append('<option value=' + courts[i].id + '>' + courts[i].number + ', ' + courts[i].court_type_name + ', ' + courts[i].club_name + '</option>');
            }
            $('#selectedCourt').on('change', function(){
                var court = courtsMap[$('#selectedCourt').val()];
                if (court){
                    selectedCourt = court.id;
                    for (var property in court) {
                        $('#' + property).val(court[property]);
                    }
                    $('button#delete').removeAttr('disabled');
                } else {
                    selectedCourt = -1;
                    $('#number').val('');
                    $('#court_type').val(0);
                    $('#club_id').val(0);
                    <?php if ($userid == 1) {
                    echo '$(\'#clubid\').val(0);';
                }?>
                    $('button#delete').attr('disabled', 'disabled');
                }
            });
        }

        function loadClubs(){
            $.ajax({
                url: '../club/load_clubs.php',
                type: 'GET',
                success: function(data) {
                    var clubs = JSON.parse(data);
                    for (var i in clubs){
                        $('#club_id').append(
                            '<option value=' + clubs[i].id + '>' + clubs[i].name + '</option>'
                        );
                    }
                }
            });
        }

        function loadCourtTypes(){
            $.ajax({
                url: '../court/load_court_types.php',
                type: 'GET',
                success: function(data) {
                    var court_types = JSON.parse(data);
                    for (var i in court_types){
                        $('#court_type').append(
                            '<option value=' + court_types[i].id + '>' + court_types[i].name + '</option>'
                        );
                    }
                }
            });
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
include("menu.php");
?>
<div class="container">
    <div class="form-group col-4">

        <?php
        if ($admin){
            echo '<h3>Select court for edit</h3>';
            echo '<select id="selectedCourt" class="form-control">';
            echo '<option selected value="-1">>NEW<</option>';
            echo '</select>';
            echo '<h3>or create new</h3>';
        }
        ?>
        <label for="number">Court number</label>
        <input id="number" type="text" class="form-control" <?php if (!$admin) echo 'disabled'?>/>
        <label for="court_type">Type</label>
        <select id="court_type" class="form-control" <?php if ($userid > 1) echo 'disabled'?>>
            <?php if ($userid == 1) echo '<option value="0">-</option>'?>
        </select>
        <label for="club_id">Club</label>
        <select id="club_id" class="form-control" <?php if ($userid > 1) echo 'disabled'?>>
            <?php if ($userid == 1) echo '<option value="0">-</option>'?>
        </select>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-2">
        <?php
        if ($admin){
            echo '<button id="save" class="btn btn-success btn-block">Save</button></div>';
            echo '<div class="col-2"><button id="delete" class="btn btn-danger btn-block" disabled>Delete</button>';
        }
        ?>
            </div>
        </div>

    </div>
</div>
</body>
</html>