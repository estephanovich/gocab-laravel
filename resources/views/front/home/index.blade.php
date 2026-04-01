@extends('front.layouts.master')

@push('css')
    <!-- aos css -->
    <link rel="preload" as="style" href="{{ asset('front/css/aos.css') }}" onload="this.onload=null;this.rel='stylesheet'">

    <!-- wow animate css link -->
    <link rel="stylesheet" href="{{ asset('front/css/vendors/wow.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/vendors/wow-animate.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://public.codepenassets.com/css/normalize-5.0.0.min.css">
@endpush
@section('title', __('static.landing_pages.landing_page'))
@section('content')
    @php
        $classes = ['ride-box', 'user-box', 'driver-box', 'rating-box', 'ride-box'];
        $blogs = getBlogsByIds(@$content['blog']['blogs'] ?? []);
        $faqs = getFaqsByIds(@$content['faq']['faqs'] ?? []);
        $half = ceil(count($faqs) / 2);
        $testimonials = getTestimonialByIds(@$content['testimonial']['testimonials'] ?? []);
    @endphp
    @if ((int) $content['home']['status'])
        <section class="home-section" id="home">
            <div class="custom-container container">
                <div class="home-content">
                    <div class="row">
                        <div class="col-xl-6 col-xxl-5  col-lg-6">
                            <div class="card content-card">
                                <div class="card-body">
                                    <div class="content-wrapper">
                                        <a href="{{ @$content['home']['top_btn_url'] }}">{{ @$content['home']['top_btn_text'] }}</a>
                                        <h1>{{ @$content['home']['title'] }}</h1>
                                        <p>{{ @$content['home']['description'] }}</p>
                                        <div class="button-group">
                                            @forelse ($content['home']['button'] as $index => $button)
                                                @if ($index == 0)
                                                    <a class="btn btn-secondary" href="{{ $button['url'] ?? '#' }}"
                                                        target="_blank">
                                                        {{ $button['text'] }}
                                                    </a>
                                                @else
                                                    <a class="btn btn-primary" href="{{ $button['url'] ?? '#' }}"
                                                        target="_blank">
                                                        {{ $button['text'] }}
                                                    </a>
                                                @endif
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="social-content">
                                        <div class="content-wrapper">
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset(@$content['home']['info_image']) }}" alt=""
                                                            loading="lazy">
                                                    </a>
                                                </li>
                                            </ul>
                                            <h3>{{ @$content['home']['info_text'] }}</h3>
                                        </div>
                                        <p>{{ @$content['home']['info_description'] }}</p>
                                        <div class="store-group">
                                            @if (@$content['home']['playstore_url'])
                                                <a href="{{ @$content['home']['playstore_url'] }}">
                                                    <img src="{{ asset('front/images/store/1.png') }}" alt="">
                                                </a>
                                            @endif
                                            @if (@$content['home']['appstore_url'])
                                                <a href="{{ @$content['home']['appstore_url'] }}">
                                                    <img src="{{ asset('front/images/store/2.png') }}" alt="">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-xxl-7  col-lg-6 d-lg-block d-none">
                            {{-- <div class="col-xl-7 col-lg-6 order-lg-2"> --}}
                            <div class="card image-card">
                                <div class="card-body">
                                    <div class="image-wrapper">
                                        <img src="{{ asset(@$content['home']['right_phone_image']) }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Home Section End -->

    <!-- Statistics section start -->
    @if ((int) $content['statistics']['status'])
        <section class="counter-section overflow-hidden">
            <div class="row counters g-3">
                @forelse($content['statistics']['counters'] ?? [] as $index => $counter)
                    <div class="col-md-3 col-sm-6">
                        <div class="counter-wrapper">
                            <h3>
                                <span class="counter" data-target="{{ $counter['count'] }}">
                                    {{ $counter['count'] }}
                                </span>
                            </h3>
                            <p>{{ $counter['description'] }}</p>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </section>
    @endif
    <!-- Experience section end -->

    <!-- Best choice section start -->
    @if ($content['feature']['status'] == 1)
        <section class="best-choice-section-2" id="why_cab_booking">
            <div class="container">
                <div class="title">
                    <h2>{{ @$content['feature']['title'] }}</h2>
                    <div class="d-inline-block">
                        <p>
                            {{ @$content['feature']['description'] }}
                        </p>
                    </div>
                </div>
                <div class="wrapper">
                    <div class="cards-content">
                        @forelse ($content['feature']['images'] ?? [] as $index => $image)
                            <div class="card-wrapper">
                                @php
                                    $no = ++$index;
                                @endphp
                                <div class="card-content card-content-{{ $no }} one">
                                    <div class="best-choice-card card-{{ $no }}">
                                        <div class="best-choice-content">
                                            <h4>{{ @$image['title'] }}</h4>
                                            <p>{{ @$image['description'] }}</p>
                                        </div>
                                        @if (file_exists_public(@$image['image']))
                                            <div class="best-choice-image">
                                                <img class="img-fluid" alt="" src="{{ @asset($image['image']) }}"
                                                    loading="eager">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Best choice section end -->

    <!-- Rides screen section start -->
    @if ($content['ride']['status'] == 1)

        <section class="sass-team-section" id="how_it_works">
            <div class="container">
                <div class="title">
                    <h2>{{ @$content['ride']['title'] }}</h2>
                    <p>{{ @$content['ride']['description'] }}</p>
                </div>

                <div class="team-main-box">
                    <div class="steps-wrapper">
                        <div class="steps-content-wrapper">
                            <div class="bar"><span class="bar__fill"></span></div>
                            @forelse($content['ride']['step'] as $index => $step)
                                @if (($index + 1) & 1)
                                    <div class="row g-0" id="step-{{ $index + 1 }}">
                                        <ul class="col-md-6">
                                            <li class="step feature-text texts bg-color" id="">
                                                @if (file_exists_public($step['image']))
                                                    <img class="img-fluid" alt="screen-img"
                                                        src="{{ asset($step['image']) }}" loading="lazy">
                                                @endif
                                            </li>
                                        </ul>
                                        <ul class="col-md-6">
                                            <li class="step feature-text">
                                                <div class="section-title ">
                                                    <span
                                                        class="bg-color">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                                    <h2>{{ $step['title'] }}</h2>
                                                    <p>
                                                        {{ $step['description'] }}
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <div class="row g-0" id="step-2">
                                        <ul class="col-md-6 order-md-1 order-2">
                                            <li class="step feature-text">
                                                <div class="section-title title-left">
                                                    <span
                                                        class="bg-color">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                                    <h2>{{ $step['title'] }}</h2>
                                                    <p>
                                                        {{ $step['description'] }}
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="col-md-6 order-md-2 order-1">
                                            <li class="step feature-text texts bg-color" id="">
                                                @if (file_exists_public($step['image']))
                                                    <img class="img-fluid" alt="screen-img"
                                                        src="{{ asset($step['image']) }}" loading="lazy">
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Rides screen section end -->

    <!-- FAQ section start -->
    @if ($content['faq']['status'] == 1)
        <section class="faq-section section-b-space" id="faqs">
            <div class="faq-container">
                <div class="title">
                    <h2 class="wow fadeInDown">{{ $content['faq']['title'] }}</h2>
                    <div class="d-inline-block">
                        <p class="wow fadeInDown">{{ $content['faq']['sub_title'] }}</p>
                    </div>
                </div>
                <div class="row gy-lg-0 gy-3">
                    <div class="col-lg-12">
                        <div class="accordion faq-accordion">
                            @forelse($faqs as $index => $faq)
                                <div class="accordion-item wow fadeInUp">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                            data-bs-toggle="collapse" data-bs-target="#faq{{ $index + 1 }}">
                                            {{ $faq['title'] }}
                                        </button>
                                    </h2>
                                    <div id="faq{{ $index + 1 }}"
                                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}">
                                        <div class="accordion-body">
                                            <p>{{ $faq['description'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <h3 class="text-center">FAQ not found!</h3>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- FAQ section end -->

    <!-- Blog section start -->
    @if ($content['blog']['status'] == 1)
        <section class="blog-section section-b-space bg-section" id="blogs">
            <div class="container">
                <div class="title">
                    <h2 class="wow fadeInDown">{{ $content['blog']['title'] }}</h2>
                    <div class="d-inline-block">
                        <p class="wow fadeInDown">{{ $content['blog']['sub_title'] }}</p>
                    </div>
                    @if (count($blogs))
                        <a href="{{ route('web.blog.index') }}">{{ __('static.landing_pages.view_all') }} <i
                                class="ri-arrow-right-s-line"></i></a>
                    @endif
                </div>

                <div class="swiper blog-swiper pagination-box swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-74f620c8f3afa81d" aria-live="polite">
                        @forelse ($blogs as $index => $blog)
                            <div class="swiper-slide wow fadeInUp">
                                <div class="blog-box">
                                    <div class="blog-image">
                                        <a href="{{ route('blog.slug', @$blog['slug']) }}">
                                            <img class="img-fluid"
                                                src="{{ asset($blog['blog_thumbnail']['original_url'] ?? '') }}"
                                                alt="{{ @$blog['slug'] }}" loading="lazy">
                                        </a>
                                    </div>
                                    <div class="blog-content">
                                        <div class="blog-bottom">
                                            <h6>
                                                {{ $blog['created_at'] ? \Carbon\Carbon::parse($blog['created_at'])->format('d M, Y') : '' }}
                                            </h6>
                                        </div>
                                        <a href="{{ route('blog.slug', @$blog['slug']) }}">
                                            <h5>{{ $content['blog']['title'] }}</h5>
                                        </a>
                                        <p>{{ $content['blog']['sub_title'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-data-found">
                                <img class="img-fluid" src="{{ asset('front/images/blog_not_found.svg') }}"
                                    loading="lazy">
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Blog section end -->

    <!-- Comment section start -->
    @if ($content['testimonial']['status'] == 1)
        <section class="comment-section section-b-space wow fadeIn" id="testimonials">
            <div class="container">
                <div class="title">
                    <h2 class="wow fadeInDown">{{ @$content['testimonial']['title'] }}</h2>
                    <div class="d-inline-block">
                        <p class="wow fadeInDown">{{ @$content['testimonial']['sub_title'] }}</p>
                    </div>
                </div>

                <div class="swiper comment-slider pagination-box swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper wow fadeInUp">
                        @forelse ($testimonials as $index => $testimonial)
                            <div class="swiper-slide swiper-slide-next">
                                <div class="comment-box">
                                    <div class="top-comment">
                                        <img class="img-fluid" alt="{{ $testimonial?->title }}"
                                            src="{{ asset($testimonial?->profile_image?->asset_url ?? '') }}"
                                            loading="lazy">
                                        <h5>{{ $testimonial?->title }}</h5>
                                    </div>
                                    <p class="comment-contain">{{ $testimonial?->description }}</p>
                                    <div class="rating-box">
                                        <h6>
                                            <svg>
                                                <use xlink:href="{{ asset('front/images/star.svg#star') }}">
                                            </svg>
                                            ({{ number_format($testimonial?->rating, 1) }})
                                        </h6>

                                        <svg class="quotes-icon">
                                            <use xlink:href="{{ asset('front/images/quotes-right.svg#quotes-right') }}">
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-data-found">
                                <img class="img-fluid" src="{{ asset('front/images/testimonial_not_found.svg') }}"
                                    loading="lazy">
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <!-- WOW JS -->
    <script src="{{ asset('front/js/wow.js') }}"></script>
    <script src='https://unpkg.com/gsap@3/dist/gsap.min.js'></script>
    <script src='https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js'></script>
    <script>
        $(document).ready(function() {
            new WOW().init();

            $(window).on('load', function() {
                setTimeout(function() {
                    $('#fullScreenLoader').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 3500);
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const wrappers = document.querySelectorAll(".steps-content-wrapper");
            const progressFill = document.querySelector(".bar__fill");
            const bar = document.querySelector(".bar");

            if (!wrappers.length || !progressFill || !bar) return;

            wrappers.forEach(wrapper => {

                const rows = wrapper.querySelectorAll(".row");

                function updateBarFillSmooth() {
                    const rect = wrapper.getBoundingClientRect();
                    const windowHeight = window.innerHeight;

                    const totalScrollable = rect.height - windowHeight;
                    if (totalScrollable <= 0) return;

                    const scrollProgress = Math.min(
                        Math.max(-rect.top / totalScrollable, 0),
                        1
                    );

                    gsap.to(progressFill, {
                        height: scrollProgress * bar.offsetHeight + "px",
                        duration: 0.25,
                        ease: "power2.out"
                    });
                }

                function updateActiveStep() {
                    let activeRowIndex = 0;
                    const triggerLine = window.innerHeight * 0.55;

                    rows.forEach((row, index) => {
                        const rect = row.getBoundingClientRect();
                        if (rect.top <= triggerLine) {
                            activeRowIndex = index;
                        }
                    });

                    rows.forEach((row, index) => {
                        const features = row.querySelectorAll(".feature-text");
                        features.forEach(feature => {
                            feature.classList.toggle("active", index === activeRowIndex);
                        });
                    });
                }

                function onScroll() {
                    updateBarFillSmooth();
                    updateActiveStep();
                }

                window.addEventListener("scroll", onScroll);

                onScroll();
            });
        });
    </script>
@endpush
