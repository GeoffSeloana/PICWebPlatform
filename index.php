<?php

require 'connection.php';
require 'functions.php';
require 'validations.php';

//construct our Connect class

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

function generalExceptionHandler($e) {
	$info = json_decode($e->getMessage(),true);
    $data = array('status' => 'error');
    isset($info['imgException'])?$data['imgException'] = $info['imgException']:null;
    isset($info['success'])?$data['success'] = $info['success']:null;
    isset($info['message'])?$data['message'] = $info['message']:null;
	isset($info['Params'])?$data['Params'] = $info['Params']:null;

//giving a 200 status code when the call is for an image
    if($data['imgException']){
        http_response_code(200);
    }else{
        http_response_code(400); 
    }
    header("Content-Type: application/json");
    echo json_encode($data);
}
set_exception_handler('generalExceptionHandler');


$validate 	= new Validates();
$function 	= new Functions();
// what was the request
// Access control would go first here
// Look for a valid action
if(isset($_POST['method'])) {
    switch($_POST['method']) {
        case "getCompanies":
            $data		= $function->getCompanies($mysqli);
            break;
        case "getCompanyServices":
            $data		= $validate->getCompanyServices();
            $data		= $function->getCompanyServices($mysqli);
            break;
        case "getIndustries":
            $data		= $function->getIndustries($mysqli);
            break;
        case "getServices":
            $data		= $function->getServices($mysqli);
            break;
        case "getUser":
            $data		= $validate->getUser();
            $data		= $function->getUser($mysqli);
            break;
        case "insertCompany":
            $data		= $validate->insertCompany();
            $data		= $function->insertCompany($mysqli);
            break;
        case "insertCompanyService":
            $data		= $validate->insertCompanyService();
            $data		= $function->insertCompanyService($mysqli);
            break;
        case "insertIndustry":
            $data		= $validate->insertIndustry();
            $data		= $function->insertIndustry($mysqli);
            break;
        case "insertService":
            $data		= $validate->insertService();
            $data		= $function->insertService($mysqli);
            break;
        case "insertUser":
            $data		= $validate->insertUser();
            $data		= $function->insertUser($mysqli);
            break;
        case "deleteCompany":
            $data		= $validate->deleteCompany();
            $data		= $function->deleteCompany($mysqli);
            break; 
        case "deleteCompanyService":
            $data		= $validate->deleteCompanyService();
            $data		= $function->deleteCompanyService($mysqli);
            break;
        case "deleteIndustry":
            $data		= $validate->deleteIndustry();
            $data		= $function->deleteIndustry($mysqli);
            break;
        case "deleteService":
            $data		= $validate->deleteService();
            $data		= $function->deleteService($mysqli);
            break;
        case "companyData":
            $data =  $function->getCompanyData($mysqli);
            break;
        default:
            http_response_code(400);
            $data = array("error" => "bad request");
            $data['status'] = "error";
            $data['success'] = false;
            $data['message'] = "Invalid Method specified";
            break;
    }
} else {
    http_response_code(200);

    $data['status'] = "error";
    $data['success'] = false;
    $data['message'] = "No method specified";
}



// let's send the data back
header("Content-Type: application/json");
echo json_encode($data);
?>