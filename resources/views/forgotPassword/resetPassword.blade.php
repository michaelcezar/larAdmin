@extends('layouts/guestLayout')

@section('pageTitle') Redefinir Senha @stop

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
								<h4 class="card-title">Redefinir Senha</h4>
								<form id="formResetPassword">
									<div class="form-group">
										<label for="user">Usuário</label>
										<span id="user">{{ app("request")->input("email") }}</span>
									</div>
									<div class="form-group">
										<label for="password">Nova Senha	</label>
										<input type="password" class="form-control" name="password" id="password" autofocus required data-minlength="6" data-error="Senha Inválida" data-eye tabindex="1">
									     <div class="help-block with-errors"></div>
									</div>
									<div class="form-group">
										<label for="passwordConfirm">Repetir Senha	</label>
										<input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" required data-error="As senhas não são iguais." data-match="#password" tabindex="2">
									     <div class="help-block with-errors"></div>
									</div>
									

									<div class="form-group m-0">
										<div class='row'>
											<div class="col-md-6">
												<button type='button' class="btn btn-secondary btn-block" id='btnConfirm' tabindex="3">
													Alterar
												</button>
											</div>
											<div class="col-md-6">
												<button type='button' class="btn btn-light btn-block " id='btnCancel' tabindex="3">
													Cancelar
												</button>
											</div>
										</div>
									</div>
									
									<div class="mt-4 text-center">
									</div>
								</form>

								<div class='row' style='display: none' id='aguarde'>
									<div class='col-md-12'>
										<label>Por favor aguarde...</label>
										<div class="progress">
 											<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
 										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
@stop      	

@section('extraJavaScript')

    <script>
		$("#btnConfirm").click(function(e){
            e.preventDefault();
            $('#formResetPassword').css('display','none');
		    $('#aguarde').css('display','block');
            if ((formValidator("formResetPassword")) === 0){
				$.ajax({
			        url     : '/password/reset',
			        method  : 'PUT',
			        dataType: 'json',
			        data: {
			            'email'          : '{{ app("request")->input("email") }}',
			            'password'       : $('#password').val(),
			            'confirmPassword': $('#passwordConfirm').val(),
			            'token'          : '{{ app("request")->input("token") }}'
			        },
			        success: function(result) {
			        	if(typeof(result.success)!=='undefined'){
								showMessage('Sucesso',result.success,'success');
					       			setTimeout(function(){
									   	$(location).attr('href', result.pageRedirect);
							  	},5000);

			        	} else if(typeof(result.error)!=='undefined') {
			        		$('#formResetPassword').css('display','block');
		    				$('#aguarde').css('display','none');
			        		showMessage('Erro',result.error,'danger');
			        	} else {
			        		$('#formResetPassword').css('display','block');
		    				$('#aguarde').css('display','none');
			        		showMessage('Atenção','A requisição falhou, tente novamente mais tarde ou entre em contato com o administrador do sistema','warning');
			        	}
			        },
			        error: function(err) {
			        	$('#formResetPassword').css('display','block');
		    			$('#aguarde').css('display','none');
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

		$("#btnCancel").click(function(e){
			$(location).attr('href', '/login');
    	});

    	$(document).keypress(function(e) {
		    if(e.which == 13) {
		        $("#btnConfirm").click();
		    }
		});
    </script>

@stop