@extends('layouts.app')

@section('title', 'Register')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header_actions')
<a class="auth-page__header-link" href="{{ url('/login') }}">login</a>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-page__inner">
        <h2 class="auth-page__title">Register</h2>

        <div class="auth-card">
            <form class="auth-form" action="{{ url('/register') }}" method="post">
                @csrf

                <div class="auth-form__group">
                    <label class="auth-form__label" for="name">お名前</label>
                    <input class="auth-form__input @error('name') auth-form__input--error @enderror" type="text" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                    <p class="auth-form__error">{{ $message }}</p>
                    @enderror
                </div>

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
                    <button class="auth-form__button" type="submit">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection