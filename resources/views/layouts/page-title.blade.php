<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0" style="text-transform: capitalize">@yield('page')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                    {{-- <li class="breadcrumb-item">@yield('page')</li> --}}
                    <li class="breadcrumb-item active">@yield('page-inner')</li>
                </ol>
            </div>

        </div>
    </div>
</div>    
