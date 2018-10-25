@extends('layouts/adminLayout')

@section('pageTitle') Início @stop

@section('pageContent')

	<div class="row">
		<div class="col-md-12">
			<div class="card fat">
				<div class="card-body">
					<div class="card fat">
						<div class="card-header text-white bg-secondary text-center">
						    Usuários
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<div class="card fat">
										<div class="card-header text-white bg-info text-center">
										    Cadastrados
										</div>
										<div class="card-body text-center"> 
											<span id="allUsers" class="counter">0</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card fat">
										<div class="card-header text-white bg-success text-center">
										    Ativos
										</div>
										<div class="card-body text-center">
											<span id="activeUsers" class="counter">0</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card ">
										<div class="card-header fat text-white bg-warning text-center">
										    Bloqueados
										</div>
										<div class="card-body text-center">
											<span id="blockUsers" class="counter">0</span>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card fat">
										<div class="card-header text-white bg-danger text-center">
										    Excluidos
										</div>
										<div class="card-body text-center">
											<span id="deleteUsers" class="counter">0</span>
										</div>
									</div>
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
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$("#home").addClass("active");
			getUserCount();
		});

		function getUserCount(){
			$.ajax({
		        url     : '/admin/user/count',
		        method  : 'GET',
		        dataType: 'json',
		        success: function(result) {

		        	$('#allUsers').html(parseInt(result.success[0].user_count) + parseInt(result.success[1].user_count) + parseInt(result.success[2].user_count) );
		        	$('#activeUsers').html(parseInt(result.success[0].user_count) );
		        	$('#blockUsers').html(parseInt(result.success[1].user_count) );
		        	$('#deleteUsers').html(parseInt(result.success[2].user_count) );

		        	$('.counter').each(function () {
				        $(this).prop('Counter',0).animate({
				            Counter: $(this).text()
				        }, {
				            duration: 1000,
				            easing: 'swing',
				            step: function (now) {
				                $(this).text(Math.ceil(now));
				            }
				        });
				    });
		        }
    		});
		}
	</script>
@stop