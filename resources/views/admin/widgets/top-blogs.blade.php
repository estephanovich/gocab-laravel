@use('App\Models\Blog')
@use('App\Enums\RoleEnum')
@php
    $dateRange = getStartAndEndDate(request('sort'), request('start'), request('end'));
    $start_date = $dateRange['start'] ?? null;
    $end_date = $dateRange['end'] ?? null;
    $blogs = Blog::where('status', true)
        ->orderby('created_at')
        ->limit(2)
        ?->whereBetween('created_at', [$start_date, $end_date])
        ->get();
@endphp
@can('blog.index')
    {{-- Blog --}}
    <div class="col-xl-6">
        <div class="card recent-blog p-0">
            <div class="card-header">
                <h3>
                    {{ __('static.blogs.recent_blog') }}
                </h3>
                <a href="{{ route('admin.blog.index') }}"><span>{{ __('static.view_all') }}</span></a>
            </div>
            <div class="card-body">
                <div class="recent-blogs">
                    <ul>
                        @forelse ($blogs as $blog)
                            @php
                                $route = route('admin.blog.edit', [$blog->id]) . '?locale=' . app()->getLocale();
                            @endphp
                            <li>
                                <div class="blog-wrapper">
                                    @php
                                        $route =
                                            route('admin.blog.edit', [$blog->id]) . '?locale=' . app()->getLocale();
                                    @endphp
                                    <a href="{{ $route }}">
                                        <img src="{{ asset($blog?->blog_thumbnail?->asset_url ?? '') }}"
                                            alt="{{ $blog->title }}">
                                    </a>
                                    <div class="image-wrapper">
                                        <span class="date-aligns">
                                            {{ $blog->created_at->format('d M, Y') }}
                                        </span>
                                        <h4>

                                            {{ $blog->title }}
                                        </h4>
                                        <div class="read-aligns">
                                            <p>
                                                {{ $blog->description }}
                                                <span> <a
                                                        href="{{ route('blog.slug', @$blog['slug']) }}">{{ __('static.blogs.read_more') }}</a></span>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="table-no-data">
                                <img src = "{{ asset('images/dashboard/data-not-found.svg') }}" alt="data not found">
                                <h6 class="text-center">{{ __('static.widgets.no_data_available') }}</h6>
                            </div>
                        @endempty
                </ul>
            </div>
        </div>
    </div>
</div>
@endcan
