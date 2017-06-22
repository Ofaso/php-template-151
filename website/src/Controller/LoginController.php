<?php

namespace Ofaso\Controller;

use Ofaso\SimpleTemplateEngine;
use Ofaso\Service\Login\LoginService;
use Ofaso\Service\Security\CSRFProtectionService;

class LoginController
{
	/**
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;

	private $loginService;

	private $csrfService;
	/**
	 * @param ihrname\SimpleTemplateEngine
	 * @param PDO
	 */
	public function __construct(SimpleTemplateEngine $template, LoginService $loginService, CSRFProtectionService $csrfService)
	{
		$this->template = $template;
		$this->loginService = $loginService;
		$this->csrfService = $csrfService;
	}

	public function showLogin()
	{
		echo $this->template->render("login.html.php", ["csrf" => $this->csrfService->getHtmlCode("csrfLogin")]);
	}

	public function login(array $data)
	{
		if(array_key_exists("csrf", $data))
		{
			if(!$this->csrfService->validateToken("csrfLogin", $data["csrf"]))
			{
				$this->showLogin();
				return;
			}
		}
		if(!array_key_exists("email", $data) OR !array_key_exists("password", $data))
		{
			$this->showLogin();
			return;
		}


		if($this->loginService->authenticate($data["email"], $data["password"]))
		{
			$_SESSION["user_id"] = $this->loginService->getUserIdByEmail($data["email"]);
			$_SESSION["email"] = $data["email"];
			header('Location: /');
		}
		else
		{
			echo $this->template->render("login.html.php", ["email" => $data["email"] , "csrf" => $this->csrfService->getHtmlCode("csrfLogin")]);
		}
	}
}
