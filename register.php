<?php
include 'dbconnect.php';
 
echo '<h3>Sign up</h3><br>';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<form method="post" action="">
        Username: <input type="text" name="username" /><br>
        Nume intreg: <input type="text" name="name" /><br>
        Parola: <input type="password" name="pass"><br>
        Verificare parola: <input type="password" name="pass_check"><br>
        Adresa: <input type="text" name="address"><br>
        E-mail: <input type="email" name="email"><br>
        <br>
        <input type="submit" value="Inregistreaza-te" />
     </form>';
}
else
{
    
    $errors = array(); /* declare the array for later use */
     
    if(isset($_POST['username']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['username']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['username']) > 32)
        {
            $errors[] = 'The username cannot be longer than 32 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }
     
     
    if(isset($_POST['pass']))
    {
        if($_POST['pass'] != $_POST['pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }
    
    if(!empty($errors)) 
    {
        echo 'Some fields are not filled in correctly...';
        echo '<ul>';
        foreach($errors as $key => $value) 
        {
            echo '<li>' . $value . '</li>'; 
        }
        echo '</ul>';
    }
    else
    {
        
        $sql = "INSERT INTO
                    members(username, name, email, password , address)
                VALUES('" . mysqli_real_escape_string($connection, $_POST['username']) . "',
                        '" . mysqli_real_escape_string($connection, $_POST['name']) . "',
                        '" . mysqli_real_escape_string($connection, $_POST['email']) . "',
                       '" . ($_POST['pass']) . "',
                       '" . mysqli_real_escape_string($connection, $_POST['address']) . "'
                        )";
                         
        $result = mysqli_query($connection, $sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo 'Something went wrong while registering. Please try again later.';
            //echo mysql_error(); //debugging purposes, uncomment when needed
        }
        else
        {
                echo 'Successfully registered. You can now <a href="login.php">log in</a> and start posting! :-)';
            
        }
    }
}

?>