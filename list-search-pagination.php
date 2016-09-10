<?php
session_start();
$conn = mysql_connect('localhost','root','') or die (mysql_error());
mysql_select_db('test',$conn);

$data = $_GET;
$sql = "SELECT * FROM user";

$where = [];
if(!empty($data['filter_id'])) {
	$where[] = 'id=' . $data['filter_id'];
}
if(!empty($data['filter_name'])) {
	$where[] = 'username LIKE \'%'.$data['filter_name'].'%\'';
}

if(!empty($where)) {
	//print_r($where);
	//$where =
	$sql .= ' WHERE ' .  implode(' AND ', $where);;
}

$limit = 10;
$start = 0;
if(!empty($data['page'])) {
	$start = ($data['page'] -1) * $limit;
}

$sql .= ' LIMIT '. $start . ', ' . $limit;

echo $sql;

$result2 = mysql_query($sql);

$sql2 = "SELECT COUNT(*) AS total FROM user";
if(!empty($where)) {
	$sql2 .= ' WHERE ' . implode(' AND ', $where);
}
$query_total = mysql_query($sql2);
$total_page = mysql_fetch_row($query_total);
$total_page = ceil($total_page[0]/$limit);

$current_page = isset($_GET['page']) ? $_GET['page'] : 0;
?>
<div>
	<div>
		<form action='test.php' method = 'GET'>
			Username: <input type='text' name='filter_name' placeholder="search" />
			<!--
			<select name='name'>
			  	<option name = 'id' >id</option>
			  	<option value = 'username' selected >username</option>
			  	<option  name = 'level' >level</option>
				<input type='text' name = 'choice' placeholder ='choise username,id,level' />
			</select>
			-->
			ID: <input type='text' name='filter_id' placeholder="search"/>
			<input type='submit' value='search' />
		</form>
	</div>
	<div>
		<a href="add.php">Add user</a>
	</div>
</div>
<div>
	<table align='left' width='400' border='1'>
		<tr>
			<td>stt</td>
			<td>username</td>
			<td>level</td>
			<td>edit</td>
			<td>del</td>
		</tr>
		<?php
		//$sql="select * from user order by id ASC";
		//$query=mysql_query($sql);
		if(mysql_num_rows($result2) == "")
		{
			echo "ko co member nao";
		} else {
			$stt = 0;
			while($row =mysql_fetch_array($result2)){
				$stt++;
				echo "<tr>";
				echo "<td>$row[id]</td>";
				echo "<td>$row[username]</td>";
				if($row['level'] == '1'){
					echo "<td> member</td>";
				} else {
					echo "<td>admin</td>";
				}
				echo "<td><a href='edit_user1.php?userid={$row['id']}'>edit</a></td>";
				echo "<td><a href='delete.php?userid={$row['id']}'>del</a></td>";
				echo "</tr>";
			}
		}
		?>

	</table>
</div>
<div>
	<?php
		if($current_page > 1 && $total_page > 1){
			echo '<a href="test.php?page='.($current_page-1).'">Prev</a> | ';
		}
		
		for($i =1 ;$i <= $total_page ;$i++)
		{
			if($i == $current_page)
			{
				echo "<span>".$i."</span> |";
			} else {
				echo '<a href="test.php?page='.$i.'">'.$i.'</a> | ';
			}
		}
	
		if ($current_page < $total_page && $total_page > 1){
                echo '<a href="test.php?page='.($current_page+1).'">Next</a> | ';
        }
        
	?>
</div>
