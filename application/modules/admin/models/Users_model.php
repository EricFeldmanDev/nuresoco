<?php

class Users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('users_public')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function usersCount($user_name = null, $category = null)
    {
        if ($user_name != null) {
            $user_name = trim($this->db->escape_like_str($user_name));
            $this->db->where("(name LIKE '%$user_name%' or email LIKE '%$user_name%')");
        }
		
        $this->db->where('delete_status', '0');
        return $this->db->count_all_results('users_public');
    }

    public function getUsers($limit, $page, $user_name = null, $orderby = null)
    {
        if ($user_name != null) {
            $user_name = trim($this->db->escape_like_str($user_name));
            $this->db->where("(users_public.name LIKE '%$user_name%' OR users_public.email LIKE '%$user_name%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('users_public.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('users_public.name', 'asc');
        }
        $this->db->where('users_public.delete_status', '0');
        $query = $this->db->select('users_public.*')->get('users_public', $limit, $page);
        return $query->result();
    }

    public function setUser($post)
    {
        if ($post['edit'] > 0) {
            if (trim($post['password']) == '') {
                unset($post['password']);
            } else {
                $post['password'] = md5($post['password']);
            }
            $this->db->where('id', $post['edit']);
            unset($post['id'], $post['edit']);
            if (!$this->db->update('users_public', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        } else {
            unset($post['edit']);
            $post['password'] = md5($post['password']);
            if (!$this->db->insert('users_public', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        }
    }

}
