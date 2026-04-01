@extends('cabbooking::front.account.master')
@section('title', __('cabbooking::front.my_wallet'))
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
    <div class="dashboard-details-box table-details-box">
        <div class="dashboard-title">
            <h3>{{ __('cabbooking::front.my_wallet') }}: <span
                    class="text-primary-color">${{ $wallet->balance ?? 0 }}</span>
            </h3>
            <a data-bs-toggle="modal" href="#addBalanceModal">+ {{ __('cabbooking::front.add_balance') }}</a>
        </div>

        <div class="table-responsive">
            <table class="table wallet-table">
                @if ($histories->count())
                    <thead>
                        <tr>
                            <th>{{ __('cabbooking::front.date') }}</th>
                            <th>{{ __('cabbooking::front.amount') }}</th>
                            <th>{{ __('cabbooking::front.remark') }}</th>
                            <th>{{ __('cabbooking::front.status') }}</th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @forelse ($histories as $history)
                        <tr>
                            <td>{{ $history->created_at->format('d M Y h:i A') }}</td>
                            <td>{{ getDefaultCurrency()->symbol }}{{ number_format($history->amount, 2) }}</td>
                            <td>{{ $history->detail }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($history->type) }}">
                                    <i class="ri-arrow-left-up-long-line"></i>
                                    <i class="ri-arrow-left-down-long-line"></i>
                                    {{ ucfirst($history->type) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="dashboard-no-data">
                                    <svg>
                                        <use xlink:href="{{ asset('images/dashboard/front/no-wallet.svg#noWallet') }}">
                                        </use>
                                    </svg>
                                    <h6>{{ __('cabbooking::front.no_wallet_history') }}</h6>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-main">
            <ul class="pagination-box">
                {{ $histories->links() }}
            </ul>
        </div>
    </div>

    <!-- Add Balance Modal -->
    <div class="modal fade theme-modal" id="addBalanceModal">
        <div class="modal-dialog modal-dialog-centered custom-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('cabbooking::front.add_money') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addBalanceForm" action="{{ route('front.cab.wallet.top-up') }}" method="POST">
                        @csrf
                        <div class="form-box">
                            <label for="payment_method"
                                class="form-label">{{ __('cabbooking::front.payment_method') }}</label>
                            <select class="form-select form-select-white select-2" id="payment_method" name="payment_method"
                                data-placeholder="{{ __('cabbooking::front.select_payment_gateway') }}">
                                <option value="" disabled selected>
                                    {{ __('cabbooking::front.select_payment_gateway') }}</option>
                                @foreach (getPaymentMethodList(false) as $payment)
                                    <option value="{{ $payment['slug'] }}">{{ $payment['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-box form-icon">
                            <label for="amount" class="form-label">{{ __('cabbooking::front.amount') }}</label>
                            <div class="position-relative">
                                <i class="ri-money-dollar-circle-line"></i>
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="{{ __('cabbooking::front.enter_amount') }}" min="1" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel-btn" data-bs-dismiss="modal">
                        {{ __('cabbooking::front.cancel') }}
                    </button>
                    <button type="submit" id="addMondayBtn" class="btn btn-primary">
                        {{ __('cabbooking::front.add_money') }}
                    </button>
                </div>
            </div>
        </div>
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
        (function($) {
            "use strict";
            $(document).ready(function() {
                $("#addBalanceForm").validate({
                    ignore: [],
                    rules: {
                        "amount": {
                            required: true,
                            min: 10,
                            max: 10000
                        },
                        "payment_method": "required"
                    },
                    messages: {
                        "amount": {
                            required: "Please enter an amount.",
                            min: "The minimum amount is 10.",
                            max: "The maximum amount is 10000."
                        },
                        "payment_method": "Please select a payment method."
                    }
                });

                $('#payment_method').on('change', function() {
                    $(this).valid();
                });

                $('#addMondayBtn').on('click', function() {
                    if ($("#addBalanceForm").valid()) {
                        $('#addBalanceForm').submit();
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
