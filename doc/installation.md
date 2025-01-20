# Modul Tutorial: Sistem Koreksi Nilai Siswa dengan CodeIgniter 3

## Pendahuluan
Sistem koreksi nilai siswa adalah aplikasi yang dirancang untuk mempermudah administrasi nilai, mulai dari input data siswa, soal, hingga proses koreksi dan laporan. Dalam modul ini, kita akan membangun sistem lengkap menggunakan framework PHP **CodeIgniter 3**, untuk templating UI nya kita akan memakai **Bootstrap** & **jQuery**.

### Fitur Utama
- Manajemen pengguna dengan role admin dan guru.
- Input data siswa, kelas, dan jurusan.
- Input data mata pelajaran dan soal.
- Koreksi nilai otomatis berdasarkan jawaban.
- Download laporan nilai.

## Struktur Database untuk Sistem Koreksi Nilai Siswa (Koreksi Asisten)

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
- **`config.php`**: Konfigurasi dasar CodeIgniter.
- **`database.php`**: Konfigurasi koneksi database.
- **`routes.php`**: Konfigurasi route url.

#### b. `controllers/`
Folder ini berisi file controller yang menangani permintaan dari pengguna.
- **`Auth.php`**: Mengelola login, logout, dan autentikasi.
- **`Dashboard.php`**: Mengelola halaman utama setelah login.
- **`Admin.php`**: Mengelola data master (user, kelas, jurusan, dll).
- **`Guru.php`**: Mengelola data siswa, soal, dan nilai.

#### c. `models/`
Folder ini berisi file model untuk manipulasi database.
- **`Auth_model.php`**: Operasi CRUD untuk tabel `users`.
- **`Admin_model.php`**: Operasi CRUD untuk data master.
- **`Guru_model.php`**: Operasi CRUD untuk data siswa, soal, dan hasil ujian.

#### d. `views/`
Folder ini menyimpan file tampilan HTML.
- **`auth/`**: Berisi halaman login.
  - `login.php`
- **`dashboard/`**: Berisi halaman utama.
  - `index.php`
- **`admin/`**: Berisi halaman untuk admin.
  - `manage_users.php`
  - `manage_kelas.php`
  - `manage_jurusan.php`
  - `manage_mapel.php`
- **`guru/`**: Berisi halaman untuk guru.
  - `manage_siswa.php`
  - `manage_soal.php`
  - `manage_nilai.php`

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
Folder inti dari framework CodeIgniter. **Jangan diubah.**

### 4. `user_guide/`
Dokumentasi bawaan CodeIgniter.

### 5. `index.php`
File utama untuk bootstrap aplikasi.

### 6. `.htaccess`
File konfigurasi server untuk mempermudah URL routing.

## Alur Pengembangan
1. **Setup Proyek**
   - Konfigurasi file `config/config.php` dan `config/database.php`.
   - Pastikan base URL dan database sesuai dengan lingkungan lokal.

2. **Buat Controller**
   - `Auth.php` untuk autentikasi.
   - `Admin.php` dan `Guru.php` untuk fitur utama.

3. **Buat Model**
   - `Auth_model.php`, `Admin_model.php`, dan `Guru_model.php`.

4. **Buat View**
   - Halaman login di `views/auth/login.php`.
   - Halaman dashboard di `views/dashboard/index.php`.
   - Halaman manajemen data di `views/admin/` dan `views/guru/`.

5. **Tambahkan CSS dan JavaScript**
   - Gunakan file di folder `assets/` untuk desain dan interaktivitas.

6. **Testing dan Deployment**
   - Lakukan pengujian menyeluruh pada fitur aplikasi.
   - Deploy ke server dengan menyesuaikan konfigurasi di `index.php` dan `config.php`.
## Implementasi Aplikasi

### 1. Controller `Auth.php`
Controller ini mengelola autentikasi pengguna.

```php
<?php
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function login_process() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Auth_model->get_user($username);

        if ($user && password_verify($password, $user['password'])) {
            $session_data = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);

            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->unset_userdata(['user_id', 'username', 'role', 'logged_in']);
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
```

### 2. Model `Auth_model.php`
Model ini mengelola data pengguna.

```php
<?php
class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_user($username) {
        $query = $this->db->get_where('users', ['username' => $username]);
        return $query->row_array();
    }

    public function create_user($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('users', $data);
    }
}
```

### 3. View Halaman Login
Buat file `login.php` di folder `application/views/auth/`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="<?= site_url('auth/login_process'); ?>" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>

    <?php if ($this->session->flashdata('error')): ?>
        <p style="color: red;"><?= $this->session->flashdata('error'); ?></p>
    <?php endif; ?>
</body>
</html>
```

## Kesimpulan
Dengan mengikuti modul ini, Anda dapat:
1. Membuat struktur database untuk sistem koreksi nilai siswa.
2. Mengelola autentikasi pengguna.
3. Mengatur data master seperti siswa, kelas, jurusan, dan mata pelajaran.
4. Mengimplementasikan sistem koreksi nilai.

Sistem ini dapat dikembangkan lebih lanjut untuk mendukung fitur tambahan seperti analitik nilai, notifikasi, dan lainnya. Semoga bermanfaat!
