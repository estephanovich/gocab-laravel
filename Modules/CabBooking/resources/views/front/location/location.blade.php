@extends('cabbooking::front.account.master')
@section('title', __('cabbooking::front.location'))
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
@section('detailBox')
<div class="dashboard-details-box">
    <div class="dashboard-title">
        <h3>{{ __('cabbooking::front.save_address') }}</h3>
        <a href="{{ route('front.cab.location.create') }}" class="btn p-0">{{ __('cabbooking::front.add_address') }}</a>
    </div>

    <ul class="address-list">
        @forelse($locations as $location)
            <li class="address-box">
                <div class="address-top">
                    <span class="badge badge-primary">{{ $location->type }}</span>
                    <div class="edit-delete">
                        <a href="{{ route('front.cab.location.edit', $location->id) }}" class="btn edit">
                            <i class="ri-edit-line"></i>
                        </a>
                        <button type="button" class="btn delete" data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $location->id }}">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
                <div class="address-bottom">
                    {{-- <p>{{ __('cabbooking::front.address') }}: <span>{{ $location->location }}</span></p> --}}
                    <p><i class="ri-map-pin-line"></i><span>{{ $location->location }}</span></p>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal theme-modal fade confirmation-modal" id="confirmationModal{{ $location->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationLabel{{ $location->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-start confirmation-data">
                                <div class="main-img">
                                    <div class="delete-icon">
                                        <i class="ri-question-mark"></i>
                                    </div>
                                </div>
                                <h4 class="modal-title">{{ __('cabbooking::static.chats.confirmation') }}</h4>
                                <p>{{ __('cabbooking::front.modal') }}</p>
                            </div>

                            <div class="modal-footer">
                                <form action="{{ route('front.cab.location.destroy', $location->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn cancel-btn" data-bs-dismiss="modal">{{ __('cabbooking::front.no') }}</button>
                                    <button type="submit" class="btn btn-primary spinner-btn">{{ __('cabbooking::front.yes') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
        <tr>
            <td colspan="8">
                <div class="dashboard-no-data">
                    <svg>
                        <use xlink:href="{{ asset('images/dashboard/front/location.svg#location') }}"></use>
                    </svg>
                    <h6>{{ __('cabbooking::front.no_locations') }}</h6>
                </div>
            </td>
        </tr>
        @endforelse
    </ul>
</div>
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
@endpush