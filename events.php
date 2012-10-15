<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * People Events Class
 * 
 * @package			CMS
 * @subpackage    	People Module
 * @category    	Events
 * @author        	Ryan Thompson - AI Web Systems, Inc.
 * @website       	http://aiwebsystems.com
 */
class Events_People {

	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		
		// Register  events
		Events::register('streams_post_insert_entry', array($this, 'insert_entry_event'));
		Events::register('streams_post_update_entry', array($this, 'update_entry_event'));
	}

	/**
	 *	Map what to run when entry is inserted
	 *
	 *	params void
	 *	return void
	 */
	public function insert_entry_event( $data )
	{
		// Store Module
		if ( $data['stream']->stream_namespace == 'people' )
		{

			// Load the search module model
			$this->CI->load->model('search_index_m');

			switch ( $data['stream']->stream_slug )
			{

				// Contacts
				case 'contacts':

					// Index this entry
					$this->CI->search_index_m->index(
						'people',
						'contact',
						'contacts',
						$data['entry_id'],
						'',	// Front URI
						$data['insert_data']['name'],
						$data['insert_data']['background'].' '.$data['insert_data']['phone'].' '.$data['insert_data']['email'].' '.$data['insert_data']['other_phone'],
						array(
							'cp_edit_uri' => 'admin/people/contacts/view/'.$data['entry_id']
							)
						);

					break;


				// Companies
				case 'companies':

					// Index this entry
					$this->CI->search_index_m->index(
						'people',
						'company',
						'companies',
						$data['entry_id'],
						'',	// Front URI
						$data['insert_data']['name'],
						$data['insert_data']['background'].' '.$data['insert_data']['phone'].' '.$data['insert_data']['email'],
						array(
							'cp_edit_uri' => 'admin/people/companies/view/'.$data['entry_id']
							)
						);

					break;
			}
		}
	}

	/*-----------------------------------------------------------------------------------------*/

	/**
	 *	Map what to run when entry is updated
	 *
	 *	params void
	 *	return void
	 */
	public function update_entry_event( $data )
	{
		
		// Store Module
		if ( $data['stream']->stream_namespace == 'people' )
		{

			// Load the search module model
			$this->CI->load->model('search_index_m');

			switch ( $data['stream']->stream_slug )
			{

				// Contacts
				case 'contacts':

					// Index this entry
					$this->CI->search_index_m->index(
						'people',
						'contact',
						'contacts',
						$data['entry_id'],
						'',	// Front URI
						$data['update_data']['first_name'].' '.$data['update_data']['last_name'],
						$data['update_data']['background'].' '.$data['update_data']['phone'].' '.$data['update_data']['email'].' '.$data['update_data']['other_phone'],
						array(
							'cp_edit_uri' => 'admin/people/contacts/view/'.$data['entry_id']
							)
						);

					// Update comments titles
					$this->CI->db->update('comments', array('entry_title' => $data['update_data']['first_name'].' '.$data['update_data']['last_name']), array('module' => 'people', 'entry_key' => 'contact', 'entry_id' => $data['entry_id']));

					// Update tasks titles
					if ( module_installed('tasks') )
					{
						$this->CI->db->update('tasks_tasks', array('entry_title' => $data['update_data']['first_name'].' '.$data['update_data']['last_name']), array('module' => 'people', 'entry_key' => 'contact', 'entry_id' => $data['entry_id']));
					}

					break;


				// Companies
				case 'companies':

					// Index this entry
					$this->CI->search_index_m->index(
						'people',
						'company',
						'companies',
						$data['entry_id'],
						'',	// Front URI
						$data['update_data']['name'],
						$data['update_data']['background'].' '.$data['update_data']['phone'].' '.$data['update_data']['email'],
						array(
							'cp_edit_uri' => 'admin/people/companies/view/'.$data['entry_id']
							)
						);

					// Update comments titles
					$this->CI->db->update('comments', array('entry_title' => $data['update_data']['name']), array('module' => 'people', 'entry_key' => 'company', 'entry_id' => $data['entry_id']));

					// Update tasks titles
					if ( module_installed('tasks') )
					{
						$this->CI->db->update('tasks_tasks', array('entry_title' => $data['update_data']['name']), array('module' => 'people', 'entry_key' => 'company', 'entry_id' => $data['entry_id']));
					}

					break;
			}
		}
	}
}
/* End of file events.php */