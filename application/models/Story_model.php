<?php
class Story_model extends CI_Model
{
    // Mendapatkan semua story yang belum kadaluwarsa
    public function get_active_stories()
    {
        $this->db->where('expiry_at >', date('Y-m-d H:i:s'));
        $query = $this->db->get('tbl_story');
        return $query->result_array();
    }

    // Menyimpan story baru
    public function add_story($data)
    {
        return $this->db->insert('tbl_story', $data);
    }

    // Menghapus story yang sudah kadaluwarsa
    public function delete_expired_stories()
    {
        $this->db->where('expiry_at <=', date('Y-m-d H:i:s'));
        $this->db->delete('tbl_story');

        // Optionally log how many rows were deleted
        return $this->db->affected_rows();
    }

    // Mendapatkan detail story berdasarkan id_story
    public function get_story_by_id($story_id)
    {
        $query = $this->db->get_where('tbl_story', ['id_story' => $story_id]);
        return $query->row_array() ?: null;  // Return null if no result found
    }

    // Menandai story sebagai sudah dilihat
    public function markAsViewed($storyId, $viewerId)
    {
        // Get the current viewed_by array
        $this->db->select('viewed_by');
        $this->db->where('id_story', $storyId);
        $query = $this->db->get('tbl_story');
        $story = $query->row_array();

        // Check if 'viewed_by' is null or empty before decoding
        $viewed_by = !empty($story['viewed_by']) ? json_decode($story['viewed_by'], true) : [];

        // Ensure $viewed_by is an array
        if (!is_array($viewed_by)) {
            $viewed_by = [];
        }

        // Add the current user to the viewed_by list if not already there
        if (!in_array($viewerId, $viewed_by)) {
            $viewed_by[] = $viewerId;
        }

        // Update the story with the new viewed_by list
        $this->db->where('id_story', $storyId);
        $this->db->set('viewed_by', json_encode($viewed_by)); // Save as JSON
        $this->db->set('views_count', 'views_count+1', FALSE); // Increment the view count
        $this->db->update('tbl_story');

        if ($this->db->affected_rows() > 0) {
            // Return updated views count and viewed_by
            return ['views_count' => $this->getViewsCount($storyId), 'viewed_by' => $viewed_by];
        }

        return false; // Return false if no rows affected
    }

    // Function to get the current views count
    public function getViewsCount($storyId)
    {
        $this->db->select('views_count');
        $this->db->where('id_story', $storyId);
        $query = $this->db->get('tbl_story');
        $result = $query->row_array();
        return $result ? $result['views_count'] : 0;  // Return views count, defaulting to 0 if not found
    }

    public function delete_all_stories_by_user($userId)
    {
        // Delete all stories where the 'id_user' matches the logged-in user
        $this->db->where('id_user', $userId);
        $this->db->delete('tbl_story');
        
        // Return the number of rows affected (i.e., number of stories deleted)
        return $this->db->affected_rows();
    }

}
