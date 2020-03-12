<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{base_url()}}">
    <div class="sidebar-brand-icon ">
        <i class="fas fa-clipboard-list"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Anotasi</div>
    </a>
    

    @if($isSuperadmin)
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
    Master
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Master Data</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Master Data</h6>
        <a class="collapse-item" href="{{base_url('user')}}">Users</a>
        <a class="collapse-item" href="{{base_url('group')}}">Group</a>
        {{-- <a class="collapse-item" href="{{base_url('jenisSurat')}}">Jenis Surat</a>
        <a class="collapse-item" href="{{base_url('ruangRapat')}}">Ruang Rapat</a> --}}

        </div>
    </div>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
    Coreference Resolution
    </div>

	
	<!-- Nav Item - Inbox -->
    <li class="nav-item">
    <a class="nav-link" href="{{base_url('inbox')}}">
        <i class="fas fa-fw fa-envelope"></i>
        <span>Anotasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>