<?php
//Connection parameters
    //Hostname
    $host = 'localhost';
    //Username
    $username = 'root';
    //Password
    $pass = null;
    //Database
    $db = 'labels';
			echo '<table border="1">';
				echo'	<thead>	';
				echo'	<tr>';
				echo'				<th >ID</th>';
				echo'				<th >First Name</th>'
			;	echo'				<th >Surname</th>'
			;	echo'				<th >Company</th>'
			;	echo'				<th >Phone Number</th>'
			;	echo'				<th >Visiting</th>'
			;	echo'			</tr>';
				echo'		</thead>';
//MySQL Connection
    $conn = mysqli_connect($host,$username,$pass,$db);
    //Connection Success
    if ($conn != null){file_put_contents('log.txt',"Connection Success \r\n",FILE_APPEND);}
    //Connection Failure
    else{file_put_contents('log.txt',"Connection Failure: \r\n" . mysqli_connect_error() . mysqli_connect_errno(),FILE_APPEND);}
	
//Print last modified
    //Print newline to log
    file_put_contents('log.txt',"\r\n",FILE_APPEND);
    //Get time last modified for log.txt
    $lastmod =  date ("F d Y H:i:s.", filemtime('log.txt'));
    //Print date last modified to log
    file_put_contents('log.txt',$lastmod."\r\n",FILE_APPEND);
	
//Display a list of whoever is currently in the building
    function currentPeople(){
        global $conn;
        $current = "SELECT * FROM details WHERE dleave is NULL";
        $rs = mysqli_query($conn,$current);
        while ($row = mysqli_fetch_array($rs,MYSQLI_ASSOC)){
            echo "<tr>";
            echo "<td>".$row['idDetails']."</td>";
            echo "<td>".$row['fname']."</td>";
            echo "<td>".$row['sname']."</td>";
            echo "<td>".$row['company']."</td>";
            echo "<td>".$row['phone']."</td>";
            echo "<td>".$row['visit']."</td>";
            echo "</tr>";
        }
		echo "</table>";
    }


//Close MySQL connection
	currentPeople();
    mysqli_close($conn);
?>