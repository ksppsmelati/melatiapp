<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'web';
$route['404_override'] = 'web/error_not_found';
$route['translate_uri_dashes'] = FALSE;

// application/config/routes.php

$route['get-anggota-data'] = 'CariTabController/getAnggotaData';
$route['get-info-rekening'] = 'CariTabController/getInfoRekening';
$route['get-agunan-data'] = 'CariTabController/getAgunanData';
$route['get-agunan-data-bpkb'] = 'CariTabController/getAgunanDataBpkb';
$route['get-agunan-data-shm'] = 'CariTabController/getAgunanDataShm';

$route['laporan_kerja'] = 'LaporanKerja/laporan_kerja';
$route['users/laporan_kerja_atasan_export_excel/(:any)/(:any)'] = 'users/laporan_kerja_atasan_export_excel/$1/$2';
$route['users/kerusakan/data_kerusakan'] = 'users/data_kerusakan';
$route['users/kerusakan/data_kerusakan_respond'] = 'users/data_kerusakan_respond';
$route['users/kerusakan/edit_kerusakan/(:num)'] = 'users/edit_kerusakan/$1';
$route['users/kerusakan/hapus_kerusakan/(:num)'] = 'users/hapus_kerusakan/$1';
$route['users/produk/produk_simpati'] = 'users/produk_simpati';
$route['users/produk/produk_simasya'] = 'users/produk_simasya';
$route['users/produk/produk_simaya'] = 'users/produk_simaya';
$route['users/produk/produk_simatang'] = 'users/produk_simatang';
$route['users/produk/produk_simaroh'] = 'users/produk_simaroh';
$route['users/produk/produk_simpel'] = 'users/produk_simpel';
$route['users/produk/produk_simmka'] = 'users/produk_simmka';
$route['users/produk/syarat_ketentuan'] = 'users/syarat_ketentuan';
$route['users/produk/form_simpanan'] = 'users/form_simpanan';
$route['users/absensi/check_absen'] = 'users/check_absen';
$route['users/absensi/detail_absensi'] = 'users/detail_absensi';
$route['users/absensi/rekap'] = 'users/rekap';
$route['users/absensi/bantuan_absensi'] = 'users/bantuan_absensi';
$route['users/absensi/info_karyawan'] = 'users/info_karyawan';
$route['users/absensi/rekap_by_date_range'] = 'users/rekap_by_date_range';
$route['users/absensi/rekap_by_date_range_manual'] = 'users/rekap_by_date_range_manual';
$route['users/usulan/usulan_tambah'] = 'users/usulan_tambah';
$route['users/usulan/usulan_data'] = 'users/usulan_data';
$route['users/usulan/usulan_detail/(:num)'] = 'users/usulan_detail/$1';
$route['users/usulan/usulan_survey/(:num)'] = 'users/usulan_survey/$1';
$route['users/survey/update_survey/(:num)'] = 'users/update_survey/$1';
$route['users/usulan/usulan_laporan'] = 'users/usulan_laporan';
$route['users/usulan_export_excel/(:any)/(:any)'] = 'users/usulan_export_excel/$1/$2';
$route['users/analisa/analisa'] = 'users/analisa';
$route['users/analisa/analisa_hasil'] = 'users/analisa_hasil';
$route['users/analisa/analisa_detail/(:num)'] = 'users/analisa_detail/$1';
$route['users/analisa/analisa_edit/(:num)'] = 'users/analisa_edit/$1';
$route['users/analisa/analisa_delete/(:any)'] = 'users/analisa_delete/$1';
$route['users/kalkulator/kalkulator'] = 'users/kalkulator';
$route['users/kalkulator/kalkulator_standar'] = 'users/kalkulator_standar';
$route['update_location'] = 'users/update_location';
$route['users/tracking/tracking'] = 'users/tracking';
$route['users/tracking/trackingall'] = 'users/trackingall';
$route['web/updateDeviceInfo'] = 'web/updateDeviceInfo';
$route['web/daftar'] = 'web/daftar';
$route['web/lanjut'] = 'web/lanjut';
$route['users/qr/qr'] = 'users/qr';
$route['users/pengaturan/sdi'] = 'users/sdi';
$route['users/info_melatiapp/info_melatiapp'] = 'users/info_melatiapp';
$route['users/harga_kendaraan/harga_kendaraan'] = 'users/harga_kendaraan';
$route['users/harga_kendaraan/harga_kendaraan_edit/(:num)'] = 'users/harga_kendaraan_edit/$1';
// $route['users/harga_kendaraan/harga_kendaraan_lihat'] = 'users/harga_kendaraan_lihat';
// $route['users/harga_kendaraan/harga_kendaraan_tambah'] = 'users/harga_kendaraan_tambah';
$route['users/edit_info/edit_info'] = 'users/edit_info';
$route['users/edit_info/edit_absen'] = 'users/edit_absen';
$route['users/absensi/update_absen/(:num)'] = 'users/update_absen/$1';
$route['users/catatan/catatan'] = 'users/catatan';
$route['users/blokir/blokir'] = 'users/blokir';

$route['users/agunan/agunan'] = 'users/agunan';
$route['users/agunan/agunan_shm'] = 'users/agunan_shm';
$route['users/agunan/agunan_data_proses'] = 'users/agunan_data_proses';
$route['users/agunan/agunan_data_proses_cabang'] = 'users/agunan_data_proses_cabang';
$route['users/agunan/agunan_tambah'] = 'users/agunan_tambah';
$route['users/agunan/agunan_tambah_shm'] = 'users/agunan_tambah_shm';
$route['users/agunan/agunan_lihat/(:num)'] = 'users/agunan_lihat/$1';
$route['users/agunan/agunan_lihat_shm/(:num)'] = 'users/agunan_lihat_shm/$1';
$route['users/agunan/agunan_delete/(:num)'] = 'users/agunan_delete/$1';
$route['users/agunan/agunan_delete_shm/(:num)'] = 'users/agunan_delete_shm/$1';
$route['users/agunan/agunan_edit/(:num)'] = 'users/agunan_edit/$1';
$route['users/agunan/agunan_edit_shm/(:num)'] = 'users/agunan_edit_shm/$1';
$route['users/agunan/agunan_kelola'] = 'users/agunan_kelola';
$route['users/agunan/agunan_info'] = 'users/agunan_info';
$route['users/agunan/agunan_update/(:num)'] = 'users/agunan_update/$1';
$route['users/agunan/agunan_update_shm/(:num)'] = 'users/agunan_update_shm/$1';
$route['users/agunan/agunan_cetak/(:num)'] = 'users/agunan_cetak/$1';
$route['users/menu/menu'] = 'users/menu';
$route['users/edit_info/edit_banner'] = 'users/edit_banner';
$route['users/monitoring/monitoring'] = 'users/monitoring';
$route['users/monitoring/monitoring_tambah'] = 'users/monitoring_tambah';
$route['users/monitoring/monitoring_edit/(:num)'] = 'users/monitoring_edit/$1';
$route['users/monitoring/monitoring_hapus/(:num)'] = 'users/monitoring_hapus/$1';
$route['users/monitoring/monitoring_lihat/(:num)'] = 'users/monitoring_lihat/$1';
$route['users/kpi/kpi_info'] = 'users/kpi_info';
$route['users/kpi/kpi_tambah'] = 'users/kpi_tambah';
$route['users/kpi/kpi_edit/(:num)'] = 'users/kpi_edit/$1';
$route['users/kpi/kpi_hapus/(:num)'] = 'users/kpi_hapus/$1';
$route['users/kpi/kpi_lihat/(:num)'] = 'users/kpi_lihat/$1';
$route['users/kpi/kpi_update/(:num)'] = 'users/kpi_update/$1';
$route['users/informasi/info_usaha'] = 'users/info_usaha';
$route['users/kritik_saran/kritik_saran_data'] = 'users/kritik_saran_data';
$route['users/kritik_saran/kritik_saran_tambah'] = 'users/kritik_saran_tambah';
$route['users/kritik_saran/kritik_saran_lihat/(:num)'] = 'users/kritik_saran_lihat/$1';
$route['users/kritik_saran/kritik_saran_edit/(:num)'] = 'users/kritik_saran_edit/$1';
$route['users/kritik_saran/kritik_saran_edit_user/(:num)'] = 'users/kritik_saran_edit_user/$1';
$route['users/kritik_saran/kritik_saran_hapus/(:num)'] = 'users/kritik_saran_hapus/$1';
$route['users/ucapan/ucapan_data'] = 'users/ucapan_data';
$route['users/ucapan/ucapan_tambah'] = 'users/ucapan_tambah';
$route['users/ucapan/ucapan_lihat/(:num)'] = 'users/ucapan_lihat/$1';
$route['users/ucapan/ucapan_edit/(:num)'] = 'users/ucapan_edit/$1';
$route['users/ucapan/ucapan_hapus/(:num)'] = 'users/ucapan_hapus/$1';
$route['users/file_center/file_center_upload'] = 'users/file_center_upload';
$route['users/file_center/file_center_lihat/(:num)'] = 'users/file_center_lihat/$1';
$route['users/file_center/file_center_edit/(:num)'] = 'users/file_center_edit/$1';
$route['users/file_center/file_center_hapus/(:num)'] = 'users/file_center_hapus/$1';
$route['users/file_center/file_center_download/(:num)'] = 'users/file_center_download/$1';
$route['users/file_center_categories'] = 'users/file_center_categories';
$route['users/file_center_by_category/(:any)'] = 'users/file_center_by_category/$1';
$route['users/menu_setting/menu_setting_data'] = 'users/menu_setting_data';
$route['users/menu_setting/menu_setting_tambah'] = 'users/menu_setting_tambah';
$route['users/menu_setting/menu_setting_lihat/(:num)'] = 'users/menu_setting_lihat/$1';
$route['users/menu_setting/menu_setting_edit/(:num)'] = 'users/menu_setting_edit/$1';
$route['users/menu_setting/menu_setting_hapus/(:num)'] = 'users/menu_setting_hapus/$1';
$route['users/setting/setting_data'] = 'users/setting_data';
$route['users/setting/setting_tambah'] = 'users/setting_tambah';
$route['users/setting/setting_edit/(:num)'] = 'users/setting_edit/$1';
$route['users/setting/setting_hapus/(:num)'] = 'users/setting_hapus/$1';

$route['users/file_user/file_user_upload'] = 'users/file_user_upload';
$route['users/file_user/file_user_lihat/(:num)'] = 'users/file_user_lihat/$1';
$route['users/file_user/file_user_edit/(:num)'] = 'users/file_user_edit/$1';
$route['users/file_user/file_user_hapus/(:num)'] = 'users/file_user_hapus/$1';
$route['users/file_user/file_user_download/(:num)'] = 'users/file_user_download/$1';
$route['users/file_user_categories'] = 'users/file_user_categories';
$route['users/file_user_by_id/(:any)'] = 'users/file_user_by_id/$1';

$route['users/kunjungan/kunjungan_laporan/(:num)'] = 'users/kunjungan_laporan/$1';
$route['users/saldo_data_riwayat/(:any)'] = 'users/saldo_data_riwayat/$1';

$route['users/komite/komite_data'] = 'users/komite_data';
$route['users/komite_data/(:any)'] = 'users/komite_data/$1';
$route['users/komite/komite_hasil'] = 'users/komite_hasil';
$route['users/komite_hasil/(:any)'] = 'users/komite_hasil/$1';

$route['users/story_data'] = 'users/story_data';
$route['users/story_tambah'] = 'users/story_tambah';
$route['users/story_upload'] = 'users/story_upload';
$route['users/mark_viewed'] = 'users/mark_viewed';

$route['users/profile/profile_data/(:num)'] = 'users/profile_data/$1';















