<?php
include('../common/session.php');
?>
<html">

<head>
    <title>Welcome page</title>
    <?php
    include("../common/scripts.html");
    ?>
</head>

<body>
<?php
include("menu.php");
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <h3>Welcome <?php echo $login_session; ?></h3>
            </div>
        </div>
    </div>
</body>
</html>