<!DOCTYPE html>
<html lang="en">


@include('admin.partials.top')

<body class="g-sidenav-show   bg-gray-100">
<div class="min-height-300 bg-primary position-absolute w-100"></div>
@include('admin.partials.sidebar')
<main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    @include('admin.partials.header')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        @yield('content')
        @include('admin.partials.footer')
    </div>
</main>

@include('admin.partials.bottom')
</body>

</html>
