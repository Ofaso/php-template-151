<?php

namespace Ofaso;

class Factory
{
	private $config;
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}

	public function getIndexController()
	{
		return new Controller\IndexController($this->getTemplateEngine(), $this->getHomepageService(), $this->getPDO(), $this->getCSRFService());
	}

	public function getPDO()
	{
		return new \PDO(
				"mysql:host=mariadb;dbname=app;charset=utf8",
				$this->config["database"]["user"],
				"my-secret-pw",
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
	}

	public function getLoginService()
	{
		return new  Service\Login\LoginPdoService($this->getPDO(), $this->getPasswordService());
	}

	public function getHomepageService()
	{
		return new  Service\Homepage\HomepagePdoService($this->getPDO());
	}

	public function getMailer()
	{
		return \Swift_Mailer::newInstance(
				\Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl")
				->setUsername("gibz.module.151@gmail.com")
				->setPassword("Pe$6A+aprunu")
				);
	}

	public function getRegisterService()
	{
		return new Service\Register\RegisterPdoService($this->getPDO(), $this->getMailer(), $this->getPasswordService());
	}

	public function getCSRFService()
	{
		return new Service\Security\CSRFProtectionService();
	}

	public function getPasswordService()
	{
		return new Service\Security\PasswordService();
	}
}
