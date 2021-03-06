<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| System Upload Controller
*| --------------------------------------------------------------------------
*| System Upload site
*|
*/
class System_upload extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_system_upload');
	}

	/**
	* show all System Uploads
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('system_upload_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['system_uploads'] = $this->model_system_upload->get($filter, $field, $this->limit_page, $offset);
		$this->data['system_upload_counts'] = $this->model_system_upload->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/system_upload/index/',
			'total_rows'   => $this->model_system_upload->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('System Upload List');
		$this->render('backend/standart/administrator/system_upload/system_upload_list', $this->data);
	}
	
	/**
	* Add new system_uploads
	*
	*/
	public function add()
	{
		$this->is_allowed('system_upload_add');

		$this->template->title('System Upload New');
		$this->render('backend/standart/administrator/system_upload/system_upload_add', $this->data);
	}


	// ===========================================

	public function add_unmatch()
	{
		$this->is_allowed('system_upload_add');

		$this->template->title('System Upload New');
		$this->render('backend/standart/administrator/system_upload/system_upload_add_unmatch', $this->data);
	}

	public function add_save_unmatch()
	{
		if (!$this->is_allowed('system_upload_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('system_upload_file_name_name', 'File Name', 'trim|required');
		// $this->form_validation->set_rules('application_source', 'Application Source', 'trim|required|max_length[225]');
		// $this->form_validation->set_rules('batch_id', 'Batch Id', 'trim|required|max_length[11]');
		// $this->form_validation->set_rules('process_month', 'Process Month', 'trim|required|max_length[11]');
		// $this->form_validation->set_rules('process_year', 'Process Year', 'trim|required|max_length[4]');
		// $this->form_validation->set_rules('upload_at', 'Upload At', 'trim|required');
		

		if ($this->form_validation->run()) {
			$system_upload_file_name_uuid = $this->input->post('system_upload_file_name_uuid');
			$system_upload_file_name_name = $this->input->post('system_upload_file_name_name');
		
			$save_data = [
				'application_source' => 'EDC_UNMATCH',
				'batch_id' => 999,
				'process_month' => 999,
				'process_year' => 999,
				'uploader' => get_user_data('id'),				
				// 'upload_at' => $this->input->post('upload_at'),
				'update_at' => date('Y-m-d H:i:s'),
			];

			if (!is_dir(FCPATH . '/uploads/system_upload/')) {
				mkdir(FCPATH . '/uploads/system_upload/');
			}

			if (!empty($system_upload_file_name_name)) {
				$system_upload_file_name_name_copy = date('YmdHis') . '-' . $system_upload_file_name_name;

				rename(FCPATH . 'uploads/tmp/' . $system_upload_file_name_uuid . '/' . $system_upload_file_name_name, 
						FCPATH . 'uploads/system_upload/' . $system_upload_file_name_name_copy);

				if (!is_file(FCPATH . '/uploads/system_upload/' . $system_upload_file_name_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['file_name'] = $system_upload_file_name_name_copy;
			}
		
			
			$save_system_upload = $this->model_system_upload->store($save_data);

// proses
$this->import_csv($save_system_upload);


			if ($save_system_upload) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_system_upload;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/system_upload/edit/' . $save_system_upload, 'Edit System Upload'),
						anchor('administrator/system_upload', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/system_upload/edit/' . $save_system_upload, 'Edit System Upload')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/system_upload');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/system_upload');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}


	//==================
public function import_csv($id)
{
	$form_system_upload = $this->model_system_upload->find($id);

	// print_r($form_system_upload );die();

	$this->load->library('csvimport');

$file = 	FCPATH . 'uploads/system_upload/'.$form_system_upload->file_name;

$batch_id = $form_system_upload->batch_id; //xxxxxxxxxx
$file_data = $this->csvimport->get_array($file);
// print_r($file_data);die();
	// $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
	foreach($file_data as $row)
	{
		$data[] = array(
			'MID' 				=>	$row["MID"] ,
			'MERCHANT_DBA_NAME'	=>	$row["MERCHANT_DBA_NAME"] ,
			'MSO'				=>	$row["MSO"] ,
			'SOURCE_CODE'		=>	$row["SOURCE_CODE"] ,
			'WILAYAH'			=>	$row["WILAYAH"] ,
			'CHANNEL'			=>	$row["CHANNEL"] ,
			'TAHUN'				=>	$row["TAHUN"] ,
			'BULAN'				=>	$row["BULAN"] 
		);
	}

	// print_r($data);die();

	// $this->csv_import_model->insert($data);
	$this->db->query("truncate temp_edc_unmatch"); 
	$tot_rows = $this->db->insert_batch('temp_edc_unmatch', $data);
	$this->db->query("

UPDATE edc_unmatch
INNER JOIN temp_edc_unmatch on edc_unmatch.MID=temp_edc_unmatch.MID
SET 
edc_unmatch.CHANNEL=temp_edc_unmatch.CHANNEL
,edc_unmatch.WILAYAH=temp_edc_unmatch.WILAYAH
,edc_unmatch.IS_MATCH=1
,edc_unmatch.update_at=now()
	
	");

	$this->db->query("truncate temp_edc_unmatch"); 

	// return $tot_rows;
	// print_r('okkkkkkkkkkkkkkk');die();
	return true;
}


	// =======================================


	/**
	* Add New System Uploads
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('system_upload_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('system_upload_file_name_name', 'File Name', 'trim|required');
		$this->form_validation->set_rules('application_source', 'Application Source', 'trim|required|max_length[225]');
		$this->form_validation->set_rules('batch_id', 'Batch Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('process_month', 'Process Month', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('process_year', 'Process Year', 'trim|required|max_length[4]');
		$this->form_validation->set_rules('upload_at', 'Upload At', 'trim|required');
		

		if ($this->form_validation->run()) {
			$system_upload_file_name_uuid = $this->input->post('system_upload_file_name_uuid');
			$system_upload_file_name_name = $this->input->post('system_upload_file_name_name');
		
			$save_data = [
				'application_source' => $this->input->post('application_source'),
				'batch_id' => $this->input->post('batch_id'),
				'process_month' => $this->input->post('process_month'),
				'process_year' => $this->input->post('process_year'),
				'uploader' => get_user_data('id'),				'upload_at' => $this->input->post('upload_at'),
				'update_at' => date('Y-m-d H:i:s'),
			];

			if (!is_dir(FCPATH . '/uploads/system_upload/')) {
				mkdir(FCPATH . '/uploads/system_upload/');
			}

			if (!empty($system_upload_file_name_name)) {
				$system_upload_file_name_name_copy = date('YmdHis') . '-' . $system_upload_file_name_name;

				rename(FCPATH . 'uploads/tmp/' . $system_upload_file_name_uuid . '/' . $system_upload_file_name_name, 
						FCPATH . 'uploads/system_upload/' . $system_upload_file_name_name_copy);

				if (!is_file(FCPATH . '/uploads/system_upload/' . $system_upload_file_name_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['file_name'] = $system_upload_file_name_name_copy;
			}
		
			
			$save_system_upload = $this->model_system_upload->store($save_data);

			if ($save_system_upload) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_system_upload;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/system_upload/edit/' . $save_system_upload, 'Edit System Upload'),
						anchor('administrator/system_upload', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/system_upload/edit/' . $save_system_upload, 'Edit System Upload')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/system_upload');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/system_upload');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view System Uploads
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('system_upload_update');

		$this->data['system_upload'] = $this->model_system_upload->find($id);

		$this->template->title('System Upload Update');
		$this->render('backend/standart/administrator/system_upload/system_upload_update', $this->data);
	}

	/**
	* Update System Uploads
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('system_upload_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('system_upload_file_name_name', 'File Name', 'trim|required');
		$this->form_validation->set_rules('application_source', 'Application Source', 'trim|required|max_length[225]');
		$this->form_validation->set_rules('batch_id', 'Batch Id', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('process_month', 'Process Month', 'trim|required|max_length[11]');
		$this->form_validation->set_rules('process_year', 'Process Year', 'trim|required|max_length[4]');
		$this->form_validation->set_rules('upload_at', 'Upload At', 'trim|required');
		
		if ($this->form_validation->run()) {
			$system_upload_file_name_uuid = $this->input->post('system_upload_file_name_uuid');
			$system_upload_file_name_name = $this->input->post('system_upload_file_name_name');
		
			$save_data = [
				'application_source' => $this->input->post('application_source'),
				'batch_id' => $this->input->post('batch_id'),
				'process_month' => $this->input->post('process_month'),
				'process_year' => $this->input->post('process_year'),
				'uploader' => get_user_data('id'),				'upload_at' => $this->input->post('upload_at'),
				'update_at' => date('Y-m-d H:i:s'),
			];

			if (!is_dir(FCPATH . '/uploads/system_upload/')) {
				mkdir(FCPATH . '/uploads/system_upload/');
			}

			if (!empty($system_upload_file_name_uuid)) {
				$system_upload_file_name_name_copy = date('YmdHis') . '-' . $system_upload_file_name_name;

				rename(FCPATH . 'uploads/tmp/' . $system_upload_file_name_uuid . '/' . $system_upload_file_name_name, 
						FCPATH . 'uploads/system_upload/' . $system_upload_file_name_name_copy);

				if (!is_file(FCPATH . '/uploads/system_upload/' . $system_upload_file_name_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['file_name'] = $system_upload_file_name_name_copy;
			}
		
			
			$save_system_upload = $this->model_system_upload->change($id, $save_data);

			if ($save_system_upload) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/system_upload', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/system_upload');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/system_upload');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete System Uploads
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('system_upload_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'system_upload'), 'success');
        } else {
            set_message(cclang('error_delete', 'system_upload'), 'error');
        }

		redirect_back();
	}

		/**
	* View view System Uploads
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('system_upload_view');

		$this->data['system_upload'] = $this->model_system_upload->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('System Upload Detail');
		$this->render('backend/standart/administrator/system_upload/system_upload_view', $this->data);
	}
	
	/**
	* delete System Uploads
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$system_upload = $this->model_system_upload->find($id);

		if (!empty($system_upload->file_name)) {
			$path = FCPATH . '/uploads/system_upload/' . $system_upload->file_name;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_system_upload->remove($id);
	}
	
	/**
	* Upload Image System Upload	* 
	* @return JSON
	*/
	public function upload_file_name_file()
	{
		if (!$this->is_allowed('system_upload_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'system_upload',
		]);
	}

	/**
	* Delete Image System Upload	* 
	* @return JSON
	*/
	public function delete_file_name_file($uuid)
	{
		if (!$this->is_allowed('system_upload_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'file_name', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'system_upload',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/system_upload/'
        ]);
	}

	/**
	* Get Image System Upload	* 
	* @return JSON
	*/
	public function get_file_name_file($id)
	{
		if (!$this->is_allowed('system_upload_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$system_upload = $this->model_system_upload->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'file_name', 
            'table_name'        => 'system_upload',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/system_upload/',
            'delete_endpoint'   => 'administrator/system_upload/delete_file_name_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('system_upload_export');

		$this->model_system_upload->export('system_upload', 'system_upload');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('system_upload_export');

		$this->model_system_upload->pdf('system_upload', 'system_upload');
	}
}


/* End of file system_upload.php */
/* Location: ./application/controllers/administrator/System Upload.php */