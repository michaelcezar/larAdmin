<?php

namespace App\ExtraClass;

class appInfo {

	public static function returnAppInfo(){
		$info = (object) array(
			'appName'     => 'larAdmin',
			'appYear'     => '2018',
			'appDev'      => 'Michael Cezar',
			'appDevEmail' => 'michael.cezar.pinto@gmail.com',
		);
		return $info;
	}

}
