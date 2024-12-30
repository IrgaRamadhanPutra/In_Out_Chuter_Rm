{{-- <ul class="sidebar-nav" id="sidebar-nav" style="background: rgb(255, 187, 42);"> --}}
<!-- Sidebar Navigation -->
<ul class="sidebar-nav bg-body-tertiary mt-2" id="sidebar-nav">

    <!-- Chutter Option -->
    <ul class="sidebar-nav bg-body-tertiary mt-4 " id="sidebar-nav">
        <li class="nav-item mt-4 {{ Request::is('indexinchutter') ? 'active' : '' }}">
            <a class="nav-link collapsed " href="{{ route('scaninchutter') }}">
                <i class="bi bi-arrow-right-square-fill"></i>
                <span>Scan In Chutter</span>
            </a>
        </li><!-- End Login Page Nav -->
        <li class="nav-item mt-4 {{ Request::is('indexoutchutter') ? 'active' : '' }}">
            <a class="nav-link collapsed " href="{{ route('scanoutchutter') }}">
                <i class="bi bi-arrow-left-square-fill"></i>

                <span>Scan Out Chutter</span>
            </a>
        </li><!-- End Login Page Nav -->

        <li class="nav-item mt-4 {{ Request::is('index_search_address') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{{ route('index') }}">
                <i class="bi bi-search"></i>
                <span>Search Data</span>
            </a>
        </li>
        <li class="nav-item mt-4 {{ Request::is('index_bpb') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="{{ route('index_bpb') }}">
                <i class="bx bxs-file-pdf"></i>
                <span>Bpb Generate</span>
            </a>
        </li>


    </ul>

</ul>
