
<?php
$pass="your_new_password";
$conn = pg_connect("host=localhost dbname=project user=postgres password=$pass");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

    $query = "SELECT e_name,plus FROM ele";
    $result = pg_query($conn, $query);

    if (pg_num_rows($result) > 0) {
        echo "Live Result is:<br>";
        echo "<table border='1'>
                <tr> <th>Candidate name</th> 
                <th>vote</th> </tr>";
        while($row = pg_fetch_assoc($result)) 
        {
            echo "<tr> 
                    <td>{$row['e_name']}</td>
                    <td>{$row['plus']}</td>
                  </tr>";
        }
        echo "</table>";
    } 
    else
    {
        echo "error";
    }
pg_close($conn);
?>