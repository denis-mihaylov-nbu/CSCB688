<div class="row" id="menu">
    <div class="col-1 menu-item">
        <a class="nav-link" href="../menu/management_club.php"><?php if ($admin) { echo 'Club management';} else { echo 'Club information';}?></a>
    </div>
    <?php
        if ($admin) {
            echo '<div class="col-1 menu-item">';
            echo '<a class="nav-link" href="../menu/management_court.php">Court management</a>';
            echo '</div>';
        }
    ?>
    <div class="col-1 menu-item">
        <a class="nav-link" href="../menu/management_user.php"><?php if ($admin) { echo 'User management';} else { echo 'Personal information';}?></a>
    </div>
    <?php
        if (!$admin){
            echo '<div class="col-1 menu-item">';
            echo '<a class="nav-link" href="../receipt/receipt.php">Receipt</a>';
            echo '</div>';
            echo '<div class="col-1 menu-item">';
            echo '<a class="nav-link" href="../calendar/calendar.php">Calendar</a>';
            echo '</div>';
            echo '<div class="col-3"></div>';
        } else {
            echo '<div class="col-4"></div>';
        }
    ?>
    <div class="col-1 menu-item">
        <a class="nav-link" href = "../logout.php">Sign Out</a>
    </div>
</div>