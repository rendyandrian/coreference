<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{base_url()}}">
    <div class="sidebar-brand-icon ">
        <i class="fas fa-clipboard-list"></i>
    </div>
    <div class="sidebar-brand-text mx-3">eMeeting</div>
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
        <a class="collapse-item" href="{{base_url('jenisSurat')}}">Jenis Surat</a>
        <a class="collapse-item" href="{{base_url('ruangRapat')}}">Ruang Rapat</a>

        </div>
    </div>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
    Jadwal Rapat Terpadu
    </div>

    <!-- Nav Item - Nomor Surat Collapse Menu -->
    <li class="nav-item ">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNomorSurat" aria-expanded="true" aria-controls="collapseNomorSurat">
        <i class="fas fa-fw fa-list-ol"></i>
        <span>Nomor Surat</span>
    </a>
    <div id="collapseNomorSurat" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Penomoran Surat</h6>
        <a class="collapse-item" href="{{base_url('penomoranSurat/add')}}">Request</a>
        <a class="collapse-item" href="{{base_url('penomoranSurat')}}">List Surat</a>
        </div>
    </div>
    </li>
	
	<!-- Nav Item - Sprint Collapse Menu -->
    <li class="nav-item ">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSprint" aria-expanded="true" aria-controls="collapseSprint">
        <i class="fas fa-fw fa-running"></i>
        <span>Sprint</span>
    </a>
    <div id="collapseSprint" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Sprint</h6>
        <a class="collapse-item" href="{{base_url('sprint/add')}}">Request</a>
        <a class="collapse-item" href="{{base_url('sprint?status=belum_set_waktu')}}">Belum Set Waktu</a>
        <a class="collapse-item" href="{{base_url('sprint?status=double_sprint')}}">Double Sprint</a>
        <a class="collapse-item" href="{{base_url('sprint?status=list_sprint')}}">List Sprint</a>
        </div>
    </div>
    </li>
	
	<!-- Nav Item - Jadwal Rapat Collapse Menu -->
    <li class="nav-item ">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJadwalRapat" aria-expanded="true" aria-controls="collapseJadwalRapat">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span>Jadwal Rapat</span>
    </a>
    <div id="collapseJadwalRapat" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Jadwal Rapat</h6>
        <a class="collapse-item" href="{{base_url().'jadwalRapat/add'}}">Request</a>
        <a class="collapse-item" href="{{base_url().'jadwalRapat'}}">List Jadwal Rapat</a>
        </div>
    </div>
    </li>
	
	<!-- Nav Item - Inbox -->
    <li class="nav-item">
    <a class="nav-link" href="{{base_url('inbox')}}">
        <i class="fas fa-fw fa-envelope"></i>
        <span>Inbox</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>