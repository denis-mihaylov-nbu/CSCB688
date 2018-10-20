<!DOCTYPE html>
<html>
<body>
<?php

require'db.php';

$sql = "SELECT * FROM user";
$result = db::getInstance()->get_result($sql);

echo '<label>User : </label>';

echo '<select>';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option>".$row['first_name']." ".$row['last_name']."</span></option><hr/>";
    }
}
echo '</select>';

?>
</body>
</html>