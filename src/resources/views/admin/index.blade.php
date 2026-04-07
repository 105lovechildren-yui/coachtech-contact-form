@extends('layouts.app')

@section('title', 'Admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header_actions')
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button class="admin-page__logout-button" type="submit">logout</button>
</form>
@endsection

@section('content')
<div class="admin-page">
    <div class="admin-page__inner">
        <h2 class="admin-page__heading">Admin</h2>

        <form class="admin-page__search-form" action="{{ route('admin.index') }}" method="get">
            <div class="admin-page__filters">
                <input class="admin-page__input admin-page__input--keyword" type="text" name="keyword" value="{{ $filters['keyword'] }}" placeholder="名前やメールアドレスを入力してください">

                <select class="admin-page__select" name="gender">
                    <option value="">性別</option>
                    @foreach ($genders as $value => $label)
                    <option value="{{ $value }}" @selected((string) $filters['gender']===(string) $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <select class="admin-page__select" name="category_id" id="category_id">
                    <option value="" disabled {{ !$filters['category_id'] ? 'selected' : '' }}>お問い合わせの種類</option>

                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $filters['category_id'] == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                    @endforeach
                </select>

                <input class="admin-page__input admin-page__input--date" type="date" name="contact_date" value="{{ $filters['contact_date'] }}">

                <button class="admin-page__button admin-page__button--search" type="submit">検索</button>
                <a class="admin-page__button admin-page__button--reset" href="{{ route('admin.index') }}">リセット</a>
            </div>
        </form>

        <div class="admin-page__toolbar">
            <button class="admin-page__export-button" type="button">エクスポート</button>

            <div class="admin-page__pagination">
                @if ($contacts->onFirstPage())
                <span class="admin-page__pagination-button admin-page__pagination-button--disabled">&lt;</span>
                @else
                <a class="admin-page__pagination-button" href="{{ $contacts->previousPageUrl() }}">&lt;</a>
                @endif

                @for ($page = 1; $page <= $contacts->lastPage(); $page++)
                    @if ($page == $contacts->currentPage())
                    <span class="admin-page__pagination-button admin-page__pagination-button--active">{{ $page }}</span>
                    @else
                    <a class="admin-page__pagination-button" href="{{ $contacts->url($page) }}">{{ $page }}</a>
                    @endif
                    @endfor

                    @if ($contacts->hasMorePages())
                    <a class="admin-page__pagination-button" href="{{ $contacts->nextPageUrl() }}">&gt;</a>
                    @else
                    <span class="admin-page__pagination-button admin-page__pagination-button--disabled">&gt;</span>
                    @endif
            </div>
        </div>

        <div class="admin-page__table-wrap">
            <table class="admin-page__table">
                <thead class="admin-page__table-head">
                    <tr class="admin-page__table-row admin-page__table-row--head">
                        <th class="admin-page__table-header">お名前</th>
                        <th class="admin-page__table-header admin-page__table-header--compact">性別</th>
                        <th class="admin-page__table-header admin-page__table-header--compact">メールアドレス</th>
                        <th class="admin-page__table-header admin-page__table-header--compact">お問い合わせの種類</th>
                        <th class="admin-page__table-header admin-page__table-header--action"></th>
                    </tr>
                </thead>
                <tbody class="admin-page__table-body">
                    @forelse ($contacts as $contact)
                    <tr class="admin-page__table-row">
                        <td class="admin-page__table-cell">{{ $contact->last_name }} {{ $contact->first_name }}</td>
                        <td class="admin-page__table-cell admin-page__table-cell--compact">{{ $genders[$contact->gender] ?? '' }}</td>
                        <td class="admin-page__table-cell admin-page__table-cell--compact">{{ $contact->email }}</td>
                        <td class="admin-page__table-cell admin-page__table-cell--compact">{{ $contact->category->content ?? '' }}</td>
                        <td class="admin-page__table-cell admin-page__table-cell--action">
                            @php
                            $contactData = [
                            'id' => $contact->id,
                            'name' => trim($contact->last_name . ' ' . $contact->first_name),
                            'gender' => $genders[$contact->gender] ?? '',
                            'email' => $contact->email,
                            'tel' => $contact->tel,
                            'address' => $contact->address,
                            'building' => $contact->building ?: 'なし',
                            'category' => $contact->category->content ?? '',
                            'detail' => $contact->detail,
                            'delete_url' => route('admin.destroy', ['contact' => $contact->id]),
                            ];
                            @endphp
                            <button
                                class="admin-page__detail-button"
                                type="button"
                                data-contact='@json($contactData)'>
                                詳細
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr class="admin-page__table-row">
                        <td class="admin-page__table-cell admin-page__table-cell--empty" colspan="5">該当するお問い合わせはありません</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <dialog class="admin-page__modal" id="admin-detail-modal">
            <div class="admin-page__modal-content">
                <button class="admin-page__modal-close" type="button" aria-label="閉じる">×</button>

                <div class="admin-page__modal-body">
                    <dl class="admin-page__detail-list">
                        <div class="admin-page__detail-row">
                            <dt class="admin-page__detail-label">お名前</dt>
                            <dd class="admin-page__detail-value" data-detail-field="name"></dd>
                        </div>
                        <div class="admin-page__detail-row">
                            <dt class="admin-page__detail-label">性別</dt>
                            <dd class="admin-page__detail-value" data-detail-field="gender"></dd>
                        </div>
                        <div class="admin-page__detail-row">
                            <dt class="admin-page__detail-label">メールアドレス</dt>
                            <dd class="admin-page__detail-value" data-detail-field="email"></dd>
                        </div>
                        <div class="admin-page__detail-row">
                            <dt class="admin-page__detail-label">電話番号</dt>
                            <dd class="admin-page__detail-value" data-detail-field="tel"></dd>
                        </div>
                        <div class="admin-page__detail-row">
                            <dt class="admin-page__detail-label">住所</dt>
                            <dd class="admin-page__detail-value" data-detail-field="address"></dd>
                        </div>
                        <div class="admin-page__detail-row">
                            <dt class="admin-page__detail-label">建物名</dt>
                            <dd class="admin-page__detail-value" data-detail-field="building"></dd>
                        </div>
                        <div class="admin-page__detail-row">
                            <dt class="admin-page__detail-label">お問い合わせの種類</dt>
                            <dd class="admin-page__detail-value" data-detail-field="category"></dd>
                        </div>
                        <div class="admin-page__detail-row admin-page__detail-row--detail">
                            <dt class="admin-page__detail-label">お問い合わせ内容</dt>
                            <dd class="admin-page__detail-value admin-page__detail-value--multiline" data-detail-field="detail"></dd>
                        </div>
                    </dl>

                    <form class="admin-page__delete-form" method="post" action="">
                        @csrf
                        @method('DELETE')
                        <button class="admin-page__delete-button" type="submit">削除</button>
                    </form>
                </div>
            </div>
        </dialog>
    </div>
</div>

{{-- 管理画面一覧の詳細モーダル制御 --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('admin-detail-modal');

        if (!modal) {
            return;
        }

        var closeButton = modal.querySelector('.admin-page__modal-close');
        var deleteForm = modal.querySelector('.admin-page__delete-form');
        var detailFields = modal.querySelectorAll('[data-detail-field]');
        var detailButtons = document.querySelectorAll('.admin-page__detail-button');

        function setDetailFields(contact) {
            detailFields.forEach(function(field) {
                var key = field.getAttribute('data-detail-field');
                field.textContent = contact[key] || '';
            });
        }

        detailButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var contact = JSON.parse(button.dataset.contact || '{}');

                setDetailFields(contact);
                deleteForm.setAttribute('action', contact.delete_url || '');
                modal.showModal();
            });
        });

        closeButton.addEventListener('click', function() {
            modal.close();
        });

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.close();
            }
        });
    });
</script>
@endsection