<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personalwebsite";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $message = $_POST["message"];

  // Check if the form data should be saved as JSON
  if (isset($_POST["save_as_json"]) && $_POST["save_as_json"] == "true") {
    // Create an array with the form data
    $formData = array(
      'name' => $name,
      'email' => $email,
      'message' => $message,
      'timestamp' => date('Y-m-d H:i:s')
    );

    // Load existing JSON data from a file
    $jsonData = file_get_contents('message.json');
    $data = json_decode($jsonData, true);

    // Add the new form data to the array
    $data['messages'][] = $formData;

    // Save the updated data as JSON
    $jsonData = json_encode($data);
    file_put_contents('message.json', $jsonData);
  }

  // Insert data into the database
  $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
  mysqli_query($conn, $sql);

}

// Close the database connection
mysqli_close($conn);
?>