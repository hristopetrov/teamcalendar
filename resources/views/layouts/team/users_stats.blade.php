@extends('app')

@section('title', 'Team projects')


@section('content')

<main class="viewport tat-c tat-center tat-middle">
	
	<h1 class="container-xs">{{$user->getFullNameAttribute()}}</h1>
	
	<div class="container-xs white tat-g">

		@if (session('success'))
		    <div class="alert success">
		        {{ session('success') }}
		    </div>
		@endif	
	
		<div id="project-stat" class="tat-u-1 padding-1 ">
			
			<span class="text-darkgray">Start Date: </span> 
				{{$user->employee->start}}
			<br>
			
			<span class="text-darkgray">Annual vacations: </span> 
				{{$user->employee->vacations_contract}}
			<br>
			
			<span class="text-darkgray">Extra vacations for this year: </span> 
				{{$user->employee->vacations_extra}}
			<br>
			
			<span class="text-darkgray">Used vacations this year: </span> 
				{{$vacations}}
			<br>
			
			<span class="text-darkgray">Remaining to this day: </span> 
				{{ $allowedVacation - $vacations }}
			<br>
			
			<span class="text-darkgray">Total days of sick in {{date('Y')}}: </span> 
				{{ $sick }}
			<br>
			
			<span class="text-darkgray">Missed by other reason in {{date('Y')}}: </span> 
				{{ $other }}
			<br>
			
		</div>
	</div>
</main>	
@endsection
