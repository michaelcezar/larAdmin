@extends('layouts/adminLayout')

@section('pageTitle') Novo Usuário @stop

@section('extraCSS') 

@stop

@section('pageContent')
		<div class="row">
			<div class="col-md-12">
				<div class="card fat">
					<div class="card-header">
					    Cadastro de Usuário
					</div>
					<div class="card-body">
						<form id='formNewUser' class='form'>
							<div class="form-row">
							    <div class="form-group col-md-6">
							      <label for="name">Nome</label>
							      <input type="text" class="form-control" id="name" placeholder="Nome" autocomplete="off" autofocus required data-error="Digite o nome do usuário.">
							      <div class="help-block with-errors"></div>
							    </div>
							    <div class="form-group col-md-6">
							      <label for="email">E-Mail</label>
							      <input type="email" class="form-control" id="email" placeholder="E-Mail" autocomplete="off" required data-error="Digite um e-mail correto.">
							      <div class="help-block with-errors"></div>
							    </div>
							</div>
							<div class="form-row">
							    <div class="form-group col-md-4">
							      <label for="password">Senha</label>
							      <input type="password" class="form-control" id="password" placeholder="Senha" autocomplete="off" required data-minlength="6" data-error="A senha deve ter no minímo 6 caracteres.">
							      <div class="help-block with-errors"></div>
							    </div>
							    <div class="form-group col-md-4">
							      <label for="passwordConfirm">Repetir Senha</label>
							      <input type="password" class="form-control" id="passwordConfirm" placeholder="Repetir Senha" autocomplete="off" required data-error="As senhas não são iguais." data-match="#password">
							      <div class="help-block with-errors"></div>
							    </div>
							     <div class="form-group col-md-4">
							      <label for="type">Tipo de Acesso</label>
							      <select class="form-control" id='type'>
							      </select>
							    </div>
							</div>
							<hr>
							<div class="form-row">
								<div class="form-group col-md-2">
									<button type="button" class="btn btn-outline-success col-md-12" id="btnCad">Cadastrar</button>
								</div>
								<div class="form-group col-md-2">
									<button type="button" class="btn btn-outline-danger col-md-12" id="btnFormCancel">Cancelar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

@stop

@section('extraJavaScript')
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$("#users").addClass("active");

			ajaxRequestSelect('/admin/user/listType','type',1);

			$('#btnCad').click(function(e){
				e.preventDefault();

	 			if ((formValidator('formNewUser')) === 0){
					data = {
						'name':     $('#name').val(),
				        'email':    $('#email').val(),
				        'password': $('#password').val(),
				        'type':     $('#type').val(),
				        'status':   1
				    };
				    modalCarregando();
					ajaxRequest('/admin/user/new','POST',data);
				} else {
	            	$("html, body").animate({scrollTop: 0}, 700);
	            	showMessage('Atenção','Corrija os erros para continuar','danger');
	            }
	        });

			$('#btnFormCancel').click(function(e){
	            e.preventDefault();
	            if (typeof(VALIDATOR_ERRORS)!=='undefined'){
	            	$('#formNewUser').validator('destroy');	
	            }
	            $('#formNewUser').trigger("reset");
	            $('#name').focus();
	        });
	    });

	</script>
@stop