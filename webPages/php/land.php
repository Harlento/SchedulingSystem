<html>
    
    <head>

        <title>Landing Page</title>

    </head>
    
    <body>

        <?php

            session_start();

            //Verify creddentials

            if(isset($_SESSION['userType']))
            {

                //Custom content based on user type

                $userType = $_SESSION['userType'];


                switch($userType)
                {

                    case "Staff":

                        printf("

                            <a href=''></a>
                            <a href=''></a>

                        ");

                        break;
                    case "Bookkeeper":

                        printf("

                            <a href=''></a>
                            <a href=''></a>

                        ");

                        break;
                    case "Coordinator":

                        printf("

                            <a href=''></a>
                            <a href=''></a>
                            <a href=''></a>
                            <a href=''></a>
                            <a href=''></a>
                            <a href=''></a>
                            <a href=''></a>
                            <a href=''></a>

                        ");

                        break;
                        //possible default for if something goes wrong an error message could be displayed

                }

            }
            else
            {

                //This will be the address of the log in page this is only a placeholder value with a get variable passed through the redirect
                //the variable can be used to change the login page to say "Invalid credentials" or something like that.
                header("Location: schedule.edenbridge.ca?message=invalidCreds");

            }

        ?>

    </body>

</html>