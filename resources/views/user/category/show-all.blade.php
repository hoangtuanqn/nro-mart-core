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
    <!-- Menu mục game -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">MENU MỤC GAME</h2>
            </header>
            <div class="category__list">
                @foreach ($categories as $category)
                    <a href="{{ route('category.index', ['slug' => $category->slug]) }}" class="category__item">
                        <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                        <h2 class="category__title">{{ $category->name }}</h2>
                        <p class="category__desc">Tổng tài khoản: {{ number_format($category->allAccount) }}</p>
                        <p class="category__desc">Acc đã bán: {{ number_format($category->soldCount) }}</p>
                        <p class="text category__action">Mua ngay</p>
                    </a>
                @endforeach

            </div>
        </div>
    </section>
@endsection
