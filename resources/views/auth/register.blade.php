@extends('app')

@section('title', 'Register')

@section('content')

<main class="viewport tat-c tat-center tat-middle">
    	    
    <h1 class="container-xs">Register</h1>
	    
    <form class="container-xs white padding-1" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <label for="firstname" class="col-md-4 control-label">First Name</label>
        <input id="firstname" type="text" class="{{ $errors->has('firstname') ? ' has-error' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus>

        @if ($errors->has('firstname'))
            <span class="alert-small error">
                {{ $errors->first('firstname') }}
            </span>
        @endif

        <label for="lastname" class="col-md-4 control-label">Last Name</label>
        <input id="lastname" type="text" class="{{ $errors->has('lastname') ? ' has-error' : '' }}" name="lastname" value="{{ old('lastname') }}" required autofocus>

        @if ($errors->has('lastname'))
            <span class="alert-small error">
                {{ $errors->first('lastname') }}
            </span>
        @endif

        <label for="email">E-Mail Address</label>
        <input id="email" type="email" class="{{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ old('email') }}" required>

        @if ($errors->has('email'))
            <span class="alert-small error">
                {{ $errors->first('email') }}
            </span>
        @endif

        <label for="password">Password</label>
        <input id="password" type="password" class="{{ $errors->has('password') ? ' has-error' : '' }}" name="password" required>

		<label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" class="{{ $errors->has('password') ? ' has-error' : '' }}" name="password_confirmation" required>    
            
        @if ($errors->has('password'))
            <span class="alert-small error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <div class="">
            <button type="submit" class="button">
                Register
            </button>
        </div>
    </form>

</main>
@endsection
