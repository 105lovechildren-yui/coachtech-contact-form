@extends('layouts.app')

@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact-form">
    <div class="contact-form__inner">
        <h2 class="contact-form__heading">Contact</h2>

        <form class="contact-form__form" action="{{ route('contact.confirm') }}" method="post">
            @csrf

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="last_name">お名前</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field contact-form__field--name">
                    <div class="contact-form__control">
                        <input class="contact-form__input contact-form__input--name @error('last_name') contact-form__input--error @enderror" type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="例: 山田">
                        @error('last_name')
                        <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="contact-form__control">
                        <input class="contact-form__input contact-form__input--name @error('first_name') contact-form__input--error @enderror" type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="例: 太郎">
                        @error('first_name')
                        <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <span class="contact-form__label">性別</span>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <div class="contact-form__field-content contact-form__field-content--radio">
                        <label class="contact-form__radio-label">
                            <input class="contact-form__radio" type="radio" name="gender" value="1" @checked(old('gender', '1' )==='1' )>
                            <span class="contact-form__radio-text">男性</span>
                        </label>
                        <label class="contact-form__radio-label">
                            <input class="contact-form__radio" type="radio" name="gender" value="2" @checked(old('gender')==='2' )>
                            <span class="contact-form__radio-text">女性</span>
                        </label>
                        <label class="contact-form__radio-label">
                            <input class="contact-form__radio" type="radio" name="gender" value="3" @checked(old('gender')==='3' )>
                            <span class="contact-form__radio-text">その他</span>
                        </label>
                    </div>
                    @error('gender')
                    <p class="contact-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="email">メールアドレス</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <input class="contact-form__input @error('email') contact-form__input--error @enderror" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="例: test@example.com">
                    @error('email')
                    <p class="contact-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="tel_area">電話番号</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <div class="contact-form__field-content contact-form__field-content--tel">
                        <input class="contact-form__input contact-form__input--tel @if($errors->has('tel') || $errors->has('tel.0') || $errors->has('tel.1') || $errors->has('tel.2')) contact-form__input--error @endif" type="text" name="tel[]" id="tel_area" value="{{ old('tel.0') }}" placeholder="080">
                        <span class="contact-form__separator">-</span>
                        <input class="contact-form__input contact-form__input--tel @if($errors->has('tel') || $errors->has('tel.0') || $errors->has('tel.1') || $errors->has('tel.2')) contact-form__input--error @endif" type="text" name="tel[]" value="{{ old('tel.1') }}" placeholder="1234">
                        <span class="contact-form__separator">-</span>
                        <input class="contact-form__input contact-form__input--tel @if($errors->has('tel') || $errors->has('tel.0') || $errors->has('tel.1') || $errors->has('tel.2')) contact-form__input--error @endif" type="text" name="tel[]" value="{{ old('tel.2') }}" placeholder="5678">
                    </div>
                    @if ($errors->has('tel') || $errors->has('tel.0') || $errors->has('tel.1') || $errors->has('tel.2'))
                    <p class="contact-form__error">
                        {{ $errors->first('tel') ?: $errors->first('tel.0') ?: $errors->first('tel.1') ?: $errors->first('tel.2') }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="address">住所</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <input class="contact-form__input @error('address') contact-form__input--error @enderror" type="text" name="address" id="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3">
                    @error('address')
                    <p class="contact-form__error">{{ $message }}</p>
                    @enderror
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
                    <select class="contact-form__select @error('category_id') contact-form__input--error @enderror" name="category_id" id="category_id">
                        <option value="" disabled @selected(!old('category_id'))>選択してください</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->content }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="contact-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__group">
                <div class="contact-form__label-wrap">
                    <label class="contact-form__label" for="detail">お問い合わせ内容</label>
                    <span class="contact-form__required">※</span>
                </div>
                <div class="contact-form__field">
                    <textarea class="contact-form__textarea @error('detail') contact-form__input--error @enderror" name="detail" id="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                    @error('detail')
                    <p class="contact-form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="contact-form__actions">
                <button class="contact-form__button" type="submit">確認画面</button>
            </div>
        </form>
    </div>
</div>
@endsection