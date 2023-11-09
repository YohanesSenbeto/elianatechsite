<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //process form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //validate data
    $errors = array();
    if(empty($name)){
        $errors[] = "Please enter your name";
    }
    if(empty($email)){
        $errors[] = "Please enter your email address";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email address";
    }
    if(empty($password)){
        $errors[] = "Please enter a password";
    } elseif(strlen($password) < 8){
        $errors[] = "Password must be at least 8 characters";
    }

    //store data in database
    if(empty($errors)){
        $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        mysqli_query($conn, $sql);
        mysqli_close($conn);

        //confirm registration
        echo "Thank you for registering!";
    } else {
        //display errors
        foreach($errors as $error){
            echo "<p>$error</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
</head>
<body>
	<h1>Registration Form</h1>
	<form method="post">
		<label>Name:</label>
		<input type="text" name="name"><br>

		<label>Email:</label>
		<input type="email" name="email"><br>

		<label>Password:</label>
		<input type="password" name="password"><br>

		<input type="submit" value="Register">
	</form>
</body>
</html>
