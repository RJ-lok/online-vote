<!DOCTYPE html>
<html>
<head>
    <title>Live Results</title>
    <style>
        body {
            background: linear-gradient(to right, #6f2b82, #f8b500);
            color: white;
            font-family: Arial, sans-serif;
            font-size: 15px;
        }
        table {
            width: 45%;
            border-collapse: collapse;
            border: 3px solid black;
        }
        th, td {
            border: 2px solid black;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            background: linear-gradient(to bottom, #ffffff, #e0f7ff);
            color: black; /* To ensure text is visible on light background */
        }
        tr {
            background: linear-gradient(to bottom, #ffffff, #e0f7ff);
        }
        h1, h2, h3 {
            color: black;
        }
        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<?php
$pass = "your_new_password"; // Replace with actual PostgreSQL password

$conn = pg_connect("host=localhost dbname=project user=postgres password=$pass");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$query = "SELECT e_name, plus, symbol FROM ele";
$result = pg_query($conn, $query);

if (pg_num_rows($result) > 0) {
    echo "<center>";
    echo "<h1>THE RESULT OF ELECTION</h1><br>";
    echo "<table>
            <tr>
                <th>Candidate Name</th>
                <th>Symbol</th>
                <th>Votes</th>
            </tr>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>
                <td><h3>{$row['e_name']}</h3></td>
                <td><img src='{$row['symbol']}'></td>
                <td>{$row['plus']}</td>
              </tr>";
    }
    echo "</table>";
    echo "</center>";
} else {
    echo "<center><h2>No results found.</h2></center>";
}

pg_close($conn);
?>
</body>
</html>
