<html>
    <body>
        <form  action="<?php $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="firstname">
        <input type="submit">
        </form>
<?php

    if($_SERVER['REQUEST_METHOD']=='GET')
    {
        $name = $_REQUEST['firstname'];
        if(empty($name))
        {
            echo "Name is Empty";
        }
        else
        {
            echo $name;
        }
    }
?>