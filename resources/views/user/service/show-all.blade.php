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
    <x-hero-header title="DỊCH VỤ GAME" description="Danh sách các dịch vụ game" />

    <section class="menu">
        <div class="container">
            <div class="category__list">
                @if ($services->count() > 0)
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
                @else
                    <div class="no-results">
                        <div class="no-results__content">
                            <i class="fas fa-exclamation-circle no-results__icon"></i>
                            <h2 class="no-results__title">Không tìm thấy dịch vụ!</h2>
                            <p class="no-results__message">Hiện tại không có dịch vụ game nào.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
