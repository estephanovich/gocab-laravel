<!-- Header section start -->
@use('App\Models\Language')
@use('App\Models\LandingPage')
@php
    $locale = Session::get('front-locale', getDefaultLangLocale());
    $landingPage = LandingPage::first()?->toArray($locale) ?? [];
    $content = $landingPage['content'] ?? [];
    $flag = Language::where('locale', Session::get('front-locale', getDefaultLangLocale()))->pluck('flag')->first();
    $menuLabel = [
        'home' => __('static.landing_pages.homes'),
        'why_cab_booking' => __('static.landing_pages.why_cabbooking'),
        'how_it_works' => __('static.landing_pages.how_it_works'),
        'faqs' => __('static.landing_pages.faq'),
        'blogs' => __('static.landing_pages.blog'),
        'testimonials' => __('static.landing_pages.testimonial'),
        'raise_ticket' => __('static.landing_pages.raise_ticket'),
    ];
@endphp
@if (@$content['header']['status'] == 1)
    <header class="wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
        <div class="custom-container">
            <div class="top-header">
                <div class="header-wrapper">
                    <div class="header-left">
                        <button class="navbar-toggler btn">
                            <i class="ri-menu-line"></i>
                        </button>
                        <a href="{{ route('home') }}" class="logo-box">
                            @if (file_exists_public(@$content['header']['logo']))
                            <img class="img-fluid light-logo" alt="Logo" src="{{ asset(@$content['header']['light_logo'] ?? '') }}" loading="lazy">
                            <img class="img-fluid dark-logo" alt="Logo" src="{{ asset(@$content['header']['dark_logo'] ?? '') }}" loading="lazy">
                            @endif
                        </a>
                    </div>
                    <div class="header-middle">
                        <div class="menu-title">
                            <h3>Menu</h3>
                            <a href="#!" class="close-menu"><i class="ri-close-line"></i></a>
                        </div>
                        <ul class="navbar-nav">
                            @forelse ($content['header']['menus'] ?? [] as $menu)
                            <li class="nav-item">
                                 @if ($menu === 'raise_ticket')
                                    <a class="nav-link" href="{{ route('ticket.form') }}">{{ $menuLabel[$menu] ?? 'N/A' }}</a>
                                 @else
                                    @if (Route::is('home'))
                                        @if($menu != 'home')
                                            <a class="nav-link" href="#{{ $menu }}">{{ $menuLabel[$menu] ?? 'N/A' }}</a>
                                        @endif
                                    @else
                                        <a class="nav-link" href="{{ route('home') }}#{{ $menu }}">{{ $menuLabel[$menu] ?? 'N/A' }}</a>
                                    @endif
                                 @endif
                            </li>
                            @empty

                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="header-right">
                    <div class="dropdown language-dropdown">
                        @php
                            $currentLocale = Session::get('locale', app()->getLocale());
                            $currentLang = getLanguageByLocale($currentLocale);
                        @endphp

                        <button class="btn language-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-fluid" loading="lazy" alt="flag-image"
                                src="{{ $currentLang?->flag ?? asset('images/flags/default.png') }}">
                            <span>{{ strtoupper($currentLang?->locale ?? 'EN') }}</span>
                        </button>

                        <ul class="dropdown-menu">
                            @forelse (getLanguages() as $lang)
                                <li>
                                    <a class="dropdown-item @if ($lang->locale === $currentLocale) active @endif"
                                        href="{{ route('lang', $lang->locale) }}" data-lng="{{ $lang->locale }}">
                                        <img class="img-fluid" loading="lazy" alt="flag-image"
                                            src="{{ $lang->flag ?? asset('images/flags/default.png') }}">
                                        <span>({{ strtoupper($lang->locale) }})</span>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <a class="dropdown-item" href="{{ route('lang', 'en') }}" data-lng="en">
                                        <img class="img-fluid" src="{{ asset('images/flags/US.png') }}" loading="lazy">
                                        <span>{{ __('static.english') }}</span>
                                    </a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="dark-mode-aligns">
    <button class="btn dark-light-mode" id="light-mode" aria-label="Switch to light mode" aria-pressed="false">
        <i class="ri-sun-line"></i>
    </button>
    <button class="btn dark-light-mode" id="dark-mode" aria-label="Switch to dark mode" aria-pressed="false">
        <i class="ri-moon-line"></i>
    </button>
</div>
                    <a href="{{ auth()->check() ? route('front.cab.ride.create') : route('front.cab.login.index') }}"
                        class="btn btn-primary ticket-btn">
                        <i class="ri-coupon-2-line d-sm-none"></i>
                        <span class="d-sm-block d-none">{{ @$content['header']['btn_text'] }}</span>
                    </a>
                </div>
            </div>
            <a href="#!" class="overlay" aria-label="Read more about this article"></a>
        </div>
    </header>
@endif
<!-- Header section end -->
