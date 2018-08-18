<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | team</title>

    <!-- Styles -->
    <link href="{{ asset('css/tat-normalise.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tat.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/pikaday.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
    
    <header id="header" class="tat-r tat-middle side-1-2">
	    
	    <div id="header-title" class="tat-f-1-0">
		    @guest
		    	<a href="{{ route('dashboard') }}"><span class="header-team text-blue">team</span><span class="header-team-name text-green" >calendar</span></a>
		    @else
				<a href="{{ route('admin:dashboard') }}"><span class="header-team text-blue">team</span><span class="header-team-name text-green">calendar</span></a>
			@endguest
		</div>
	    
	    <div id="menu-open" class="tat-f-0-0" data-tat="toggle" data-toggleid="menu"><s class="bar"></s><s class="bar"></s><s class="bar"></s></div>
	    
	    <nav id="header-menu" class="tat-f-0-0 tat-r tat-middle tat-center tat-right-md">
		    <ul class="tat-c tat-r-md">
			    @guest
			    	<li class="menu-item">
				    	<a href="{{ route('login') }}" class="menu-link">Login</a>
				    </li>
					<li class="menu-item">
				    	<a href="{{ route('register') }}" class="menu-link">Register</a>
				    </li>
			    @else
				    <li class="menu-item">
				    	<a href="{{ route('admin:users:list') }}" class="menu-link">Users</a>
				    </li>
				    <li class="menu-item">
				    	<a href="{{ route('admin:projects:list') }}" class="menu-link">Projects</a>
				    </li>
				    <li class="menu-item">
				    	<a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				            Logout
				        </a>
				    </li>
				@endguest
		    </ul>
		    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	            {{ csrf_field() }}
	        </form>
	    </nav>
    </header>
	
    @yield('content')

    <!-- Scripts -->
    <script>
	    var domain = '{{ env('APP_AJAX_URL') }}';
	</script>
	<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
    <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script src="{{ asset('js/tat.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/pikaday.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('scripts')    

	
</body>
</html>
