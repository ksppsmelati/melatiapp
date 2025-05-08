<?php
defined('BASEPATH') OR die('No direct script access allowed!');

function check_absen_harian()
{
    $CI =& get_instance();
    $id_user = $CI->session->id_user;
    $CI->load->model('Absensi_model', 'absensi');
    $absen_user = $CI->absensi->absen_harian_user($id_user)->num_rows();
    if (!is_weekend()) {
        if ($absen_user < 2) {
            $CI->session->set_userdata('absen_warning', 'true');
        } else {
            $CI->session->set_userdata('absen_warning', 'false');
        }
    }
}

function check_jam($jam, $status, $raw = false)
{
    if ($jam) {
        $status = ucfirst($status);
        $CI =& get_instance();
        $CI->load->model('Jam_model', 'jam');
        $jam_kerja = $CI->jam->db->where('keterangan', $status)->get('tbl_jam')->row();

        $jam_9_pagi = '09:00:00';
        $jam_12_siang = '12:00:00';
        $jam_14_siang = '14:00:00';
        $jam_15_siang = '15:00:00';

        // Cek jika statusnya "Masuk Siang" terlebih dahulu
        if ($status == 'Masuk' && $jam > $jam_9_pagi && $jam <= $jam_12_siang) { 
            if ($raw) {
                return [
                    'status' => 'siang',
                    'text' => $jam
                ];
            } else {
                return '<span class="badge badge-warning">' . $jam . '</span>';
            }
        }

        // Cek jika statusnya "Masuk" (telat)
        if ($status == 'Masuk' && $jam > $jam_kerja->finish) {
            if ($raw) {
                return [
                    'status' => 'telat',
                    'text' => $jam
                ];
            } else {
                return '<span class="badge badge-danger">' . $jam . '</span>';
            }
        }

        // Cek jika statusnya "Pulang Setengah Hari" (pulang antara 12:00 dan 14:00)
        if ($status == 'Pulang' && $jam >= $jam_12_siang && $jam < $jam_14_siang) {
            if ($raw) {
                return [
                    'status' => 'setengah',
                    'text' => $jam
                ];
            } else {
                return '<span class="badge" style="background-color: #3b43d6;">' . $jam . '</span>';
            }
        }

        // Cek jika statusnya "Pulang" atau "Pulang Cepat"
        if ($status == 'Pulang') {
            if ($jam > $jam_kerja->finish) {
                if ($raw) {
                    return [
                        'status' => 'lembur',
                        'text' => $jam
                    ];
                } else {
                    return '<span class="badge badge-success">' . $jam . '</span>';
                }
            } elseif ($jam >= $jam_14_siang && $jam <= $jam_15_siang) { // Cek jika pulang antara 14:00 dan 15:00
                if ($raw) {
                    return [
                        'status' => 'cepat',
                        'text' => $jam
                    ];
                } else {
                    return '<span class="badge badge-info">' . $jam . '</span>';
                }
            }
        }

        // Jika tidak ada kondisi khusus, kembalikan status normal
        if ($raw) {
            return [
                'status' => 'normal',
                'text' => $jam
            ];
        } else {
            return '<span class="badge"  style="background-color: #2196f3;">' . $jam . '</span>';
        }
    } else {
        if ($raw) {
            return [
                'status' => 'normal',
                'text' => 'N/A'
            ];
        }
        return 'N/A';
    }
}



function is_weekend($tgl = false)
{
    $tgl = @$tgl ? $tgl : date('d-m-Y');
    return in_array(date('l', strtotime($tgl)), ['Saturday', 'Sunday']);
}
