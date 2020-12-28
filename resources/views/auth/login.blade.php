@extends('layouts.login')

@section('title', 'Login E-Raport SIT Ikhtiar')

@section('content')

<div class="main-title mb-5"><h2 class="mb-5">SIGN IN</h2>
    <p>silahkan sign in menggunakan akun yang diberikan administrator untuk mengakses e-raport</p>
</div>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required autocomplete="email" aria-describedby="emailHelp" placeholder="email@address.com">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="at least 8 characters">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">Biarkan saya tetap masuk</label>
        <a href="/forget-password" class="float-right">Lupa Password?</a>
    </div>
    <button type="submit" class="btn s-btn-primary w-100">Sign In</button>
</form>
@endsection
