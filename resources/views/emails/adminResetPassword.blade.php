<html>
	<body>
		<p>Olá, o administrador do sistema solicitou a alteração de sua senha, a partir deste momento a senha que você utilizava anteriormente não é mais válida.</p>
		<a href =	@if(isset($bodyMessage))  {{ $bodyMessage }}  @endif >Clique aqui para redefinir sua senha</a>
		<p>Em caso de duvidas, fale com o administrador do sistema.</p>
		<p>Você ainda pode acessar o sistema, clicar em "Esqueceu a Senha?" e um novo e-mail será enviado para redefini-la.</p>
	</body>
</html>