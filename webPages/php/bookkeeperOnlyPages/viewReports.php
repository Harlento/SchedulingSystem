<html>

    <head>

        <title>View Reports</title>

    </head>
    
    <body>

        <?php

            //Includes

            printf("

                <form action=''>

                    From:
                        Start Date:
                            <input type='date'>
                        End Date:
                            <input type='date'><br /><br />

                    Filter by:
                        Client:
                            <select>
                                <option></option>
                            </select>
                        Department:
                            <select>
                                <option></option>
                            </select>

                        Staff:
                            <select>
                                <option></option>
                            </select><br /><br />

                    Show: 
                        Overtime Hours: 
                            <input type='checkbox' name='OTHours' value=''> 
                        Time Discrepancies: 
                            <input type='checkbox' name='timeDiscrep' value=''><br /><br />

                    Order by:
                        Department Name
                            <input type='radio' name='orderBy' value=''>
                        Client Name
                            <input type='radio' name='orderBy' value=''>
                        Staff Name    
                            <input type='radio' name='orderBy' value=''>
                        Hours Worked
                            <input type='radio' name='orderBy' value=''><br /><br />

                    Order:
                        Ascending
                            <input type='radio' name='orderBy' value=''>
                        Decending
                            <input type='radio' name='orderBy' value=''>

                    <input type='submit' value='Generate report'>

                </form>

            ");

            //Make table

            printf("

                <form action=''>
                    <input type='submit' value='Print Report'>
                </form>

                <form action=''>
                    <input type='submit' value='Export to PDF'>
                </form>

            ");

            //Include footer

        ?>

    </body>

</html>