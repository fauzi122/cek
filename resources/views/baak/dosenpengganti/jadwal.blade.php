@extends('layouts.dosen.main')
@section('content')
<style>
  .hide {
    display: none;
  }
</style>
<div class="flash-tambah" data-flashdata="{{ session('status') }}"></div>
<div class="flash-error" data-flasherror="{{ session('error') }}"></div>

<div class="content-wrapper">
  <div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <div class="col-sm-5 col-md-5">
            </div>
          </div>
        </div>
        <div class="btn-group">
        </div>
        <div class="card-body">
          <div class="custom-btn-group">
            <!-- Buttons -->
            <div class="table-responsive">
              <table id="myTable2" class="table custom-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nip</th>
                    <th>Kd Dosen</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Matkul</th>
                    <th>Jam</th>
                    <th>Ruang</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  @endsection

  @push('scripts')
  <script type="text/javascript">
    $('.tombol-hapus').on('click', function(e) {
      e.preventDefault();
      const href = $(this).attr('href');
      Swal.fire({
        title: 'Apakah anda yakin',
        text: "Data akan dihapus",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Data!'
      }).then((result) => {
        if (result.value) {
          document.location.href = href;

        }
      })
    });
    $(document).ready(function() {
      $('#myTable2').DataTable({
        processing: true,
        serverSide: false,
        ajax: '{!! route("jadwal.index") !!}',
        dom: 'Blfrtip',
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true,
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
          },
          {
            data: 'nip',
            name: 'nip'
          },
          {
            data: 'kd_dosen',
            name: 'kd_dosen'
          },
          {
            data: 'kelas',
            name: 'kelas'
          },
          {
            data: 'hari_t',
            name: 'hari_t'
          },
          {
            data: 'nm_mtk',
            name: 'nm_mtk'
          },
          {
            data: 'jam_t',
            name: 'jam_t'
          },
          {
            data: 'no_ruang',
            name: 'no_ruang'
          },
        ]
      });

    });
  </script>
  @endpush