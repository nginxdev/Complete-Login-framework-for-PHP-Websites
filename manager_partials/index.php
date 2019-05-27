
<!DOCTYPE html>
<html>
<body>

<?php
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

$sql = "SELECT item_id, restaurant_id, item_name, item_category, item_type, item_price FROM menu_items";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table style='border=1'> <tr><td>Item Id</td><td>restaurant_id</td><td>item_name</td><td>item_category</td><td>item_type</td><td>item_price</td></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>". "<td>".$row["item_id"]. "<td>".$row["restaurant_id"]. "<td>".$row["item_name"]. 
        "<td>".$row["item_category"]. "<td>".$row["item_type"]. "<td>".$row["item_price"]. "</tr>";
    }
} else {
    echo "0 results";
}

$conn->close();
?> 

</body>
</html>