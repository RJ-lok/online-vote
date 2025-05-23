<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = pg_connect("host=localhost dbname=project user=postgres password=your_new_password");
if (!$conn) {
    die("Connection failed: " . pg_last_error($conn));
}

function showMessage($message) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Submit Vote</title>
        <link rel="stylesheet" href="submit_vote.css" />
    </head>
    <body>
        <div class="screen-center">
            <div class="box">
                <h3><?= htmlspecialchars($message) ?></h3>
                <a href="vote.html">Back to Home</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['candidate']) && isset($_POST['vote_id'])) {
    $candidate = pg_escape_string($conn, $_POST['candidate']);
    $vote_id = pg_escape_string($conn, $_POST['vote_id']);

    $check_query = "SELECT count FROM vote WHERE id = '$vote_id'";
    $check_result = pg_query($conn, $check_query);

    if ($check_result && pg_num_rows($check_result) > 0) {
        $row = pg_fetch_assoc($check_result);

        if ($row['count'] == '0') {
            $update_candidate = "UPDATE ele SET plus = plus + 1 WHERE e_name = '$candidate'";
            $update_vote = "UPDATE vote SET count = 1 WHERE id = '$vote_id'";

            $result1 = pg_query($conn, $update_candidate);
            $result2 = pg_query($conn, $update_vote);

            if ($result1 && $result2) {
                showMessage("Your vote has been recorded successfully.");
            } else {
                showMessage("Error recording vote: " . pg_last_error($conn));
            }
        } else {
            showMessage("You already voted.");
        }
    } else {
        showMessage("Voter ID not found.");
    }
} else {
    showMessage("Invalid vote submission. Please try again.");
}

pg_close($conn);
?>
