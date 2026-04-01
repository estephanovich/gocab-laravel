@extends('front.layouts.master')
@section('title', __('cabbooking::front.login'))
@push('css')
    <!-- aos css -->
    <link rel="preload" as="style" href="{{ asset('front/css/aos.css') }}" onload="this.onload=null;this.rel='stylesheet'">

    <!-- wow animate css link -->
    <link rel="stylesheet" href="{{ asset('front/css/vendors/wow.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/vendors/wow-animate.css') }}" media="print"
        onload="this.media='all'">
    <link rel="stylesheet" href="https://public.codepenassets.com/css/normalize-5.0.0.min.css">
    {{-- <link rel='stylesheet' href='https://codepen.io/GreenSock/pen/xxmzBrw.css'> --}}
@endpush
@section('content')
    <section class="authentication-section section-b-space">
        <div class="container">
            @php
                $cabSettings = getSettings();
            @endphp
            <div class="auth-form-box">
                <img src="{{ asset('images/authentication-img2.png') }}" class="img-fluid auth-image">
                <div class="row align-items-center">

                    <div class="col-xl-5 col-lg-6 mx-auto">
                        <div class="auth-right-box">
                            <h3>{{ __('cabbooking::front.welcome_to', ['app_name' => env('APP_NAME')]) }}</h3>
                            <h6>{{ __('cabbooking::front.account_information') }}</h6>
                            <form method="POST" id="loginForm">
                                @csrf
                                <div class="form-box">
                                    <div class="number-mail-box">
                                        <div class="country-code-section" style="display: block;">
                                            <select class="select-2 form-control" id="select-country-code"
                                                name="country_code">
                                                @foreach (getCountryCodes() as $option)
                                                    <option class="option" value="{{ $option->calling_code }}"
                                                        data-image="{{ asset('images/flags/' . $option->flag) }}"
                                                        @selected($option->calling_code == old('country_code', rideCountryCode() ?? 1))>
                                                        {{ $option->calling_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" class="form-control" name="email_or_phone" id="email_or_phone"
                                            placeholder="{{ __('cabbooking::front.enter_phone_email') }}"
                                            value="{{ old('email_or_phone') }}">
                                        @error('email_or_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary otp-btn"
                                    id="get-otp-btn">{{ __('cabbooking::front.get_otp') }}</button>
                            </form>

                            <div class="or-box">
                                <span>{{ __('cabbooking::front.login_with') }}</span>
                            </div>
                            @isset($cabSettings['activation']['default_credentials'])
                                @if ((int) $cabSettings['activation']['default_credentials'])
                                    <div class="demo-credential">
                                        <button class="btn btn-outline default-credentials guest-btn"
                                            data-email="rider@example.com">
                                            <span>
                                                <i class="ri-user-3-fill"></i>
                                            </span>
                                            {{ __('cabbooking::front.demo_user') }}</button>
                                    </div>
                                @endif
                            @endisset
                            <h6 class="new-account">{{ __('cabbooking::front.don’t_have_account') }}
                                <a
                                    href="{{ route('front.cab.register.index') }}">{{ __('cabbooking::front.sign_up') }}</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <!-- WOW JS -->
    <script src="{{ asset('front/js/wow.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                new WOW().init();
                $("#changePasswordForm").validate({
                    ignore: [],
                    rules: {
                        "current_password": "required",
                        "new_password": {
                            required: true,
                            minlength: 8
                        },
                        "confirm_password": {
                            required: true,
                            equalTo: "#new_password"
                        },
                    },
                });

                $("#updateProfileForm").validate({
                    ignore: [],
                    rules: {
                        "name": "required",
                        "email": "required",
                        "phone": "required"
                    },
                });
            });
        })(jQuery);
    </script>
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {

                let isNumb = false;

                // Detect if email or phone number is entered
                $('#email_or_phone').on('input', function() {
                    const value = $(this).val();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Email format
                    const alphaRegex = /[a-zA-Z]/; // Any alphabetic character

                    if (emailRegex.test(value) || alphaRegex.test(value)) {
                        $('.country-code-section').hide();
                        $('.col-sm-9').addClass('col-sm-12-full');
                        isNumb = false;
                    } else {
                        $('.country-code-section').show();
                        $('.col-sm-9').removeClass('col-sm-12-full');
                        isNumb = true;
                    }

                    // Update validation rules dynamically
                    $('#email_or_phone').rules('remove', 'minlength maxlength');
                    if (isNumb) {
                        $('#email_or_phone').rules('add', {
                            minlength: 6,
                            maxlength: 15
                        });
                    }
                });

                $('#loginForm').validate({
                    rules: {
                        email_or_phone: {
                            required: true
                        }
                    },
                    messages: {
                        email_or_phone: {
                            required: "Please enter your email or phone number.",
                            minlength: "Phone number must be at least 6 digits.",
                            maxlength: "Phone number cannot exceed 15 digits."
                        }
                    }
                });

                $('#get-otp-btn').click(function() {
                    if (!$('#loginForm').valid()) return;

                    const emailOrPhone = $('#email_or_phone').val();
                    const countryCode = $('#select-country-code').val();
                    const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailOrPhone);

                    $.ajax({
                        url: "{{ route('front.cab.login_with_credential') }}",
                        method: 'POST',
                        data: {
                            email_or_phone: emailOrPhone,
                            country_code: isEmail ? null : countryCode,
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            $('#get-otp-btn').prop('disabled', true).html(
                                '{{ __('cabbooking::front.get_otp') }} <span class="spinner-border spinner-border-sm ms-2 spinner_loader"></span>'
                                );
                        },
                        complete: function() {
                            $('#get-otp-btn').prop('disabled', false).text(
                                '{{ __('cabbooking::front.get_otp') }}');
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href =
                                    "{{ route('front.cab.verify_otp') }}";
                            } else {
                                toastr.error(response.message ||
                                    "{{ __('cabbooking::front.failed_resent_otp') }}");
                            }
                        },
                        error: function(xhr) {
                            let message =
                            "{{ __('cabbooking::front.failed_resent_otp') }}";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                message = Object.values(xhr.responseJSON.errors).join('\n');
                            }
                            toastr.error(message);
                        }
                    });
                });

                $(".default-credentials").click(function() {
                    $("#email_or_phone").val("");
                    var email = $(this).data("email");
                    $("#email_or_phone").val(email);
                    $('.country-code-section').hide();
                    $('.col-sm-9').addClass('col-sm-12-full');
                });
            });
        })(jQuery);
    </script>
    <script>
        $(document).ready(function() {
            $('#select-country-code').select2({
                templateResult: function(data) {
                    if (!data.id) return data.text;

                    const imageUrl = $(data.element).data('image');
                    const $result = $(`
                            <span>
                                <img src="${imageUrl}" class="flag-img" onerror="this.onerror=null;this.src='{{ asset('front/images/placeholder/49x37.png') }}';" />
                                + ${data.text.trim()}
                            </span>
                        `);
                    return $result;
                },
                templateSelection: function(data) {
                    if (!data.id) return data.text;

                    const imageUrl = $(data.element).data('image');
                    const $result = $(`
                            <span>
                                <img src="${imageUrl}" class="flag-img" onerror="this.onerror=null;this.src='{{ asset('front/images/placeholder/49x37.png') }}';" />
                                + ${data.text.trim()}
                            </span>
                        `);
                    return $result;
                },
                escapeMarkup: function(m) {
                    return m;
                }
            });
        });
    </script>
@endpush
