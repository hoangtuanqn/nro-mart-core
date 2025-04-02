<!-- Hero Small Variant -->
<section class="hero--small">
    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title">{{ $title }}</h1>
            @if (isset($description) && $description)
                <p class="hero__desc">{{ $description }}</p>
            @endif
        </div>
    </div>
</section>
