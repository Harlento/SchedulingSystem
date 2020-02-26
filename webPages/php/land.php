<html>
    
    <head>

        <title>Landing Page</title>

    </head>
    
    <body>

        <?php

            session_start();

            //Verify creddentials

            //Include header

            //Include navbar
            //Potentially include mobile navbar

            include "logIn.php";

            if(isset($_SESSION['userType']))
            {

                //Custom content based on user type

                $userType = $_SESSION['userType'];

                switch($userType)
                {

                    case "S":

                        printf("

                            <div>
                                <a href=''></a>
                                <a href=''></a>
                            </div>

                        ");


                        //Include footer

                        break;

                    case "B":

                        printf("

                            <a href=''></a>
                            <a href=''></a>

                        ");

                        //Include footer

                        break;

                    case "C":

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

                        //Include footer

                        break;

                    case "SP":

                        break;

                    default:

                        header("Location: schedule.edenbridge.ca?message=invalidCreds");

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