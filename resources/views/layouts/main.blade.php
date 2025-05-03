@include('layouts.main.styles')

<body id="page-top">

    <div id="wrapper">
        <!-- Sidebar -->
        @include('layouts.main.sidebar')
    
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
    

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
               @include('layouts.main.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content') 
                </div>
                
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   
    

@include('layouts.main.scripts')