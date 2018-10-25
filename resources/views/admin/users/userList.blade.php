@extends('layouts/adminLayout')

@section('pageTitle') Listar Usuários @stop

@section('extraCSS') 
	<link href="/js/datatables/dataTables.bootstrap4.min.css"               rel="stylesheet">
	<link href='/js/datatables/Buttons/css/buttons.bootstrap4.min.css'      rel='stylesheet' type='text/css'/>
	<link href='/js/bootstrap-select/bootstrap-select.css'                  rel='stylesheet' type='text/css'/>
@stop

@section('pageContent')
		<div class="row">
			<div class="col-md-12">
				<div class="card fat">
					<div class="card-header">
					    Listar Usuários
					</div>
					<div class="card-body">
						<div class="table-responsive">
		  					<table class="table table-hover table-overflow" id="tableListarUsuario" width="100%">
								<thead>
								    <tr>
									    <th>Usuário</th>
									    <th>E-mail</th>
									    <th>Tipo</th>
									    <th>Status</th>
									    <th>Ações</th>
								    </tr>
						  		</thead>
						  		<tbody>
							  	</tbody>
		  					</table>
		  				</div>
					</div>
				</div>
			</div>
		</div>
@stop

@section('extraJavaScript')
	
	<script src="/js/datatables/jquery.dataTables.min.js"         type="text/javascript"></script>
	<script src="/js/datatables/dataTables.bootstrap4.min.js"     type="text/javascript"></script>
	
	<script src='/js/datatables/Buttons/js/dataTables.buttons.js' type='text/javascript'></script>
    <script src='/js/datatables/Buttons/js/buttons.bootstrap4.js' type='text/javascript'></script>
    <script src='/js/datatables/JSZip/jszip.min.js'               type='text/javascript'></script>
    <script src='/js/datatables/pdfmake/pdfmake.min.js'           type='text/javascript'></script>
    <script src='/js/datatables/pdfmake/vfs_fonts.js'             type='text/javascript'></script>
    <script src='/js/datatables/Buttons/js/buttons.html5.js'      type='text/javascript'></script>
    <script src='/js/datatables/Buttons/js/buttons.print.js'      type='text/javascript'></script>

	<script src="/js/datatables/dataTablesUtilities.js"           type="text/javascript"></script>

	<script src='/js/bootstrap-select/bootstrap-select.js'        type="text/javascript"></script>
	<script src='/js/bootstrap-select/i18n/defaults-pt_BR.js'     type="text/javascript"></script>

	<script type="text/javascript">
		
		jQuery(document).ready(function(){
			$("#users").addClass("active");

			setDataTable = {
				'tableId'                : '#tableListarUsuario',
				'url'                    : '/admin/user/list',
				'method'                 : 'POST',
				'searchParams'           :  [{
				    'name':   '',
				    'email':  '',
				    'type':   '0',
				    'status': '0'
			    }],
				'dataSrc'                : '',
				'buttons'                : true,
				'reportId'               : 'listaUsuario',
				'reportTitle'            : 'Listagem de Usuários',
				'reportOrientation'      : 'portrait',
				'orderMenuLength'        : 'asc',
				'showColumnsReportArray' : [0,1,2,3],
				'orderColumnsnArray'     : [ [3, 'asc'], [0, 'asc'] ],
				'columnsAray'            : [
					{ "mData": "name"},
	                { "mData": "email"},
	                { "mData": "type_description"},
	                { "mData": "user_status_description"},
	                { "mData": null, "className": " alncenter",  "orderable": false,
	                	"render": function(full){
	                		var actions = "";
	                		if(full.user_status != 3){
	                			if(full.user_status == 1){
		                		actions += '<i class="far fa-envelope  fa-fw tooltips clicavelPlus text-info" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Redefinir Senha do Usuário "></i>&nbsp;&nbsp';
		                		actions += '<i class="fas fa-user-edit fa-fw tooltips clicavelPlus text-secondary" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar Usuário "></i>&nbsp;&nbsp';
								actions += '<i class="fas fa-key       fa-fw tooltips clicavelPlus text-secondary" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Alterar Senha do Usuário "></i>&nbsp;&nbsp';
								actions += '<i class="fas fa-user-lock fa-fw tooltips clicavelPlus text-danger" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Bloquear Usuário "></i>&nbsp;&nbsp';
								}
								if(full.user_status == 2){
									actions += '<i class="fas fa-user-edit  fa-fw tooltips clicavelPlus text-secondary" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar Usuário "></i>&nbsp;&nbsp';
									actions += '<i class="fas fa-user-check fa-fw tooltips clicavelPlus text-success"   data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Ativar Usuário "></i>&nbsp;&nbsp';
								}
		                		actions += '<i class="fas fa-user-times fa-fw tooltips clicavelPlus text-danger" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Excluir Usuário "></i>&nbsp;&nbsp';
	                		} else {
	                			actions += '<i class="fas fa-user-edit  fa-fw tooltips clicavelPlus text-secondary" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar Usuário "></i>&nbsp;&nbsp';
	                			actions += '<i class="fas fa-user-plus  fa-fw tooltips clicavelPlus text-success" data-container="body" data-toggle="tooltip" data-placement="bottom" data-original-title="Restaurar Usuário "></i>&nbsp;&nbsp';
	                		}
	                		return actions;
	                	}
	           		}
	           	]
			}

			tabListaUsarios = $(setDataTable.tableId).DataTable(
				ajaxDataTable(setDataTable)
			)

			tabListaUsarios.on('click', '.fa-envelope', function(){
		        var dados = tabListaUsarios.row($(this).parents('tr')).data();
				modalDecisao('Atenção','<p>Tem certeza que deseja enviar o e-mail de redefinição de senha para o usuário: '+dados.name+', e-mail: '+dados.email+'?</p>','Sim, Redefinir senha e enviar e-mail','Cancelar');
				$('#btnmodalOk').click(function(e){
					e.preventDefault();
					data = {
			        	'id': dados.id
			        };
			        ajaxRequest('/admin/user/redefinePassword','PUT',data);
				});
	    	});

			tabListaUsarios.on('click', '.fa-user-edit', function(){
		        var dados = tabListaUsarios.row($(this).parents('tr')).data();
		        $("#areaModal").html("");
	     		$("#areaModal").html("\n\
	     			 <div class='modal fade ' tabindex='-1' role='dialog' aria-labelledby='updateUserModal' aria-hidden='true' data-backdrop='static' id='updateUserModal'>\n\
			            <div class='modal-dialog mw-100 w-75'>\n\
			                <div class='modal-content'>\n\
			                    <div class='modal-header'>\n\
			                        <h5 class='modal-title'>Editar Usuário</h5>\n\
			                    </div>\n\
			                    <div class='modal-body'>\n\
			                        <form id='formEditUser'>\n\
			                            <div class='form-row'>\n\
										    <div class='form-group col-md-6'>\n\
										      <label for='name'>Nome</label>\n\
										      <input type='text' class='form-control' id='name' placeholder='Nome' autocomplete='off' autofocus required data-error='Digite o nome do usuário.' value='"+dados.name+"'>\n\
										      <div class='help-block with-errors'></div>\n\
										    </div>\n\
										     <div class='form-group col-md-6'>\n\
										      <label for='email'>E-Mail</label>\n\
										      <input type='email' class='form-control' id='email' placeholder='E-Mail' autocomplete='off' required data-error='Digite um e-mail correto.' value='"+dados.email+"'>\n\
										      <div class='help-block with-errors'></div>\n\
										    </div>\n\
										</div>\n\
										<div class='form-row'>\n\
										    <div class='form-group col-md-6'>\n\
										      <label for='type'>Tipo de Acesso</label>\n\
										      <select class='form-control' id='type'>\n\
											  </select>\n\
										    </div>\n\
										    <div class='form-group col-md-6'>\n\
										      <label for='status'>Status</label>\n\
										      <select class='form-control' id='status'>\n\
											  </select>\n\
										    </div>\n\
										</div>\n\
			                        </form>\n\
			                    </div>\n\
			                    <div class='modal-footer'>\n\
			                        <button type='button' class='btn btn-success' id='btnmodalOk'>Salvar</button>\n\
			                        <button type='button' class='btn btn-secondary' id='btnModalClose' data-dismiss='modal'>Cancelar</button>\n\
			                    </div>\n\
			                </div>\n\
			            </div>\n\
			        </div>\n\
	     		");

				$('#updateUserModal').modal();
				ajaxRequestSelect('/admin/user/listType',   'type',  dados.user_type);
				ajaxRequestSelect('/admin/user/listStatus', 'status',dados.user_status);
				$('#name').focus();

				$('#btnmodalOk').click(function(e){
					e.preventDefault();
					if ((formValidator('formEditUser')) === 0){
						data = {
				        	'id':       dados.id,
				            'name':     $('#name').val(),
				            'email':    $('#email').val(),
				            'type':     $('#type').val(),
				            'status':   $('#status').val()
				        };
				        ajaxRequest('/admin/user/update','PUT',data,tabListaUsarios);
					} else {
						$("html, body").animate({scrollTop: 0}, 700);
		            	showMessage('Atenção','Corrija os erros para continuar','danger');
					}
				});
	    	});

			tabListaUsarios.on('click', '.fa-key', function(){
				var dados = tabListaUsarios.row($(this).parents('tr')).data();
				$("#areaModal").html("");
	     		$("#areaModal").html("\n\
	     			<div class='modal fade ' tabindex='-1' role='dialog' aria-labelledby='updateUserPasswordModal' aria-hidden='true' data-backdrop='static' id='updateUserPasswordModal'>\n\
			            <div class='modal-dialog  modal-sm'>\n\
			                <div class='modal-content'>\n\
			                    <div class='modal-header'>\n\
			                        <div class='modal-title'> <h5 >Alterar Senha<br/></h5><h6 >Usuário: "+dados.name+"<br/>E-Mail: "+dados.email+"</h6></div>\n\
			                    </div>\n\
			                    <div class='modal-body'>\n\
			                        <form id='formUpdateUserPassword'>\n\
			                            <div class='form-row'>\n\
			                                <div class='form-group col-md-12'>\n\
			                                    <label for='newPassword'>Nova Senha</label>\n\
			                                    <input type='password' class='form-control' id='newPassword' placeholder='Nova Senha' autocomplete='off' required data-error='Digite a nova senha' data-minlength='6'>\n\
			                                    <div class='help-block with-errors'></div>\n\
			                                </div>\n\
			                            </div>\n\
			                            <div class='form-row'>\n\
			                                <div class='form-group col-md-12'>\n\
			                                    <label for='confirmNewPassword'>Repita a Nova Senha</label>\n\
			                                    <input type='password' class='form-control' id='confirmNewPassword' placeholder='Repita a Nova Senha' autocomplete='off' required data-error='As senhas não são iguais' data-match='#newPassword'>\n\
			                                    <div class='help-block with-errors'></div>\n\
			                                </div>\n\
			                            </div>\n\
			                        </form>\n\
			                    </div>\n\
			                    <div class='modal-footer'>\n\
			                        <button type='button' class='btn btn-success' id='btnmodalOk'>Alterar Senha</button>\n\
			                        <button type='button' class='btn btn-secondary' id='btnModalClose' data-dismiss='modal'>Cancelar</button>\n\
			                    </div>\n\
			                </div>\n\
			            </div>\n\
			        </div>\n\
	     		");

				$('#updateUserPasswordModal').modal();

				$('#btnmodalOk').click(function(e){
					e.preventDefault();
					if ((formValidator('formUpdateUserPassword')) === 0){
						data = {
				        	'id':                 dados.id,
				            'newPassword':        $('#newPassword').val(),
	                		'confirmNewPassword': $('#confirmNewPassword').val()
				        };
				        ajaxRequest('/admin/user/updatePassword','PUT',data,tabListaUsarios);
					} else {
						$("html, body").animate({scrollTop: 0}, 700);
		            	showMessage('Atenção','Corrija os erros para continuar','danger');
					}
				});
			});

			tabListaUsarios.on('click', '.fa-user-lock', function(){
		        var dados = tabListaUsarios.row($(this).parents('tr')).data();
				modalDecisao('Atenção','<p>Tem certeza que deseja bloquear o usuário: '+dados.name+', e-mail: '+dados.email+'?</p>','Sim, Bloquear Usuário','Cancelar');
				$('#btnmodalOk').click(function(e){
					e.preventDefault();
					data = {
			        	'id': dados.id
			        };
			        ajaxRequest('/admin/user/block','PUT',data,tabListaUsarios);
				});
	    	});

			tabListaUsarios.on('click', '.fa-user-check', function(){
		        var dados = tabListaUsarios.row($(this).parents('tr')).data();
		        modalDecisao('Atenção','<p>Tem certeza que deseja ativar o usuário: '+dados.name+', e-mail: '+dados.email+'?</p>','Sim, Ativar Usuário','Cancelar');
				$('#btnmodalOk').click(function(e){
					e.preventDefault();
					data = {
			        	'id': dados.id
			        };
			        ajaxRequest('/admin/user/activate','PUT',data,tabListaUsarios);
				});
	    	});

			tabListaUsarios.on('click', '.fa-user-times', function(){
		        var dados = tabListaUsarios.row($(this).parents('tr')).data();
		        modalDecisao('Atenção','<p>Tem certeza que deseja excluir o usuário: '+dados.name+', e-mail: '+dados.email+'?</p>','Sim, Excluir Usuário','Cancelar');
		        $('#btnmodalOk').click(function(e){
					e.preventDefault();
					data = {
			        	'id': dados.id
			        };
			        ajaxRequest('/admin/user/delete','PUT',data,tabListaUsarios);
				});
		    });

		    tabListaUsarios.on('click', '.fa-user-plus', function(){
		        var dados = tabListaUsarios.row($(this).parents('tr')).data();
		        modalDecisao('Atenção','<p>Tem certeza que deseja restaurar o usuário: '+dados.name+', e-mail: '+dados.email+'?</p>','Sim, Restaurar Usuário','Cancelar');
		        $('#btnmodalOk').click(function(e){
					e.preventDefault();
					data = {
			        	'id': dados.id
			        };
			        ajaxRequest('/admin/user/restore','PUT',data,tabListaUsarios);
				});
		    });	
		});

		function listaUsuarioSEARCH(){
	        $("#areaModal").html("");
     		$("#areaModal").html("\n\
     			 <div class='modal fade ' tabindex='-1' role='dialog' aria-labelledby='searchUserModal' aria-hidden='true' data-backdrop='static' id='searchUserModal'>\n\
		            <div class='modal-dialog mw-100 w-75'>\n\
		                <div class='modal-content'>\n\
		                    <div class='modal-header'>\n\
		                        <h5 class='modal-title'>Pesquisar Usuários</h5>\n\
		                    </div>\n\
		                    <div class='modal-body'>\n\
		                        <form id='formSearchUser'>\n\
		                            <div class='form-row'>\n\
									    <div class='form-group col-md-6'>\n\
									      <label for='name'>Nome</label>\n\
									      <input type='text' class='form-control' id='name' placeholder='Todos' autocomplete='off' autofocus required data-error='Digite o nome do usuário.' >\n\
									      <div class='help-block with-errors'></div>\n\
									    </div>\n\
									     <div class='form-group col-md-6'>\n\
									      <label for='email'>E-Mail</label>\n\
									      <input type='email' class='form-control' id='email' placeholder='Todos' autocomplete='off' required data-error='Digite um e-mail correto.'>\n\
									      <div class='help-block with-errors'></div>\n\
									    </div>\n\
									</div>\n\
									<div class='form-row'>\n\
									    <div class='form-group col-md-6'>\n\
									      <label for='type'>Tipo de Acesso</label>\n\
									      <select class='form-control selectpicker' id='type' name='type[]' multiple data-actions-box='true'>\n\
										  </select>\n\
									    </div>\n\
									    <div class='form-group col-md-6'>\n\
									      <label for='status'>Status</label>\n\
									      <select class='form-control selectpicker' id='status' name='status[]' multiple data-actions-box='true'>\n\
										  </select>\n\
									    </div>\n\
									</div>\n\
		                        </form>\n\
		                    </div>\n\
		                    <div class='modal-footer'>\n\
		                        <button type='button' class='btn btn-success' id='btnmodalOk'>Pesquisar</button>\n\
		                        <button type='button' class='btn btn-secondary' id='btnModalClose' data-dismiss='modal'>Cancelar</button>\n\
		                    </div>\n\
		                </div>\n\
		            </div>\n\
		        </div>\n\
     		");

			$('#searchUserModal').modal();
			
			ajaxRequestSelectBootstrap('/admin/user/listType',   'type',   'All');
			ajaxRequestSelectBootstrap('/admin/user/listStatus', 'status', 'All');

			$('#name').focus();
			$("#btnmodalOk").click(function(e){
            	e.preventDefault();

            	setDataTable.searchParams[0].name   = $('#name').val();
            	setDataTable.searchParams[0].email  = $('#email').val();
            	setDataTable.searchParams[0].type   = $('#type').val();
            	setDataTable.searchParams[0].status = $('#status').val();

            	tabListaUsarios.ajax.reload();

            	$("#btnModalClose").click();
            });
		}
	</script>
@stop