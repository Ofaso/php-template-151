<?php
namespace Ofaso\Service\Homepage;

Interface HomepageService
{
	public function getAllPost();
	public function getLikesByPostId($post_id, $isDislike);
	public function getLikeByUserIdAndPostId($user_id, $post_id);
	public function addLike($user_id, $post_id, $isDislike);
	public function changeLike($like_id, $isDislike);
	public function removeLike($like_id);
	public function addPost($user_id,$title, $content);
	public function deletePost($post_id);
}
