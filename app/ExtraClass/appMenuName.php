<?php

namespace App\ExtraClass;

class appMenuName {

	public static function returnMenuName(){
		$language = 'pt-br';

		switch ($language) {
			case 'pt-br':
				$menuName = (object) array(
					'home'           => 'Início',
					'user'           => 'Usuário',
					'newUser'        => 'Novo',
					'listUser'       => 'Listar',
					'changePassword' => 'Alterar Senha',
					'logout'         => 'Sair',
				);
			break;
			
			default:
				$menuName = (object) array(
					'home'           => 'Home',
					'user'           => 'User',
					'newUser'        => 'New',
					'listUser'       => 'List',
					'changePassword' => 'Change Password',
					'logout'         => 'Logout',
				);
			break;
		}

		return $menuName;
	}

}


					