<?php

class Validates
{
	protected $missingParams=array();

	# ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function getCompanyServices() {
		/**
		   check user params missing
		**/
	    !isset($_POST['C_ID']) ? $this->missingParams['C_ID']=null:null;

		/**
		   throw error if any missing params
		**/
		if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function getUser() {


		/**
		   check user params missing
		**/
	    !isset($_POST['userEmail']) ? $this->missingParams['userEmail']=null:null;
	    !isset($_POST['userPassword']) ? $this->missingParams['userPassword']=null:null;


		/**
		   throw error if any missing params
		**/
		if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function insertCompany() {


		/**
		   check user params missing
		**/
	    !isset($_POST['companyName']) ? $this->missingParams['companyName']=null:null;
	    !isset($_POST['companyDescription']) ? $this->missingParams['companyDescription']=null:null;
	    !isset($_POST['companyImageURL']) ? $this->missingParams['companyImageURL']=null:null;


		/**
		   throw error if any missing params
		**/
		if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function insertCompanyService() {


		/**
		   check user params missing
		**/
	    !isset($_POST['C_ID']) ? $this->missingParams['C_ID']=null:null;
	    !isset($_POST['S_ID']) ? $this->missingParams['S_ID']=null:null;
	    !isset($_POST['companyServiceDescription']) ? $this->missingParams['companyServiceDescription']=null:null;


		/**
		   throw error if any missing params
		**/
		if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function insertIndustry() {


		/**
		   check user params missing
		**/
	    !isset($_POST['industryName']) ? $this->missingParams['industryName']=null:null;
	    !isset($_POST['industryDescription']) ? $this->missingParams['industryDescription']=null:null;
	    
		/**
		   throw error if any missing params
		**/
		if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function insertService() {


		/**
		   check user params missing
		**/
	    !isset($_POST['serviceName']) ? $this->missingParams['serviceName']=null:null;
	    !isset($_POST['serviceDescription']) ? $this->missingParams['serviceDescription']=null:null;
	    !isset($_POST['serviceVideoURL']) ? $this->missingParams['serviceVideoURL']=null:null;


		/**
		   throw error if any missing params
		**/
		if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function insertUser() {


		/**
		   check user params missing
		**/
	    !isset($_POST['userName']) ? $this->missingParams['userName']=null:null;
	    !isset($_POST['userType']) ? $this->missingParams['userType']=null:null;
	    !isset($_POST['userEmail']) ? $this->missingParams['userEmail']=null:null;
	    !isset($_POST['userPassword']) ? $this->missingParams['userPassword']=null:null;


		/**
		   throw error if any missing params
		**/
		if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function deleteCompany(){
    	
    	//check params validation
    	!isset($_POST['C_ID']) ? $this->missingParams['C_ID']=null:null;
    	
    	if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function deleteCompanyService(){
    	
    	//check params validation
    	!isset($_POST['C_ID']) ? $this->missingParams['C_ID']=null:null;
    	
    	if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function deleteIndustry(){
    	
    	//check params validation
    	!isset($_POST['I_ID']) ? $this->missingParams['I_ID']=null:null;
    	
    	if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
    # ================================ #
	# ==== user validation method ==== #
	# ================================ #
    public function deleteService(){
    	
    	//check params validation
    	!isset($_POST['S_ID']) ? $this->missingParams['S_ID']=null:null;
    	
    	if($this->missingParams){
			$data = array(
				"success"	=> false,
				"message"	=>"Missing Parameter(s)",
				"Params"	=>$this->missingParams
			);
			throw new Exception(json_encode($data));
		}else{
			$data = array("success"	=> true);
		}
        return $data;
    }
    
   
}