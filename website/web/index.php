<?php

use Ofaso\Controller;
use Ofaso\Service\Login\LoginPdoService;

session_start();
error_reporting(E_ALL);

require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__ . "/../config.ini", true);
$factory = new Ofaso\Factory($config);
$tmpl = $factory->getTemplateEngine();
$pdo = $factory->getPDO() ;
$loginService = $factory->getLoginService();

switch($_SERVER["REQUEST_URI"]) {
	case "/testroute":
		echo "Test jebemti";
		break;
		
	case "/":
		$factory->getTemplateEngine()->homepage();
		break;
		
	case "/login":
		$ctr = new Controller\LoginController($tmpl, $loginService);
		if($_SERVER["REQUEST_METHOD"] == "GET"){
			$ctr->showLogin();
		}
		else{
			$ctr->login($_POST);
		}
		break;

	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			(new Ofaso\Controller\IndexController($tmpl))->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

