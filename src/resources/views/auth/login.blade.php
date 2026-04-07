@extends('layouts.app')

@section('title', 'Login')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header_actions')
<a class="auth-page__header-link" href="{{ url('/register') }}">register</a>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-page__inner">
        <h2 class="auth-page__title">Login</h2>

        <div class="auth-card">
            <form class="auth-form" action="{{ url('/login') }}" method="post">
                @csrf

                <div class="auth-form__group">
                    <label class="auth-form__label" for="email">メールアドレス</label>
                    <input class="auth-form__input @error('email') auth-form__input--error @enderror" type="email" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                    <p class="auth-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="password">パスワード</label>
                    <input class="auth-form__input @error('password') auth-form__input--error @enderror" type="password" name="password" id="password">
                    @error('password')
                    <p class="auth-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="auth-form__actions">
                    <button class="auth-form__button" type="submit">ログイン</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection