<?php

class Blog_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deletePost($id)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('blog_posts');
        $this->db->where('for_id', $id)->delete('blog_translations');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function postsCount($search = null)
    {
        if ($search !== null) {
            $this->db->like('blog_translations.title', $search);
        }
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('blog_posts');
    }

    public function getPosts($lang = null, $limit, $page, $search = null, $month = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(blog_translations.title LIKE '%$search%' OR blog_translations.description LIKE '%$search%')");
        }
        if ($month !== null) {
            $from = $month['from'];
            $to = $month['to'];
            $this->db->where("time BETWEEN $from AND $to");
        }
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        if ($lang == null) {
            $this->db->where('blog_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        } else {
            $this->db->where('blog_translations.abbr', $lang);
        }
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts', $limit, $page);
        return $query->result_array();
    }

    public function setPost($post, $id)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            $this->db->where('id', $id);
            if (!$this->db->update('blog_posts', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('blog_posts', array(
                        'image' => $post['image'],
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();
            $this->db->where('id', $id);
            if (!$this->db->update('blog_posts', array(
                        'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        $this->setBlogTranslations($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    private function setBlogTranslations($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'description' => $post['description'][$i],
                'abbr' => $abbr,
                'for_id' => $id
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('blog_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('blog_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getOnePost($id)
    {
        $query = $this->db->where('id', $id)->get('blog_posts');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('blog_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['description'] = $row->description;
        }
        return $arr;
    }

    
    public function addBlog($post){ 
		$popular_post = '0';
		if(isset($post['popular_post'])) $popular_post = '1';
		$recent_post = '0';
		if(isset($post['recent_post']))  $recent_post = '1';
		
        $data=array('title'=>$post['blog_title'],'description'=>$post['description'],'image'=>$post['image'],'is_popular_post'=>$popular_post,'is_recent_post'=>$recent_post,'blog_date'=>$post['blog_date'],'created_by'=>$post['created_by'],'status'=>'1','delete_status'=>'0','created_on'=>date("Y-m-d H:i:s"),'modify_on'=>date("Y-m-d H:i:s"));
        $qry=$this->db->insert('blogs',$data);
        if(isset($qry)) return 1; else return 0;     
    }


    /*public function getBlogs(){
        $query = $this->db->select('*')->where('delete_status','0')->get('blogs'); 
        return $query->result_array();
    }*/

    public function getBlogs($limit, $start)  {   
        $this->db->where('delete_status','0');
        $this->db->limit($limit, $start);
        $this->db->order_by('blog_date','DESC');
        $query = $this->db->get("blogs");
        if ($query->num_rows() > 0)  {
            foreach ($query->result_array() as $row){
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

     public function get_total(){
        $query = $this->db->select('*')->where('delete_status','0')->get('blogs'); 
        return $query->num_rows(); 
    }
      

    public function getDataById($id){
        $query = $this->db->select('*')->where('blog_id',$id)->get('blogs');
        return $query->result_array();   
    }

    public function removeBlog($id){
        $id=base64_decode($id);
        $data=array('delete_status'=>1);
        $this->db->where('blog_id',$id);
        $this->db->update('blogs',$data);
        $aff=$this->db->affected_rows();
        if($aff==1) return 1; else return 0;    
    }



    public function updateBlog($post) {  

        $popular_post = '0';
		if(isset($post['popular_post'])) $popular_post = '1';
		$recent_post = '0';
		if(isset($post['recent_post']))  $recent_post = '1';
        
		$data=array(
                'title' => $post['blog_title'],
                'description' => $post['description'],
                'is_popular_post'=>$popular_post,
                'is_recent_post'=>$recent_post,
                'blog_date'=>$post['blog_date'],
                'created_by' => $post['created_by'],
                'status'=>'1',
                'delete_status'=>'0',
                'created_on'=>date('Y-m-d H:i:s'),
                'modify_on'=>date('Y-m-d H:i:s')
			);
		
		if(isset($post['image']))
		{   
             $data['image'] = $post['image'];
		}
		
		$this->db->where('blog_id', $post['pageId']); 
		if(!$this->db->update('blogs', $data)) {
              log_message('error', print_r($this->db->error(), true));
              show_error(lang('database_error'));  
		}           
		$afftectedRows=$this->db->affected_rows();
		if($afftectedRows>0) return 1; else return 0;
    }
    


}
