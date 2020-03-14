  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Siap untuk keluar aplikasi?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Klik tombol "Logout" Jika Anda ingin keluar dari aplikasi.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{base_url('logout')}}">Logout</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Anotasi Modal-->
  <div class="modal fade" id="anotasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background:#3A60D0;">
          <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Anotasi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:#fff;">×</span>
          </button>
        </div>
        <div class="modal-body" id="modalAyat">Klik tombol "Logout" Jika Anda ingin keluar dari aplikasi.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
          <a class="btn btn-primary" href="#"><i class="fa fa-save"></i> Simpan</a>
        </div>
      </div>
    </div>
  </div>

  
  <!-- Bootstrap core JavaScript-->
  <script src="{{ assets_url("") }}vendor/jquery/jquery.min.js"></script>
  <script src="{{ assets_url("") }}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <!-- Core plugin JavaScript-->
  <script src="{{ assets_url("") }}vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="{{ assets_url("") }}vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ assets_url("") }}js/sb-admin-2.min.js"></script>
  <script src="{{ assets_url("") }}js/penomoranSurat.js"></script>
  <script src="{{ assets_url("") }}js/app.js"></script>
  <script src="{{ assets_url("") }}js/personel.js"></script>
  <script src="{{ assets_url("") }}js/rapat.js"></script>
  <script src="{{ assets_url("") }}js/sprint.js"></script>
  <script src="{{ assets_url("") }}js/pdf_viewer/EZView.js"></script>
  <script src="{{ assets_url("") }}js/pdf_viewer/draggable.js"></script>
  <!-- Custom scripts for all pages-->
  
  
  
  <!-- ADD REMOVE INPUT FIELD JQUERY -->
  {{-- <script src="{{ assets_url("") }}js/toast/jquery.min.js"></script> --}}

  
  <!-- Page level plugins -->
  <script src="{{ assets_url("") }}vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ assets_url("") }}vendor/datatables/dataTables.bootstrap4.min.js"></script>
  
  <!-- Page level custom scripts -->
  <script src="{{ assets_url("") }}js/demo/datatables-demo.js"></script>
  
  <!-- custom sweetalert -->
  <script src="{{ assets_url("") }}js/alert/sweetalert-dev.js"></script>
  <script src="{{ assets_url("") }}js/alert/alert.js"></script>

  <script src="{{ assets_url("") }}js/selectsearch/bootstrap-select.js"></script>   
  <script src="{{ assets_url("") }}js/toast/bootstrap.min.js"></script>