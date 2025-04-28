<!-- BEGIN PAGE HEADER -->
<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ $title ?? 'Dashboard' }}</h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">
                    <ol class="breadcrumb breadcrumb-arrows">
                        @foreach ($breadcrumbs as $crumb)
                            @if ($crumb['url'])
                                <li class="breadcrumb-item">
                                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item active">{{ $crumb['name'] }}</li>
                            @endif
                        @endforeach
                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE HEADER -->
