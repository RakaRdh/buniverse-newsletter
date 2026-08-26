<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unsubscribe extends MY_Controller {

    public function index()
    {
        $email = $this->input->get('email', TRUE);
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            show_error('Email address is invalid or missing.');
        }

        $this->load->model('Subscriber_model');
        $subscriber = $this->Subscriber_model->get_by_email($email);
        
        if ($subscriber) {
            $this->Subscriber_model->update($subscriber['id'], ['status' => 'inactive']);
            $data['email'] = $email;
            $this->load->view('public/unsubscribe_success', $data);
        } else {
            show_error('Subscriber not found.');
        }
    }
}
