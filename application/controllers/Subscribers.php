<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subscriber_model');
    }

    public function index()
    {
        $search = $this->input->get('search', TRUE);
        $sort_order = $this->input->get('sort_order', TRUE) ?: 'normal';
        if (!in_array($sort_order, ['asc', 'desc', 'normal'])) {
            $sort_order = 'normal';
        }
        $data['subscribers'] = $this->Subscriber_model->get_all($search, $sort_order);
        $data['search'] = $search;
        $data['sort_order'] = $sort_order;
        $data['admin'] = $this->admin;

        $this->load->view('admin/subscribers_list', $data);
    }

    public function toggle($id)
    {
        $subscriber = $this->Subscriber_model->get_by_id($id);
        if ($subscriber) {
            $new_status = ($subscriber['status'] === 'active') ? 'inactive' : 'active';
            $this->Subscriber_model->update($id, ['status' => $new_status]);
            $this->session->set_flashdata('success', 'Status subscriber berhasil diubah.');
        } else {
            $this->session->set_flashdata('error', 'Subscriber tidak ditemukan.');
        }
        redirect('subscribers');
    }

    public function import()
    {
        if (empty($_FILES['csv_file']['name'])) {
            $this->session->set_flashdata('error', 'Silakan pilih berkas CSV terlebih dahulu.');
            redirect('subscribers');
        }

        $config['upload_path']   = './application/cache/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size']      = 2048; // 2MB
        
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('csv_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('subscribers');
        }

        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];

        $subscribers_to_insert = [];
        $duplicate_count = 0;
        $success_count = 0;

        if (($handle = fopen($file_path, "r")) !== FALSE) {
            // Read header
            $header = fgetcsv($handle, 1000, ",");
            
            // Map headers to lower case index
            $name_idx = array_search('name', array_map('strtolower', $header));
            $email_idx = array_search('email', array_map('strtolower', $header));

            if ($name_idx === FALSE || $email_idx === FALSE) {
                fclose($handle);
                unlink($file_path);
                $this->session->set_flashdata('error', 'Format CSV salah. Pastikan kolom header memiliki "name" dan "email".');
                redirect('subscribers');
            }

            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) <= max($name_idx, $email_idx)) {
                    continue;
                }

                $name = trim($row[$name_idx]);
                $email = trim($row[$email_idx]);

                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                // Check if email already exists
                $existing = $this->Subscriber_model->get_by_email($email);
                if ($existing) {
                    // If exists and inactive, reactivate it
                    if ($existing['status'] === 'inactive') {
                        $this->Subscriber_model->update($existing['id'], ['name' => $name, 'status' => 'active']);
                        $success_count++;
                    } else {
                        $duplicate_count++;
                    }
                } else {
                    $subscribers_to_insert[] = [
                        'name' => $name,
                        'email' => $email,
                        'status' => 'active'
                    ];
                }
            }
            fclose($handle);
        }

        unlink($file_path); // Delete the uploaded temp file

        if (!empty($subscribers_to_insert)) {
            $this->Subscriber_model->insert_batch($subscribers_to_insert);
            $success_count += count($subscribers_to_insert);
        }

        $msg = "Import selesai. {$success_count} subscriber baru/diaktifkan kembali.";
        if ($duplicate_count > 0) {
            $msg .= " ({$duplicate_count} email duplikat di-skip)";
        }
        $this->session->set_flashdata('success', $msg);
        redirect('subscribers');
    }
}
