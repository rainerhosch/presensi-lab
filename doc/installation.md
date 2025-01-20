# Modul: Sistem Presensi Siswa dengan CodeIgniter 3

## Pendahuluan
Sistem Presensi siswa adalah aplikasi yang dirancang untuk mempermudah administrasi pencatatan presensi. Dalam modul ini, kita akan membangun sistem lengkap menggunakan framework PHP **CodeIgniter 3**, untuk templating UI nya kita akan memakai **Bootstrap** & **jQuery**.

### Fitur Utama
- Manajemen pengguna dengan role admin dan guru.
- Input data siswa, kelas, dan jurusan.
- Perekaman presensi siswa dengan QR-Code.
- Download laporan laporan presensi.

## Struktur Database untuk Sistem Presensi Siswa

### Tahap pertama buat database, sebagai contoh kita akan membuat presensi_siswa_2025
```sql
CREATE DATABASE presensi_siswa_2025;
USE presensi_siswa_2025;
```

### Tabel Master
1. **tabel admin**
    ```sql
    --
    -- Table structure for table `admin`
    --
    CREATE TABLE `admin` (
        `id` int(11) NOT NULL,
        `username` varchar(50) NOT NULL,
        `password` varchar(255) NOT NULL,
        `role` enum('admin','guru') NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```
    

2. **tabel angkatan**
    ```sql
    --
    -- Table structure for table `angkatan`
    --

    CREATE TABLE `angkatan` (
        `id_angkatan` int(11) NOT NULL,
        `tahun_angkatan` varchar(200) NOT NULL,
        `status` tinyint(4) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

3. **tabel jurusan**
    ```sql
    --
    -- Table structure for table `jurusan`
    --

    CREATE TABLE `jurusan` (
        `id_jurusan` int(11) NOT NULL,
        `nama_jurusan` varchar(200) NOT NULL,
        `status` tinyint(4) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

4. **tabel kelas**
    ```sql
    --
    -- Table structure for table `kelas`
    --

    CREATE TABLE `kelas` (
        `id_kelas` int(11) NOT NULL,
        `nama_kelas` varchar(200) NOT NULL,
        `status` tinyint(4) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```


5. **tabel presensi**
    ```sql
    --
    -- Table structure for table `presensi`
    --

    CREATE TABLE `presensi` (
        `id_presensi` int(11) NOT NULL,
        `id_siswa` int(11) NOT NULL,
        `id_tahun_ajaran` int(11) NOT NULL,
        `check_in` datetime DEFAULT NULL,
        `check_out` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```


6. **tabel siswa**
    ```sql
    --
    -- Table structure for table `siswa`
    --

    CREATE TABLE `siswa` (
        `id_siswa` int(11) NOT NULL,
        `nisn` varchar(11) NOT NULL,
        `nama_siswa` varchar(200) NOT NULL,
        `id_angkatan` int(11) NOT NULL,
        `id_kelas` int(11) NOT NULL,
        `id_jurusan` int(11) NOT NULL,
        `alamat` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

7. **tabel tahun_ajaran**
    ```sql
    --
    -- Table structure for table `tahun_ajaran`
    --

    CREATE TABLE `tahun_ajaran` (
        `id_tahun_ajaran` int(11) NOT NULL,
        `nama` varchar(200) NOT NULL,
        `status` tinyint(4) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```


## Buat Dummy Data, untuk mengisi database.
**query untuk inisialisasi data admin**
```sql
    --
    -- Dumping data for table `admin`
    --

    INSERT INTO `admin` (`username`, `password`, `role`) VALUES
    ('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');
```

**query untuk mengisi tabel kelas**

```sql
    -- Data Dummy untuk Tabel `kelas`
    INSERT INTO kelas (nama_kelas) 
    VALUES 
    ('Kelas 10'), ('Kelas 11'), ('Kelas 12');
```

**query untuk mengisi tabel jurusan**
```sql
-- Data Dummy untuk Tabel `jurusan`
INSERT INTO jurusan (nama_jurusan) 
VALUES 
('IPA'), ('IPS'), ('Bahasa'), ('TKJ'), ('RPL'), ('Mesin'), ('Automotif'), ('Elektro'), ('Sipil');
```

**query untuk mengisi tabel angkatan**
```sql
-- Data Dummy untuk tabel angkatan
INSERT INTO `angkatan` (`tahun_angkatan`, `status`) VALUES
('2020', 1),
('2021', 1),
('2022', 1),
('2023', 1),
('2024', 1);
```

**query untuk mengisi tabel kelas**
```sql
-- Data Dummy untuk tabel kelas
INSERT INTO `kelas` (`nama`, `status`) VALUES
('X IPA 1', 1),
('X IPS 1', 1),
('XI Bahasa 1', 1),
('XII Automotif', 1),
('XII Mesin Elektro', 1);
```

**query untuk mengisi tabel tahun_ajaran**
```sql
-- Data Dummy untuk tabel tahun_ajaran
INSERT INTO `tahun_ajaran` (`tahun_ajaran`, `status`, `created_at`) VALUES
('2020/2021', 1),
('2021/2022', 1),
('2022/2023', 1),
('2023/2024', 1),
('2024/2025', 1);
```

**query untuk mengisi tabel siswa**
```sql
-- Data Dummy untuk tabel siswa (minimal 100 baris)
INSERT INTO `siswa` (`nisn`, `nama`, `id_angkatan`, `id_kelas`, `id_jurusan`, `alamat`) VALUES
('12345678901', 'Siswa 1', 1, 1, 1, 'Jl. Merdeka No. 1'),
('12345678902', 'Siswa 2', 1, 1, 1, 'Jl. Merdeka No. 2'),
('12345678903', 'Siswa 3', 1, 2, 2, 'Jl. Merdeka No. 3'),
('12345678904', 'Siswa 4', 1, 2, 2, 'Jl. Merdeka No. 4'),
('12345678905', 'Siswa 5', 1, 3, 3, 'Jl. Merdeka No. 5'),
('12345678906', 'Siswa 6', 2, 3, 3, 'Jl. Merdeka No. 6'),
('12345678907', 'Siswa 7', 2, 4, 4, 'Jl. Merdeka No. 7'),
('12345678908', 'Siswa 8', 2, 4, 4, 'Jl. Merdeka No. 8'),
('12345678909', 'Siswa 9', 2, 5, 5, 'Jl. Merdeka No. 9'),
('12345678910', 'Siswa 10', 2, 5, 5, 'Jl. Merdeka No. 10'),
-- tambahkan siswa hingga mencapai 100 baris
-- Baris berikutnya hanya contoh
(100, '12345679000', 'Siswa 100', 5, 5, 5, 'Jl. Merdeka No. 100');
```



## Struktur Direktori Utama
```
project_root/
|-- application/
|   |-- config/
|   |   |-- autoload.php
|   |   |-- config.php
|   |   |-- database.php
|   |   |-- routes.php
|   |-- controllers/
|   |   |-- Angkatan.php
|   |   |-- Dashboard.php
|   |   |-- Jurusan.php
|   |   |-- Kelas.php
|   |   |-- Login.php
|   |   |-- Scan.php
|   |   |-- Siswa.php
|   |   |-- Tahun.php
|   |-- models/
|   |   |-- MAngkatan.php
|   |   |-- MJurusan.php
|   |   |-- MKelas.php
|   |   |-- MLogin.php
|   |   |-- MScan.php
|   |   |-- MSiswa.php
|   |   |-- MTahun.php
|   |-- views/
|   |   |-- angkatan.php
|   |   |-- dashboard.php
|   |   |-- jurusan.php
|   |   |-- kelas.php
|   |   |-- login.php
|   |   |-- scan.php
|   |-- libraries/
|   |-- helpers/
|-- assets/
|   |-- css/
|   |-- js/
|   |-- images/
|-- system/
|-- index.php
|-- .htaccess
```

## Penjelasan Direktori dan File

### 1. `application/`
Berisi kode aplikasi utama.

#### a. `config/`
Folder ini menyimpan file konfigurasi.
- **`autoload.php`**: Memuat library, helper, dan model yang diperlukan.
- **`config.php`**: Konfigurasi dasar aplikasi.
- **`database.php`**: Konfigurasi koneksi database.
- **`routes.php`**: Konfigurasi route URL.

#### b. `controllers/`
Folder ini berisi file controller yang menangani permintaan dari pengguna.
- **`Angkatan.php`**: Mengelola data angkatan.
- **`Dashboard.php`**: Mengelola halaman utama setelah login.
- **`Jurusan.php`**: Mengelola data jurusan.
- **`Kelas.php`**: Mengelola data kelas.
- **`Login.php`**: Mengelola proses login dan logout.
- **`Scan.php`**: Mengelola fitur scan presensi.
- **`Siswa.php`**: Mengelola data siswa.
- **`Tahun.php`**: Mengelola data tahun ajaran.

#### c. `models/`
Folder ini berisi file model untuk manipulasi database.
- **`MAngkatan.php`**: Operasi CRUD untuk data angkatan.
- **`MJurusan.php`**: Operasi CRUD untuk data jurusan.
- **`MKelas.php`**: Operasi CRUD untuk data kelas.
- **`MLogin.php`**: Operasi autentikasi pengguna.
- **`MScan.php`**: Operasi terkait scan presensi.
- **`MSiswa.php`**: Operasi CRUD untuk data siswa.
- **`MTahun.php`**: Operasi CRUD untuk data tahun ajaran.

#### d. `views/`
Folder ini menyimpan file tampilan HTML.
- **`angkatan.php`**: Tampilan untuk data angkatan.
- **`dashboard.php`**: Tampilan untuk halaman utama.
- **`jurusan.php`**: Tampilan untuk data jurusan.
- **`kelas.php`**: Tampilan untuk data kelas.
- **`login.php`**: Tampilan untuk halaman login.
- **`scan.php`**: Tampilan untuk fitur scan presensi.

#### e. `libraries/`
Custom library untuk fitur tambahan (jika diperlukan).

#### f. `helpers/`
Custom helper untuk fungsi-fungsi utilitas (jika diperlukan).

### 2. `assets/`
Folder ini menyimpan file statis seperti CSS, JavaScript, dan gambar.

#### a. `css/`
Folder untuk file CSS.
- **`style.css`**: File utama untuk styling aplikasi.

#### b. `js/`
Folder untuk file JavaScript.
- **`app.js`**: File utama untuk scripting aplikasi.

#### c. `images/`
Folder untuk menyimpan gambar.

### 3. `system/`
Folder inti dari framework. **Jangan diubah.**

### 4. `index.php`
File utama untuk bootstrap aplikasi.

### 5. `.htaccess`
File konfigurasi server untuk mempermudah URL routing.

## Alur Pengembangan
1. **Setup Proyek**
   - Konfigurasi file `application/config/config.php` dan `application/config/database.php`.
   - Pastikan base URL dan database sesuai dengan lingkungan lokal.

2. **Buat Controller**
   - `Angkatan.php` untuk data angkatan.
   - `Jurusan.php` untuk data jurusan.
   - `Kelas.php` untuk data kelas.
   - `Login.php` untuk autentikasi.
   - `Scan.php` untuk fitur scan presensi.

3. **Buat Model**
   - `MAngkatan.php`, `MJurusan.php`, `MKelas.php`, `MLogin.php`, dan lainnya untuk data yang sesuai.

4. **Buat View**
   - Halaman login di `application/views/login.php`.
   - Halaman dashboard di `application/views/dashboard.php`.
   - Halaman data angkatan, jurusan, kelas, dan siswa di folder yang sesuai.

5. **Tambahkan CSS dan JavaScript**
   - Gunakan file di folder `assets/` untuk desain dan interaktivitas.

6. **Testing dan Deployment**
   - Lakukan pengujian menyeluruh pada fitur aplikasi.
   - Deploy ke server dengan menyesuaikan konfigurasi di `index.php` dan `config.php`.
   - 
## Implementasi Aplikasi

### Implementasi Aplikasi

Berikut adalah panduan implementasi untuk fitur **Login** dan **Scan** menggunakan arsitektur MVC.

---

## 1. **Implementasi Login**

### a. **Controller**
File: `application/controllers/Login.php`
```php
    <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Login extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('MLogin');
            $this->load->library('form_validation');
        }

        public function action()
        {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|alpha_numeric');
            if ($this->form_validation->run() == TRUE) {
                $username = $this->input->post('username');
                $pass = md5($this->input->post('password'));
                $data_db = $this->MLogin->cek_login(['username' => $username, 'password' => $pass]);
                // var_dump($data_db);
                // exit;
                if (!empty($data_db)) {
                    $data_sesi = [
                        'username' => $username,
                        'role' => $data_db['role']
                    ];
                    $this->session->set_userdata($data_sesi);
                    redirect(base_url('dashboard'));
                } else {
                    $this->session->set_flashdata('notif', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data dismiss='alert' aria-hidden='true'>&times;</button> <h4><i class='icon fa fa-warning'></i> Alert!</h4> Username/Passwords Salah</div>");
                    redirect(base_url('login'));
                }
            } else {
                $this->session->set_flashdata('notif', "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data dismiss='alert' aria-hidden='true'>&times;</button> <h4><i class='icon fa fa-warning'></i> Alert!</h4> Salah input data</div>");
                redirect(base_url('login'));
            }
        }
    }

```

---

### b. **Model**
File: `application/models/MLogin.php`
```php
    <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class MLogin extends CI_Model
    {
        public function cek_login($where)
        {
            $this->db->select('*');
            $this->db->from('admin');
            $this->db->where($where);
            return $this->db->get()->row_array();
        }
    }
```

---

### c. **View**
File: `application/views/login.php`
```html
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log In</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="assets/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="assets/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="assets/AdminLTE-3.2.0/index2.html" class="h1"><b>Login</b> Admin LAB</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to start your session</p>

				<form action="action-login" method="post">
					<div class="input-group mb-3">
						<input type="username" name="username" class="form-control" placeholder="Username">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" name="password" class="form-control" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-8">

						</div>
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>


				<!-- /.social-auth-links -->


			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="assets/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
</body>

</html>
```

---

## 2. **Implementasi Scan**

### a. **Controller**
File: `application/controllers/Scan.php`
```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MScan', 'Scan');
		$this->load->library('form_validation');
	}

	public function action_simpan()
	{
		// MHS
		$manif = 0;
		$insertV = 0;
		$manif_out = 0;
		$jam_now = date("H:i:s");
		$format  = date("Y-m-d");
		$create_at  = date("Y-m-d H:i:s");
		$nisn = $this->input->post('nisn');
		// $nisn = 12345;

		$where_ = [
			'siswa.nisn' => $nisn
		];

		$cek  = $this->Scan->cek($where_);
		if ($cek > 0) {
			$where_presensi = [
				'id_siswa' => $cek['id_siswa'],
				'tgl_check_out' => '0000-00-00'
			];

			$where_max = [
				'id_siswa' => $cek['id_siswa']
			];

			$cek_max_id = $this->Scan->cek_last_absen($where_presensi);

			if (empty($cek_max_id)) {
				$cek_max_id['id_presensi'] = null;
				$cek_max_id['tgl_check_in'] = null;
				$cek_max_id['jam_check_in'] = null;
				$cek_max_id['tgl_check_out'] = null;
				$cek_max_id['jam_check_out'] = null;
			}
			$cek_last_absen = $this->Scan->cek_last_absen($where_max);
			if (empty($cek_last_absen)) {

				$cek_max_id['id_presensi'] = null;
				$cek_last_absen['tgl_check_in'] = null;
				$cek_last_absen['jam_check_in'] = null;
				$cek_last_absen['tgl_check_out'] = null;
				$cek_last_absen['jam_check_out'] = null;
			}

			$create_at_last = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];

			$checkout_last = $cek_last_absen['tgl_check_out'] . ' ' . $cek_last_absen['jam_check_out'];
			$diff  = date_diff(date_create($create_at_last), date_create());
			$dataJam =  $diff->d . ' hari, ' . $diff->h . ' jam, ' . $diff->i . ' menit, ' . $diff->s . ' detik, ';
			$diff_mulai  = date_diff(date_create($checkout_last), date_create());
			$dataJam_mulai =  $diff_mulai->d . ' hari, ' . $diff_mulai->h . ' jam, ' . $diff_mulai->i . ' menit, ' . $diff_mulai->s . ' detik, ';
			$checkout_last2 = $cek_max_id['tgl_check_out'] . ' ' . $cek_max_id['jam_check_out'];
			$diff_mulai2  = date_diff(date_create($checkout_last2), date_create());

			// ABSEN TERAKHIR
			if ($cek_last_absen !== null && $cek_last_absen['tgl_check_out'] == '0000-00-00') {

				//UPDATE CHECKOUT

				if ($diff->d < 1 && ($diff->i >= 1 && $diff->h >= 0 && $diff->h <= 16)) {
					$data_jam = [
						'tgl_check_out' => $format,
						'jam_check_out' => $jam_now
					];
					$prosesUpdate = $this->Scan->update_absen(['id_presensi' => $cek_last_absen['id_presensi']], $data_jam);
					// JIKA BERHASIL
					if ($prosesUpdate > 0) {
						$data = 'Terima kasih';
						$status = 2;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					// JIKA 24 JAM BELUM CHECKOUT
				} else if ($diff->d > 0) {
					$times = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
					$dt = new DateTime($times);
					$dt->modify('+ 1 hour');
					$tglk = date_format($dt, "Y-m-d");
					$jamk = date_format($dt, "H:i:s");
					$data_jam = [
						'tgl_check_out' => $tglk,
						'jam_check_out' => $jamk
					];
					$prosesUpdate = $this->Scan->update_absen(['id_presensi' => $cek_last_absen['id_presensi']], $data_jam);
					if ($prosesUpdate > 0) {
						$data = 'Checkout kemarin, Silahkan Scan lagi...';
						$status = 6;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					//JIKA BELUM CHECK OUT
				} else if ($diff->d > 0 && $diff->h > 15) {
					$times = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
					$dt = new DateTime($times);
					$dt->modify('+ 1 hour');
					$tglk = date_format($dt, "Y-m-d");
					$jamk = date_format($dt, "H:i:s");
					$data_jam = [
						'tgl_check_out' => $tglk,
						'jam_check_out' => $jamk
					];
					$prosesUpdate = $this->Scan->update_absen(['id_presensi' => $cek_last_absen['id_presensi']], $data_jam);
					if ($prosesUpdate > 0) {
						$data = 'Checkout kemarin, Silahkan Scan lagi...';
						$status = 6;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					//JIKA BELUM CHECK OUT
				} else if ($diff->d < 1 && $diff->h > 15) {
					$times = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
					$dt = new DateTime($times);
					$dt->modify('+ 1 hour');
					$tglk = date_format($dt, "Y-m-d");
					$jamk = date_format($dt, "H:i:s");
					$data_jam = [
						'tgl_check_out' => $tglk,
						'jam_check_out' => $jamk
					];
					$prosesUpdate = $this->Scan->update_absen(['id_absensi' => $cek_last_absen['id_presensi']], $data_jam);
					if ($prosesUpdate > 0) {
						$data = 'Checkout kemarin, Silahkan Scan lagi...';
						$status = 6;
						$manif_out = 1;
					} else {
						$data = 'Tidak Tersimpan';
						$status = 0;
					}
					//JIKA BELUM PULANG
				} else {
					$data = 'Tunggu satu menit...';
					$status = 3;
				}
				//JIKA ABSEN BELUM PERNAH DIBUAT 
			} else {
				//JIKA SUDAH ABSEN HARI INI 1 MENIT
				if ($cek_max_id['id_presensi'] !== null && $diff_mulai2->d < 1 && $diff_mulai2->h < 1 && $diff_mulai2->i < 1) {
					$create_last_w = $cek_max_id['tgl_check_in'] . ' ' . $cek_max_id['jam_check_in'];
					$checkout_last_w  = $cek_max_id['tgl_check_out'] . ' ' . $cek_max_id['jam_check_out'];
					$diff  = date_diff(date_create($checkout_last_w), date_create($create_last_w));
					$dataJam =  $diff->d . ' hari, ' . $diff->h . ' jam, ' . $diff->i . ' menit, ' . $diff->s . ' detik, ';
					$data = 'Sudah mengisi list...';
					$status = 4;
					// BATAS CEK IN
				} else {
					$where_data = [
						'id_siswa'  => $cek['id_siswa'],
						'id_tahun_ajaran'  => 2025,
						'tgl_check_in'  => $format,
						'jam_check_in'  => $jam_now,
						'tgl_check_out' => '',
						'jam_check_out' => ''
					];
					$prosesInsert = $this->Scan->insert_absen($where_data);
					$dataJam = '-';
					$data    = 'Scan Tersimpan.';
					$status  = 1;
					$manif   = 1;
					$insertV = 1;
				}
			}

			//MANIPULASI WAKTU
			if ($manif == 1) {
				$awalW = $create_at;
			} else {
				$awalW = $cek_last_absen['tgl_check_in'] . ' ' . $cek_last_absen['jam_check_in'];
			}

			if ($insertV == 1) {
				$akhirW = '-';
			} else {
				if ($cek_last_absen['tgl_check_out'] != '0000-00-00') {
					$akhirW = $cek_last_absen['tgl_check_out'] . ' ' . $cek_last_absen['jam_check_out'];
				} else {
					$akhirW = $manif_out == 1 ? $create_at : '-';
				}
			}
			//END MANIPULASI WAKTU

			// ENCODE JSON
			$Edata = [
				'notif' => $data,
				'nisn' => $cek['nisn'],
				'nama' => $cek['nama'],
				'status' => $status,
				'dataJam_mulai' => $dataJam_mulai,
				'dataJam' => $dataJam,
				'sql' => $cek_last_absen,
				'awal' => $awalW,
				'akhir' => $akhirW,
				'max' => $cek_max_id
			];
		} else {
			$Edata = [
				'error' => 1
			];
		}
		echo json_encode($Edata);
	}
}
```

---

### b. **Model**
File: `application/models/MScan.php`
```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class MScan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function cek($where)
    {
        $this->db->select('*');
        $this->db->from('siswa');
        // $this->db->join('siswa', 'siswa.id_siswa = presensi.id_siswa');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function cek_last_absen($where)
    {
        $this->db->select('*');
        $this->db->from('presensi');
        $this->db->where($where);
        $this->db->order_by('id_presensi', 'DESC');
        $this->db->limit(1);
        // ORDER BY id DESC LIMIT 0, 1
        return $this->db->get()->row_array();
    }

    public function update_absen($where, $data)
    {
        $this->db->update('presensi', $data, $where);
        return $this->db->affected_rows();
    }
    public function insert_absen($data)
    {
        $this->db->insert('presensi', $data);
        return $this->db->affected_rows();
    }

    public function data_presensi($where)
    {
        $this->db->select('siswa.*, kelas.nama AS kelas, jurusan.nama AS jurusan, presensi.tgl_check_in, presensi.jam_check_in, presensi.tgl_check_out, presensi.jam_check_out');
        $this->db->from('presensi');
        $this->db->join('siswa', 'siswa.id_siswa = presensi.id_siswa');
        $this->db->join('jurusan', 'siswa.id_jurusan = jurusan.id_jurusan');
        $this->db->join('kelas', 'siswa.id_kelas = kelas.id_kelas');
        $this->db->where($where);
        $this->db->order_by('`presensi`.`id_presensi`', 'DESC');
        return $this->db->get()->result_array();
    }
}
```

---

### c. **View**
File: `application/views/scan.php`
```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scan</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->

        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1>Presensi Laboratorium Komputer SMAN 1 PASAWAHAN</h1>
                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card card-primary">
                    <!-- Block Content -->
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="text-center col-md-8 text-center">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($presensi as $key => $value) { ?>

                                            <tr style="<?= $key == 0 ? 'background-color: aquamarine;' : ''; ?>">
                                                <td><?= $key + 1; ?></td>
                                                <td><?= $value['nama']; ?></td>
                                                <td><?= $value['kelas']; ?></td>
                                                <td><?= $value['jurusan']; ?></td>
                                                <td><?= $value['tgl_check_in'] . ' ' . $value['jam_check_in']; ?></td>
                                                <td><?= $value['tgl_check_out'] . ' ' . $value['jam_check_out']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="text-center col-md-4 text-center">
                                <div class="text-center" style="width: 100%" id="reader"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/html5-qrcode/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            // stop
            // html5QrcodeScanner.clear();

            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;

                // Handle on success condition with the decoded text or result.
                console.log(`Scan result: ${decodedText}`, decodedResult);
                let nisn = 0;
                if (decodedResult.result.format.formatName == "QR_CODE") {
                    nisn = parseInt(decodedResult.result.text);

                    if (nisn > 0) {

                        console.log(nisn);
                        $.ajax({
                            type: "post",
                            url: "<?= base_url('scan-action') ?>",
                            data: {
                                nisn: nisn
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#modal-id').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                });
                            },

                            success: function(response) {
                                let timerInterval;
                                let table = `<table class="text-left">`;
                                table += `<tr>`;
                                table += `<td>NISN</td>`;
                                table += `<td>: ` + response.nisn + `</td>`;
                                table += `</tr>`;
                                table += `<tr>`;
                                table += `<td>NAMA</td>`;
                                table += `<td>: ` + response.nama + `</td>`;
                                table += `</tr>`;
                                table += `</table>`;
                                Swal.fire({
                                    title: response.notif,
                                    html: table,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const timer = Swal.getPopup().querySelector("b");
                                        timerInterval = setInterval(() => {
                                            timer.textContent = `${Swal.getTimerLeft()}`;
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                    }
                                }).then((result) => {
                                    /* Read more about handling dismissals below */
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        console.log("I was closed by the timer");

                                        location.reload();
                                    }
                                });
                            },
                            error: function(e) {
                                $('#modal-id').modal('hide');
                                alert('Error');
                                // location.reload();
                            },
                        });
                    } else {
                        alert('null');
                        location.reload();
                    }
                } else {
                    alert('Bukan QR Code!')
                    location.reload();
                }
            } else {
                console.log('stop');
            }

        }

        function onScanError(errorMessage) {
            // handle on error condition, with error message

        }

        const config = {
            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            },
            rememberLastUsedCamera: true,
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA, Html5QrcodeScanType.SCAN_TYPE_FILE],
            showTorchButtonIfSupported: false,
            showZoomSliderIfSupported: true,
            defaultZoomValueIfSupported: 1,
        };

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", config);


        // A $( document ).ready() block.
        $(document).ready(function() {
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        });
    </script>
</body>
</html>
```
---

## Kesimpulan
Dengan mengikuti modul ini, Anda dapat:
1. Membuat struktur database untuk sistem presensi siswa.
2. Mengelola autentikasi pengguna.
3. Mengatur data master seperti siswa, kelas, jurusan, dan data presensi.
4. Mengimplementasikan sistem presensi dengan konsep Scan QR-Code.

---

Silakan sesuaikan sesuai kebutuhan proyek Anda! Jika ada bagian yang perlu dijelaskan lebih lanjut, beri tahu saya.
Sistem ini dapat dikembangkan lebih lanjut untuk mendukung fitur tambahan seperti analitik nilai, notifikasi, dan lainnya. Semoga bermanfaat!
