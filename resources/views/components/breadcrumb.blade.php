<!-- BEGIN PAGE HEADER -->
<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="d-flex flex-column">
                    <h2 class="page-title text-truncate mb-1">
                        {{ $title ?? 'Dashboard' }}
                    </h2>

                    <!-- Breadcrumb for mobile (simplified) -->
                    <div class="d-md-none">
                        <div class="text-muted text-truncate">
                            @if (count($breadcrumbs) > 1)
                                @if (end($breadcrumbs)['url'])
                                    <a href="{{ end($breadcrumbs)['url'] }}" class="text-reset">
                                        {{ end($breadcrumbs)['name'] }}
                                    </a>
                                @else
                                    {{ end($breadcrumbs)['name'] }}
                                @endif
                            @else
                                {{ $breadcrumbs[0]['name'] ?? 'Home' }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="d-flex align-items-center">
                    <!-- Desktop breadcrumb -->
                    <div class="d-none d-md-block">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-arrows" style="--tblr-breadcrumb-divider: '›';">
                                @foreach ($breadcrumbs as $index => $crumb)
                                    @if ($crumb['url'] && $index < count($breadcrumbs) - 1)
                                        <li class="breadcrumb-item">
                                            <a href="{{ $crumb['url'] }}" class="text-muted">
                                                @if ($index === 0)
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-home" width="16"
                                                        height="16" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                                    </svg>
                                                    <span class="ms-1">{{ $crumb['name'] }}</span>
                                                @else
                                                    {{ $crumb['name'] }}
                                                @endif
                                            </a>
                                        </li>
                                    @else
                                        <li class="breadcrumb-item active" aria-current="page">
                                            {{ $crumb['name'] }}
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                    </div>

                    @isset($actions)
                        <div class="ms-3">
                            {{ $actions }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE HEADER -->
