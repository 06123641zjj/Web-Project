<!DOCTYPE html>

<html>
    <head>
        <title> COMP484 Lab4 </title>
    </head>
    
    <body>
        <?php
            //page1 used to login or register (default)
            //page2 tell you whether you succeed to login
            //page3 result of register
            $pageNum=1;
            if(isset($_POST["page"]))
                $pageNum=$_POST["page"];
            $userNameOccupied=false;
            $dbUserName;
            $succeedToLogin=false;
            
            //display page according to the page number
            if($pageNum==1)
            {
        ?>
            <h1> Hello you can login or register here </h1>
            <!--login form-->
            <h2> Login here </h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                <input type="hidden" name="page" value="2">
                <label>Your name: </lable>
                <input type="text" name="lName" > <br>
                <label>Your password: </lable>
                <input type="password" name="lPW" > <br>
                <input type="submit" value="SUBMIT">
            </form>
            <!--register form-->
            <h2> register here </h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                <input type="hidden" name="page" value="3">
                <label>Your name: </lable>
                <input type="text" name="rName" > <br>
                <label>Your password: </lable>
                <input type="password" name="rPW" > <br>
                <input type="submit" value="SUBMIT">
            </form>
            <br><br><br><br><br>
            <p> Team member: Jingjie Zhang (106671199) Jian Chen (104936856)<p>
        <?php
            }

            //login result page
            elseif($pageNum==2)
            {
                if(!isset($_POST["lName"]) || !isset($_POST["lPW"]))
                {
        ?>
                 <p> please go to previous page and enter user name and password </p>
                    
                 <a href="lab4.php" > previous page </a>
        <?php
                }
                else
                {
                    $currUserName=$_POST["lName"];
                    $currPW=$_POST["lPW"];

                    
                    //connect to mysql
                    $query="SELECT * FROM lab4";
                    if(!($database=mysql_connect("localhost","root","Ace8322408919&")))
                        die("could not connect to DB </body></html>");
                    //open db
                    if(!mysql_select_db("comp484",$database))
                    die("could not open userInfo DB" . mysql_error() . " </body></html>");
                    //get result table
                    if(!($result=mysql_query($query,$database)))
                    {
                        print("<p> could not exeute query! </p>");
                        die(mysql_error() . " </body></html> ");
                    }
                    //check result table row by row, try to match the user name and password in database
                    while($row = mysql_fetch_row($result))
                    {
                        $dbUserName=$row[1];
                        $dbPW=$row[2];
                        if($currUserName==$dbUserName && $currPW==$dbPW)
                        {
                            $succeedToLogin=true;
                            break;
                        }
                    }
                    mysql_close($database);
                    
                    //display result according to the result of previous matching
                    if($succeedToLogin)
                        print("<h1> Hello $dbUserName, login succeed !</h1>");
                    else
                        print("<h1> Password or user name is wrong ! </h1>");
        ?>
                
                <p> you can go back to previous page. </p>
                <a href="lab4.php" > previous page </a>    
        <?php
                }
            }
            
            //this is register result page
            else
            {
                $newUserName=$_POST["rName"];
                $newPW=$_POST["rPW"];
                //insert statement
                $inserQ="INSERT INTO lab4 (userId,userName,userPassword) VALUES (null,'".$newUserName."','".$newPW."')";
                //selete statement
                $query="SELECT * FROM lab4";
                //connect database
                if(!($database=mysql_connect("localhost","root","Ace8322408919&")))
                    die("could not connect to DB </body></html>");
                //open db
                if(!mysql_select_db("comp484",$database))
                die("could not open userInfo DB" . mysql_error() . " </body></html>");
                //get result table
                if(!($result=mysql_query($query,$database)))
                {
                    print("<p> could not exeute query! </p>");
                    die(mysql_error() . " </body></html> ");
                }
                //check whether the user name is occupied
                while($row = mysql_fetch_row($result))
                {
                    $dbUserName=$row[1];
                    if($newUserName==$dbUserName)
                    {
                        $userNameOccupied=true;
                        break;
                    }
                }
                
                //display result according to preivous check,also add new row to database if user name is available
                if($userNameOccupied)
                    print("<h1> Sorry user name \"$newUserName\", is occupied.Pick a new name !</h1>");
                else
                {
                    print("<h1> Congraduation this name is no occupied.Succeed to register,you can login with this user  \"$newUserName\" now ! </h1>");
                    mysql_query($inserQ,$database);
                }
                mysql_close($database);
            
        ?>
                <p> you can go back to previous page. </p>
                <a href="lab4.php" > previous page </a>
        <?php
            }
        ?>
    </body>
<html>
















