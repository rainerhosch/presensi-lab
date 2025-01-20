<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Siswa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active">Siswa</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->

<section class="content">

    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <?php if (!empty($_SESSION['notif'])) { ?>
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-info"></i> <?= $_SESSION['notif']; ?></h5>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Filter</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="filter_kelas" name="filter_kelas">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Jurusan</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="filter_jurusan" name="filter_jurusan">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fa fa-plus"></i> Tambah Data Siswa
                        </button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="">Nama</th>
                                    <th width="10%">Kelas</th>
                                    <th width="10%">Jurusan</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($siswa as $key => $val) { ?>

                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $val['nisn'] . ' - ' . $val['nama']; ?></td>
                                        <td><?= $val['kelas']; ?></td>
                                        <td><?= $val['jurusan']; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-xs exampleModalCenterEdit" data-id="<?= $val['nisn']; ?>" data-nama="<?= $val['nama']; ?>" data-toggle="modal">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="">Nama</th>
                                    <th width="10%">Kelas</th>
                                    <th width="10%">Jurusan</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url(); ?>/action-simpan-siswa">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="col-form-label">NISN</label>
                            <input type="text" class="form-control" name="nisn" id="nisn" required>
                        </div>
                        <div class="form-group">
                            <label for="siswa-name" class="col-form-label">Nama Siswa</label>
                            <input type="text" class="form-control" name="nama" id="siswa-name" required>
                        </div>
                        <div class="form-group">
                            <label for="siswa-name" class="col-form-label">Angkatan</label>
                            <select class="form-control" name="angkatan" required>
                                <option value="">-</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="siswa-name" class="col-form-label">Kelas</label>
                            <select class="form-control" name="kelas" required>
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="siswa-name" class="col-form-label">Jurusan</label>
                            <select class="form-control" name="jurusan" required>
                                <option value="">-</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenterEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url(); ?>/action-edit-siswa">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="siswa-name" class="col-form-label">Nama Siswa</label>
                            <input type="hidden" class="form-control" name="id_edit" id="id_edit" required>
                            <input type="text" class="form-control" name="nama_edit" id="nama_edit" required>
                        </div>
                        <div class="form-group">
                            <label for="siswa-name" class="col-form-label">Status</label>
                            <select class="form-control" name="status_edit" id="status_edit" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->
<!-- jQuery -->
<script src="assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/jszip/jszip.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    // A $( document ).ready() block.
    $(document).ready(function() {
        console.log("ready!");
        $('.exampleModalCenterEdit').on('click', function(e) {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let status = $(this).data('status');

            $('#id_edit').val(``);
            $('#nama_edit').val(``);
            $('#status_edit').val(``);

            $('#id_edit').val(id);
            $('#nama_edit').val(nama);
            $('#status_edit').val(status);

            console.log(id);
            console.log(nama);
            console.log(status);
            $('#exampleModalCenterEdit').modal('show');
        });
    });
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>