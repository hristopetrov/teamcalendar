@extends('app')

@section('title', 'Login')

@section('content')

<main class="viewport tat-c tat-center tat-middle">
    	    
    <h1 class="container-xs">login</h1>

    <form class="container-xs white padding-1" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <label for="email">E-Mail Address</label>
        <input id="email" type="email" class="{{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

        @if ($errors->has('email'))
            <div class="alert-small error">
                {{ $errors->first('email') }}
            </div>
        @endif


        <label for="password">Password</label>
        <input id="password" type="password" class="{{ $errors->has('password') ? ' has-error' : '' }}" name="password" required>

        @if ($errors->has('password'))
            <div class="alert-small error">
                {{ $errors->first('password') }}
            </div>
        @endif


        <label class="checkbox" for="remember">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>

        <div>
            <button type="submit" class="button">
                Login
            </button>

            <a class="button clean" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        </div>
    </form>
    
</main>

@endsection
