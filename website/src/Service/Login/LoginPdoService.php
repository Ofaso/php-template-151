<?php
namespace Ofaso\Service\Login;

use Ofaso\Service\Security\PasswordService;

class LoginPdoService implements  LoginService
{
	/**
	 *  @ var \PDO
	 */
	private $pdo;

	private $passwordService;

	public function __construct(\PDO $pdo, PasswordService $passwordService)
	{
		$this->pdo = $pdo;
		$this->passwordService = $passwordService;
	}

	public function authenticate($username, $password)
	{
		$hash = $this->getPasswordByEmail($username);
		if($hash == null)
		{
			return false;
		}
		if (!$this->passwordService->verify($password, $hash))
		{
			return false;
		}

		$stmt = $this->pdo->prepare("Select * FROM user WHERE email=? AND isActivated='1'");
		$stmt->bindValue(1,$username);
		$stmt->execute();

		if($stmt->rowCount() === 1)
		{
			$_SESSION["email"] = $username;
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getPasswordByEmail($email)
	{
		$stmt = $this->pdo->prepare("SELECT password FROM user WHERE email=?");
		$stmt->bindValue(1, $email);
		$stmt->execute();
		if($stmt->rowCount()==1)
		{
			return $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT)[0];
		}
		return null;
	}

	public function getUserIdByEmail($email)
	{
		$stmt = $this->pdo->prepare("Select * FROM user WHERE email=?");
		$stmt->bindValue(1,$email);
		$stmt->execute();

		if($stmt->rowCount() === 1)
		{
			foreach ($stmt as $row)
			{
				return $row['id'];
			}
		}
		else
		{
			return NULL;
		}
	}
}
