<?php

namespace Ofaso\Service\Homepage;

class HomepagePdoService implements  HomepageService
{
	/**
	 *  @ var \PDO
	 */
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getAllPost()
	{
		try {
			$stmt = $this->pdo->prepare("Select * FROM post");
			$stmt->execute();

			if($stmt->rowCount() >= 1)
			{
				return $stmt;
			}
			else
			{
				return NULL;
			}
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}

	public function getLikesByPostId($post_id, $isDislike)
	{
		try {
			$stmt = $this->pdo->prepare("Select * FROM `like` WHERE post_id=? AND isDislike=?");
			$stmt->bindValue(1,$post_id);
			$stmt->bindValue(2,$isDislike);
			$stmt->execute();
			return $stmt->rowCount();
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}

	public function getLikeByUserIdAndPostId($user_id, $post_id)
	{
		try {
			$stmt = $this->pdo->prepare("Select * FROM `like` WHERE user_id=? AND post_id=?");
			$stmt->bindValue(1,$user_id);
			$stmt->bindValue(2,$post_id);
			$stmt->execute();

			if($stmt->rowCount() == 1)
			{
				foreach ($stmt as $row)
				{
					return $row;
				}
			}
			else
			{
				return NULL;
			}
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}
	public function addLike($user_id, $post_id, $isDislike)
	{
		try {
			$stmt = $this->pdo->prepare("INSERT INTO `like` (user_id, post_id, isDislike) VALUES (? , ?, ?)");
			$stmt->bindValue(1,$user_id);
			$stmt->bindValue(2,$post_id);
			$stmt->bindValue(3, $isDislike);
			$stmt->execute();
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}
	public function changeLike($like_id, $isDislike)
	{
		try {
			$stmt = $this->pdo->prepare("UPDATE `like` SET isDislike=? WHERE id=?");
			$stmt->bindValue(1,$isDislike);
			$stmt->bindValue(2,$like_id);
			$stmt->execute();
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}
	public function removeLike($like_id)
	{
		try {
			$stmt = $this->pdo->prepare("DELETE FROM `like` WHERE id=?");
			$stmt->bindValue(1,$like_id);
			$stmt->execute();
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}
	public function addPost($user_id, $title, $content)
	{
		try {
			$stmt = $this->pdo->prepare("INSERT INTO `post`(user_id, title, content) VALUES (? , ?, ?)");
			$stmt->bindValue(1,$user_id);
			$stmt->bindValue(2,$title);
			$stmt->bindValue(3,$content);
			$stmt->execute();
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}
	public function deletePost($post_id)
	{
		try {
			$stmt = $this->pdo->prepare("DELETE FROM `like` WHERE post_id=?");
			$stmt->bindValue(1,$post_id);
			$stmt->execute();
			$stmt = $this->pdo->prepare("DELETE FROM `post` WHERE id=?");
			$stmt->bindValue(1,$post_id);
			$stmt->execute();
		}
		catch(PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}
}
