<?php
//mySQL Connection
global $conn;
$conn = mysqli_connect('localhost','root',null,'labels');
if ($conn != null){
    file_put_contents('log.txt','Connection Success!');
}
else{
    file_put_contents('log.txt','Connection Failure: ' . mysqli_connect_error());
}
//Assign form variables

$fname = $_POST["fname"];
$sname = $_POST["sname"];
$phone = $_POST["phone"];

searchDB($phone);
//Functions

//Delete record from table
function deleteRecord(){
global $conn,$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave;
$stmt = mysqli_prepare($conn,"DELETE * FROM details WHERE (fname = ? OR '') AND (sname = ? OR '') AND (company = ? OR '') AND (phone = ? OR '') AND (carpark = ? OR '') AND (carreg = ?) OR '') AND (visit = ? OR '') AND (darrive = ? OR '') AND (dleave = ? OR '')");
mysqli_stmt_bind_param($stmt,"sssiissss",$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave);
mysqli_stmt_execute($stmt);
}

//Search the table based on details, return resultSet in HTML table
function searchDB($phone){
    global $conn,$fname,$sname,$phone;
    $rs = mysqli_prepare($conn,"SELECT DISTINCT fname,sname,company,phone FROM details WHERE (fname = ? OR '') AND (sname = ? OR '') AND (phone = ? OR '')");
    mysqli_stmt_bind_param($rs,"ssi",$fname,$sname,$phone);
    mysqli_stmt_execute($rs);
    $result = mysqli_stmt_get_result($rs);
    echo "<table>
    <tr>
    <th>First Name</th>
    <th>Surname</th>
    <th>Company</th>
    <th>Phone</th>
    </tr>";
	//$row = mysqli_fetch_array($result);
    while ($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>".$row['fname']."</td>";
    echo "<td>".$row['sname']."</td>";
    echo "<td>".$row['company']."</td>";
    echo "<td>".$row['phone']."</td>";
    }
    echo "</tr></table>";
}

//Insert a new profile into the DB, checking for duplicates
function insertDB(){
    global $conn,$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave;
    $stmt = mysqli_prepare($conn,"INSERT INTO details(fname,sname,company,phone,carpark,carreg,visit,darrive,dleave) VALUES (?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt,"sssiissss",$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave);
    mysqli_stmt_execute($stmt);
}

//Update an existing profile in the DB
function updateDB(){
    global $conn,$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave;
    $stmt = mysqli_prepare($conn,"UPDATE details SET fname = ?, sname = ?, company = ?, phone = ?, carpark = ?, carreg = ?, visit = ?, darrive = ?, dleave = ? ON DUPLICATE KEY UPDATE fname = fname, sname = sname, company = company, phone = phone, carpark = carpark, carreg = carreg, visit = visit, darrive = darrive, dleave = dleave, fullname = fullname");
    mysqli_stmt_bind_param($stmt,"sssiissss",$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave);
    mysqli_stmt_execute($stmt);
}

function fillForm(){

}

//Print out a label with a profile on it
function printLabel(){

}

//Print out an A4 page with a resultSet on it
function printPage(){

}

//Insert a new profile, and print a label for it
function savePrint(){
    global $conn,$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave,$fullname;
    insertDB($conn,$fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave,$fullname);
    printLabel();
}

//Update a profile, then print a label for it
function updatePrint(){
    updateDB();
    printLabel();
}

//Get the range of dates between two dates
function createDateRangeArray($strDateFrom,$strDateTo){
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}
//Search for who was in the building on a given date
function pastDate($conn){
    $userDates = createDateRangeArray("$_POST(date1)","$_POST(date2)");
    $rs = mysqli_query($conn,"SELECT darrive,dleave FROM details");
/*    while ($row = mysqli_fetch_array($rs)){
    $resultArray[] = $row;
    }
    foreach ($resultArray as $result){
    $date[] = substr($result,0,9);
    }*/
//    $date = array_intersect($userDates,$resultArray);
    foreach ($userDates as $day){
    $stmt = mysqli_prepare($conn,"SELECT * FROM details WHERE ? BETWEEN darrive AND dleave");
    mysqli_stmt_bind_param($stmt,"s",$day);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_array($result));
    }
    echo "<table>
    <tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Surname</th>
    <th>Company</th>
    <th>Phone</th>
    <th>Parking?</th>
    <th>Car Registration</th>
    <th>Visiting</th>
    <th>Date & Time of Arrival</th>
    <th>Date & Time of Departure</th>
    </tr>";
    while($row = mysqli_fetch_array($stmt)){
    echo "<tr>";
    echo "<td>".$row['ID']."</td>";
    echo "<td>".$row['First Name']."</td>";
    echo "<td>".$row['Surname']."</td>";
    echo "<td>".$row['Company']."</td>";
    echo "<td>".$row['Phone']."</td>";
    echo "<td>".$row['Parking?']."</td>";
    echo "<td>".$row['Car Registration']."</td>";
    echo "<td>".$row['Visiting']."</td>";
    echo "<td>".$row['Date & Time of Arrival']."</td>";
    echo "<td>".$row['Date & Time of Departure']."</td>";
    }
    echo "</tr></table>";

}

//Display a list of whoever is currently in the building
function currentPeople($conn){
$rs = mysqli_query($conn,"SELECT * FROM details WHERE NOW() between darrive AND dleave");
echo "<table>
<tr>
<th>ID</th>
<th>First Name</th>
<th>Surname</th>
<th>Company</th>
<th>Phone</th>
<th>Parking?</th>
<th>Car Registration</th>
<th>Visiting</th>
<th>Date & Time of Arrival</th>
<th>Date & Time of Departure</th>
</tr>";
while ($row = mysqli_fetch_array($rs)){
echo "<tr>";
echo "<td>".$row['ID']."</td>";
echo "<td>".$row['First Name']."</td>";
echo "<td>".$row['Surname']."</td>";
echo "<td>".$row['Company']."</td>";
echo "<td>".$row['Phone']."</td>";
echo "<td>".$row['Parking?']."</td>";
echo "<td>".$row['Car Registration']."</td>";
echo "<td>".$row['Visiting']."</td>";
echo "<td>".$row['Date & Time of Arrival']."</td>";
echo "<td>".$row['Date & Time of Departure']."</td>";
}
echo "</tr></table>";
}

//Print out the list of whoever is currently in the building
function printCurrent($conn){
currentPeople($conn);
printPage();

}