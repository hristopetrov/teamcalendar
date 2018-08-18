@extends('app')

@section('title', 'Team members')

@section('content')
<main class="viewport tat-c tat-center tat-middle">
    	    
    <h1 class="container-xs">Edit Project</h1>
	    
    <form class="container-xs white padding-1" method="POST" action="{{ route('admin:project:edit', $project->id) }}">

			@if ($errors->any())
				<div class="alert error">Моля, попълнете коректно всички полета.</div>
				@foreach ($errors->all() as $error) 
					{{ $error }}
				@endforeach
			@endif
			<input type="hidden" name="_method" value="PUT">
			 
		        {{ csrf_field() }}
		
		        <label for="name">Name</label>
		        <input id="name" type="text" class="{{ $errors->has('name') ? ' has-error' : '' }}" name="name" placeholder="Project Name" value="{{ old('name')? old('name') : $project->name }}" required autofocus>
		
		        @if ($errors->has('name'))
		            <div class="alert-small error">
		                {{ $errors->first('name') }}
		            </div>
		        @endif
		

		        <label for="budgeted">Budget</label>
		        <input name="budgeted" placeholder="Budget" class="{{ $errors->has('budgeted') ? ' has-error' : '' }}" type="number" value="{{ old('budgeted') ? old('budgeted') : $project->budgeted }}" required>
		
		        @if ($errors->has('budgeted'))
		            <div class="alert-small error">
		                {{ $errors->first('budgeted') }}
		            </div>
		        @endif

		         <label for="deadline">Deadline</label>
		        <input name="deadline" placeholder="Deadline" class="{{ $errors->has('deadline') ? ' has-error' : '' }}" type="text" id="datepickerend" value="{{ old('deadline') ? old('deadline') : $project->deadline }}" required>
		
		        @if ($errors->has('deadline'))
		            <div class="alert-small error">
		                {{ $errors->first('deadline') }}
		            </div>
		        @endif

		        <label for="color">Color</label>
		        <input id="color" type="text" name="color" placeholder="Project color" value="{{ old('color') ? old('color') : $project->color }}" maxlength="6" style="border-bottom: 6px solid #{{  $project->color }};">
				
				{{ ColorsHelper::display() }}
				
				<label class="checkbox" for="active">
		            <input type="checkbox" name="active" id="active" value="1" {{ $project->active ? 'checked' : '' }}> Currently active
		        </label>
				
		        
		        <div>
		            <button type="submit" class="button green">
		                Edit Project
		            </button>
		        </div>
		    </form>
		</div>
	

@endsection

@section('scripts')
<script>
swatch.init();
</script>
@endsection