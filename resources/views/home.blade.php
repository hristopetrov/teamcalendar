@extends('app')

@section('title', 'calendar')

@section('content')

	@if (session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@endif


<main class="viewport tat-c-r tat-r-xl tat-center tat-top">
	
	<div id="calendar-bar" class=" padding-1-2 white tat-f-1-0 tat-u-1 tat-u-xl-4-5 tat-r">
		
		<div id="calendar-members" class="tat-f-0-0">
			
			<div class="calendar-member">
				{{ $user->firstname }} {{ $user->lastname }}
			</div>
					
		</div>
		
		<div id="calendar" class="tat-f-1-1 tat-g js-calendar" data-start="">
			
			<div class="spinner-overlay"><i class="spinner"></i></div>
				
		</div>
		
	</div>


	<div id="projects-bar" class="white padding-1-2 tat-f-0-0 tat-u-1 tat-u-xl-1-5 tat-g">
		
		@if (count($projects) > 0)
						
				@foreach ($projects as $project)
					
					<div class="calendar-project tat-f-0-0 green" draggable="true" style="">
						{{ $project->name }}
					</div>
					
				@endforeach
				
		@endif
		
	</div>
	
</main>

@endsection
