@use('Modules\Ticket\Models\Ticket')
@use('App\Enums\RoleEnum')
@php
    $dateRange = getStartAndEndDate(request('sort'), request('start'), request('end'));
    $start_date = $dateRange['start'] ?? null;
    $end_date = $dateRange['end'] ?? null;
    $roleName = getCurrentRoleName();
@endphp

@if($roleName == RoleEnum::ADMIN)
@php
    $tickets = Ticket::orderby('created_at')
        ?->limit(3)?->whereBetween('created_at', [$start_date, $end_date])?->get();
@endphp
@else
@php
    $tickets = Ticket::orderby('created_at')
        ?->where('user_id', getCurrentUserId())
        ?->limit(3)?->whereBetween('created_at', [$start_date, $end_date])
        ?->get();
@endphp
@endif


@can('ticket.ticket.index')
    {{-- Recent Tickets --}}
    <div class="col-xl-6">
        <div class="card top-drivers-card p-0">
            <div class="card-header">
                <h3>{{ __('ticket::static.widget.recent_tickets') }}</h3>
                <a href="{{ route('admin.ticket.index') }}">{{ __('ticket::static.widget.view_all_tickets') }}</a>
            </div>
            <div class="recent-rides-card pending-ticket custom-scrollbar">
                @if (count($tickets))
                    <table class="recent-rides-table">
                        <thead>
                            <tr>
                                <th>{{ __('ticket::static.widget.ticket_number') }}</th>
                                <th>{{ __('ticket::static.widget.created_by') }}</th>
                                <th>{{ __('ticket::static.widget.created_at') }}</th>
                                <th>{{ __('ticket::static.widget.priority') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td><span class="id-wrapper">#{{ $ticket->ticket_number ?? 'N/A' }}</span></td>
                                    <td>
                                        <div class="driver-info">
                                            @if ($ticket?->user)
                                                @if ($ticket?->user?->profile_image?->original_url)
                                                    <img src="{{ asset('images/dashboard/4.png') }}" alt="">
                                                @else
                                                    <div class="user-initials">
                                                        {{ strtoupper(substr($ticket?->user?->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4>{{ $ticket->user?->name }}</h4>
                                                    <span>{{ isDemoModeEnabled() ? __('ticket::static.demo_mode') : $ticket->user->email }}</span>
                                                </div>
                                            @else
                                                <div class="user-initials">
                                                    {{ strtoupper(substr($ticket?->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h4>{{ $ticket->name }}</h4>
                                                    <span>{{ isDemoModeEnabled() ? __('ticket::static.demo_mode') : $ticket->email }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $ticket?->created_at?->format('Y-m-d, h:i A') }}</td>
                                    <td>{{ $ticket?->priority?->name }}</td>
                                </tr>
                            @empty

                            @endempty
                        </tbody>
                    </table>
                @else
                <div class="table-no-data">
                    <img src="{{ asset('images/dashboard/data-not-found.svg') }}" class="img-fluid" alt="data not found">
                    <h6 class="text-center">{{ __('ticket::static.widget.no_data_available') }}</h6>
                </div>
                @endif
            </div>
        </div>
    </div>
@endcan
