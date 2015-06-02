<?php
	if(isset($_POST)){
		$response = array();
		switch($_POST['Type']){
			case 'load_location':
				$response = loadLocation();
			break;
			}
			echo json_encode($response);
		}
	
	function addImports(){
		require_once('utils/db_config.php');
		}
	
	function loadLocation(){
		addImports();
		$db = new DbConnect();
		$con = $db->connect();
		$response = array();
		$query = "SELECT `destination_from` FROM `destination`";
		$result = mysqli_query($con, $query);
		
		while($row = mysqli_fetch_array($result)){
				$response = array($row['destination_from']);
			}
		return $response;
		}
?>
