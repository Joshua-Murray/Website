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
//MySQL Connection
    $conn = mysqli_connect($host,$username,$pass,$db);
	/*
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
*/
//If method = POST
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        //Cases for action switch
      //  switch ($_POST['action']){
        //    case ("insert"):
			if($_POST["action"]=="insert")
			{
                $fname=$_POST['fname'];
                $sname=$_POST['sname'];
                $company=$_POST['company'];
                $phone=$_POST['phone'];
                $carpark=$_POST['carpark'];
                $carreg=$_POST['carreg'];
                $visit=$_POST['visit'];
                insertDB($fname,$sname,$company,$phone,$carpark,$carreg,$visit);
			}
			else if($_POST["action"]=="current")
			{
				currentPeople();
			}
			else if ($_POST["action"]=="signout")
			{
				$ID=$_POST['id'];
				mysqli_query($conn,"UPDATE details SET dleave=NOW() WHERE idDetails='$ID'");
			}
			else if ($_POST["action"]=="delete")
			{
				$ID=$_POST['id'];
				mysqli_query($conn,"DELETE FROM details WHERE idDetails = '$ID' ");
				//deleteRecord($ID);
			}
			else if ($_POST["action"]=="search")
			{
				$fname=$_POST['fname'];
                $sname=$_POST['sname'];
                $company=$_POST['company'];
                $phone=$_POST['phone'];
				searchDB($fname,$sname,$company,$phone);
			}
			else if ($_POST["action"]=="edit")
			{
				$ID=$_POST["id"];
				displayFilledForm($ID);
			}
        }

//Functions
	//Function to return a filled form.
	function displayFilledForm($ID)
	{
		global $conn;
		$fname=mysqli_query($conn,"SELECT fname from details where idDetails='$ID'");
		$sname=mysqli_query($conn,"SELECT sname from details where idDetails='$ID'");
		$company=mysqli_query($conn,"SELECT company from details where idDetails='$ID'");
		$phone=mysqli_query($conn,"SELECT phone from details where idDetails='$ID'");
		$visit=mysqli_query($conn,"SELECT visit from details where idDetails='$ID'");
		$carreg=mysqli_query($conn,"SELECT carreg from details where idDetails='$ID'");
		$row1=mysqli_fetch_array($fname,MYSQLI_ASSOC);
		$row2=mysqli_fetch_array($sname,MYSQLI_ASSOC);
		$row3=mysqli_fetch_array($company,MYSQLI_ASSOC);
		$row4=mysqli_fetch_array($phone,MYSQLI_ASSOC);
		$row5=mysqli_fetch_array($visit,MYSQLI_ASSOC);
		$row6=mysqli_fetch_array($carreg,MYSQLI_ASSOC);
		

		//$carreg==mysqli_query($conn,"SELECT carreg from details where idDetails='$ID'");
		echo '
						
							<div class="row collapse">
                              		<div class="large-1 columns">
                                  		<label class="inline">First Name</label>
                                	</div>
									<div class="large-11 columns">
										<input type="text" name="fname" id="fname" value="'.$row1["fname"].'">
									</div>
							</div>
                            
							<div class="row collapse">
                              		<div class="large-1 columns">
                                  		<label class="inline">Surname</label>
                                	</div>
									<div class="large-11 columns">
										<input type="text" name="sname" id="sname" value="'.$row2["sname"].'">
									</div>
							</div>

                            <div class="row collapse">
									<div class="large-1 columns">
										<label class="inline">Company</label>
									</div>
									<div class="large-11 columns">
										<input type="text" name="company" id="company"value="'.$row3["company"].'">
									</div>
                            </div>
							
							<div class="row collapse">
								<div class="large-1 columns">
                                  <label class="inline">Phone Number</label>
								</div>
								<div class="large-11 columns">
                                  <input type="text" name="phone" id="phone" value="'.$row4["phone"].'">
								</div>
                            </div>
    
							<div class="row collapse">
								<div class="large-1 columns">
                                  <label class="inline align">Visiting</label>
								</div>
								<div class="large-11 columns">
								  <input type="text" name="visit" id="visit" value="'.$row5["visit"].'">
								</div>
							</div>
							
							<div class="row collapse">
								<div class="large-1 columns">
                                  <label class="inline align">Arrival Time</label>
								</div>
								<div class="large-11 columns">
									<input type="text" name="darrive" id=darrive>
								</div>
							</div>
							
							<!-- Javascript Current Time For Receptionist To See -->
							<script language="javascript" type="text/javascript">
									document.getElementById("darrive").value = Date();
							</script>
							
							<!-- Javascript Print Function -->
							<script language="javascript" type="text/javascript">

									function SendtoLabel() {
										//Send Name To Label For Printing
										var LabelName = document.getElementById("fname").value.toUpperCase() + " " + document.getElementById("sname").value.toUpperCase();
										document.getElementById("LabelVal1").innerHTML = LabelName;
										//Send Company To Label For Printing
										var LabelCompany = document.getElementById("company").value.toUpperCase();
										document.getElementById("LabelVal2").innerHTML = LabelCompany;
										//Send Visiting To Label For Printing
										var LabelVisiting = document.getElementById("visit").value.toUpperCase();
										document.getElementById("LabelVal3").innerHTML =LabelVisiting;
										
										
									}

									function printDiv(printlabel) {
										SendtoLabel();
										//Get the HTML of div
										var divElements = document.getElementById(printlabel).innerHTML;
										//Get The HTML Of Whole Page
										var oldPage = document.body.innerHTML;
										//Reset The Page\'s HTML With Div\'s HTML Only
										document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
										//Print Page
										window.print();
										//Return To HomePage
										window.location="index.html";
															}
							</script>
							
							<div class="row collapse">
								<div class="large-1 column">
									<label>Car Parking</label>
								</div>
								<div class="large-11 columns">
									<ul class="button-group align left">
										<li><input class="carYes" id="carpark" type="radio" name="carpark" value="1"><label for="carpark">Yes</label></li>
										<li><input class="carNo" id="carpark" type="radio" name="carpark" value="0"><label for="carpark">No</label></li>
									</ul>
								</div>
							</div>
							
							<!-- JQuery To Show Car Reg If Car Is Selected -->
							<script>
								$(document).ready(function(){
									$(".carNo").click(function(){
											$("#carreg").hide(500);
											$("#carregl").hide(500);
											$("#carreg").val("");
										});
									$(".carYes").click(function(){
											$("#carreg").show(500);
											$("#carregl").show(500);
										});
								});
							</script>
							
							<div class="row collapse">
                              <div class="large-1 columns">
                                  <label id="carregl" style="display: none" class="inline">Car Registration</label>
                              </div>
                              <div class="large-11 columns">
                                  <input type="text" id="carreg" name="carreg" style="display: none" value="'.$row6["carreg"].'">
                              </div>
                            </div>
							
							<div class="row collapse" >
								<div class="large-12 columns">
									<ul class="button-group align right">
											<li><input value="Save & Print"type="submit" id="saveprint" class="button openet submit"></li>
									</ul>
								</div>
							</div>
							';

							echo '<div style="display:none;" id="printlabel" class="printlabel">
	<div class="row">
		<div class="large-13">
		<img id="layout" src="img/Openet/icon.jpg"></img>
			
			<div id="LabelVal1">Names</div>
			
			<div id="Company" style	="display:inline;"><div id="LabelVal2"style="display:inline;">Company Name</div></div>
			<br>
			<div id="Visiting"style="display:inline;"  >Visiting: <div id="LabelVal3" style="display:inline;">Name</div></div>
			<div ID="Visitor">VISITOR</DIV>
		</div>
	</div>
</div>';
						
			echo '<script type="text/javascript" >
        $(function() {
            $("#saveprint").click(function() {
                var fname = $("#fname").val().toUpperCase();
                var sname = $("#sname").val().toUpperCase();
                var company = $("#company").val().toUpperCase();
                var phone = $("#phone").val().toUpperCase();
                var carpark = $("#carpark").val().toUpperCase();
                var carreg = $("#carreg").val().toUpperCase();
                var visit = $("#visit").val().toUpperCase();

                if(fname=="" || sname=="" || company=="" || phone==""|| visit=="") {
					alert("You must fill out all the fields!");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "testopenet.php",
                        data: {
                            action: "insert",
                            fname: fname,
                            sname: sname,
                            company: company,
                            phone: phone,
                            carpark: carpark,
                            carreg: carreg,
                            visit: visit
                        },
                        success: function(){
							printDiv("printlabel");
							//document.getElementById("errorSuccess").value();
                        }
                    });
                 }
               return false;
             });
         });
    </script>';
		
	}
    //Function to search the DB
    function searchDB($fname,$sname,$company,$phone){
        //Import global connection
            global $conn;
			$fname=addslashes($fname);
			$sname=addslashes($sname);
			$company=addslashes($company);
			$phone=addslashes($phone);
        //Execute query on DB
            $select = "SELECT DISTINCT idDetails,fname,sname,company,phone,carpark,carreg,visit,darrive FROM details"; //(fname LIKE '$fname' OR '') AND (sname LIKE '$sname' OR '') AND (phone LIKE '$phone' OR '') AND (company LIKE '$company' OR '')";
			if($fname != '' || $sname !='' || $phone != '' || $company !='')
			{
				$select.=" WHERE ";
			}
			if ($fname != '')
				{
					$select .=  " (fname LIKE '$fname' OR '') ";
					if($sname !='' || $phone != '' || $company !='')
					{
						$select .=  " AND ";
					}
				}			
			if($sname != '')
				{
					$select .= " (sname LIKE '$sname' OR '') ";
					if($phone != '' || $company !='')
					{
						$select .=  " AND ";
					}
				}
			if($phone != '')
				{
					$select .= " (phone LIKE '$phone' OR '') ";
					if($company !='')
					{
						$select .=  " AND ";
					}
				}
			if($company != '')
				{
					$select.= " (company LIKE '$company' OR '') ";
				}
			//$select=addslashes($select);
            $stmt = mysqli_query($conn,$select)
        //If query error, exit and print error
            or die(mysqli_error($conn));
        //Print out all the results from the query
            while ($row = mysqli_fetch_array($stmt,MYSQLI_ASSOC)) {
                if(empty($row)) {
                    echo "<tr>";
                        echo "<td colspan='4'>There were not records</td>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                        echo "<td>".$row['idDetails']."</td>";
                        echo "<td>".$row['fname']."</td>";
                        echo "<td>".$row['sname']."</td>";
                        echo "<td>".$row['company']."</td>";
                        echo "<td>".$row['phone']."</td>";
						echo '<td><a class="edit">Edit & Print</a></td>';
						echo '<td><a class="delete">Delete Profile</a></td>';
                    echo "</tr>";
                }
        }

		echo '<script type="text/javascript" >
					$(function() 
					{
						$(".edit").click(function() 
						{
							var id =  $("td:first", $(this).parents("tr")).text();
							$.ajax({
								type: "POST",
								url: "testopenet.php",
								data: {
									action:"edit",
									id:id
								},
							success: function(response){
								$("#blankForm").html(response);
                        }
           
             });
						});
					 });
				 </script>';
				 echo '<script type="text/javascript" >
					$(function() 
					{
						$(".delete").click(function() 
						{
							var id =  $("td:first", $(this).parents("tr")).text();
							$.ajax({
								type: "POST",
								url: "testopenet.php",
								data: {
									action:"delete",
									id:id
								},
							success: function(response){
                        }
           
             });
						});
					 });
				 </script>';
				 echo '<script type=text/javascript>
		$(function()
		{
                $(".delete").click(function(){
                var row = $(this).closest("tr");
                row.hide(200);
                });
			});           
		</script>';
    }

    //Function to insert record into the DB
    function insertDB($fname,$sname,$company,$phone,$carpark,$carreg,$visit){
        global $conn;
		$fname=addslashes($fname);
        $sname=addslashes($sname);
        $company=addslashes($company);
        $phone=addslashes($phone);
        $carpark=addslashes($carpark);
        $carreg=addslashes($carreg);
        $visit=addslashes($visit);
        $insert = "INSERT INTO details(fname,sname,company,phone,carpark,carreg,visit,darrive) VALUES ('$fname','$sname','$company','$phone','$carpark','$carreg','$visit',NOW())";
		//$insert=addslashes($insert);
        mysqli_query($conn,$insert);
    }

    //Update an existing profile in the DB
    function updateDB($fname,$sname,$company,$phone,$carpark,$carreg,$visit,$darrive,$dleave){
        global $conn;
        $update = "UPDATE details SET fname = '$fname', sname = '$sname', company = '$company', phone = '$phone', carpark = '$carpark', carreg = '$carreg', visit = '$visit', darrive = NOW(), dleave = '$dleave'";
        mysqli_query($conn,$update);
    }

    //Delete record from table
    function deleteRecord($ID){
        global $conn;
        $delete = "DELETE * FROM details WHERE idDetails LIKE '$ID' ";
        mysqli_query($conn,$delete);
    }

    //Display a list of whoever is currently in the building
    function currentPeople(){
        global $conn;
        $current = "SELECT * FROM details WHERE dleave is NULL";
        $rs = mysqli_query($conn,$current);
        while ($row = mysqli_fetch_array($rs)){
            echo "<tr>";
			echo "<td>".$row['idDetails']."</td>";
            echo "<td>".$row['fname']."</td>";
            echo "<td>".$row['sname']."</td>";
            echo "<td>".$row['company']."</td>";
            echo "<td>".$row['phone']."</td>";
			echo '<td><a class="signout">Sign Out</a></td>';
            echo "</tr>";
			
        }
		
		echo '<script type=text/javascript>
		$(function()
		{
                $(".signout").click(function(){
                var row = $(this).closest("tr");
                row.hide(200);
                });
			});           
		</script>';
		echo '<script type="text/javascript" >
					$(function() 
					{
						$(".signout").click(function() 
						{
							var id =  $("td:first", $(this).parents("tr")).text();
							$.ajax({
								type: "POST",
								url: "testopenet.php",
								data: {
									action:"signout",
									id:id
								},
							success: function(responce){
                        }
           
             });
						});
					 });
				 </script>';
    }


//Close MySQL connection
    mysqli_close($conn);