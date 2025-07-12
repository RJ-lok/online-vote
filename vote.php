<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pass="your_new_password";
$conn = pg_connect("host=localhost port=5432 dbname=project user=postgres password=$pass");

if (!$conn) {
    die("Connection failed: " . pg_last_error($conn));
}

function showMessage($message, $showForm = false, $vote_id = '') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Voting Page</title>
<link rel="stylesheet" href="vote.css" />

    </head>
    <body>
        <div class="screen-center">
            <div class="box">
                <h3><?= htmlspecialchars($message) ?><br></h3>
<?php if ($showForm): ?>
    <form method="post" action="submit_vote.php" class="vote-form">
        <input type="hidden" name="vote_id" value="<?= htmlspecialchars($vote_id) ?>">
             <label class="vote-option">
            <input type="radio" name="candidate" value="Rutuja" required>
            <img src="Rutuja.jpeg" alt="Rutuja" class="candidate-img">
            Rutuja
        </label>
        
       <br>

        <label class="vote-option">
            <input type="radio" name="candidate" value="Shitija">
            <img src="Shitija.jpg" alt="Shitija" class="candidate-img">
            Shitija
        </label><br>

        <label class="vote-option">
            <input type="radio" name="candidate" value="Rajesh">
            <img src="Rajesh.jpeg" alt="Rajesh" class="candidate-img">
            Rajesh
        </label><br>

        <label class="vote-option">
            <input type="radio" name="candidate" value="Rina">
            <img src="Rina.png" alt="Rina" class="candidate-img">
            Rina
        </label>
        <div class="button-group">
        <input type="submit" value="Vote" class="vote-button">

    </form>
<?php endif; ?>


    <a href="index.html" class="back-button">Back to Home</a>     
       </div>
</div>
        </div>
    </body>
    </html>
    <?php
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote_id']) && isset($_POST['aadhaar_last4'])) {
    $vote_id = pg_escape_string($conn, $_POST['vote_id']);
    $aadhar_id = pg_escape_string($conn, $_POST['aadhaar_last4']);

    $check_query = "SELECT * FROM vote WHERE id = '$vote_id' AND aadhar_id ='$aadhar_id'";
    $check_result = pg_query($conn, $check_query);

    if (pg_num_rows($check_result) > 0) {
        $count_query = "SELECT count FROM vote WHERE id = '$vote_id'";
        $count_result = pg_query($conn, $count_query);
        $row = pg_fetch_assoc($count_result);

        if ($row['count'] == 1) {
            showMessage("You have already voted.");
        } else {
            showMessage("Select your candidate:", true, $vote_id);
        }
    } else {
        showMessage("Voter not found. Check voter ID.");
    }
} else {
    header("Location: vote.html");
    exit;
}

pg_close($conn);
?>
