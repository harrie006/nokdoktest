<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "Database.php";

$dbObject = new Database;

$result = $dbObject->execQuery("
	Select hospitals.id, hospitals.name, COUNT(Distinct practices.doctor_id)  as no_of_doctors from hospitals 
			left join practices on hospitals.id = practices.hospital_id
			
			Group by practices.hospital_id order by COUNT(Distinct practices.doctor_id) desc
	");

$arr = array();
//echo "<pre>";
$max = '';
while ($row = $result->fetch_assoc()) {
		if($max == '')
		{
			$max = $row['no_of_doctors'];	
		}
		else
		{
			if($max > $row['no_of_doctors']) break;
		}	

        $arr[] = ( $row);
    }
$heading = "Hospitals with Max Doctors" ;   

include "Views/hospital_list_view.php";
