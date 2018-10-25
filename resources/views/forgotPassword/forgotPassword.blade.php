@extends('layouts/guestLayout')

@section('pageTitle') Esqueceu a Senha? @stop

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
								<h4 class="card-title">Esqueceu a Senha?</h4>
								<form id="formResetPassword">
									<div class="form-group">
										<label for="email">Informe seu e-mail e dentro de instantes enviaremos a redefinição de senha para você</label>
										<input type="email" class="form-control" name="email" id="email" autocomplete='off' autofocus required data-error="E-Mail inválido" tabindex="1" placeholder="E-Mail">
										<div class="help-block with-errors"></div>
									</div>
									<div class="form-group m-0">
										<div class="row">
											<div class="col-md-6">
												<button type='button' class="btn btn-secondary btn-block " id='btnSendMail' tabindex="2">
													Enviar E-Mail
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
			jQuery(document).ready(function() {
				$("#btnSendMail").click(function(e){
		            e.preventDefault();
		            if ((formValidator("formResetPassword")) === 0){
						data = {
					        'email':    $('#email').val()
					    };
					    $('#formResetPassword').css('display','none');
					    $('#aguarde').css('display','block');
		            	$.ajax({
					        url     : '/password/emailReset',
					        method  : 'POST',
					        dataType: 'json',
					        data    : data,
					        success: function(result) {
					            if(typeof(result.success)!=='undefined'){
					                showMessage('Sucesso',result.success,'success');
					       			setTimeout(function(){
									   	$(location).attr('href', '/login');
								  	},7000);
					            } else if(typeof(result.error)!=='undefined') {
					                showMessage('Erro',result.error,'danger');
					                $('#formResetPassword').css('display','block');
					    			$('#aguarde').css('display','none');

					            } else {
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
					                showMessage('Atenção','Acesso negado<br>Entre em contato com o administrador do sistema','danger');
					            } else {
					                showMessage('Atenção','A requisição falhou, tente novamente mais tarde ou entre em contato com o administrador do sistemas<br>'+err.status+' - '+err.statusText,'warning');
					            }
					        }
					    });
		           	}
		        });

		    	$("#btnCancel").click(function(e){
		    		$(location).attr('href', '/login')
		    	});

		    	$(document).keypress(function(e) {
				    if(e.which == 13) {
				        $("#btnSendMail").click();
				    }
				});

				$('form input').on('keypress', function(e) {
				    if(e.which == 13) {
				       $("#btnSendMail").click();
				    }
				    return e.which !== 13;
				});
			});
		</script>
@stop