<div>
	<div data-bs-theme="{{ Auth::user()->view_mode ? "dark" : 'light'}}">
		<header>
			<nav class="navbar navbar-expand-md fixed-top bg-body-tertiary">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link {{  $principal ?? ''}}" href="/dashboard">Principal</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle {{ $sistema ?? ''}}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Sistema
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="/users">Usuarios</a></li>
								<li><a class="dropdown-item" href="/roles">Roles</a></li>
								<li><a class="dropdown-item" href="/permissions">Permisos</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="collapse navbar-collapse">
					<a class="navbar-brand" href="">
						<img src="/icons/5991785_coronavirus_countries_infected_map_spread_icon.svg" width="30" height="30" class="d-inline-block align-top" alt="logotipo" loading="lazy">
						Brand Name
					</a>
				</div>
					@guest
						<div class="collapse navbar-collapse">
							<ul class="navbar-nav mr-auto">
								@if (Route::has('login'))
								<li class="navbar-nav mr-auto"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
								@endif
								
								@if (Route::has('register'))
								<li class="navbar-nav mr-auto"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
								@endif
							</ul>
						</div>
					@else
						<div class="nav-item dropdown">
							<ul class='navbar-nav mr-auto'>
								<li class="nav-item">
									<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
										{{ Auth::user()->name }}
									</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li>
											<a class="dropdown-item" href=""
												onclick="event.preventDefault();
																document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
												@csrf
											</form>
										</li>
										<li><a class="dropdown-item" href="changeViewMode">Día / Noche</a></li>
									</ul>
								</li>
							</ul>
						</div>
					@endguest
			</nav>
		</header>
</div>
