@extends('layouts.app')

@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact-form">
    <div class="contact-form__inner">
        <h2 class="contact-form__heading">Contact</h2>

        {{-- TODO: バリデーション実装時にフォーム全体のエラーメッセージ表示を追加する --}}
        <form class="contact-form__form" action="" method="post">
            @csrf

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="last_name">お名前</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field contact-form__field--name">
                    {{-- TODO: バリデーション実装時に各入力欄のエラー表示と error クラス付与を追加する --}}
                    <input class="contact-form__input contact-form__input--name" type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="例: 山田">
                    <input class="contact-form__input contact-form__input--name" type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="例: 太郎">
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <span class="contact-form__label">性別</span>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field contact-form__field--radio">
                    <label class="contact-form__radio-label">
                        <input class="contact-form__radio" type="radio" name="gender" value="male" @checked(old('gender', 'male' )==='male' )>
                        <span class="contact-form__radio-text">男性</span>
                    </label>
                    <label class="contact-form__radio-label">
                        <input class="contact-form__radio" type="radio" name="gender" value="female" @checked(old('gender')==='female' )>
                        <span class="contact-form__radio-text">女性</span>
                    </label>
                    <label class="contact-form__radio-label">
                        <input class="contact-form__radio" type="radio" name="gender" value="other" @checked(old('gender')==='other' )>
                        <span class="contact-form__radio-text">その他</span>
                    </label>
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="email">メールアドレス</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <input class="contact-form__input" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="例: test@example.com">
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="tel_area">電話番号</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field contact-form__field--tel">
                    {{-- TODO: バリデーション実装 半角数字（5桁まで） --}}
                    <input class="contact-form__input contact-form__input--tel" type="text" name="tel[]" id="tel_area" value="{{ old('tel.0') }}" placeholder="080">
                    <span class="contact-form__separator">-</span>
                    <input class="contact-form__input contact-form__input--tel" type="text" name="tel[]" value="{{ old('tel.1') }}" placeholder="1234">
                    <span class="contact-form__separator">-</span>
                    <input class="contact-form__input contact-form__input--tel" type="text" name="tel[]" value="{{ old('tel.2') }}" placeholder="5678">
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="address">住所</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <input class="contact-form__input" type="text" name="address" id="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3">
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="building">建物名</label>
                </div>
                <div class="contact-form__field">
                    <input class="contact-form__input" type="text" name="building" id="building" value="{{ old('building') }}" placeholder="例: 千駄ヶ谷マンション101">
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="category_id">お問い合わせの種類</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <select class="contact-form__select" name="category_id" id="category_id">
                        <option value="" disabled @selected(!old('category_id'))>選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->content }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="detail">お問い合わせ内容</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <textarea class="contact-form__textarea" name="detail" id="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                </div>
            </div>

            <div class="contact-form__actions">
                <button class="contact-form__button" type="submit">確認画面</button>
            </div>
        </form>
    </div>
</div>
@endsection