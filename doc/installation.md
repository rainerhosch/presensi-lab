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
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('MLogin');
    }

    public function index() {
        $this->load->view('login');
    }

    public function authenticate() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->MLogin->check_credentials($username, $password);

        if ($user) {
            $this->session->set_userdata('user_data', $user);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('login');
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_data');
        redirect('login');
    }
}
```

---

### b. **Model**
File: `application/models/MLogin.php`
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MLogin extends CI_Model {
    public function check_credentials($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password)); // Ensure passwords are hashed
        return $this->db->get('users')->row_array(); // Adjust 'users' to your table name
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>
    <form method="POST" action="<?php echo base_url('login/authenticate'); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
```

---

## 2. **Implementasi Scan**

### a. **Controller**
File: `application/controllers/Scan.php`
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('MScan');
    }

    public function check_in() {
        $id_siswa = $this->input->post('id_siswa');
        $data = [
            'id_siswa' => $id_siswa,
            'check_in' => date('Y-m-d H:i:s'),
        ];

        $this->MScan->save_check_in($data);
        echo 'Check-in successful!';
    }

    public function check_out() {
        $id_siswa = $this->input->post('id_siswa');
        $data = [
            'check_out' => date('Y-m-d H:i:s'),
        ];

        $this->MScan->update_check_out($id_siswa, $data);
        echo 'Check-out successful!';
    }
}
```

---

### b. **Model**
File: `application/models/MScan.php`
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MScan extends CI_Model {
    public function save_check_in($data) {
        $this->db->insert('presensi', $data);
    }

    public function update_check_out($id_siswa, $data) {
        $this->db->where('id_siswa', $id_siswa);
        $this->db->where('check_out', null); // Ensure no duplicate check-outs
        $this->db->update('presensi', $data);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan</title>
</head>
<body>
    <h1>Scan Presensi</h1>
    <form method="POST" action="<?php echo base_url('scan/check_in'); ?>">
        <label for="id_siswa">ID Siswa:</label>
        <input type="text" name="id_siswa" id="id_siswa" required>
        <button type="submit">Check-in</button>
    </form>
    <br>
    <form method="POST" action="<?php echo base_url('scan/check_out'); ?>">
        <label for="id_siswa">ID Siswa:</label>
        <input type="text" name="id_siswa" id="id_siswa" required>
        <button type="submit">Check-out</button>
    </form>
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
