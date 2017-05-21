<?php

include 'dbconnect.php';
 
echo '<h3>Sign in</h3><br>';

 
//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        echo '<form method="post" action="">
            Username: <input type="text" name="username" /><br>
            Password: <input type="password" name="pass"><br><br>
            <input type="submit" value="Sign in" />
         </form>';
    }
    else
    {
        $errors = array(); 
         
        if(!isset($_POST['username']))
        {
            $errors[] = 'The username field must not be empty.';
        }
         
        if(!isset($_POST['pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }
         
        if(!empty($errors)) 
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) 
            {
                echo '<li>' . $value . '</li>'; 
            }
            echo '</ul>';
        }
        else
        {
            $sql = "SELECT 
                        id,
                        username
                    FROM
                        members
                    WHERE
                        username = '" . mysqli_real_escape_string($connection, $_POST['username']) . "'
                    AND
                        password = '" . ($_POST['pass']) . "'";
                         
            $result = mysqli_query($connection, $sql);
            if(!$result)
            {
                echo 'Something went wrong while signing in. Please try again later.';
            }
            else
            {
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                }
                else
                {
                    $_SESSION['signed_in'] = true;
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $_SESSION['id']    = $row['id'];
                        $_SESSION['username']  = $row['username'];
                        
                    }
                     
                    echo 'Welcome, ' . $_SESSION['username'] . '. You will be redirected to the main page.';
                    header( "refresh:2.5;url=index.php" );
                }
            }
        }
    }
}
?>