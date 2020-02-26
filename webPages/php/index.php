<html>

    <head>

        <title>Log in</title>

    </head>

    <body>

        <?php

            session_start();

            //Include header

            //Include navbar
            //Potentially include mobile navbar

            printf("
                
                <form action='land.php'>
                    <input type='text' name='userName' value='$userName' /><br /><br />
                    <input type='password' name='password' value='' /><br /><br />
                    <input type='submit' value='Login'>
                </form>

            ");

            //Include footer

        ?>

    </body>

</html>