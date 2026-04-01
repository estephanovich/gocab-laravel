@use('App\Models\Page')
@use('App\Models\LandingPage')
@php
    $locale = Session::get('front-locale', getDefaultLangLocale());
    $landingPage = LandingPage::first()?->toArray($locale) ?? [];
    $content = $landingPage['content'] ?? [];
@endphp
@if (@$content['footer']['status'] == 1)
    <footer class="footer-section">
        <div class="top-footer">
            <div class="container">
                <div class="row justify-content-between gy-sm-0 gy-4">
                    <div class="col-lg-4 col-md-8 col-sm-7">
                        <div class="logo-box">
                            @if(file_exists_public(@$content['footer']['footer_logo']))
                            <a href="{{route('home')}}" class="footer-logo wow fadeInUp"
                                style="visibility: hidden; animation-name: none;">
                                <img class="img-fluid" alt="footer-logo" src="{{ asset(@$content['footer']['footer_logo']) }}">
                            </a>
                            @endif
                            <p class="wow fadeInUp" data-wow-delay="0.2s"
                                style="visibility: hidden; animation-delay: 0.2s; animation-name: none;">
                                {{ $content['footer']['description'] }}
                            </p>
                        </div>

                        <div class="social-links">
                            <h4>Contact with Us</h4>
                            <ul>
                                @if(!empty($content['footer']['social']['facebook']))
                                    <li>
                                        <a href="{{ $content['footer']['social']['facebook'] }}">
                                            <img src="{{asset('front/images/home/facebook.png')}}" alt="">
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($content['footer']['social']['google']))
                                    <li>

                                        <a href="{{ $content['footer']['social']['google'] }}">
                                            <img src="{{asset('front/images/home/google.png')}}" alt="">
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($content['footer']['social']['instagram']))
                                    <li>
                                        <a href="{{ $content['footer']['social']['instagram'] }}">
                                            <img src="{{asset('front/images/home/instagram.png')}}" alt="">
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($content['footer']['social']['linkedin']))
                                <li>
                                    <a href="{{ $content['footer']['social']['linkedin'] }}">
                                        <img src="{{asset('front/images/home/linkdin.png')}}" alt="">
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-4">
                        @isset($content['footer']['pages'])
                            @php
                                $pages = Page::whereIn('id', $content['footer']['pages'] )?->paginate(5);
                            @endphp
                            <div class="footer-content wow fadeInUp" data-wow-delay="0.8s"
                                style="visibility: hidden; animation-delay: 0.8s; animation-name: none;">
                                <div class="footer-title">
                                    <h4>Pages</h4>
                                </div>
                                <ul class="content-list">
                                    @foreach ($pages as $page)
                                    <li>
                                        <a href="{{ route('page.slug', $page->slug) }}">{{ $page->title }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endisset
                    </div>
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="footer-image">
                            <div class="footer-form wow fadeInUp" data-wow-delay="0.3s"
                                style="visibility: hidden; animation-delay: 0.3s; animation-name: none;">
                                <form method="POST" action="{{ route('newsletter') }}">
                                    @csrf

                                        <label for="email" class="form-label">{{ $content['footer']['newsletter']['label'] }}</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="{{ $content['footer']['newsletter']['placeholder'] }}" required>
                                        <button type="submit" class="btn btn-secondary">
                                            {{ $content['footer']['newsletter']['button_text'] }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="store-list">
                                <ul>
                                    @if($content['footer']['play_store_url'])
                                        <li class="wow fadeInUp" data-wow-delay="0.5s"
                                            style="visibility: hidden; animation-delay: 0.5s; animation-name: none;">
                                            <a href="{{ $content['footer']['play_store_url'] }}" target="_blank">
                                                <img class="img-fluid" alt="store-1" src="{{ asset('front/images/store/1.svg') }}">
                                            </a>
                                        </li>
                                    @endif
                                    @if($content['footer']['app_store_url'])
                                        <li class="wow fadeInUp" data-wow-delay="0.6s"
                                            style="visibility: hidden; animation-delay: 0.6s; animation-name: none;">
                                            <a href="{{ $content['footer']['app_store_url'] }}" target="_blank">
                                                <img class="img-fluid" alt="store-2" src="{{ asset('front/images/store/2.svg') }}">
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                {{-- <p>*Download our App for better Experience</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sub-footer">
            <div class="container">
                <div class="row gy-md-0 gy-3">
                    <div class="col-md-12">
                        <h6>{{ $content['footer']['copyright'] ?? '© Your Company' }} {{ date('Y') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif
<!-- Footer end -->
