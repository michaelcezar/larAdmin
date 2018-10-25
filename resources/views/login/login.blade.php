@extends('layouts/guestLayout')

@section('pageTitle') Login @stop

@section('extraCSS') 
		<link href="/css/guest.css"                       rel="stylesheet">
@stop

@section('pageContent')

					<div class="container h-100">
							<div class="row justify-content-md-center h-100">
								<div class="card-wrapper">
									<div class="brand">
									</div>
									<div class="card fat">
										<div class="card-body">
											<h4 class="card-title">Login</h4>
											<form method="POST" id="formLogin">
												<div class="form-group">
													<label for="email">E-Mail</label>
													<input type="email" class="form-control" name="email" id="email" autocomplete='off' autofocus required data-error="E-Mail inválido" tabindex="1">
													<div class="help-block with-errors"></div>
												</div>
												<div class="form-group">
													<label for="password">Senha
														<a href="/password/forgot" class="float-right" tabindex="5">
															Esqueceu a Senha?
														</a>
													</label>
													<input type="password" class="form-control" name="password" id="password" required data-minlength="6" data-error="Senha Inválida" data-eye tabindex="2">
												     <div class="help-block with-errors"></div>
												</div>
												<div class="form-group">
													<div class="custom-checkbox custom-control">
														<input type="checkbox" name="remember" id="remember" class="custom-control-input" tabindex="4">
														<label for="remember" class="custom-control-label">Manter Conectado</label>
													</div>
												</div>
												<div class="form-group m-0">
													<button type='button' class="btn btn-secondary btn-block" id='btnConfirm' tabindex="3">
														Login
													</button>
												</div>
												<div class="mt-4 text-center">
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
@stop

@section('extraJavaScript')

	    <script src="/js/guest.js"                             type="text/javascript"></script>
	    <script>
	    	var next = '{{ app("request")->input("next") }}';
			$("#btnConfirm").click(function(e){
	            e.preventDefault();
	            if ((formValidator("formLogin")) === 0){
					$.ajax({
				        url     : '/login',
				        method  : 'POST',
				        dataType: 'json',
				        data: {
				            'email':    $('#email').val(),
				            'password': $('#password').val(),
				            'remember': $('#remember').is(':checked')
				        },
				        success: function(result) {
				        	console.log(result);
				        	if(typeof(result.success)!=='undefined'){
				        		if(next === ''){
				        			$(location).attr('href', result.pageRedirect);
				        		} else {
				        			$(location).attr('href', next);
				        		}
				        		
				        	} else if(typeof(result.error)!=='undefined') {
				        		showMessage('Erro',result.error,'danger');
				        		$('#password').val('');
				        		console.clear();
				        	} else {
				        		showMessage('Atenção','A requisição falhou, tente novamente mais tarde ou entre em contato com o administrador do sistema','warning');
				        	}
				        },
				        error: function(err) {
				        	if (err.status === 422) {
								jQuery.each(err.responseJSON.errors, function(index, value){
									showMessage('Atenção',value,'danger');
								});
				        	} else if (err.status === 403) {
				        		showMessage('Atenção','Acesso negado','danger');
				        	} else {
				        		showMessage('Atenção','A requisição falhou, tente novamente mais tarde ou entre em contato com o administrador do sistemas<br>'+err.status+' - '+err.statusText,'warning');
				        	}
				        }
				    });
				}
	        });
	    </script>
@stop