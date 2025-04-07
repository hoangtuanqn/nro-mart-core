<div class="col-lg-12 text-center">
    @if ($title)
        <h5>{{ $title }}</h5>
    @endif
    <img id="preview-thumb" alt="preview" src="{{ $image }}" class="mx-auto d-block mb-3 preview-thumb">
    <div id="preview-images" class="d-flex flex-wrap justify-content-center gap-3 mb-3"></div>
</div>
