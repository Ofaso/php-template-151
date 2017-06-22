<?php
namespace Ofaso\Service\Register;

Interface RegisterService
{
	public function reg($username, $password);
	public function chpw($pw, $url);
	public function acti($url, $userid);
}
