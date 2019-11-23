<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Task extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('task_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->taskListing();
    }
    
    /**
     * This function is used to load the user list
     */
    function taskListing()
    {
        $id = $this->session->userdata('userId');
        $lang = array();
        if($this->session->userdata('lang')=="english"){

            $lang['title']="User Management";
            $lang['title_small']="Task list";
            $lang['btn_add']="Add New task";

            $lang['col_id']="Number";
            $lang['col_name']="Name";
            $lang['col_description']="Description";
            $lang['col_user']="User";
            $lang['col_status']="Status";
            $lang['col_date']="Date ";
            $lang['col_action']="Action ";
            
            
        }elseif($this->session->userdata('lang')=="persion"){
            
            $lang['title']="تسک ها";
            $lang['title_small']="لیست تسک ها";
            $lang['btn_add']="اضافه کردن";
            
            $lang['col_id']="شماره";
            $lang['col_name']="اسم وظیفه";
            $lang['col_description']="تشریحات";
            $lang['col_user']="کاربر";
            $lang['col_status']="حالت";
            $lang['col_date']="تاریخ ";
            $lang['col_action']="عملیات ";
        }
       $data['lang'] = $lang;
            

        
        $this->load->library('pagination');
        
        $count = $this->task_model->taskListingCount();

        $returns = $this->paginationCompress ( "taskListing/", $count, 10 );
        
        $data['taskRecords'] = $this->task_model->taskListing( $returns["page"], $returns["segment"],$id);
        
        $this->global['pageTitle'] = 'CodeInsect : task Listing';
        
        $this->loadViews("task/tasks", $this->global, $data, NULL);
      
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        $lang = array();
        if($this->session->userdata('lang')=="english"){

            $lang['title']="User Management";
            $lang['title_small']="Add user";
            $lang['lbl_details']="Enter Task Details";

            $lang['lbl_taskname']="Task Name";
            $lang['lbl_taskdescription']="Description";
            $lang['lbl_taskuser']="User";
            
            $lang['btn_submit']="Submit";
            $lang['btn_reset']="Reset";
            
            
        }elseif($this->session->userdata('lang')=="persion"){
            
            $lang['title']="مدیریت کاربران";
            $lang['title_small']="اضافه کردن کاربر";
            $lang['lbl_details']="جزئیات تسک را وارد نمایید";


            $lang['lbl_taskname']="اسم تسک";
            $lang['lbl_taskdescription']="تشریحات";
            $lang['lbl_taskuser']="کاربر";

            $lang['btn_submit']="تایید و ذخیره";
            $lang['btn_reset']="ریسیت";
            
        }
       $data['lang'] = $lang;

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('task_model');
            $data['users'] = $this->task_model->getUsers();
            
            $this->global['pageTitle'] = 'Add new task';

            $this->loadViews("task/addNew", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to add new user to the system
     */
    function addNewTask()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('description','Description','trim|required|max_length[128]');
            $this->form_validation->set_rules('user','Password','required|max_length[20]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = $this->input->post('name');
                $description = $this->input->post('description');
                $user = $this->input->post('user');
                
                $taskInfo = array(
                    'name'=>$name, 
                    'description'=>$description, 
                    'user_id'=> $user,
                    'status'=>1, 
                    'create_date'=>time());
                
                $this->load->model('task_model');
                $result = $this->task_model->addNewTask($taskInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Task created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Task creation failed');
                }
                
                redirect('task/addNew');
            }
        }
    }

    
    
    /**
     * This function is used to edit the user information
     */
 

    /**
     * This function is used to delete the task using id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteTask($taskid)
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            
            
            $result = $this->task_model->deleteTask($taskid);
            
            if ($result > 0) {
                redirect("task");
             }
            else {
                echo(json_encode(array('status'=>FALSE))); }
        }
    }
    function completeTask($taskid)
    {
        $this->db->query('update tbl_tasks set status=0 where id='.$taskid);
        redirect('task');
        
    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>