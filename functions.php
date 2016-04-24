<?php

class Functions
{

     /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
    
    
	# =========================== #
	# ==== insert user in DB ==== #
	# =========================== #
    public function user_INS($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL user_INS(?,?,?,?,?,?,?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$User_Name = $_POST['User_Name'];
		$User_Email = $_POST['User_Email'];
		$User_Password = $_POST['User_Password'];
		$User_Phone = $_POST['User_Phone'];
		$User_Age = $_POST['User_Age'];
		$User_Gender = $_POST['User_Gender'];
		$User_Race = $_POST['User_Race'];

		if (!$stmt->bind_param("sssssss", $User_Name,$User_Email,$User_Password,$User_Phone,$User_Age,$User_Gender,$User_Race)) {
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

		    $user_ID = NULL;
		    $user_Name = NULL;
		    $user_Email = NULL;
		    $user_Password = NULL;
		    $user_Phone = NULL;
		    $user_Age = NULL;
		    $user_Gender = NULL;
		    $user_Race = NULL;
		    $user_CreatedDateTime = NULL;

		    if (!$stmt->bind_result($user_ID,$user_Name,$user_Email,$user_Password,$user_Phone,$user_Age,$user_Gender,$user_Race,$user_CreatedDateTime)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'User_ID'	=> $user_ID,
					'User_Name'	=>  $user_Name,
					'User_Email'	=>  $user_Email,
					'User_Password'	=>  $user_Password,
					'User_Phone'	=>  $user_Phone,
					'User_Age'	=>  $user_Age,
					'User_Gender'	=>  $user_Gender,
					'User_Race'	=>  $user_Race,
					'User_CreatedDateTime' =>  $user_CreatedDateTime
				);
				array_push( $resultArray, $user);
		    }
		    return $data = array(
			    "success"	=>true,
			    "message" 	=>"User inserted",
			    "user"		=>$user
		    );
		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # ===================== #
	# ==== select user ==== #
	# ===================== #
    public function user_SEL($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL user_SEL(?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$User_ID = $_POST['User_ID'];

		if (!$stmt->bind_param("s", $User_ID)) {
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

		    $user_ID = NULL;
		    $user_Name = NULL;
		    $user_Email = NULL;
		    $user_Phone = NULL;
		    $user_Age = NULL;
		    $user_Gender = NULL;
		    $user_Race = NULL;
		    $user_CreatedDateTime = NULL;

		    if (!$stmt->bind_result($user_ID,$user_Name,$user_Email,$user_Phone,$user_Age,$user_Gender,$user_Race,$user_CreatedDateTime)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'User_ID'	=> $user_ID,
					'User_Name'	=>  $user_Name,
					'User_Email'	=>  $user_Email,
					'User_Phone'	=>  $user_Phone,
					'User_Age'	=>  $user_Age,
					'User_Gender'	=>  $user_Gender,
					'User_Race'	=>  $user_Race,
					'User_CreatedDateTime' =>  $user_CreatedDateTime
				);
				array_push( $resultArray, $user);
		    }
		    $data = array(
			    "success"	=>true,
			    "user"		=>$user
		    );


			/**
			   check if user exits in DB
			**/
		    if($data["user"] != null){
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
	# ==== delete user ==== #
	# ===================== #
  //  public function user_DEL($mysqli) {
	 //   $resultArray = array();

		// if (!($stmt = $mysqli->prepare("CALL user_DEL(?)"))) {
		//     $data = array(
		// 		"success"	=> false,
		// 		"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
		// 	);
		// 	throw new Exception(json_encode($data));
		// }
		// $User_ID = $_POST['User_ID'];

		// if (!$stmt->bind_param("s", $User_ID)) {
		//     $data = array(
		// 		"success"	=> false,
		// 		"message"	=> "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error
		// 	);
		// 	throw new Exception(json_encode($data));
		// }

		// if (!$stmt->execute()) {
		//     $data = array(
		// 		"success"	=> false,
		// 		"message"	=> "Execute failed: (" . $stmt->errno . ") " . $stmt->error
		// 	);
		// 	throw new Exception(json_encode($data));
		// }


		// do {

		//     $user_ID = NULL;
		//     $user_Name = NULL;
		//     $user_Email = NULL;
		//     $user_Phone = NULL;
		//     $user_Age = NULL;
		//     $user_Gender = NULL;
		//     $user_Race = NULL;
		//     $user_CreatedDateTime = NULL;

		//     if (!$stmt->bind_result($user_ID,$user_Name,$user_Email,$user_Phone,$user_Age,$user_Gender,$user_Race,$user_CreatedDateTime)) {
		//         $data = array(
		// 			"success"	=> false,
		// 			"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
		// 		);
		// 		throw new Exception(json_encode($data));
		//     }

		//     while ($stmt->fetch()) {
		//         $user = array(
		// 			'User_ID'	=> $user_ID,
		// 			'User_Name'	=>  $user_Name,
		// 			'User_Email'	=>  $user_Email,
		// 			'User_Phone'	=>  $user_Phone,
		// 			'User_Age'	=>  $user_Age,
		// 			'User_Gender'	=>  $user_Gender,
		// 			'User_Race'	=>  $user_Race,
		// 			'User_CreatedDateTime' =>  $user_CreatedDateTime
		// 		);
		// 		array_push( $resultArray, $user);
		//     }
		//     $data = array(
		// 	    "success"	=>true,
		// 	    "message"	=> "User has been deleted",
		// 	    "user"		=>$user
		//     );


		// 	/**
		// 	   check if user exits in DB
		// 	**/
		//     if($data["user"] != null){
		//     	return $data;
		//     }else{
		//     	$error = array(
		// 			"success"	=>false,
		// 			"message"	=>"User doesn't exist"
		// 		);
		//     	throw new Exception(json_encode($error));
		//     }


		// } while ($stmt->more_results() && $stmt->next_result());
  //  }
    
    # =========================== #
	# ==== insert user in DB ==== #
	# =========================== #
    public function insertCompany($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL insertCompany(?,?,?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$companyName = $_POST['companyName'];
		$companyDescription = $_POST['companyDescription'];
		$companyImageURL = $_POST['companyImageURL'];

		if (!$stmt->bind_param("sss", $companyName, $companyDescription, $companyImageURL)) {
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

		    $C_ID = NULL;
		    $companyName = NULL;
		    $companyDescription = NULL;
		    $companyImageURL = NULL;
		    $DateTimeStamp = NULL;

		    if (!$stmt->bind_result($C_ID, $companyName, $companyDescription, $companyImageURL, $DateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'C_ID'	=> $C_ID,
					'companyName'	=>  $companyName,
					'companyDescription'	=>  $companyDescription,
					'companyImageURL'	=>  $companyImageURL,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    return $data = array(
			    "success"	=>true,
			    "message" 	=>"User inserted",
			    "user"		=>$user
		    );
		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # =========================== #
	# ==== insert user in DB ==== #
	# =========================== #
    public function insertCompanyService($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL insertCompany(?,?,?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$C_ID = $_POST['C_ID'];
		$S_ID = $_POST['S_ID'];
		$companyServiceDescription = $_POST['companyServiceDescription'];

		if (!$stmt->bind_param("sss", $C_ID, $S_ID, $companyServiceDescription)) {
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

		    $CS_ID = NULL;
		    $C_ID = NULL;
		    $S_ID = NULL;
		    $companyServiceDescription = NULL;
		    $DateTimeStamp = NULL;

		    if (!$stmt->bind_result($CS_ID, $C_ID, $S_ID, $companyServiceDescription, $DateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'CS_ID'	=> $CS_ID,
					'C_ID'	=>  $C_ID,
					'S_ID'	=>  $S_ID,
					'companyServiceDescription'	=>  $companyServiceDescription,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    return $data = array(
			    "success"	=>true,
			    "message" 	=>"User inserted",
			    "user"		=>$user
		    );
		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # =========================== #
	# ==== insert user in DB ==== #
	# =========================== #
    public function insertIndustry($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL insertIndustry(?,?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$industryName = $_POST['industryName'];
		$industryDescription = $_POST['industryDescription'];

		if (!$stmt->bind_param("ss", $industryName, $industryDescription)) {
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

		    $I_ID = NULL;
		    $industryName = NULL;
		    $industryDescription = NULL;
		    $DateTimeStamp = NULL;

		    if (!$stmt->bind_result($I_ID, $industryName, $industryDescription, $DateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'I_ID'	=> $I_ID,
					'industryName'	=>  $industryName,
					'industryDescription'	=>  $industryDescription,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    return $data = array(
			    "success"	=>true,
			    "message" 	=>"User inserted",
			    "user"		=>$user
		    );
		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # =========================== #
	# ==== insert user in DB ==== #
	# =========================== #
    public function insertService($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL insertIndustry(?,?,?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$serviceName = $_POST['serviceName'];
		$serviceDescription = $_POST['serviceDescription'];
		$serviceVideoURL = $_POST['serviceVideoURL'];

		if (!$stmt->bind_param("sss", $serviceName, $serviceDescription, $serviceVideoURL)) {
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
					'serviceName'	=>  $serviceName,
					'serviceDescription'	=>  $serviceDescription,
					'serviceVideoURL'	=>  $serviceVideoURL,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    return $data = array(
			    "success"	=>true,
			    "message" 	=>"User inserted",
			    "user"		=>$user
		    );
		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # =========================== #
	# ==== insert user in DB ==== #
	# =========================== #
    public function insertUser($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL insertUser(?,?,?,?,?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$userName = $_POST['userName'];
		$userType = $_POST['userType'];
		$userEmail = $_POST['userEmail'];
		$userPassword = $_POST['userPassword'];
		
		$hash = $this->hashSSHA($userPassword);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

		if (!$stmt->bind_param("sssss",$userName, $userType, $userEmail,$encrypted_password,$salt)) {
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

		    $U_ID = NULL;
		    $userName = NULL;
		    $userType = NULL;
		    $userEmail = NULL;
		    $encrypted_password = NULL;
		    $salt = NULL;
		    $DateTimeStamp = NULL;

		    if (!$stmt->bind_result($U_ID, $userName, $userType, $userEmail, $encrypted_password, $salt,$DateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'U_ID'	=> $U_ID,
					'userName'	=>  $userName,
					'userType'	=>  $userType,
					'userEmail'	=>  $userEmail,
					'encrypted_password'	=>  $encrypted_password,
					'salt'	=>  $salt,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    return $data = array(
			    "success"	=>true,
			    "message" 	=>"User inserted",
			    "user"		=>$user
		    );
		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # =========================== #
	# ==== get user in DB ======= #
	# =========================== #
    public function getUser($mysqli){
    $resultArray = array();

    if (!($stmt = $mysqli->prepare("CALL `getUser`(?)")))
    {
            $data = array(
                "success"    => false,
                "message"    => "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
            );
            mysqli_close($mysqli);
            throw new Exception(json_encode($data));
    }
        //$hcwID = $_POST['hcw_ID'];
        //$hcwpasswordaa = $_POST['hcw_passwordaa'];
        $userEmail = $_POST['userEmail'];
        $userPassword = $_POST['userPassword'];
        
     
        

        if (!$stmt->bind_param("s", $userEmail)) {
            $data = array(
                "success"    => false,
                "message"    => "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error
            );
            mysqli_close($mysqli);
            throw new Exception(json_encode($data));
        }


        if (!$stmt->execute()) {
              $data = array(
                "success"    => false,
                "message"    => "Execute failed: (" . $stmt->errno . ") " . $stmt->error
                );
                mysqli_close($mysqli);
              throw new Exception(json_encode($data));

        }

        do {

            $U_ID = NULL;
		    $userName = NULL;
		    $userType = NULL;
		    $userEmail = NULL;
		    $encrypted_password = NULL;
		    $salt = NULL;
		    $DateTimeStamp = NULL;

		    if (!$stmt->bind_result($U_ID, $userName, $userType, $userEmail, $encrypted_password, $salt,$DateTimeStamp)) {
                $data = array(
                    "success"    => false,
                    "message"    => "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
                );
                mysqli_close($mysqli);
                throw new Exception(json_encode($data));
            }


            while ($stmt->fetch()) {
                $user = array(
                    'U_ID'         => $U_ID,
                    'userName'       => $userName,
                    'userType'    =>  $userType,
                    'userEmail'       =>  $userEmail,
                    'encrypted_password'      =>  $encrypted_password,
                    'salt'     =>  $salt,
                    'DateTimeStamp'    =>  $DateTimeStamp
                );
                
                if($U_ID != null){
                    $user_password = $_POST['userPassword'];
                    $hash = $this->checkhashSSHA($salt, $user_password);
                    // check for password
                    if ($encrypted_password == $hash) {
                        mysqli_close($mysqli);
                        return $data = array(
                            "success"    =>true,
                            "message"     =>"User Selected",
                            "user"        =>$user
                        );
                        
                    }else {
                        mysqli_close($mysqli);
                        return $data = array(
                            "success"    =>false,
                            "message"     =>"User incorrect password"
                        );
                    }
                    
                }
            
                $user = array();
            }
           
            
            
            
            
            
        } while ($stmt->more_results() && $stmt->next_result());
         mysqli_close($mysqli);
            return $data = array(
                        "success"    =>false,
                        "message"     =>"User doesn't exist"
            );
  }
    
    # ===================== #
	# ==== select companies ==== #
	# ===================== #
    public function getCompanies($mysqli) {
    	
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL getCompanies()"))) {
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

		    $C_ID = NULL;
		    $companyName = NULL;
		    $companyDescription = NULL;
		    $companyImageURL = NULL;
		    $DateTimeStamp = NULL;
		   

		    if (!$stmt->bind_result($C_ID, $companyName, $companyDescription, $companyImageURL, $DateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'C_ID'	=> $C_ID,
					'companyName'	=>  $companyName,
					'companyDescription'	=>  $companyDescription,
					'companyImageURL'	=>  $companyImageURL,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    $data = array(
			    "success"	=>true,
			    "user"		=> $resultArray
		    );


			/**
			   check if user exits in DB
			**/
		    if($data["user"] != null){
		    	return $data;
		    }else{
		    	$error = array(
					"success"	=>false,
					"message"	=>"Company doesn't exist"
				);
		    	throw new Exception(json_encode($error));
		    }


		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # ===================== #
	# ==== select company services ==== #
	# ===================== #
    public function getCompanyServices($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL getCompanyServices(?)"))) {
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

		    $CS_ID = null;
		    $C_ID = null;
		    $S_ID = null;
		    $CS_DESCRIPTION = null;
		    $S_NAME = null;
		    $S_DESCRIPTION = null;
		    $S_VIDEOURI = null;

		    if (!$stmt->bind_result($CS_ID, $C_ID, $S_ID, $CS_DESCRIPTION, $S_NAME, $S_DESCRIPTION, $S_VIDEOURI)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'CS_ID'	=> $CS_ID,
					'C_ID' => $C_ID,
					'S_ID' => $S_ID,
					'companyServiceDescription' => $CS_DESCRIPTION,
					'serviceName' => $S_NAME,
					'serviceVideoURL' => $S_VIDEOURI,
					'serviceDescription' => $S_DESCRIPTION
				);
				array_push( $resultArray, $user);
		    }
		    $data = array(
			    "success"	=>true,
			    "user"		=> $resultArray
		    );


			/**
			   check if user exits in DB
			**/
		    if($data["user"] != null){
		    	return $data;
		    }else{
		    	$error = array(
					"success"	=>false,
					"message"	=>"Company service doesn't exist"
				);
		    	throw new Exception(json_encode($error));
		    }


		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # ===================== #
	# ==== select industries ==== #
	# ===================== #
    public function getIndustries($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL getIndustries()"))) {
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

		    $I_ID = NULL;
		    $industryName = NULL;
		    $industryDescription = NULL;
		    $industryVideoURL = NULL;
		    $DateTimeStamp = NULL;
		   

		    if (!$stmt->bind_result($I_ID, $industryName, $industryDescription, $industryVideoURL, $DateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }

		    while ($stmt->fetch()) {
		        $user = array(
					'I_ID'	=> $I_ID,
					'industryName'	=>  $industryName,
					'industryDescription'	=>  $industryDescription,
					'industryVideoURL'	=>  $industryVideoURL,
					'DateTimeStamp'	=>  $DateTimeStamp
				);
				array_push( $resultArray, $user);
		    }
		    $data = array(
			    "success"	=>true,
			    "user"		=> $resultArray
		    );


			/**
			   check if user exits in DB
			**/
		    if($data["user"] != null){
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
    
    # ===================== #
	# ==== delete company service==== #
	# ===================== #
    public function deleteCompanyService($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL deleteCompanyService(?)"))) {
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
			    "message"	=> "Company service has been deleted"
		    );
		    
		    return $data;


		} while ($stmt->more_results() && $stmt->next_result());
    }
    
    # ===================== #
	# ==== delete industry==== #
	# ===================== #
    public function deleteIndustry($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL deleteIndustry(?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$I_ID = $_POST['I_ID'];

		if (!$stmt->bind_param("s", $I_ID)) {
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
			    "message"	=> "Industry has been deleted"
		    );
		    
		    return $data;


		} while ($stmt->more_results() && $stmt->next_result());
    }
    
     # ===================== #
	# ==== delete service==== #
	# ===================== #
    public function deleteService($mysqli) {
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL deleteService(?)"))) {
		    $data = array(
				"success"	=> false,
				"message"	=> "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error
			);
			throw new Exception(json_encode($data));
		}
		$S_ID = $_POST['S_ID'];

		if (!$stmt->bind_param("s", $S_ID)) {
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
			    "message"	=> "Service has been deleted"
		    );
		    
		    return $data;


		} while ($stmt->more_results() && $stmt->next_result());
    }
    
        # ===================== #
	# ==== select company data ==== #
	# ===================== #
    public function getCompanyData($mysqli) {
    	
	    $resultArray = array();

		if (!($stmt = $mysqli->prepare("CALL TDA_Bubblewave.getCompanies()"))) {
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

		    $C_ID = null;
		    $companyName = null;
		    $companyDescription = null;
		    $companyImageURL = null;
		    $dateTimeStamp = null;
		    

		    if (!$stmt->bind_result($C_ID, $companyName, $companyDescription, $companyImageURL, $dateTimeStamp)) {
		        $data = array(
					"success"	=> false,
					"message"	=> "Binding results failed: (" . $stmt->errno . ") " . $stmt->error
				);
				throw new Exception(json_encode($data));
		    }
		    
		    

		    while ($stmt->fetch()) {
		    	
		        $user = array(
					'C_ID'	=> $C_ID,
					'companyName' => $companyName,
					'companyDescription'	=>  $companyDescription,
					'companyImageURL'	=>  $companyImageURL,
					'DateTimeStamp'	=>  $dateTimeStamp
				);
				array_push( $resultArray, $user);
				
		    }
		    $data = array(
			    "success"	=>true,
			    "user"		=> $resultArray
		    );
		    

		   if($data["user"]){
		   	
		   	return $data;
		   	
		   }else{
		   	echo "error";
		   }
		  
	
		 


		} while ($stmt->more_results() && $stmt->next_result());
    }
    
}