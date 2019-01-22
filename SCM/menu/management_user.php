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

        var userid = '<?php echo $userid?>';
        var admin = '<?php echo $admin?>';
        var clubid = '<?php echo $clubid?>';

        var selectedUser = -1;

        var usersMap = {};

        init();

        function init() {
            loadClubs();
            loadUsers();
        }

        function loadUsers(){
            $.ajax({
                url: '../user/load_users.php',
                type: 'GET',
                success: function(data) {
                    users = JSON.parse(data);
                    <?php
                        if (!$admin){
                            echo 'fillUser(users);';
                        } else {
                            echo 'fillDropdown(users);';
                        }
                    ?>
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
                        $('#clubid').append(
                            '<option value=' + clubs[i].id + '>' + clubs[i].name + '</option>'
                        );
                    }

                }
            });
        }

        function fillUser(users){
            for (var i in users){
                usersMap[users[i].id] = users[i];
                if (users[i].id == userid){
                    for (var property in users[i]) {
                        if (users[i].hasOwnProperty(property)) {
                            $('#' + property).val(users[i][property]);
                        }
                    }
                }
            }
        }

        function fillDropdown(users){
            for (var i in users) {
                usersMap[users[i].id] = users[i];
                $('#selectedUser').append('<option value=' + users[i].id + '>' + users[i].fname + ' ' + users[i].lname + '</option>');
            }
            $('#selectedUser').on('change', function(){
                var user = usersMap[$('#selectedUser').val()];
                if (user){
                    selectedUser = user.id;
                    for (var property in user) {
                        $('#' + property).val(user[property]);
                    }
                    $('button#delete').removeAttr('disabled');
                } else {
                    selectedUser = -1;
                    $('#username').val('');
                    $('#password').val('');
                    $('#fname').val('');
                    $('#lname').val('');
                    $('#role').val(1);
                    <?php if ($userid == 1) {
                        echo '$(\'#clubid\').val(0);';
                    }?>
                    $('button#delete').attr('disabled', 'disabled');
                }
            });
        }



        $('button#save').on('click', function (){
            var user = {};
            user.id = selectedUser;
            user.username = $('#username').val();
            user.password = $('#password').val();
            user.fname = $('#fname').val();
            user.lname = $('#lname').val();
            user.role = $('#role').val();
            user.clubid = $('#clubid').val();
            $.ajax({
                url: '../user/save_user.php',
                type: 'POST',
                data: {user: user},
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
        });

        $('button#delete').on('click', function (){
                var user = {};
                user.id = selectedUser;
                $.ajax({
                    url: '../user/delete_user.php',
                    type: 'POST',
                    data: {user: user},
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
        if ($admin){
            echo '<h3>Select user for edit</h3>';
            echo '<select id="selectedUser" class="form-control">';
            echo '<option selected value="-1">>NEW<</option>';
            echo '</select>';
            echo '<h3>or create new</h3>';
        }
        ?>
        <label for="username">Username</label>
        <input id="username" type="text" class="form-control" <?php if (!$admin) echo 'disabled'?>/>
        <label for="password">Password</label>
        <input id="password" type="password" class="form-control" <?php if (!$admin) echo 'disabled'?>/>
        <label for="fname">First name</label>
        <input id="fname" type="text" class="form-control" <?php if (!$admin) echo 'disabled'?>/>
        <label for="lname">Last name</label>
        <input id="lname" type="text" class="form-control" <?php if (!$admin) echo 'disabled'?>/>
        <label for="role">Role</label>
        <select id="role" class="form-control" <?php if (!$admin) echo 'disabled'?>>
            <option value="1">receptionist</option>
            <option value="2">administrator</option>
        </select>
        <label for="club">Club</label>
        <select id="clubid" class="form-control" <?php if ($userid > 1) echo 'disabled'?>>
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