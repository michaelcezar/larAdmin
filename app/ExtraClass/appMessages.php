<?php

namespace App\ExtraClass;

class appMessages {

	public static function returnRequestMessage(){
		$message = array(
			'required' => ':attribute é óbrigatório',
            'numeric'  => ':attribute deve ser numérico',
            'min'      => ':attribute deve ter no minímo :min caracteres',
            'max'      => ':attribute deve ter no máximo :max caracteres',
            'same'     => ':attribute deve ser igual',
            'email'    =>  'Informe um e-mail válido',
            'unique'   =>  'O e-mail informado está cadastrado para outro usuário',
		);
		return $message;
	}

	public static function returnMessage(){
		$message = (object) array(
			'userNotFound'              => 'Usuário não localizado',
			'userBlock'                 => 'Usuário bloqueado, entre em contato com o administrador do sistema',
			'errorUserLogin'            => 'Usuário e/ou senha inválidos',
			'succesCreateUser'          => 'Usuário cadastrado com sucesso',
			'errorCreateUser'           => 'Ocorreu um problema ao cadastrar o usuário',
			'successUpdateUser'         => 'Dados do usuário alterados com sucesso',
			'errorUpdateUser'           => 'Ocorreu um erro ao alterar os dados do usuário',
			'successUpdatePasswordUser' => 'Senha do usuário alterada com sucesso',
			'errorUpdatePasswordUser'   => 'Ocorreu um erro ao alterar a senha do usuário',
			'successBlockUser'          => 'Usuário bloqueado com sucesso',
			'errorBlockUser'            => 'Ocorreu um erro ao bloquear o usuário',
			'successActivateUser'       => 'Usuário ativado com sucesso',
			'errorActivateUser'         => 'Ocorreu um erro ao ativar o usuário',
			'successDeleteUser'         => 'Usuário excluido com sucesso',
			'errorDeleteUser'           => 'Ocorreu um erro ao excluir o usuário',
			'successRestoreUser'        => 'Usuário restaurado com sucesso',
			'errorRestoreUser'          => 'Ocorreu um erro ao restaurar o usuário',
			
			'successSendMail'           => 'Dentro de instantes o e-mail será enviado',
			'errorSendMail'             => 'Ocorreu um problema ao enviar o e-mail, tente novamente mais tarde ou entre em contato com o administrador do sistema',

			'invalidResetPasswordToken' => 'Token inválido, por favor realize novamente o procedimento de envio de e-mail de redefinição de senha',
			'successPasswordReset'      => 'Senha redefinida com sucesso<br>Aguarde, redirecionando...',
			'errorPasswordReset'        => 'Ocorreu um erro ao redefinir a senha, tente novamente mais tarde ou entre em contato com o administrador do sistema',
			'successUpdatePassword'     => 'Senha alterada com sucesso',
			'errorUpdatePassword'       => 'Ocorreu um erro ao alterar a senha, tente novamente mais tarde ou entre em contato com o administrador do sistema',
			'invalidCurrentPassword'    => 'Senha atual inválida',
		);
		return $message;
	}
}