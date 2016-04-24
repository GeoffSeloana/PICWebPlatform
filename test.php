<?php 
# ===================== #
	# ==== select services ==== #
	# ===================== #
    public function getServices($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL getServices"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}



		if (!$stmt->execute()) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Execute failed: (" . $stmt->errno . ") " . $stmt->error
			);
			throw new Exception(json_encode($data));
		}


		do {

		    $S_ID = NULL;
		    $serviceName = NULL;
		    $serviceDescription = NULL;
		    $serviceVideoURL = NULL;
		    $DateTimeStamp = NULL;
		   

		    if (!$stmt->bind_result($S_ID, $serviceName, $serviceDescription, $serviceVideoURL, $DateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'S_ID'	=> $S_ID,
					'serviceName' => $serviceName,
					'serviceDescription' => $serviceDescription,
					'serviceVideoURL'	=>  $serviceVideoURL,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    $data = array(
			    "success"	=>true,
			    "services"		=> $resultArray
		    );


			/**
			   check if user exits in DB
			**/
		    if($data["services"] != null){
		    	return $data;
		    }else{
		    	$error = array(
					"success"	=>false,
					"message"	=>"User doesn't exist"
				);
		    	throw new Exception(json_encode($error));
		    }


		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # ===================== #
	# ==== delete company ==== #
	# ===================== #
    public function deleteCompany($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL deleteCompany(?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$C_ID = $_POST['C_ID'];

		if (!$stmt->bind_param("s", $C_ID)) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error
			);
			throw new Exception(json_encode($data));
		}

		if (!$stmt->execute()) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Execute failed: (" . $stmt->errno . ") " . $stmt->error
			);
			throw new Exception(json_encode($data));
		}


		do {

		  

		   
		    $data = array(
			    "success"	=>true,
			    "message"	=> "Company has been deleted"
		    );
		    
		    return $data;


		} while ($stmt->more_results() && $stmt->next_result());
    }
    