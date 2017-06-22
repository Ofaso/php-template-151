<?php
namespace Ofaso\Service\Register;

use Ofaso\Service\Security\PasswordService;

class RegisterPdoService implements  RegisterService
{
	/**
	 *  @ var \PDO
	 */
	private $pdo;
	private $mailer;
	private $passwordService;

	public function __construct(\PDO $pdo, $mailer, PasswordService $passwordService)
	{
		$this->pdo = $pdo;
		$this->mailer = $mailer;
		$this->passwordService = $passwordService;
	}

	public function acti($url, $userid)
	{
		if($url == $this->getactivationCodeById($userid))
		{
			$stmt = $this->pdo->prepare("UPDATE `user` SET isActivated=? WHERE id=?");
			$stmt->bindValue(1,'1');
			$stmt->bindValue(2,$userid);
			$stmt->execute();
			echo "<p>Your Acc has been activated</p>";
			echo "<a href=https://".$_SERVER['HTTP_HOST']."/login>login</a>";
			return;
		}
		else
		{
			echo "wrong activationcode";
			return;
		}
	}

	public function reg($email, $pw)
	{
		if ($this->userNotExist($email) == true)
		{
			$url = $this->passwordService->generateRandomString();
			$this->createUser($email, $pw, $url);
			$this->sendRegistrationEmail($email, $url, $this->getUserIdByEmail($email));
			echo "email  with register link has been sent to .$email.";
		}
			else
			{
				return false;
			}
		}

		private function getUserIdByEmail($email)
		{
			$stmt = $this->pdo->prepare("Select * FROM user WHERE email=?");
			$stmt->bindValue(1, $email);
			$stmt->execute();
			foreach ($stmt as $row)
			{
				return $row['id'];
				break;
			}
		}
		private function getactivationCodeById($userid)
		{
			$stmt = $this->pdo->prepare("Select * FROM user WHERE id=?");
			$stmt->bindValue(1, $userid);
			$stmt->execute();
			foreach ($stmt as $row)
			{
				return $row['activationCode'];
				break;
			}
		}

		private function userNotExist($email)
		{
			$stmt = $this->pdo->prepare("SELECT email FROM user WHERE email=?");
			$stmt->bindValue(1, $email);
			$stmt->execute();
			if($stmt->rowCount() == 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		private function createUser($email,$pw, $url)
		{
			$securePW = $this->passwordService->gethash($pw);
			$stmt = $this->pdo->prepare("INSERT INTO user(right_id,email,password,isActivated,activationCode) VALUES(1,?,?,0,?)");
			$stmt->bindValue(1, $email);
			$stmt->bindValue(2, $securePW);
			$stmt->bindValue(3, $url);
			$stmt->execute();
			if($stmt->errorCode()==="00000")
			{
				return $url;
			}
			else
			{
				return null;
			}
		}

		private function sendRegistrationEmail($email, $url, $userid)
		{
			$this->mailer->send(
							\Swift_Message::newInstance("Registrierung")
							->setContentType("text/html")
							->setFrom(["gibz.module.151@gmail.com" => "WebProject"])
							->setTo($email)
							->setBody("Registrierungsformular<br><a href=https://".$_SERVER['HTTP_HOST']."/activate?url=".$url."&userid=".$userid.">Link</a>")
							);
		}
		private function getCurrentUser()
		{
			if(isset($_SESSION['user_id']))
			{
				$userid = $_SESSION['user_id'];
				$stmt = $this->pdo->prepare("Select * FROM user WHERE id=?");
				$stmt->bindValue(1, $userid);
				$stmt->execute();
				foreach ($stmt as $row)
				{
					return $row;
					break;
				}
			}
			else
			{
				echo "you are not logged in <a href=https://".$_SERVER['HTTP_HOST']."/login>login</a>";
			}

		}
		public function chpw($pw, $url)
		{
			if(isset($_SESSION['user_id']))
			{
				$userid = $_SESSION['user_id'];
				if($url == $this->getactivationCodeById($userid))
				{
					$securePW = $this->passwordService->gethash($pw);
					$stmt = $this->pdo->prepare("UPDATE `user` SET password=? WHERE id=?");
					$stmt->bindValue(1,$securePW);
					$stmt->bindValue(2,$userid);
					$stmt->execute();
					echo "password has been changed";
				}
			}
			else
			{
				echo "you are not logged in <a href=https://".$_SERVER['HTTP_HOST']."/login>login</a>";
			}
		}

		public function sendCode()
		{
			$user = $this->getCurrentUser();
			$activationCode = $user['activationCode'];
			$this->mailer->send(
					\Swift_Message::newInstance("Change PW")
					->setContentType("text/html")
					->setFrom(["gibz.module.151@gmail.com" => "WebProject"])
					->setTo($user['email'])
					->setBody("<p>Change PW Code:</p> $activationCode")
					);
		}
	}
