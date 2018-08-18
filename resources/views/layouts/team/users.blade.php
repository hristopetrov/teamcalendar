@extends('app')

@section('title', 'Team members')

@section('content')

<main class="viewport tat-c tat-center tat-middle">
	
	<h1 class="container-l">team members</h1>
	
	<div class="container-l white tat-g">
		
		<div class="tat-u-1 tat-u-lg-2-3 padding-1">
			
			@if (session('success'))
			    <div class="alert success">
			        {{ session('success') }}
			    </div>
			@endif

			Edit your team here.
						
			@if (count($users) > 0)
				
				<div class="tat-c table top-1-2">
					@foreach ($users as $user)
					
						<div class="tat-g table-row">
							<div class="tat-u-1 tat-u-md-1-3 table-cell">
								<a href="{{route('admin:user:stats', $user->id)}}">{{ $user->firstname }} {{ $user->lastname }}</a>
							</div>
							<div class="tat-u-1 tat-u-md-1-3 table-cell">
								{{ $user->email }}
							</div>
							<div class="tat-u-1-2 tat-u-md-1-6 table-cell">
								@if ($user->admin) 
									Admin
								@endif
							</div>
							@if (auth()->user()->admin)
							<div class="tat-u-1-2 tat-u-md-1-6 center table-cell">	
								<a href="{{ route('admin:user:edit', $user->id)  }}"><i class="material-icons">edit</i></a>
								<a href="{{ route('admin:user:del', $user->id)  }}"><i class="material-icons">delete</i></a>								
							</div>
							@endif
						</div>
					
					@endforeach
				</div>
			@endif
		</div>
		
		<div class="tat-u-1 tat-u-lg-1-3 padding-1 lightgray">

			@if ($errors->any())
				<div class="alert error">Моля, попълнете коректно всички полета.</div>
				@foreach ($errors->all() as $error) 
					{{ $error }}
				@endforeach
			@endif
			
			Add new user.
			
			<form id="user-add-form" class="top-1-2 form-white" method="POST" action="{{ route('admin:users:create') }}">
		        {{ csrf_field() }}
		
		        <label for="firstname">First Name</label>
		        <input id="firstname" type="text" class="{{ $errors->has('firstname') ? ' has-error' : '' }}" name="firstname" placeholder="First Name" value="{{ old('firstname') }}" required autofocus>
		
		        @if ($errors->has('firstname'))
		            <div class="alert-small error">
		                {{ $errors->first('firstname') }}
		            </div>
		        @endif
		
		        <label for="lastname">Last Name</label>
		        <input id="lastname" type="text" class="{{ $errors->has('lastname') ? ' has-error' : '' }}" name="lastname" palceholder="Last Name" value="{{ old('lastname') }}" required>
		
		        @if ($errors->has('lastname'))
		            <div class="alert-small error">
		                {{ $errors->first('lastname') }}
		            </div>
		        @endif
		
		        <label for="email">E-Mail Address</label>
		        <input id="email" type="email" class="{{ $errors->has('email') ? ' has-error' : '' }}" name="email" placeholder="Email" value="{{ old('email') }}" required>
		
		        @if ($errors->has('email'))
		            <div class="alert-small error">
		                {{ $errors->first('email') }}
		            </div>
		        @endif

		        <label for="start">Start at</label>
		        <input name="start" placeholder="Start at" class="{{ $errors->has('start') ? ' has-error' : '' }}" type="text" id="datepickerstart" value="{{ old('start') }}" required>
		
		        @if ($errors->has('start'))
		            <div class="alert-small error">
		                {{ $errors->first('start') }}
		            </div>
		        @endif

		       <!--  <label for="vacation">Vacation days</label>
		        <input name="vacation" placeholder="Vacation days" class="{{ $errors->has('vacation') ? ' has-error' : '' }}" type="number" id="vacation" value="{{ old('vacation') }}" required>
		
		        @if ($errors->has('vacation'))
		            <div class="alert-small error">
		                {{ $errors->first('vacation') }}
		            </div>
		        @endif -->

		        <label for="vacations_contract">Vacations contract</label>
		        <input name="vacations_contract" placeholder="Vacations contract" class="{{ $errors->has('vacations_contract') ? ' has-error' : '' }}" type="number" id="vacations_contract" value="{{ old('vacations_contract') }}" required>
		
		        @if ($errors->has('vacations_contract'))
		            <div class="alert-small error">
		                {{ $errors->first('vacations_contract') }}
		            </div>
		        @endif

		        <label for="vacations_extra">Vacations Extra</label>
		        <input name="vacations_extra" placeholder="Vacations Extra" class="{{ $errors->has('vacations_extra') ? ' has-error' : '' }}" type="number" id="vacations_extra" value="{{ old('vacations_extra') }}" required>
		
		        @if ($errors->has('vacations_extra'))
		            <div class="alert-small error">
		                {{ $errors->first('vacations_extra') }}
		            </div>
		        @endif
				
				<label class="checkbox" for="admin">
		            <input type="checkbox" name="admin" id="admin" value="1" {{ old('admin') ? 'checked' : '' }}> Team Admin
		        </label>
		        
		        <div>
		            <button type="submit" class="button green">
		                Add User
		            </button>
		        </div>
		    </form>
		</div>
	</div>
	
</main>


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
	
</script>
@endsection