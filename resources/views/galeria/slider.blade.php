<div 
    id="ejemploCarousel" 
    class="carousel slide" 
    data-ride="carousel"
>
    <ol 
        class="carousel-indicators"
    >
        @foreach($slides as $item)
            <li 
                data-target="#ejemploCarousel" 
                data-slide-to="{{ $loop->index }}" 
                class="{{ $loop->first ? 'active' : '' }}" 
                aria-current="true" 
                aria-label="Slide {{$loop->index + 1}}"
            ></button>
        @endforeach
    </ol>
    <div 
        class="carousel-inner"
    >
        @foreach($slides as $item)
            <div 
                class="carousel-item {{ $loop->first ? 'active' : '' }}"
            >
                <a 
                    href="{{ url("your url!!!") }}"
                >
                    <img 
                        style="height:500px; margin:0 auto;" 
                        class="img-responsive center-block" 
                        src="{{ url($item->url) }}"
                        alt="{{ $item->title }}"
                    >
                </a>
                <div 
                    class="
                        carousel-caption 
                        d-none 
                        d-md-block"
                >
                    <h3>
                        <a 
                            href="{{ url("your url!!!") }}"
                        > {{ $item->title }}
                        </a>
                    </h3>
                    <h5>
                        {{ $item->description}}
                    </h5>
                </div>
            </div>
        @endforeach
    </div>
    <button 
        class="carousel-control-prev img-responsive center-block"
        type="button" 
        data-target="#ejemploCarousel" 
        data-slide="prev"
    >
        <span 
            class="carousel-control-prev-icon img-responsive center-block" 
            aria-hidden="true"
        >
        </span>
        <span 
            class="sr-only img-responsive center-block"
        >
            Previous
        </span>
    </button>
    <button 
        class="carousel-control-next img-responsive center-block" 
        type="button" 
        data-target="#ejemploCarousel" 
        data-slide="next"
    >
        <span 
            class="carousel-control-next-icon img-responsive center-block" 
            aria-hidden="true"
        >
        </span>
        <span 
            class="sr-only img-responsive center-block"
        >
            Next
        </span>
    </button>
</div>

