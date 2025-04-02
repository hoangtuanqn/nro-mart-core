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
    <x-hero-header title="VÒNG QUAY MAY MẮN" description="Danh sách các danh mục vòng quay may mắn" />

    <section class="menu">
        <div class="container">
            <div class="category__list">
                @endphp
                @if ($categories->count() > 0)
                    @foreach ($categories as $category)
                        @if ($category->active)
                            <a href="{{ route('random.index', ['slug' => $category->slug]) }}" class="category__item">
                                <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                                <h2 class="category__title">{{ strtoupper($category->name) }}</h2>
                                <p class="category__desc">Số lượt quay: {{ number_format($category->soldCount) }}</p>
                                <p class="text category__action">Mua ngay</p>
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="no-results">
                        <div class="no-results__content">
                            <i class="fas fa-exclamation-circle no-results__icon"></i>
                            <h2 class="no-results__title">Không tìm thấy danh mục!</h2>
                            <p class="no-results__message">Hiện tại không có danh mục vòng quay nào.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
