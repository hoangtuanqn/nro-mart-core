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
    <x-hero-header title="DANH MỤC GAME" description="Danh sách các danh mục tài khoản game" />

    <section class="menu">
        <div class="container">
            <div class="category__list">
                @if ($categories->count() > 0)
                    @foreach ($categories as $category)
                        @if($category->active)
                            <a href="{{ route('category.index', ['slug' => $category->slug]) }}" class="category__item">
                                <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                                <h2 class="category__title">{{ $category->name }}</h2>
                                <div class="category__stats">
                                    <span class="badge">{{ number_format($category->allAccount) }} Tài khoản</span>
                                    <span class="badge">Đã bán: {{ number_format($category->soldCount) }}</span>
                                </div>
                                <p class="category__action">XEM CHI TIẾT</p>
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="no-results">
                        <div class="no-results__content">
                            <i class="fas fa-exclamation-circle no-results__icon"></i>
                            <h2 class="no-results__title">Không tìm thấy danh mục!</h2>
                            <p class="no-results__message">Hiện tại không có danh mục game nào.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
