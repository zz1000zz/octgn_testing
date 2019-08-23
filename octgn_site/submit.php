<?php

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();


if (login_check($mysqli) == false) : ?>

<p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="login.php">login</a>.
            </p>


        <?php else : ?>
<?php

if(isset($_POST['Survey']) )
{
$sub = $_POST;
$cut = array_slice($sub, 2);
$user = $_SESSION['user_id'];


$mysqli->autocommit(FALSE);

foreach ($cut as $paper) {

if (!empty($paper[comments])) {
$sql = ("INSERT INTO izuru_tcp.ratings (id_abstract, id_member, endorse, quantify,comments) VALUES ($paper[abstract],$user,$paper[endorse],$paper[quantify],\"$paper[comments]\")");
}
else {
$sql = ("INSERT INTO izuru_tcp.ratings (id_abstract, id_member, endorse, quantify) VALUES ($paper[abstract],$user,$paper[endorse],$paper[quantify])");
}
//print_r($sql);

$mysqli->query($sql);

}

$mysqli->commit();

}
$name = htmlentities($_SESSION['username']);
?>

Thank you for your participation <?php echo $name;?>!<br><br>
Feel free to <a href="test.php">submit</a> more ratings or visit your <a href="index.php">home page</a> to see your results.

<?php endif; ?>