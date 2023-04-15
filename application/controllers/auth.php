<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if($this->form_validation->run() == false)
        {
            $data['title']  = 'Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }else{
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if($user)
        {
            if($user['is_active'] == 1){
                if(password_verify($password, $user['password'])){
                    $data = [
                        'email' => $user['email'],
                        'password' => $user['password']
                    ];
                    $this->session->set_userdata($data);
                    redirect('user');
                }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password !</div>');
                    redirect('auth');
                }
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                This email is not activated !</div>');
                redirect('auth');
            }
        }else{
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Email is not registered !</div>');
        redirect('auth');
        }
    }
    
    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This Email Has Already Registered !'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'password dont match !',
            'min_length' => 'password too short !'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[8]|matches[password1]');


        if($this->form_validation->run() == false)
        {
            $data['title'] = 'Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        }else{
            $data =[
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'image' => $this->input->post('image'),
                'is_active' => 1
            ];

        $this->db->insert('user', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Congratulation! your account has been created. Please Login</div>');
        redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'     => 'smtp',
            'smtp_host'    => 'smtp.gmail.com',
            'smtp_user'    => 'fathan.065118081@unpak.ac.id',
            'smtp_pass'    => 'FathanRasil081',
            'smtp_port'    => 587,
            'smtp_crypto'  =>'tls',
            'mailtype'     =>'html',
            'charset'      =>'utf-8',
            'newline'      =>"\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('fathan.065118081@unpak.ac.id', 'Muhammad Fathan Rasil Haq');
        $this->email->to($this->input->post('email'));

        if($type == 'forget'){
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if ($this->email->send())
        {
            return true;
        }else{
            echo $this->email->print_debugger();
            die;
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        You have been logged out !</div>');
        redirect('auth');
    }

    public function forgetpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if($this->form_validation->run() == false){
            $data['title']  = 'Forget Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forget-password');
            $this->load->view('templates/auth_footer');
        }else{
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active'=> 1])->row_array();

        if($user){
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user_token', $user_token);
            $this->_sendEmail($token, 'forget');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Please check your email to reset your password !</div>');
            redirect('auth/forgetpassword');

        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered !</div>');
            redirect('auth/forgetpassword');
        }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if($user)
        {
            $user_token = $this->db->get_where('user_token', ['token'=>$token])->row_array();

            if($user_token)
            {
                $this->session->set_userdata('reset_email', $email);
                $this->changepassword();
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Reset password failed! Wrong token !</div>');
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Reset password failed! Wrong email !</div>');
            redirect('auth');
        }
    }

    public function changepassword()
    {
        if(!$this->session->userdata('reset_email')){
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[8]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[8]|matches[password1]');
        if ($this->form_validation->run() == false){
            $data['title']  = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        }else{
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');


            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Password has been changed! Please login.</div>');
            redirect('auth');
        }
    }

}