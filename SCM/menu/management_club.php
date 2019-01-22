<?php
include('../common/session.php');
?>
<html>

<head>
    <title>Club information page</title>
    <?php
    include("../common/scripts.html");
    ?>

    <script>
        $(document).ready(function(){

            var clubsMap = {};
            var selectedClub = -1;

            loadClubs();

            function loadClubs(){
                $.ajax({
                    url: '../club/load_clubs.php',
                    type: 'GET',
                    success: function(data) {
                        var clubs = JSON.parse(data);
                        <?php if ($userid == 1) {
                            echo 'handleSuperAdmin(clubs)';
                        } else {
                            echo 'handleRegularUser(clubs)';
                        }?>

                    }
                });
            }

            function handleSuperAdmin(clubs){
                for (var i in clubs){
                    clubsMap[clubs[i].id] = clubs[i];
                    $('#selectedClub').append(
                        '<option value=' + clubs[i].id + '>' + clubs[i].name + '</option>'
                    );
                }
                $('#selectedClub').on('change', function(){
                    var club = clubsMap[$('#selectedClub').val()];
                    if (club){
                        selectedClub = club.id;
                        for (var property in club) {
                            $('#' + property).val(club[property]);
                        }
                        $('button#delete').removeAttr('disabled');
                    } else {
                        selectedClub = -1;
                        $('#name').val('');
                        $('#address').val('');
                        $('button#delete').attr('disabled', 'disabled');
                    }
                });
            }

            function handleRegularUser(clubs){
                selectedClub = clubs[0].id;
                $('#name').val(clubs[0].name);
                $('#address').val(clubs[0].address);
            }

            $('button#save').on('click', function (){
                var club = {};
                club.id = selectedClub;
                club.name = $('#name').val();
                club.address = $('#address').val();
                $.ajax({
                    url: '../club/save_club.php',
                    type: 'POST',
                    data: {club: club},
                    success: function(data) {
                        alert(data);
                        location.reload();
                    }
                });
            });

            $('button#delete').on('click', function (){
                var club = {};
                club.id = selectedClub;
                $.ajax({
                    url: '../club/delete_club.php',
                    type: 'POST',
                    data: {club: club},
                    success: function(data) {
                        alert(data);
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
            if ($userid == 1){
                echo '<h3>Select club for edit</h3>';
                echo '<select id="selectedClub" class="form-control"><option value="0">>NEW<</option>';
                echo '</select>';
                echo '<h3>or create new</h3>';
            }
        ?>
        <label for="name">Name</label>
        <input id="name" type="text" class="form-control" <?php if (!$admin) echo 'disabled'?>/>
        <label for="address">Address</label>
        <input id="address" type="text" class="form-control" <?php if (!$admin) echo 'disabled'?>/>
        <div class="row">
            <div class="col-4"></div>
        <?php
            if ($userid == 1){
                echo '<div class="col-2"><button id="save" class="btn btn-success btn-block">Save</button></div>';
                echo '<div class="col-2"><button id="delete" class="btn btn-danger btn-block" disabled>Delete</button></div>';
            } else {
                if ($admin){
                    echo '<div class="col-2"></div><div class="col-2"><button id="save" class="btn btn-success btn-block">Save</button></div>';
                } else {
                    echo '<div class="col-4"></div>';
                }
            }
        ?>

        </div>
    </div>
</div>
</body>
</html>