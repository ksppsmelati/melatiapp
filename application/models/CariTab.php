<?php
defined('BASEPATH') or exit('No direct script access allowed');

// application/models/CariTab.php

class CariTab extends CI_Model
{

    // public function getAnggota($searchTerm) {
    //     $searchTerm = $searchTerm ?? '';

    //     $this->db->select('fnama, notab, kodeloc, kodeprd, sahirrp');
    //     $this->db->like('fnama', $searchTerm);
    //     $this->db->or_like('notab', $searchTerm);
    //     $query = $this->db->get('TOFTABB');
    //     return $query->result_array();
    // }

    // public function getAnggota($searchTerm) {
    //     $searchTerm = $searchTerm ?? '';

    //     $this->db->select('fnama, notab, kodeloc, kodeprd, sahirrp');
    //     $this->db->like('fnama', $searchTerm);
    //     $this->db->or_like('notab', $searchTerm);
    //     $query1 = $this->db->get('TOFTABB');
    //     $result1 = $query1->result_array();

    //     $this->db->select('nama as fnama, nodep as notab, kdloc as kodeloc, saldrata1 as sahirrp');
    //     $this->db->like('nama', $searchTerm);
    //     $this->db->or_like('nodep', $searchTerm);
    //     $query2 = $this->db->get('TOFDEP');
    //     $result2 = $query2->result_array();

    //     $result_array = array_merge($result1, $result2);

    //     return $result_array;
    // }

    public function getAnggota($searchTerm)
    {
        $searchTerm = $searchTerm ?? '';

        $this->db->select('TOFTABB.notab, TOFTABB.kodeloc, TOFTABB.kodeprd, TOFTABB.sahirrp, 
                           IF(TOFTABQQ.namaqq IS NOT NULL, CONCAT(TOFTABB.fnama, " QQ ", TOFTABQQ.namaqq), TOFTABB.fnama) as fnama');
        $this->db->from('TOFTABB');
        $this->db->join('TOFTABQQ', 'TOFTABQQ.notab = TOFTABB.notab', 'left');
        $this->db->like('TOFTABB.fnama', $searchTerm);
        $this->db->or_like('TOFTABB.notab', $searchTerm);
        $this->db->where('TOFTABB.stsrec', 'A');
        $this->db->order_by('fnama', 'ASC');
        $query1 = $this->db->get();
        $result1 = $query1->result_array();

        $this->db->select('TOFDEP.nodep as notab, TOFDEP.kdloc as kodeloc, TOFDEP.saldrata1 as sahirrp, TOFDEP.nama as fnama');
        $this->db->from('TOFDEP');
        $this->db->like('TOFDEP.nama', $searchTerm);
        $this->db->or_like('TOFDEP.nodep', $searchTerm);
        $this->db->where('TOFDEP.stsrec', 'A');
        $this->db->order_by('TOFDEP.nama', 'ASC');
        $query2 = $this->db->get();
        $result2 = $query2->result_array();

        $result_array = array_merge($result1, $result2);

        return $result_array;
    }

    public function getInfoRekening($searchTerm)
    {
        $searchTerm = $searchTerm ?? '';

        // Query pertama dari TOFTABB dengan join ke TOFTABQQ dan mCIF
        $this->db->select('TOFTABB.notab, TOFTABB.kodeloc, TOFTABB.kodeprd, 
                           IF(TOFTABQQ.namaqq IS NOT NULL, CONCAT(TOFTABB.fnama, " QQ ", TOFTABQQ.namaqq), TOFTABB.fnama) as fnama, 
                           mCIF.nocif, mCIF.alamat, mCIF.hp');
        $this->db->from('TOFTABB');
        $this->db->join('TOFTABQQ', 'TOFTABQQ.notab = TOFTABB.notab', 'left');
        $this->db->join('mCIF', 'mCIF.nocif = TOFTABB.nocif', 'left'); // Join ke mCIF berdasarkan nocif
        $this->db->like('TOFTABB.fnama', $searchTerm);
        $this->db->or_like('TOFTABB.notab', $searchTerm);
        $this->db->where('TOFTABB.stsrec', 'A');
        $this->db->order_by('fnama', 'ASC');
        $query1 = $this->db->get();
        $result1 = $query1->result_array();

        // Query kedua dari TOFDEP dengan join ke mCIF
        $this->db->select('TOFDEP.nodep as notab, TOFDEP.kdloc as kodeloc, TOFDEP.kdprd as kodeprd, 
                           TOFDEP.nama as fnama, 
                           mCIF.nocif, mCIF.alamat, mCIF.hp');
        $this->db->from('TOFDEP');
        $this->db->join('mCIF', 'mCIF.nocif = TOFDEP.nocif', 'left'); // Join ke mCIF berdasarkan nocif
        $this->db->like('TOFDEP.nama', $searchTerm);
        $this->db->or_like('TOFDEP.nodep', $searchTerm);
        $this->db->where('TOFDEP.stsrec', 'A');
        $this->db->order_by('TOFDEP.nama', 'ASC');
        $query2 = $this->db->get();
        $result2 = $query2->result_array();

        // Query kedua dari TOFLMB dengan join ke mCIF
        $this->db->select('TOFLMB.nokontrak as notab, TOFLMB.kdloc as kodeloc, TOFLMB.kdprd as kodeprd, 
                TOFLMB.nama as fnama, mCIF.nocif, mCIF.alamat, mCIF.hp, TOFJAMIN.catatan');
        $this->db->from('TOFLMB');
        $this->db->join('mCIF', 'mCIF.nocif = TOFLMB.nocif', 'left'); // Join ke mCIF berdasarkan nocif
        $this->db->join('TOFJAMIN', 'TOFJAMIN.nokontrak = TOFLMB.nokontrak', 'left'); // Join ke TOFJAMIN berdasarkan nokontrak
        $this->db->like('TOFLMB.nama', $searchTerm);
        $this->db->or_like('TOFLMB.nokontrak', $searchTerm);
        $this->db->where('TOFLMB.stsrec', 'A');
        $this->db->order_by('TOFLMB.nama', 'ASC');
        $query3 = $this->db->get();
        $result3 = $query3->result_array();

        // Gabungkan hasil dari kedua tabel
        $result_array = array_merge($result1, $result2, $result3);

        return $result_array;
    }

    public function getAgunan($searchTerm)
    {
        $this->db->select('TOFJAMIN.noreg, TOFJAMIN.nocif, TOFLMB.nokontrak, TOFJAMIN.jnsjamin, TOFJAMIN.digunakan, TOFJAMIN.jnsdokumen, TOFJAMIN.an, TOFJAMIN.lokasi, TOFJAMIN.catatan, TOFJAMIN.kdloc, TOFJAMIN.inptgljam, TOFJAMIN.tglkeluar, mCIF.nm, mCIF.alamat');
        $this->db->from('TOFJAMIN');
        $this->db->join('TOFLMB', 'TOFJAMIN.nokontrak = TOFLMB.nokontrak', 'left');
        $this->db->join('mCIF', 'TOFLMB.nocif = mCIF.nocif', 'left');
        // $this->db->join('TOFMSPK', 'TOFLMB.nocif = TOFMSPK.nocif', 'left');
        $this->db->group_start(); // Memulai grup untuk kondisi LIKE
        $this->db->like('TOFJAMIN.nocif', $searchTerm);
        $this->db->or_like('TOFLMB.nokontrak', $searchTerm);
        $this->db->or_like('TOFJAMIN.noreg', $searchTerm);
        $this->db->group_end(); // Menutup grup untuk kondisi LIKE
        $this->db->group_by('TOFLMB.nokontrak');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAgunanBpkb($searchTerm)
    {
        $this->db->select('TOFJAMIN.noreg, TOFJAMIN.nocif, TOFLMB.nokontrak, TOFJAMIN.jnsjamin, TOFJAMIN.digunakan, TOFJAMIN.jnsdokumen, TOFJAMIN.an, TOFJAMIN.lokasi, TOFJAMIN.catatan, TOFJAMIN.kdloc, TOFJAMIN.inptgljam, TOFJAMIN.tglkeluar, mCIF.nm, mCIF.alamat');
        $this->db->from('TOFJAMIN');
        $this->db->join('TOFLMB', 'TOFJAMIN.nokontrak = TOFLMB.nokontrak', 'left');
        $this->db->join('mCIF', 'TOFLMB.nocif = mCIF.nocif', 'left');
        // $this->db->join('TOFMSPK', 'TOFLMB.nocif = TOFMSPK.nocif', 'left');
        $this->db->where_in('TOFJAMIN.jnsdokumen', [6, 8, 9]); // Kondisi untuk jnsdokumen = 6
        $this->db->group_start(); // Memulai grup untuk kondisi LIKE
        $this->db->like('TOFJAMIN.nocif', $searchTerm);
        $this->db->or_like('TOFLMB.nokontrak', $searchTerm);
        $this->db->or_like('TOFJAMIN.noreg', $searchTerm);
        $this->db->group_end(); // Menutup grup untuk kondisi LIKE
        $this->db->group_by('TOFLMB.nokontrak');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAgunanShm($searchTerm)
    {
        $this->db->select('TOFJAMIN.noreg, TOFJAMIN.nocif, TOFLMB.nokontrak, TOFJAMIN.jnsjamin, TOFJAMIN.digunakan, TOFJAMIN.jnsdokumen, TOFJAMIN.an, TOFJAMIN.lokasi, TOFJAMIN.catatan, TOFJAMIN.kdloc, TOFJAMIN.inptgljam, TOFJAMIN.tglkeluar, mCIF.nm, mCIF.alamat');
        $this->db->from('TOFJAMIN');
        $this->db->join('TOFLMB', 'TOFJAMIN.nokontrak = TOFLMB.nokontrak', 'left');
        $this->db->join('mCIF', 'TOFLMB.nocif = mCIF.nocif', 'left');
        // $this->db->join('TOFMSPK', 'TOFLMB.nocif = TOFMSPK.nocif', 'left');
        $this->db->where_in('TOFJAMIN.jnsdokumen', [1, 2, 3, 4, 5, 21]);
        $this->db->group_start(); // Memulai grup untuk kondisi LIKE
        $this->db->like('TOFJAMIN.nocif', $searchTerm);
        $this->db->or_like('TOFLMB.nokontrak', $searchTerm);
        $this->db->or_like('TOFJAMIN.noreg', $searchTerm);
        $this->db->group_end(); // Menutup grup untuk kondisi LIKE
        $this->db->group_by('TOFLMB.nokontrak');
        $query = $this->db->get();
        return $query->result_array();
    }
}
