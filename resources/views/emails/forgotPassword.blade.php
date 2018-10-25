<html>
	<body>
		<p>Olá, foi solicitado o envio do e-mail para a redefinição de sua senha.</p>
		<a href =	@if(isset($bodyMessage))  {{ $bodyMessage }}  @endif >Clique aqui para redefinir sua senha</a>
        <p>Caso não tenha realizado essa solicitação por favor desconsidere essa mensagem.</p>
	</body>
</html>