@extends('cabbooking::front.account.master')
@section('title', __('cabbooking::front.notifications'))
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
            <h3>{{ __('cabbooking::front.notification') }}</h3>
            <form action="{{ route('front.cab.notifications.markAsRead') }}" method="POST" style="display: inline;">
                @csrf
                <a class="btn p-0">
                    <i class="ri-check-double-line"></i>
                    {{ __('cabbooking::front.mark_as_all_read') }}
                </a>
            </form>
        </div>
        <ul class="notification-list">
            @php
                $notifications = auth()->user()->notifications()->paginate(10);
            @endphp
            @forelse ($notifications as $notification)
                <li class="@if (!$notification->read_at) unread @endif">
                    <i class="ri-time-line"></i>
                    <div class="notification-content">
                        <p>{{ $notification->data['message'] }}
                            <span>{{ $notification->created_at->format('Y-m-d h:i:s A') }}</span>
                        </p>
                    </div>
                </li>
            @empty
                <div class="dashboard-no-data">
                    <svg>
                        <use xlink:href="{{ asset('images/dashboard/front/notification.svg#notification') }}"></use>
                    </svg>
                    <h6>{{ __('cabbooking::front.notifications_not_found') }}</h6>
                </div>
            @endforelse
        </ul>
        @if ($notifications->count())
            @if ($notifications->lastPage() > 1)
                <div class="pagination-main">
                    <ul class="pagination-box">
                        {!! $notifications->links() !!}
                    </ul>
                </div>
            @endif
        @endif
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
    <script>
        $(document).ready(function() {
            "use strict";

            setTimeout(markAllRead, 5000);

            $('#mark-all-read').on('click', markAllRead);

            function markAllRead() {
                $.ajax({
                    url: "{{ route('front.cab.notifications.markAsRead') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.notification-list li.unread').removeClass('unread');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    </script>
@endpush
