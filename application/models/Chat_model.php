<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat_model extends CI_Model
{
    private $table = 'tbl_chat';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Get all conversations for a user (grouped by other participants)
    public function get_conversations($user_id)
    {
        $this->db->select('c.*, u.nama_lengkap as sender_name, u.level as sender_level, u.foto_profile as sender_photo');
        $this->db->from("(SELECT 
                        CASE 
                            WHEN id_user = $user_id THEN receiver_id 
                            ELSE id_user 
                        END as other_user,
                        MAX(created_at) as latest_message_time
                      FROM {$this->table}
                      WHERE (id_user = $user_id OR receiver_id = $user_id)
                      AND status_sender = 'active' 
                      GROUP BY other_user) as latest", false);
        $this->db->join("{$this->table} as c", "(c.id_user = latest.other_user OR c.receiver_id = latest.other_user) 
                                                AND c.created_at = latest.latest_message_time");
        $this->db->join('tbl_user as u', 'u.id_user = latest.other_user');
        $this->db->order_by('c.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Get messages between two users
    public function get_messages($user_id, $other_user_id, $limit = 50, $offset = 0)
    {
        $this->db->select('c.*, u.nama_lengkap as sender_name, u.level as sender_level, u.foto_profile as sender_photo');
        $this->db->from("{$this->table} as c");
        $this->db->join('tbl_user as u', 'u.id_user = c.id_user');
        $this->db->where('((c.id_user = ' . $user_id . ' AND c.receiver_id = ' . $other_user_id . ') 
                          OR (c.id_user = ' . $other_user_id . ' AND c.receiver_id = ' . $user_id . '))');
        $this->db->where('c.status_sender', 'active');
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    // Mark messages as read
    public function mark_as_read($user_id, $sender_id)
    {
        $this->db->where('id_user', $sender_id);
        $this->db->where('receiver_id', $user_id);
        $this->db->where('is_read', 0);
        return $this->db->update($this->table, ['is_read' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    // Get unread message count
    public function count_unread_messages($user_id)
    {
        $this->db->where('receiver_id', $user_id);
        $this->db->where('is_read', 0);
        $this->db->where('status_sender', 'active');
        return $this->db->count_all_results($this->table);
    }

    // Send a new message
    public function send_message($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();

        // Tambahkan ini di akhir metode:
        if ($message_id) {
            // Kirim notifikasi Telegram jika pesan bukan dari Telegram
            if (!isset($data['from_telegram']) || !$data['from_telegram']) {
                $this->send_telegram_notification($data['receiver_id'], $data);
            }
        }

        return $message_id;
    }

    // Delete a message (soft delete)
    public function delete_message($message_id, $user_id)
    {
        // Ambil pesan dulu untuk cek siapa pengirim dan penerimanya
        $message = $this->db->get_where($this->table, ['id' => $message_id])->row();

        if (!$message) {
            return false; // Pesan tidak ditemukan
        }

        // Cek apakah user yang login adalah pengirim atau penerima
        if ($message->id_user == $user_id) {
            // User adalah pengirim
            return $this->db->update($this->table, [
                'status_sender' => 'deleted',
                'deleted_at' => date('Y-m-d H:i:s')
            ], ['id' => $message_id]);
        } elseif ($message->receiver_id == $user_id) {
            // User adalah penerima
            return $this->db->update($this->table, [
                'status_receiver' => 'deleted',
                'deleted_at' => date('Y-m-d H:i:s')
            ], ['id' => $message_id]);
        }

        // User bukan pengirim maupun penerima
        return false;
    }

    public function clear_conversation($user_id, $other_user_id)
    {
        // Begin transaction
        $this->db->trans_begin();

        try {
            // Option 1: Soft delete - Update status to 'deleted' 
            // This is preferable as it keeps a record of messages
            $this->db->where('(id_user = ' . $user_id . ' AND receiver_id = ' . $other_user_id . ') OR 
                          (id_user = ' . $other_user_id . ' AND receiver_id = ' . $user_id . ')');
            $this->db->update('tbl_chat', ['status_sender' => 'deleted']);

            // Option 2: Hard delete - If you prefer to completely remove the messages
            // $this->db->where('(id_user = ' . $user_id . ' AND receiver_id = ' . $other_user_id . ') OR 
            //                  (id_user = ' . $other_user_id . ' AND receiver_id = ' . $user_id . ')');
            // $this->db->delete('tbl_chat');

            // Commit transaction
            $this->db->trans_commit();
            return true;
        } catch (Exception $e) {
            // Roll back transaction on error
            $this->db->trans_rollback();
            log_message('error', 'Clear conversation error: ' . $e->getMessage());
            return false;
        }
    }

    // Upload attachment
    public function upload_attachment($file_data)
    {
        // Configure upload settings
        $config['upload_path'] = './files/chat_attachments/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|txt';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('attachment')) {
            return [
                'status' => false,
                'error' => $this->upload->display_errors()
            ];
        } else {
            return [
                'status' => true,
                'data' => $this->upload->data()
            ];
        }
    }

    // Get recent messages for a user
    public function get_recent_messages($user_id, $limit = 10)
    {
        $this->db->select('c.*, u.nama_lengkap as sender_name, u.level as sender_level, u.foto_profile as sender_photo');
        $this->db->from("{$this->table} as c");
        $this->db->join('tbl_user as u', 'u.id_user = c.id_user');
        $this->db->where('c.receiver_id', $user_id);
        $this->db->where('c.status', 'active');
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    // Search messages
    public function search_messages($user_id, $keyword)
    {
        $this->db->select('c.*, u.nama_lengkap as sender_name, u.level as sender_level, u.foto_profile as sender_photo');
        $this->db->from("{$this->table} as c");
        $this->db->join('tbl_user as u', 'u.id_user = c.id_user');
        $this->db->where('((c.id_user = ' . $user_id . ') OR (c.receiver_id = ' . $user_id . '))');
        $this->db->where('c.status', 'active');
        $this->db->like('c.message', $keyword);
        $this->db->order_by('c.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // Get a single message by ID
    public function get_message_by_id($message_id)
    {
        $this->db->select('c.*, u.nama_lengkap as sender_name, u.level as sender_level, u.foto_profile as sender_photo');
        $this->db->from("{$this->table} as c");
        $this->db->join('tbl_user as u', 'u.id_user = c.id_user');
        $this->db->where('c.id', $message_id);
        return $this->db->get()->row();
    }

    // Mengirim notifikasi Telegram untuk pesan baru
    public function send_telegram_notification($user_id, $message_data)
    {
        // Dapatkan info pengguna
        $this->db->select('telegram_chat_id');
        $this->db->where('id_user', $user_id);
        $this->db->where('telegram_chat_id IS NOT NULL', null, false);
        $query = $this->db->get('tbl_user');

        // Jika user memiliki telegram_chat_id
        if ($query->num_rows() > 0) {
            $user = $query->row();

            // Jika user terdaftar di Telegram
            if ($user->telegram_chat_id) {
                // Dapatkan info pengirim
                $this->db->select('nama_lengkap');
                $this->db->where('id_user', $message_data['id_user']);
                $sender = $this->db->get('tbl_user')->row();

                // Siapkan pesan
                $text = "Pesan baru dari {$sender->nama_lengkap}:\n\n{$message_data['message']}";

                // Kirim notifikasi ke Telegram
                $CI = &get_instance();
                if (!isset($CI->telegram)) {
                    $CI->load->library('telegram_lib');
                }

                return $CI->telegram->send_message($user->telegram_chat_id, $text);
            }
        }

        return false;
    }

    // Menandai pesan tertentu sebagai dibaca
    public function mark_message_as_read($message_id, $id_user)
    {
        $this->db->where('id', $message_id);
        $this->db->where('receiver_id', $id_user);

        return $this->db->update('tbl_chat', ['is_read' => 1]);
    }

    // Mengambil pesan yang belum dibaca
    public function get_unread_messages($id_user)
    {
        $this->db->select('c.*, u.nama_lengkap as sender_name');
        $this->db->from('tbl_chat c');
        $this->db->join('tbl_user u', 'u.id_user = c.id_user');
        $this->db->where('c.receiver_id', $id_user);
        $this->db->where('c.is_read', 0);
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function delete_all_conversations($user_id)
    {
        // Update status_sender untuk user sebagai pengirim
        $this->db->where('id_user', $user_id);
        $this->db->update($this->table, ['status_sender' => 'deleted']);

        // Update status_receiver untuk user sebagai penerima
        $this->db->where('receiver_id', $user_id);
        $this->db->update($this->table, ['status_receiver' => 'deleted']);

        // Update status untuk user sebagai pengirim
        // $this->db->where('id_user', $user_id);
        // $this->db->update($this->table, ['status' => 'deleted']);

        // Update status untuk user sebagai penerima
        // $this->db->where('receiver_id', $user_id);
        // $this->db->update($this->table, ['status' => 'deleted']);
    }
}
