<!DOCTYPE html>
<html>
<body>

<?php
echo "<h3>Edit Item Details</h3>";
$item_idErr = "";
$item_id= $restaurant_id= $item_name= $item_category= $item_type= $item_price= "";
  if (empty($_GET["item_id"])) {
    $item_idErr = "item_id is required";
    echo "no item id";
  } else {
    $item_id = test_input($_GET["item_id"]);
  }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
/*sql actions get item by item_id*/
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

$sql = "SELECT restaurant_id, item_name, item_category, item_type, item_price FROM menu_items where item_id='$item_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table style='border=1'> <tr><td>Item Id</td><td>restaurant_id</td><td>item_name</td><td>item_category</td><td>item_type</td><td>item_price</td></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>". "<td>".$row["item_id"]. "<td>".$row["restaurant_id"]. "<td>".$row["item_name"]. 
        "<td>".$row["item_category"]. "<td>".$row["item_type"]. "<td>".$row["item_price"]. "</tr>";
        $restaurant_id = $row["restaurant_id"];
        $item_name = (string)$row["item_name"];
        $item_category = $row["item_category"];
        $item_type = $row["item_type"];
        $item_price = $row["item_price"];
    }
} else {
    echo "0 results";
}

$conn->close();
?>
<p><span class="error">* required field.</span></p>
<form method="post" action="editMenuItemPersist.php">  
  item_id: <input type="text" name="item_id" value="<?php echo $item_id?>">
  <br><br>
  restaurant_id: <input type="text" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
  <br><br>
  item_name: <input type="text" name="item_name" value="<?php echo $item_name; ?>">
  <br><br>
  item_category: <input type="text" name="item_category" value="<?php echo $item_category; ?>">
  <br><br>
  item_type: <input type="text" name="item_type" value="<?php echo $item_type; ?>">
  <br><br>
  item_price: <input type="text" name="item_price" value="<?php echo $item_price; ?>">
  <br><br>
  <input type="submit" name="submit" value="Submit"> 
</form>
</body>
</body>
</html>