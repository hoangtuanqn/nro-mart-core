{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Danh mục Random')

@section('content')
    <x-hero-header title="DANH MỤC RANDOM" description="Danh sách các danh mục tài khoản random" />

    <section class="menu">
        <div class="container">
            <div class="category__list">
                @if ($categories->count() > 0)
                    @foreach ($categories as $category)
                        <a href="{{ route('random.index', ['slug' => $category->slug]) }}" class="category__item">
                            <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                            <h2 class="category__title">{{ strtoupper($category->name) }}</h2>
                            <p class="category__desc">Tổng tài khoản: {{ number_format($category->allAccount) }}</p>
                            <p class="category__desc">Acc đã bán: {{ number_format($category->soldCount) }}</p>
                            <p class="text category__action">Mua ngay</p>
                        </a>
                    @endforeach
                @else
                    <div class="no-results">
                        <div class="no-results__content">
                            <i class="fas fa-exclamation-circle no-results__icon"></i>
                            <h2 class="no-results__title">Không tìm thấy danh mục!</h2>
                            <p class="no-results__message">Hiện tại không có danh mục random nào.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
