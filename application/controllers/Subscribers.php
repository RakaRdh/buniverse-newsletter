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

        $this->load->library('pagination');

        $config['base_url'] = base_url('subscribers');
        $config['total_rows'] = $this->Subscriber_model->count_all($search);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        // Tailwind styling for pagination
        $config['full_tag_open'] = '<div class="flex items-center gap-1 mt-4 justify-end font-sans">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['first_tag_close'] = '</span>';
        $config['last_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['last_tag_close'] = '</span>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['next_tag_close'] = '</span>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['prev_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="px-3 py-1.5 bg-accent-500 text-white rounded-md text-xs font-bold shadow-sm">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="px-3 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['num_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $config['per_page'];

        $data['subscribers'] = $this->Subscriber_model->get_all($search, $sort_order, $config['per_page'], $offset);
        $data['pagination_links'] = $this->pagination->create_links();
        $start_num = $config['total_rows'] > 0 ? ($offset + 1) : 0;
        $end_num = min($offset + $config['per_page'], $config['total_rows']);
        $data['showing_counter'] = "Menampilkan $start_num - $end_num dari {$config['total_rows']}";
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

        $tempDir = (getenv('VERCEL') || !is_writable('./application/cache/')) ? sys_get_temp_dir() : './application/cache/';
        $config['upload_path']   = rtrim($tempDir, '/\\') . DIRECTORY_SEPARATOR;
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
