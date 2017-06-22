<?php

use Ofaso\Controller;
use Ofaso\Factory;

error_reporting(E_ALL);

session_start();
require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__ . "/../config.ini", true);
$factory = new Factory($config);
$tmpl = $factory->getTemplateEngine();
if($_SERVER["REQUEST_METHOD"] == "PUT")
{
	die();
}
if(strpos($_SERVER["REQUEST_URI"], '/activate') !== false)
{
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$registerService = $factory->getRegisterService();
		$ctr = new Controller\RegisterController($tmpl, $registerService);
		$ctr->activate($_GET);
	}
}
else
{
	switch($_SERVER["REQUEST_URI"])
	{
		case "/":
			$ctr = $factory->getIndexController();
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				if(array_key_exists('like',$_POST))
				{
					$ctr->like($_POST);
				}
				if(array_key_exists('dislike',$_POST))
				{
					$ctr->dislike($_POST);
				}
				if(array_key_exists('logout',$_POST))
				{
					unset($_SESSION['user_id']);
				}
				if(array_key_exists('login',$_POST))
				{
					header('Location: /login');
				}
				if(array_key_exists('register',$_POST))
				{
					header('Location: /register');
				}
				if(array_key_exists('deletePost',$_POST))
				{
					$ctr->deletePost($_POST);
				}
			}
			$ctr->homepage();
			break;
		case "/login":
			$loginService = $factory->getLoginService();
			$ctr = new Controller\LoginController($tmpl, $loginService, $factory->getCSRFService());
			if($_SERVER["REQUEST_METHOD"] == "GET")
			{
				$ctr->showLogin();
			}
			else
			{
				$ctr->login($_POST);
			}
			break;
		case "/register":
			$registerService = $factory->getRegisterService();
			$ctr = new Controller\RegisterController($tmpl, $registerService);
			if($_SERVER["REQUEST_METHOD"] == "GET")
			{
				$ctr->showRegister();
			}
			else
			{
				$ctr->register($_POST);
			}
			break;
		case "/changepw":
			$registerService = $factory->getRegisterService();
			$ctr = new Controller\RegisterController($tmpl, $registerService);
			if($_SERVER["REQUEST_METHOD"] == "GET")
			{
				$ctr->sendChangePwCode();
				$ctr->showChangePw();
			}
			else
			{
				$ctr->changePw($_POST);
			}
			break;
		case "/newPost":
			$ctr = $factory->getIndexController();
			if(array_key_exists('newPost',$_POST))
			{
				$ctr->addPost($_POST);
			}
			else
			{
				$ctr->showNewPost();
			}
			break;
		default:
			$matches = [];
			if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches))
			{
				$ctr = $factory->getIndexController();
				$ctr->homepage();
				break;
			}
			echo "Not Found";
	}
}
