@extends('layouts.app')

@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact-form contact-thanks">
    <div class="contact-form__inner contact-thanks__inner">
        <p class="contact-thanks__message">お問い合わせありがとうございました</p>
        <a class="contact-thanks__button" href="{{ url('/') }}">HOME</a>
    </div>
</div>
@endsection