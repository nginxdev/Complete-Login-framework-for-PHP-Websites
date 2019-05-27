<!DOCTYPE html>
<html>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = test_input($_POST["item_id"]);
    $restaurant_id = test_input($_POST["restaurant_id"]);
    $item_name = test_input($_POST["item_name"]);
    $item_category = test_input($_POST["item_category"]);
    $item_type = test_input($_POST["item_type"]);
    $item_price = test_input($_POST["item_price"]);
    echo $item_id, $restaurant_id, $item_name, $item_category, $item_type, $item_price; 
  }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$servername = "zingerpie.com";
$username = "zing164_pradeep";
$password = "Dael_q433";
$dbname = "zing164_MainDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$int_restaurant_id = (int)$restaurant_id;
$float_item_price = (float)$item_price;
echo "before update";
$sql = "UPDATE menu_items SET restaurant_id='$restaurant_id', item_name='$item_name', item_category='$item_category', 
item_type='$item_type', item_price='$float_item_price' where item_id='$item_id'";
echo "after update";

$result = $conn->query($sql);

$conn->close();
?>

</body>

</body>
</html>