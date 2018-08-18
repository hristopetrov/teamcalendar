@extends('app')

@section('title', 'Team projects')

@section('content')

<main class="viewport tat-c tat-center tat-middle">
	
	<h1 class="container-xs">{{$project->name}}</h1>
	
	<div class="container-xs white tat-g">
			@if (session('success'))
			    <div class="alert success">
			        {{ session('success') }}
			    </div>
			@endif
			
		<div id="project-stat" class="tat-u-1 padding-1">
			
			
			<span class="text-darkgray">Client: </span> <strong>{{$project->client->name}}</strong>
			<br>
			<span class="text-darkgray">Budgeted days: </span> {{$project->budgeted}}	
			<br>
			<span class="text-darkgray">Actual days: </span> {{$project->calendars->sum('length')}}
			<br>
			<span class="text-darkgray">Project deadline: </span> {{$project->deadline}}	
			<br>
			
		     
<!--
			@foreach ($project->calendars()->groupBy('user_id') as $user)
				<div class="tat-r">
					<span>Project Total Days per {{$user->firstname}}: </span>	
					{{$project->calendars->where('user_id', $user->id)->sum('length')}}
				</div>
			@endforeach
-->
		</div>
		
	</div>
</main>	

@endsection