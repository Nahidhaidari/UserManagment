<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $lang = array();
        if($this->session->userdata('lang')=="english"){

            $lang['title']="Dasboard";
            $lang['title_small']="control panel";

            
            $lang['users']="Users";
            $lang['tasks']="Tasks";
            $lang['c-tasks']="Complete Tasks";
            $lang['more-info']="More info";
            
        }elseif($this->session->userdata('lang')=="persion"){
            $lang['title']="داشبرد";
            $lang['title_small']="پنل مدیریت";
            $lang['users']="کاربران";
            $lang['tasks']="وظایف";
            $lang['c-tasks']="وظایف کامل شده";
            $lang['more-info']="معلومات بیشتر";
        }
       $data['lang'] = $lang;

        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        $lang = array();
        if($this->session->userdata('lang')=="english"){

            $lang['title']="User Management";
            $lang['title_small']="Users list";
            $lang['btn_add']="Add New";
            $lang['col_name']="Name";
            $lang['col_image']="Image";
            $lang['col_email']="Email";
            $lang['col_mobile']="Mobile";
            $lang['col_role']="Role";
            $lang['col_date']="Created On";
            $lang['col_action']="Action";

        }elseif($this->session->userdata('lang')=="persion"){

            $lang['title']="یوزر ها";
            $lang['title_small']="لیست یوزر ها";
            $lang['btn_add']="اضافه کردن";
            $lang['col_name']="اسم";
            $lang['col_image']="عکس";
            $lang['col_email']="ایمیل";
            $lang['col_mobile']="موبایل";
            $lang['col_role']="رول";
            $lang['col_date']="تاریخ ایجاد";
            $lang['col_action']="عملیات";
        }
       $data['lang'] = $lang;
        
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 3);
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : User Listing';
            
            $this->loadViews("user/users", $this->global, $data, NULL);
        }
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
            $lang['lbl_image']="Image";
            $lang['lbl_fullname']="Full Name";
            $lang['lbl_password']="Password";
            $lang['lbl_cpassword']="Confirm Password";
            $lang['lbl_mobile']="Mobile number";
            $lang['lbl_email']="Email";
            $lang['lbl_role']="Role";
            $lang['lbl_details']="Enter User Details";
            $lang['btn_submit']="Submit";
            $lang['btn_reset']="Reset";
            
            
        }elseif($this->session->userdata('lang')=="persion"){
            
            $lang['title']="مدیریت کاربران";
            $lang['title_small']="اضافه کردن کاربر";
            $lang['lbl_image']="عکس";
            $lang['lbl_fullname']="اسم کامل";
            $lang['lbl_password']="رمز عبور";
            $lang['lbl_cpassword']="تایید رمز عبور";
            $lang['lbl_mobile']="شماره موبایل";
            $lang['lbl_email']="ایمیل آدرس";
            $lang['lbl_role']="رول";
            $lang['lbl_details']="مشخصات کاربر را وارد نمایید";
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
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'CodeInsect : Add New User';

            $this->loadViews("user/addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = $this->input->post('fname');
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $image =$this->upload_image();

                $userInfo = array(
                    'email'=>$email, 
                    'password'=>getHashedPassword($password),
                    'roleId'=>$roleId, 
                    'name'=> $name,
                    'mobile'=>$mobile, 
                    'createdBy'=>$this->vendorId, 
                    'createdDtm'=>date('Y-m-d H:i:s'),
                    'image'=> $image);
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('addNew');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {


        $lang = array();
        if($this->session->userdata('lang')=="english"){

            $lang['title']="User Management";
            $lang['title_small']="Add user";
            $lang['lbl_image']="Image";
            $lang['lbl_fullname']="Full Name";
            $lang['lbl_password']="Password";
            $lang['lbl_cpassword']="Confirm Password";
            $lang['lbl_mobile']="Mobile number";
            $lang['lbl_email']="Email";
            $lang['lbl_role']="Role";
            $lang['lbl_details']="Enter User Details";
            $lang['btn_submit']="Submit";
            $lang['btn_reset']="Reset";
            
            
        }elseif($this->session->userdata('lang')=="persion"){
            
            $lang['title']="مدیریت کاربران";
            $lang['title_small']="اضافه کردن کاربر";
            $lang['lbl_image']="عکس";
            $lang['lbl_fullname']="اسم کامل";
            $lang['lbl_password']="رمز عبور";
            $lang['lbl_cpassword']="تایید رمز عبور";
            $lang['lbl_mobile']="شماره موبایل";
            $lang['lbl_email']="ایمیل آدرس";
            $lang['lbl_role']="رول";
            $lang['lbl_details']="مشخصات کاربر را وارد نمایید";
            $lang['btn_submit']="تایید و ذخیر";
            $lang['btn_reset']="ریسیت";
            
        }
       $data['lang'] = $lang;


        if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit User';
            
            $this->loadViews("user/editOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = $this->input->post('fname');
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $image = $this->upload_image();
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email,
                            'roleId'=>$roleId,
                            'name'=>$name,
                            'mobile'=>$mobile,
                            'updatedBy'=>$this->vendorId, 
                            'image'=>$image, 
                            'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email,
                            'password'=>getHashedPassword($password),
                            'roleId'=>$roleId,
                            'name'=>ucwords($name), 
                            'mobile'=>$mobile, 
                            'updatedBy'=>$this->vendorId, 
                            'image'=>$image, 
                            'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function is used to show users profile
     */
    function profile($active = "details")
    {   


        $lang = array();
        if($this->session->userdata('lang')=="english"){

            $lang['title']="My Profile";
            $lang['title_small']="Update profile";
            $lang['lbl_image']="Image";
            $lang['lbl_fullname']="Full Name";
            $lang['lbl_phone']="Mobile Number";
            $lang['lbl_email']="Email";
            $lang['lbl_oldpass']="Old password";
            $lang['lbl_newpass']="New Password";
            $lang['lbl_cnewpass']="Confirm new password";
            $lang['tab_details']="Details";
            $lang['tab_chpass']="Change Password";
            $lang['btn_submit']="Submit";
            $lang['btn_reset']="Reset";
            
        }elseif($this->session->userdata('lang')=="persion"){
            
            $lang['title']="پروفایل من";
            $lang['title_small']="آپدیت کردن پروفایل";
            $lang['lbl_image']="عکس";
            $lang['lbl_fullname']="اسم کامل";
            $lang['lbl_phone']="شماره تماس";
            $lang['lbl_email']="ایمیل آدرس";
            $lang['lbl_oldpass']="رمز قبلی";
            $lang['lbl_newpass']="رمز جدید";
            $lang['lbl_cnewpass']="تایید رمز جدید";
            $lang['tab_details']="جزئیات";
            $lang['tab_chpass']="تغییر پسورد";
            $lang['btn_submit']="تایید و ذخیره";
            $lang['btn_reset']="ریسیت";
            
        }
       $data['lang'] = $lang;


        $data["userInfo"] = $this->user_model->getUserInfoWithRole($this->vendorId);
        $data["active"] = $active;
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        
        $this->global['pageTitle'] = $active == "details" ? 'CodeInsect : My Profile' : 'CodeInsect : Change Password';
        $this->loadViews("user/profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    function profileUpdate($active = "details")
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|callback_emailExists');        
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $name = $this->input->post('fname');
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $image = $this->upload_image();
            $userInfo = array(
                'name'=>$name, 
                'email'=>$email, 
                'mobile'=>$mobile, 
                'updatedBy'=>$this->vendorId, 
                'image'=>$image, 
                'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->editUser($userInfo, $this->vendorId);
            
            if($result == true)
            {
                $this->session->set_userdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Profile updation failed');
            }

            redirect('profile/'.$active);
        }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('profile/'.$active);
            }
        }
    }

    /**
     * This function is used to check whether email already exist or not
     * @param {string} $email : This is users email
     */
    function emailExists($email)
    {
        $userId = $this->vendorId;
        $return = false;

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ $return = true; }
        else {
            $this->form_validation->set_message('emailExists', 'The {field} already taken');
            $return = false;
        }

        return $return;
    }
    public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }
}

?>