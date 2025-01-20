<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']    = 'Welcome/scan';
$route['login']                 = 'Welcome';
$route['action-login']          = 'Login/action';
$route['dashboard']             = 'Dashboard';

$route['kelas']                 = 'Kelas';
$route['action-simpan-kelas']   = 'Kelas/action_simpan';
$route['action-edit-kelas']     = 'Kelas/action_edit';

$route['jurusan']                 = 'Jurusan';
$route['action-simpan-jurusan']   = 'Jurusan/action_simpan';
$route['action-edit-jurusan']     = 'Jurusan/action_edit';

$route['tahun-ajaran']          = 'Tahun';
$route['action-simpan-tahun']   = 'Tahun/action_simpan';
$route['action-edit-tahun']     = 'Tahun/action_edit';

$route['data-siswa']          = 'Siswa';
$route['action-simpan-siswa']   = 'Siswa/action_simpan';
$route['action-edit-siswa']     = 'Siswa/action_edit';

$route['angkatan']                 = 'Angkatan';
$route['action-simpan-angkatan']   = 'Angkatan/action_simpan';
$route['action-edit-angkatan']     = 'Angkatan/action_edit';

$route['scan-action']     = 'Scan/action_simpan';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
