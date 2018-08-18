@extends('app')

@section('title', 'Team members')

@section('content')
<main class="viewport tat-c tat-center tat-middle">
    	    
    <h1 class="container-xs">Edit Client</h1>
	    
    <form class="container-xs white padding-1" method="POST" action="{{ route('admin:client:edit', $client->id) }}">

			@if ($errors->any())
				<div class="alert error">Моля, попълнете коректно всички полета.</div>
				@foreach ($errors->all() as $error) 
					{{ $error }}
				@endforeach
			@endif
			<input type="hidden" name="_method" value="PUT">
			 
		        {{ csrf_field() }}
		
		        <label for="name">Client</label>
		        <input id="name" type="text" class="{{ $errors->has('name') ? ' has-error' : '' }}" name="name" placeholder="Client Name" value="{{ old('name')? old('name') : $client->name }}" required autofocus>
		
		        @if ($errors->has('name'))
		            <div class="alert-small error">
		                {{ $errors->first('name') }}
		            </div>
		        @endif
				
				<label class="checkbox" for="active">
		            <input type="checkbox" name="active" id="active" value="1" {{ $client->active ? 'checked' : '' }}> Currently active
		        </label>
		        
		        <div>
		            <button type="submit" class="button green">
		                Edit Client
		            </button>
		        </div>
		    </form>
		</div>
	

@endsection