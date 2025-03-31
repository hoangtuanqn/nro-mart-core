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
    <!-- Menu mục dịch vụ game -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">DỊCH VỤ GAME</h2>
            </header>
            <div class="category__list">
                @foreach ($services as $service)
                    @if ($service->active)
                        <a href="{{ route('service.show', ['slug' => $service->slug]) }}" class="category__item">
                            <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}" class="category__img" />
                            <h2 class="category__title">{{ strtoupper($service->name) }}</h2>
                            <p class="category__desc">Tổng giao dịch: {{ number_format($service->orderCount) }}</p>
                            <p class="text category__action">Thuê ngay</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
