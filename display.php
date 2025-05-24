
<?php
$pass="your_new_password";
$conn = pg_connect("host=localhost dbname=project user=postgres password=$pass");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

    $query = "SELECT e_name,plus,symbol FROM ele";
    $result = pg_query($conn, $query);

    if (pg_num_rows($result) > 0) {
        echo "<center>";
        echo "<h1>Live Result is:<br></h1>";
        echo "<table border='1' style=width:50%; height=80%;>
                <tr> <th>Candidate name</th> 
                <th>vote</th> 
                <th>symbol</th>
                </tr>";
        while($row = pg_fetch_assoc($result)) 
        {
            echo "<tr> 
                   <td align=center><h3>{$row['e_name']}</h3></td>
                    <td align=center><img src={$row['symbol']}  style=width:150px; height:150px; vertical-align:middle; margin-right:8px;></td>
                     <td align=center>{$row['plus']}</td>
                    </tr>";
        }
        echo "</table>";
    } 
    else
    {
        echo "error";
    }
    echo "</center>";
pg_close($conn);
?>