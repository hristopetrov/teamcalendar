@extends('app')

@section('title', 'calendar')

@section('content')

	@if (session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@endif


<main class="viewport tat-c-r tat-r-xl tat-center tat-top">
		
	<div id="calendar-bar" class=" padding-1-2 white tat-f-1-0 tat-u-1 tat-u-xl-4-5">
		
		<div id="calendar-nav" class="tat-r tat-hspace">
			<span class="js-move-calendar" data-move="left"><i class="js-del-task material-icons" >keyboard_arrow_left</i></span>
			<span class="js-move-calendar" data-move="right"><i class="js-del-task material-icons" >keyboard_arrow_right</i></span>
		</div>
		
		
		<div id="calendar" class="js-calendar tat-r" data-start="today" data-length="{{ $length }}">
			
			<div id="calendar-members" class="tat-f-0-0">
			
				@if (count($users) > 0)
							
					@foreach ($users as $user)
						
						<div class="calendar-member right">
							{{ $user->firstname }} {{ $user->lastname }}
						</div>
						
					@endforeach
					
				@endif
			</div>
			
			<div id="calendar-days" class="tat-f-1-1 tat-g">
				
				@foreach ($days as $day)
					<div class="calendar-day tat-u-1 tat-u-sm-1-2 tat-u-md-1-4 tat-u-lg-1-{{ $length }}" data-date="{{ $day['date'] }}">
						
						<div class="calendar-day-th mint tat-c tat-right">
							<span class="text-gray">{{ $day['day'] }}</span>	
							<span class="text-blue">{{ $day['weekday'] }}</span>
						</div>
						
						<div class="calendar-day-td tat-c">			
							
							@for ($i=1; $i <= count($users); $i++)
								
								<div class="calendar-slot tat-c dropable" data-date="{{ $day['date'] }}">
								
								</div>
								
							@endfor
							
						</div>
						
					</div>
				@endforeach
				
			</div>
			
			<div class="spinner"><i class="spinner-icon"></i></div>
		
		</div>	
		
	</div>


	<div id="projects-bar" class="white padding-1-2 tat-f-0-0 tat-u-1 tat-u-xl-1-5 tat-g">
		
		<h5 class="tat-u-1 text-gray">Tasks:</h5>
		
		@if (count($projects) > 0)
						
				@foreach ($projects as $project)
					
					<div class="calendar-project dragable tat-f-0-0 tat-r green @if (ColorsHelper::isDark($project->color)) darkcolor @endif" 
						@if (!empty($project->color)) style="background-color: #{{$project->color}}" @endif
						draggable="true" style="" data-project="{{ $project->id }}">
						<div class="tat-f-1-1 tat-c tat-center">
							<span class="project-client">{{ $project->client->name }}</span>
							<span class="project-name">{{ $project->name }}</span>
						</div>
						<div class="tat-f-0-0 tat-s-middle project-actions">
							<span class=""><i class="js-del-task material-icons text-white" >close</i></span>
						</div>
					</div>
					
				@endforeach
				
		@endif
		
		<div class="calendar-project vacation dragable tat-f-0-0 tat-r tat-middle lightgray" draggable="true" style="" data-length="1.0" data-away="vacation">		
			<span class="tat-f-1-1 away-name">Vacation</span>
			<div class="tat-f-0-0 tat-s-middle project-actions">
				<span class=""><i class="js-del-task material-icons" >close</i></span>
			</div>
		</div>
		
		<div class="calendar-project vacation dragable tat-f-0-0 tat-r tat-middle lightgray" draggable="true" style="" data-length="1.0" data-away="sick">		
			<span class="tat-f-1-1 away-name">Illness</span>
			<div class="tat-f-0-0 tat-s-middle project-actions">
				<span class=""><i class="js-del-task material-icons" >close</i></span>
			</div>
		</div>
		
		<div class="calendar-project vacation dragable tat-f-0-0 tat-r tat-middle lightgray" draggable="true" style="" data-length="1.0" data-away="other">		
			<span class="tat-f-1-1 away-name">Other</span>
			<div class="tat-f-0-0 tat-s-middle project-actions">
				<span class=""><i class="js-del-task material-icons" >close</i></span>
			</div>
		</div>		
		
	</div>
	
		
</main>

@endsection
