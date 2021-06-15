<section class="full-box nav-lateral">
			<div class="full-box nav-lateral-bg show-nav-lateral"></div>
			<div class="full-box nav-lateral-content">
				<figure class="full-box nav-lateral-avatar">
					<i class="far fa-times-circle show-nav-lateral"></i>
					<img src="<?php echo SERVERURL; ?>views/assets/images/Avatar.png" class="img-fluid" alt="Avatar">
					<figcaption class="roboto-medium text-center">
						Jhonny Quispe <br><small class="roboto-condensed-light">Administrador</small>
					</figcaption>
				</figure>
				<div class="full-box nav-lateral-bar"></div>
				<nav class="full-box nav-lateral-menu">
					<ul>
						<li>
							<a href="<?php echo SERVERURL; ?>home"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
						</li>

						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas fa-book fa-fw"></i> &nbsp; Biblioteca <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVERURL; ?>book-reservation"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de reservas</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>book-new"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar libro</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>book-list"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de libros</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>book-search"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar libro</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Mesa de Partes <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVERURL; ?>desk-recents"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Solicitudes nuevas</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>desk-list"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de solicitudes</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>desk-search"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar Solicitud</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas  fa-user-secret fa-fw"></i> &nbsp; Usuarios <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVERURL; ?>user-new"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo usuario</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>user-list"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de usuarios</a>
								</li>
								<li>
									<a href="<?php echo SERVERURL; ?>user-search"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar usuario</a>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</section>