<div>
	<div data-bs-theme="{{ ( isset(Auth::user()->view_mode) && Auth::user()->view_mode ? 'dark' : 'light') ?? 'light'}}">
		<header>
			<nav class="navbar navbar-expand-md fixed-top bg-body-tertiary">
				<div class="container-fluid">
					
					<!-- 1. Botón Toggler para Móviles -->
					<button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- 2. Título / Marca centrada o alineada -->
					<a class="navbar-brand font-orbitron me-auto me-md-4" href="/">CONSELLO CPM</a>

					<!-- 3. Sección Login/Register / Usuario (Siempre visible horizontalmente a la derecha) -->
					<div class="d-flex align-items-center order-md-last ms-auto">
						@guest
							<ul class="navbar-nav flex-row gap-2">
								@if (Route::has('login'))
									<li class="nav-item">
										<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
									</li>
								@endif
								
								@if (Route::has('register'))
									<li class="nav-item">
										<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
									</li>
								@endif
							</ul>
						@else
							<div class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									{{ Auth::user()->name }}
								</a>
								<ul class="dropdown-menu dropdown-menu-end">
									<li>
										<a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
											{{ __('Logout') }}
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
									</li>
									<li><a class="dropdown-item" href="changeViewMode">Día / Noche</a></li>
								</ul>
							</div>
						@endguest
					</div>

					<!-- 4. Contenido Principal del Menú Colapsable -->
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						@guest
							<ul class="navbar-nav me-auto">
								<li class="nav-item">
									<a class="nav-link" href="/">Inicio</a>
								</li>
							</ul>
						@else	
							@hasrole ('Cliente')
								<ul class="navbar-nav me-auto">
									<li class="nav-item">
										<a class="nav-link" href="/clientes">Eventos</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="/reservas">Mis Reservas</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="/contacto">Contacto</a>
									</li>
								</ul>		
							@else
								<ul class="navbar-nav me-auto">
									<li class="nav-item">
										<a class="nav-link" href="/dashboard">Dashboard</a>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Lectores
										</a>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="/lectorPuerta">Puerta</a></li>
											<li><a class="dropdown-item" href="/lectorBarra">Barra</a></li>
										</ul>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Datos
										</a>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="/eventos">Eventos</a></li>
										</ul>
									</li>
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Sistema
										</a>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="/users">Usuarios</a></li>
											<li><a class="dropdown-item" href="/roles">Roles</a></li>
											<li><a class="dropdown-item" href="/permissions">Permisos</a></li>
										</ul>
									</li>
								</ul>
							@endif
						@endguest
					</div>

				</div>
			</nav>
		</header>
	</div>
</div>
