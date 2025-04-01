{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <x-hero-header title="{{ strtoupper($category->name) }}" description="{{ $category->description }}" />

    <section class="account-list">
        <div class="container">
            <!-- Account List -->
            <div class="account-list__content">
                @if ($accounts->count() > 0)
                    <div class="account-grid">
                        @foreach ($accounts as $account)
                            <div class="account-card">
                                <div class="account-card__image">
                                    <a href="{{ route('random.account.show', $account->id) }}">
                                        <img src="{{ $account->thumbnail ?? 'https://via.placeholder.com/300x180' }}"
                                            alt="Account Image">
                                    </a>
                                </div>
                                <div class="account-card__content">
                                    <div class="account-card__header">
                                        <span class="account-card__id">#{{ $account->id }}</span>
                                    </div>
                                    <div class="account-card__price">
                                        <span class="highlight-price">{{ number_format($account->price) }}đ</span>
                                    </div>
                                </div>
                                <a href="{{ route('random.account.show', $account->id) }}" class="account-card__link">
                                    <span class="account-card__link-text">Chi tiết</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination">
                        {{ $accounts->links('vendor.pagination.default') }}
                    </div>
                @else
                    <div class="no-results">
                        <div class="no-results__content">
                            <i class="fas fa-exclamation-circle no-results__icon"></i>
                            <h2 class="no-results__title">Không tìm thấy tài khoản!</h2>
                            <p class="no-results__message">Hiện tại không có tài khoản nào trong danh mục này.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
