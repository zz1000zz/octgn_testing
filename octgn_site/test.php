<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == false) : ?>

<p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>


        <?php else : ?>
<?php
$user = htmlentities($_SESSION['username']);
?>
<p>Welcome <?php echo $user;?>!</p>
<?php
$sql = ("SELECT abs.id,title, abstract From izuru_tcp.abstracts as abs

WHERE NOT EXISTS (
SELECT * FROM izuru_tcp.abstracts
WHERE EXISTS (
SELECT * 
FROM abstracts, izuru_tcp.ratings as rats
WHERE abs.id = rats.id_abstract AND rats.id_member = $_SESSION[user_id] AND id_abstract < 51 )
)
AND abs.id<51
ORDER BY RAND()
limit 5");

$result = $mysqli->query($sql) or die  ("Error in query: $query " . mysql_error());
$rs = $result;
$res = $rs;
$fields = ($result->fetch_fields());

$num_results = mysqli_num_rows($result);

if ($num_results>0) { 


?> 

<form name="papers" method="post" action="submit.php">
<input name="Survey" value="1" type="hidden">
<input name="Name" value="<?php echo $user; ?>" type="hidden">



<table border="1px solid black" width="90%"><tr> <?php
foreach($fields as $field) { 
    ?> <th><?php echo $field->name; ?></th> <?php
}
?> </tr> <?php
while($row = mysqli_fetch_array($result)){
  ?><tr><?php

?>


<td style="text-align: center;"> <?php echo $row[0]; ?> </td>
<td style="text-align: center;"> <?php echo $row[1]; ?> </td>
<td style="text-align: center;"> <?php echo $row[2]; ?> </td>

<td>
<input name="<?php echo $row[0]; ?>[abstract]" value="<?php echo $row[0]; ?>" type="hidden">

<select name="<?php echo $row[0]; ?>[endorse]" id="<?php echo $row[0]; ?>">
<option selected="selected" value="">Select...</option>
<option value="1">1. Explicitly Endorses AGW</option>
<option value="2">2. Implicitly Endorses AGW </option>
<option value="3">3. Neutral</option>
<option value="4">4. Implicitly Rejects AGW</option>
<option value="5">5. Explicitly Rejects AGW</option>
</select>

<select name="<?php echo $row[0]; ?>[quantify]" id="<?php echo $row[0]; ?>">
<option selected="selected" value="">Select...</option>
<option value="1">1. AGW >50%</option>
<option value="2">2. No Quantification </option>
<option value="3">3. AGW <50%</option>
</select>
<textarea name="<?php echo$row[0]; ?>[comments]" style="width:100%;height:80px;border:solid 1px gray"></textarea>

</td>

<?php } 

?>

</tr>

</table> 


<input value="Submit My Ratings" class="button" type="submit">

</form>


        <?php 
$thread_id = mysqli_thread_id($mysqli);
$mysqli->kill($thread_id);
}
else{
echo "Sorry, there are currently no abstracts for you to rate.";
}
endif; ?>