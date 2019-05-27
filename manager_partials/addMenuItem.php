<!DOCTYPE html>
<html>
<body>

<?php
$item_idErr = $restaurant_idErr = $item_nameErr = $item_categoryErr = $item_typeErr = $item_priceErr = "";
$item_id= $restaurant_id= $item_name= $item_category= $item_type= $item_price= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["item_id"])) {
    $item_idErr = "item_id is required";
  } else {
    $item_id = test_input($_POST["item_id"]);
  }
  if (empty($_POST["restaurant_id"])) {
    $restaurant_idErr = "restaurant_id is required";
  } else {
    $restaurant_id = test_input($_POST["restaurant_id"]);
  }
  if (empty($_POST["item_name"])) {
    $item_nameErr = "item_name is required";
  } else {
    $item_name = test_input($_POST["item_name"]);
  }
  if (empty($_POST["item_category"])) {
    $item_categoryErr = "item_category is required";
  } else {
    $item_category = test_input($_POST["item_category"]);
  }
  if (empty($_POST["item_type"])) {
    $item_typeErr = "item_type is required";
  } else {
    $item_type = test_input($_POST["item_type"]);
  }
  if (empty($_POST["item_price"])) {
    $item_priceErr = "item_price is required";
  } else {
    $item_price = test_input($_POST["item_price"]);
  }
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  item_id: <input type="text" name="item_id">
  <span class="error">* <?php echo $item_idErr;?></span>
  <br><br>
  restaurant_id: <input type="text" name="restaurant_id">
  <span class="error">* <?php echo $restaurant_idErr;?></span>
  <br><br>
  item_name: <input type="text" name="item_name">
  <span class="error">* <?php echo $item_nameErr;?></span>
  <br><br>
  item_category: <input type="text" name="item_category">
  <span class="error">* <?php echo $item_categoryErr;?></span>
  <br><br>
  item_type: <input type="text" name="item_type">
  <span class="error">* <?php echo $item_typeErr;?></span>
  <br><br>
  item_price: <input type="text" name="item_price">
  <span class="error">* <?php echo $item_priceErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit"> 
</form>

<?php
if($item_id != "" && $restaurant_id != "" &&  $item_name != "" &&  
    $item_category != "" &&  $item_type != "" &&  $item_price != ""){
echo "<h2>Input </h2>";
echo $item_id;
echo "<br>";
echo $restaurant_id;
echo "<br>";
echo $item_name;
echo "<br>";
echo $item_category;
echo "<br>";
echo $item_type;
echo "<br>";
echo $item_price;

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
$sql = "INSERT INTO menu_items ( restaurant_id, item_name, item_category, item_type, item_price) 
VALUES ($int_restaurant_id, '$item_name', '$item_category','$item_type', $float_item_price)";

$result = $conn->query($sql);

$conn->close();
}
?>

</body>

</body>
</html>