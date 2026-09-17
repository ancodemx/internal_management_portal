<!doctype html>
<html lang="en">
	<!-- [Head] start -->

	<head>
		<title>Login | Admindek Dashboard Template</title>
		<!-- [Meta] -->
		<meta charset="utf-8" />
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
		/>
		<meta
			name="description"
			content="Admindek - Modern responsive dashboard template built with Bootstrap 5. Features dark/light themes, RTL support, and extensive UI components for admin panels and web applications."
		/>
		<meta
			name="keywords"
			content="Admindek - Bootstrap 5 admin template, responsive dashboard, dark mode, RTL support, admin panel, UI components, web application template, modern dashboard"
		/>
		<meta name="author" content="DashboardPack.com" />
		<meta name="theme-color" content="#1e293b" />
		<meta name="color-scheme" content="light dark" />

		<!-- [Favicon] icons -->
		<link rel="shortcut icon" href="<?php echo URL_PATH; ?>/img/logo.ico">
		<link rel="apple-touch-icon" href="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/images/apple-touch-icon.png" />
		<link rel="manifest" href="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/images/site.webmanifest" />
		<!-- [Font] Family -->
		<link
			href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap"
			rel="stylesheet"
		/>
		<!-- [phosphor Icons] https://phosphoricons.com/ -->
		<link rel="stylesheet" href="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/css/plugins/phosphor-icons.css" />
		<!-- [Tabler Icons] https://tablericons.com -->
		<link rel="stylesheet" href="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/css/plugins/tabler-icons.min.css" />
		<!-- [Template CSS Files] -->
		<link rel="stylesheet" href="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/css/style.css" id="main-style-link" />
		<link rel="stylesheet" href="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/css/style-preset.css" />
		<!-- [Vite Development Scripts] -->
		<!-- Development script removed for production -->
	</head>
	<!-- [Head] end -->
	<!-- [Body] Start -->
	<body
		data-pc-preset="preset-1"
		data-pc-sidebar-caption="true"
		data-pc-direction="ltr"
		data-pc-theme="light"
	>
		<div class="auth-main" style="background-image: url(<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/images/authentication/back_palace_web_opacity.jpg);">
			<div class="auth-wrapper v5">
				<div class="auth-form">
					<div class="card my-2">
						<div class="card-body">
							<h4 class="text-center f-w-500 mt-4 mb-3">Iniciar sesión</h4>

							<div id="liveAlertPlaceholder"></div>

							<form action="login/logIn" id="login" method="post">
								<div class="mb-3">
									<input
										type="text"
										class="form-control"
										id="txt_username" 
										name="username"
										placeholder="Usuario"
									/>
								</div>
								<div class="mb-3">
									<input
										type="password"
										class="form-control"
										id="txt_password" 
										name="password"
										placeholder="Contraseña"
									/>
								</div>
								<div class="d-flex mt-1 justify-content-between align-items-center">
									<a href="#" class="text-secondary f-w-400 mb-0">¿Se te olvidó la contraseña?</a>
								</div>
								<div class="text-center mt-4">
									<button class="btn btn-primary shadow px-sm-4" id="btn_entrar" type="submit">
										Entrar
									</button>
								</div>
								<!-- <div class="d-flex justify-content-between align-items-end mt-4">
									<h6 class="f-w-500 mb-0">¿No tienes una cuenta?</h6>
										<a href="#" class="link-primary">Crear cuenta</a>
								</div> -->

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- [ Main Content ] end -->
		<!-- Required JS -->
		<script src="<?php echo URL_PATH; ?>/jquery/jquery.min.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/popper.min.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/simplebar.min.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/bootstrap.min.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/i18next.min.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/plugins/i18nextHttpBackend.min.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/script.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/theme.js"></script>
		<script src="<?php echo RESOURCES_PATH; ?>/admindek310/dist/assets/js/multi-lang.js"></script>

		<script type="text/javascript">

			const alertPlaceholder = document.getElementById('liveAlertPlaceholder');

			const alert = (message, type) => {
				const wrapper = document.createElement('div');
				wrapper.innerHTML = [
				`<div class="alert alert-${type} alert-dismissible" role="alert">`,
				`   <div>${message}</div>`,
				'   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
				'</div>'
				].join('');

				// Sobrescribe la alerta anterior
				alertPlaceholder.innerHTML = wrapper.innerHTML;
			};
	
			$('#login').on('submit', function(e) {
				e.preventDefault();
				$("#btn_entrar").prop('disabled', true);
				$.ajax({
					type: "POST",
					url: $(this).attr('action'),
					data: $(this).serialize(),
					beforeSend: function() {
						alert('Accesando!', 'info');
					},
					success: function(datos) {
						if ( datos.is_error == false && datos.response.session_on == true ) {
							location.href = 'home';
						}else{
							alert(datos.message, datos.meta_data.alert_type);
							$("#btn_entrar").prop('disabled', false);
						}
					}
				});
			});

		</script>

	</body>
	<!-- [Body] end -->
</html>
