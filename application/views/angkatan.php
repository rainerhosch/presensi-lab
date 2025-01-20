<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Angkatan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active">Angkatan</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fa fa-plus"></i> Tambah Data Angkatan
                        </button>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="">Nama</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($angkatan as $key => $val) { ?>

                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $val['nama']; ?></td>
                                        <?php
                                        if ($val['status'] == 1) {
                                            $v = 'Aktif';
                                        } else {
                                            $v = 'Tidak Aktif';
                                        } ?>
                                        <td><button type="button" class="btn btn-block btn-info btn-xs" fdprocessedid="opufb"><?= $v; ?></button></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-xs exampleModalCenterEdit" data-id="<?= $val['id_angkatan']; ?>" data-nama="<?= $val['nama']; ?>" data-status="<?= $val['status']; ?>" data-toggle="modal">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Angkatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url(); ?>/action-simpan-angkatan">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="angkatan-name" class="col-form-label">Nama Angkatan</label>
                            <input type="text" class="form-control" name="nama" id="angkatan-name" required>
                        </div>
                        <div class="form-group">
                            <label for="angkatan-name" class="col-form-label">Status</label>
                            <select class="form-control" name="status" required>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenterEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Angkatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url(); ?>/action-edit-angkatan">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="angkatan-name" class="col-form-label">Nama Angkatan</label>
                            <input type="hidden" class="form-control" name="id_edit" id="id_edit" required>
                            <input type="text" class="form-control" name="nama_edit" id="nama_edit" required>
                        </div>
                        <div class="form-group">
                            <label for="angkatan-name" class="col-form-label">Status</label>
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
            "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>