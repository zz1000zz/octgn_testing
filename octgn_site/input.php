<?php
include_once 'db_connect.php';
if(isset($_POST['card_name']) )
{
$sub = $_POST;
//print_r($sub);
//$user = $_SESSION['user_id'];

$mysqli->autocommit(FALSE);
$card = $sub;


$sql = ("INSERT INTO fanz_testing.set13 (card_name, style, set_number, type, endurance, text, traits, copies, PUR, power_rating, rarity, level) VALUES (\"$card[card_name]\", \"$card[style]\", \"$card[set_number]\", \"$card[type]\", \"$card[endurance]\", \"$card[text]\", \"$card[traits]\", \"$card[copies]\", \"$card[PUR]\", \"$card[power_rating]\", \"$card[rarity]\", \"$card[level]\")");


$mysqli->query($sql);
$mysqli->commit();
}
?>


Thank you for submitting the card <?php echo $cut[card_name];?>!<br><br>
Feel free to <a href="create-card.html">submit</a> more cards.

In the meantime, here are the cards currently listed in the database:</br></br>


<?php
$sql = ("SELECT id_cards, card_name, style, set_number, type, endurance, text, traits, copies, PUR, power_rating, rarity, level FROM fanz_testing.set13");
$result = $mysqli->query($sql) or die  ("Error in query: $query " . mysql_error());
$fields = ($result->fetch_fields());
$num_results = mysqli_num_rows($result);


if ($num_results>0) { 
print_r($num_results);
#print_r($fields);

?> 
<table border="1px solid black" width="90%"><tr> <?php


foreach($fields as $field) { 
    ?> <th><?php echo $field->name; ?></th> <?php
}

while($row = $result->fetch_array()){
#print_r($row[12]);

?>
<tr>
<td style="text-align: center;"> <?php echo $row[0]; ?> </td>
<td style="text-align: center;"> <?php echo $row[1]; ?> </td>
<td style="text-align: center;"> <?php echo $row[2]; ?> </td>
<td style="text-align: center;"> <?php echo $row[3]; ?> </td>
<td style="text-align: center;"> <?php echo $row[4]; ?> </td>
<td style="text-align: center;"> <?php echo $row[5]; ?> </td>
<td style="text-align: center;"> <?php echo $row[6]; ?> </td>
<td style="text-align: center;"> <?php echo $row[7]; ?> </td>
<td style="text-align: center;"> <?php echo $row[8]; ?> </td>
<td style="text-align: center;"> <?php echo $row[9]; ?> </td>
<td style="text-align: center;"> <?php echo $row[10]; ?> </td>
<td style="text-align: center;"> <?php echo $row[11]; ?> </td>
<td style="text-align: center;"> <?php echo $row[12]; ?> </td>
</tr>
<?php
}



}?>










