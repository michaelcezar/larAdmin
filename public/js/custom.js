jQuery(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
});

function showMessage(title,message,type){
	var icon = '';
	switch(type) {
	    case 'success':
	        icon = 'fas fa-check';
        break;
        case 'danger':
        	icon = 'fas fa-exclamation-triangle';
        break;
        case 'warning':
        	icon = 'fas fa-exclamation-circle';
        break;
        case 'info':
        	icon = 'fas fa-info-circle';
        break;
        default:
        	console.log('Message type not found.');
        	return false;
    }
    $.notify(
        {
        	icon: icon,
            title  : '<strong>'+title+'</strong><br/>',
            message: message 
        },
        {
            type: type, /*success - info - warning - danger*/
            offset: 20,
			spacing: 10,
            delay: 5000,
            timer: 1000,
            z_index: 99999,
            placement: {
                from : "top",
                align: "right"
            },
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
        }
    );
}

function updatePassword(){
    $("#areaModal").html("");
     $("#areaModal").html("\n\
        <div class='modal fade ' tabindex='-1' role='dialog' aria-labelledby='updatePasswordModal' aria-hidden='true' data-backdrop='static' id='updatePasswordModal'>\n\
            <div class='modal-dialog modal-sm'>\n\
                <div class='modal-content'>\n\
                    <div class='modal-header'>\n\
                        <h5 class='modal-title'>Alterar Senha</h5>\n\
                    </div>\n\
                    <div class='modal-body'>\n\
                        <form id='formUpdatePassword'>\n\
                            <div class='form-row'>\n\
                                <div class='form-group col-md-12'>\n\
                                    <label for='currentPassword_'>Senha Atual</label>\n\
                                    <input type='password' class='form-control' id='currentPassword' placeholder='Senha Atual' autocomplete='off' required data-error='Digite a senha atual' data-minlength='6'>\n\
                                    <div class='help-block with-errors'></div>\n\
                                </div>\n\
                            </div>\n\
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

    $('#updatePasswordModal').modal();

    $('#currentPassword').focus();

    $('#btnmodalOk').click(function(e){
        e.preventDefault();
        if ((formValidator('formUpdatePassword')) === 0){
            data = {
                'currentPassword'   : $('#currentPassword').val(),
                'newPassword'       : $('#newPassword').val(),
                'confirmNewPassword': $('#confirmNewPassword').val()
            };
            ajaxRequest('/password/update','PUT',data);
        } else {
            $("html, body").animate({scrollTop: 0}, 700);
            showMessage('Atenção','Corrija os erros para continuar','danger');
        }
    });
}

function modalDecisao(title,body,buttonOK,buttonCancel){
    $("#areaModal").html("");
    $("#areaModal").html("\n\
        <div class='modal fade ' tabindex='-1' role='dialog' aria-labelledby='modalDecisao' aria-hidden='true' data-backdrop='static' id='modalDecisao'>\n\
            <div class='modal-dialog  modal-lg'>\n\
                <div class='modal-content'>\n\
                    <div class='modal-header'>\n\
                        <div class='modal-title'> <h5 >"+title+"</h5></div>\n\
                    </div>\n\
                    <div class='modal-body'>\n\
                       "+body+"\n\
                    </div>\n\
                    <div class='modal-footer'>\n\
                        <button type='button' class='btn btn-success'   id='btnmodalOk'>"+buttonOK+"</button>\n\
                        <button type='button' class='btn btn-secondary' id='btnModalClose' data-dismiss='modal'>"+buttonCancel+"</button>\n\
                    </div>\n\
                </div>\n\
            </div>\n\
        </div>\n\
    ");

    $('#modalDecisao').modal();
}

function modalCarregando(){
    $("#areaModal").html("");
    $("#areaModal").html("\n\
        <div class='modal fade ' tabindex='-1' role='dialog' aria-labelledby='modalDecisao' aria-hidden='true' data-backdrop='static' id='modalCarregando'>\n\
            <div class='modal-dialog  modal-lg'>\n\
                <div class='modal-content '>\n\
                    <div class='modal-body text-center'>\n\
                        <p></p>\n\
                        <div class='progress'>\n\
                            <div class='progress-bar progress-bar-striped progress-bar-animated bg-info' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%''></div>\n\
                        </div>\n\
                        <label class='text-center'>Carregando, por favor aguarde...</label>\n\
                    </div>\n\
                    <div class='modal-footer' style='display: none'>\n\
                        <button type='button' class='btn btn-secondary disabled' id='btnModalClose' data-dismiss='modal'>Fechar</button>\n\
                    </div>\n\
                </div>\n\
            </div>\n\
        </div>\n\
    ");

    $('#modalCarregando').modal();
}


function ajaxRequest(url,method,data,tableReload){
    var buttonText = $('#btnmodalOk').text();
    $('#btnmodalOk').text('Aguarde...');
    $('#btnmodalOk').addClass('disabled');
    $('#btnModalClose').addClass('disabled');
    $.ajax({
        url     : url,
        method  : method,
        dataType: 'json',
        data    : data,
        success: function(result) {
            
            if(typeof(result.success)!=='undefined'){
                showMessage('Sucesso',result.success,'success');
                
                if (typeof(tableReload)!=='undefined'){
                    if (tableReload!==''){
                        ajaxTableReload(tableReload);
                    }
                }
                
                $('.form').trigger("reset");
                
                if (typeof(VALIDATOR_ERRORS)!=='undefined'){
                    $('.form').validator('destroy');
                }
                
                $('#btnFormCancel').click();
                $('#btnModalClose').click();


            } else if(typeof(result.error)!=='undefined') {
                showMessage('Erro',result.error,'danger');
                
            } else {
                showMessage('Atenção','A requisição falhou, tente novamente mais tarde ou entre em contato com o administrador do sistema','warning');
            }
            $('#btnmodalOk').text(buttonText);
            $('#btnmodalOk').removeClass('disabled');
            $('#btnModalClose').removeClass('disabled');
        },

        error: function(err) {
            if (err.status === 422) {
                jQuery.each(err.responseJSON.errors, function(index, value){
                    showMessage('Atenção',value,'danger');
                });
            } else if (err.status === 403) {
                showMessage('Atenção','Acesso negado<br>Realize o login novamente ou entre em contato com o administrador do sistema','danger');
            } else {
                showMessage('Atenção','A requisição falhou, tente novamente mais tarde ou entre em contato com o administrador do sistemas<br>'+err.status+' - '+err.statusText,'warning');
            }
            $('#btnmodalOk').text(buttonText);
            $('#btnmodalOk').removeClass('disabled');
            $('#btnModalClose').removeClass('disabled');
        }
    });
}

function ajaxTableReload(tableReload){
    tableReload.ajax.reload(null, false);
}

function ajaxRequestSelect(url,id,sel){
    $.ajax({
        url:      url,
        method:   'GET',
        dataType: 'json',
        success: function(data){
            var option = '';
            $.each(data, function(i, types) {
                option += '<option value="'+types.id+'">'+types.description+'</option>';
            });
            $('#'+id).append(option).show();
            $('#'+id).val(sel);
        }
    }); 
}

function ajaxRequestSelectBootstrap(url,id,sel){
    $('#'+id).selectpicker('destroy');
    $.ajax({
        url:      url,
        method:   'GET',
        dataType: 'json',
        success: function(data){
            var option = '';
            $.each(data, function(i, types) {
                option += '<option value="'+types.id+'">'+types.description+'</option>';
            });
            $('#'+id).append(option).show();
            $('#'+id).selectpicker('show');

            if(sel==='All'){
                $('#'+id).selectpicker('selectAll');
            } else {
                $('#'+id).selectpicker('val', sel);
            }

        }
    });
}