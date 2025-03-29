@if (!empty($title) && !empty($description))
    <section class="hero hero--small">
        <div class="container">
            <div class="hero__content">
                <h1 class="hero__title">{{ $title }}</h1>
                <p class="hero__desc">{{ $description }}</p>
            </div>
        </div>
    </section>

@endif