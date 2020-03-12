<!DOCTYPE html>
<html lang="en">
    <head>
        <title>eMeeting (Jadwal Rapat Terpadu)</title>
        @include('layouts.head')
    </head>
    <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts.side')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            @include('layouts.header')
            <!-- Begin Page Content -->
            <div class="container-fluid">
            @yield('content')
            </div>
        </div>
        <!-- End of Main Content -->
        <footer class="sticky-footer bg-white">
        @include('layouts.footer')
        </footer>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    @include('layouts.foot')
    </body>
</html>