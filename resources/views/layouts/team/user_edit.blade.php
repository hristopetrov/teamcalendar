@extends('app')

@section('title', 'Team members')

@section('content')
<main class="viewport tat-c tat-center tat-middle">
    	    
    <h1 class="container-xs">Edit User</h1>
	    
    <form class="container-xs white padding-1" method="POST" action="{{ route('admin:user:edit', $user->id) }}">

			@if ($errors->any())
				<div class="alert error">Моля, попълнете коректно всички полета.</div>
				@foreach ($errors->all() as $error) 
					{{ $error }}
				@endforeach
			@endif
			<input type="hidden" name="_method" value="PUT">
			 
		        {{ csrf_field() }}
		
		        <label for="firstname">First Name</label>
		        <input id="firstname" type="text" class="{{ $errors->has('firstname') ? ' has-error' : '' }}" name="firstname" placeholder="First Name" value="{{ old('firstname')? old('firstname') : $user->firstname }}" required autofocus>
		
		        @if ($errors->has('firstname'))
		            <div class="alert-small error">
		                {{ $errors->first('firstname') }}
		            </div>
		        @endif
		
		        <label for="lastname">Last Name</label>
		        <input id="lastname" type="text" class="{{ $errors->has('lastname') ? ' has-error' : '' }}" name="lastname" palceholder="Last Name" value="{{ old('lastname') ? old('lastname') : $user->lastname }}" required>
		
		        @if ($errors->has('lastname'))
		            <div class="alert-small error">
		                {{ $errors->first('lastname') }}
		            </div>
		        @endif
		
		        <label for="email">E-Mail Address</label>
		        <input id="email" type="email" class="{{ $errors->has('email') ? ' has-error' : '' }}" name="email" placeholder="Email" value="{{ old('email') ? old('email') : $user->email }}" required>
		
		        @if ($errors->has('email'))
		            <div class="alert-small error">
		                {{ $errors->first('email') }}
		            </div>
		        @endif

		        <label for="start">Start at</label>
		        <input name="start" placeholder="Start at" class="{{ $errors->has('start') ? ' has-error' : '' }}" type="text" id="datepickerstart" value="{{ old('start') ? old('start') : $user->employee->start }}" required>
		
		        @if ($errors->has('start'))
		            <div class="alert-small error">
		                {{ $errors->first('start') }}
		            </div>
		        @endif

		         <label for="end">End at</label>
		        <input name="end" placeholder="End at" class="{{ $errors->has('end') ? ' has-error' : '' }}" type="text" id="datepickerend" value="{{ old('end') ? old('end') : $user->employee->end }}" >

		        @if ($errors->has('end'))
		            <div class="alert-small error">
		                {{ $errors->first('end') }}
		            </div>
		        @endif
		
		     	<label for="vacations_contract">Vacations contract</label>
		        <input name="vacations_contract" placeholder="Vacations contract" class="{{ $errors->has('vacations_contract') ? ' has-error' : '' }}" type="number" id="vacations_contract" value="{{ old('vacations_contract') ? old ('vacations_contract') : $user->employee->vacations_contract }}" required>
		
		        @if ($errors->has('vacations_contract'))
		            <div class="alert-small error">
		                {{ $errors->first('vacations_contract') }}
		            </div>
		        @endif

		        <label for="vacations_extra">Vacations Extra</label>
		        <input name="vacations_extra" placeholder="Vacations Extra" class="{{ $errors->has('vacations_extra') ? ' has-error' : '' }}" type="number" id="vacations_extra" value="{{  old('vacations_extra') ? old ('vacations_extra') : $user->employee->vacations_extra }}" required>
		
		        @if ($errors->has('vacations_extra'))
		            <div class="alert-small error">
		                {{ $errors->first('vacations_extra') }}
		            </div>
		        @endif


		        <!-- <label for="vacation">Vacation days</label>
		        <input name="vacation" placeholder="Vacation days" class="{{ $errors->has('vacation') ? ' has-error' : '' }}" type="number" id="vacation" value="{{ old('vacation') }}" required>
		
		        @if ($errors->has('vacation'))
		            <div class="alert-small error">
		                {{ $errors->first('vacation') }}
		            </div>
		        @endif -->
				
				<label class="checkbox" for="admin">
		            <input type="checkbox" name="admin" id="admin" value="1" {{ old('admin') ? 'checked' : '' }}> Team Admin
		        </label>
		        
		        <div>
		            <button type="submit" class="button green">
		                Edit User
		            </button>
		        </div>
		    </form>
		</div>
	

@endsection

@section('scripts')
<script>
	
var pickerstart = new Pikaday({
    field: document.getElementById('datepickerstart'),
    format: 'YYYY-MM-DD',
    onSelect: function() {
        console.log(this.getMoment().format('YYYY-MM-DD'));
    }
});
var pickerend = new Pikaday({
    field: document.getElementById('datepickerend'),
    format: 'YYYY-MM-DD',
    onSelect: function() {
        console.log(this.getMoment().format('YYYY-MM-DD'));
    }
});
	
</script>
@endsection