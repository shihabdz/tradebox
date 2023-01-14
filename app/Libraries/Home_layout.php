<?php namespace App\Libraries;
use App\Models\Common_model;
use App\Views\view_css;

class Home_layout {
	public function __construct()
    {
        $this->session 	= session();
        $this->db 		= db_connect();
        $this->uri 		= current_url(true);
        $this->common_model 		= new Common_model();

    }
	public function master($data){

		$data['settings'] 	  = $this->setting_data();
		$data['session']	  = session();
		$data['lang']      	  = $this->langSet();
		$data['web_language'] = $this->common_model->findById('web_language', array('id' => 1));
		//$data['query_pair']   = $this->common_model->findById('dbt_coinpair', array('status' => 1));
        $data['query_pair']   = $this->common_model->findByIdDesc('dbt_coinpair', array('status' => 1,'isDefault'=>1));
       
		$data['segments']     = $this->uri->getSegments();
		$data['userinfo']     = $this->user_data();
		$data['social_link']  = $this->common_model->findAll('web_social_link', array('status' => 1), 'id', 'asc');
		$data['category']     = $this->common_model->findAll('web_category', array('status' => 1), 'position_serial', 'asc');

		$theme           	  = $this->common_model->findById('dbt_theme', array('status' => 1));
        $data['addTemplate']  = $this->common_model->findById('themes', array('status' => 1));

        $data['theme']   	= json_decode($theme->settings);
        $data['css_page']	= view('view_css', $data);
        $data['languages'] = $this->languageList();
        $builder = $this->db->table('themes');
        $template = $builder->select('name')->where('status',1)->get()->getRow();
        echo view('website/'.$template->name.'/header', $data);
        echo view($data['page'], $data);
        return view('website/'.$template->name.'/footer', $data);
	}

    public function languageList()
    { 
        if ($this->db->tableExists("language")) { 

            $fields = $this->db->getFielddata("language");
            $i = 1;
            foreach ($fields as $field)
            {  
                if ($i++ > 2)
                $result[$field->name] = ucfirst($field->name);
            }

            if (!empty($result)) return $result;
        } else {

            return false;
        }
    }


	public function setting_data(){
		$builder = $this->db->table('setting')->get()->getRow(); 
		return $builder;
	}

	public function user_data(){
		$builder = $this->db->table('dbt_user')->where('user_id', $this->session->get('user_id'))->get()->getRow(); 
		return $builder;
	}


	/******************************
    * Language Set For User
    ******************************/
     public function langSet($lan = null, $user = null){

        $lang = "";
        if($user == null) {
             $user_id = $this->session->get('user_id');
        } else {
            $user_id = $user;
        }
      
       if($lan != null) {
             $lang  = $lan ; 
        } else {
            if ($user_id != "" || $user_id != NULL) {
                $ulang = $this->db->table('dbt_user')->select('language')->where('user_id', $user_id)->get()->getRow();

                if ($this->session->lang ) {
                     $lang    = $this->session->lang ; 
                } else if($ulang) {
                    $lang     =  $ulang->language ;                
                } else {
                    $lang ='english'; 
                }

            } else {
                if ($this->session->lang ) {
                     $lang    = $this->session->lang ;                                
                } else {
                    $lang ='english'; 
                }

            } 

        }          
        $newdata = array(
                    'lang'  => $lang
                );
        $this->session->set($newdata);
        return $lang;
    }

}
