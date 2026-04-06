@extends('layouts.app')

@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact-form contact-confirm">
    <div class="contact-form__inner">
        <h2 class="contact-form__heading">Confirm</h2>

        <form class="contact-form__form" action="{{ route('contact.store') }}" method="post">
            @csrf

            <table class="contact-confirm__table">
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">お名前</th>
                    <td class="contact-confirm__value">
                        <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
                        <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
                        {{ $contact['full_name'] }}
                    </td>
                </tr>
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">性別</th>
                    <td class="contact-confirm__value">
                        <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
                        {{ $contact['gender_label'] }}
                    </td>
                </tr>
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">メールアドレス</th>
                    <td class="contact-confirm__value">
                        <input type="hidden" name="email" value="{{ $contact['email'] }}">
                        {{ $contact['email'] }}
                    </td>
                </tr>
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">電話番号</th>
                    <td class="contact-confirm__value">
                        @foreach ($contact['tel'] as $value)
                        <input type="hidden" name="tel[]" value="{{ $value }}">
                        @endforeach
                        {{ $contact['tel_display'] }}
                    </td>
                </tr>
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">住所</th>
                    <td class="contact-confirm__value">
                        <input type="hidden" name="address" value="{{ $contact['address'] }}">
                        {{ $contact['address'] }}
                    </td>
                </tr>
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">建物名</th>
                    <td class="contact-confirm__value">
                        <input type="hidden" name="building" value="{{ $contact['building'] }}">
                        {{ $contact['building'] }}
                    </td>
                </tr>
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">お問い合わせの種類</th>
                    <td class="contact-confirm__value">
                        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                        {{ $contact['category_content'] }}
                    </td>
                </tr>
                <tr class="contact-confirm__row">
                    <th class="contact-confirm__label">お問い合わせ内容</th>
                    <td class="contact-confirm__value contact-confirm__value--detail">
                        <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
                        {!! nl2br(e($contact['detail'])) !!}
                    </td>
                </tr>
            </table>

            <div class="contact-confirm__actions">
                <button class="contact-confirm__button contact-confirm__button--submit" type="submit">送信</button>
                <button class="contact-confirm__button contact-confirm__button--back" type="button" onclick="history.back()">修正</button>
            </div>
        </form>
    </div>
</div>
@endsection