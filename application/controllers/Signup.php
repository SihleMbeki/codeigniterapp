<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Signup extends CI_Controller {

    	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/weSignup
	 *	- or -
	 * 		http://example.com/index.php/Signup/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
     * */
	public $benchmark    = [];
    public $hooks     = [];
    public $config      = [];
    public $log      = [];
    public $utf8       = [];
    public $uri       = [];
    public $router      = [];
    public $output      = [];
    public $security      = [];
    public $input      = [];
    public $lang       = [];
    public $db       = [];
    public $Account_model;
    public $form_validation;
    public $session;

    public function __construct() {
        parent::__construct();
        $this->load->model('Account_model');
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
        $this->load->library(['form_validation', 'session']); // Add 'session' here
    }

    public function index() {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('signup_view');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            if ($this->Account_model->username_exists($username)) {
                $this->session->set_flashdata('error', 'Username already exists');
                redirect('signup');
            }
            
            $token = bin2hex(random_bytes(50)); // Generate secure token
            
            if ($this->Account_model->create_user($username, $password, $token)) {
                // Send verification email or process token here
                $this->session->set_flashdata('success', 'Registration successful!');
                redirect('signup');
            } else {
                $this->session->set_flashdata('error', 'Registration failed');
                redirect('signup');
            }
        }
    }
}