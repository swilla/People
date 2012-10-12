<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * People Module
 *
 * @author 		Ryan Thompson - AI Web Systems, Inc.
 * @package 	CMS
 * @subpackage 	People Module
 * @category 	Modules
 */
class Contacts extends Admin_Controller
{
	
	// Set the section	
	protected $section = 'contacts';

	// Tabs for the form
	protected $tabs = '';
	

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->lang->load('people');
		$this->load->helper('people');
		$this->load->driver('streams');


		// Make the tabs
		$this->tabs = array();

		$this->tabs = array(
			array(
				'title' 	=> lang('people:tab:contact_information'),
				'id'		=> 'contact-information-tab',
				'fields'	=> array('str_id', 'profile_image', 'first_name', 'last_name', 'title', 'company', 'phone', 'mobile', 'fax', 'email', 'website'),
				),
			array(
				'title' 	=> lang('people:tab:address'),
				'id'		=> 'addresss-tab',
				'fields'	=> array('street', 'street_extra', 'city', 'state', 'postal_code', 'country'),
				),
			array(
				'title' 	=> lang('people:tab:billing_address'),
				'id'		=> 'billing-address-tab',
				'fields'	=> array('billing_street', 'billing_street_extra', 'billing_city', 'billing_state', 'billing_postal_code', 'billing_country'),
				),
			array(
				'title' 	=> lang('people:tab:social'),
				'id'		=> 'social-tab',
				'fields'	=> array('facebook', 'twitter', 'linkedin'),
				),
			array(
				'title' 	=> lang('people:tab:other'),
				'id'		=> 'other-tab',
				'fields'	=> array('source', 'industry', 'user', 'background', 'keywords'),
				),
			array(
				'title' 	=> lang('people:tab:files'),
				'id'		=> 'files-tab',
				'fields'	=> array('contact_files'),
				),
			);

		// Always load these
		$this->template
			->append_css('module::admin.css')
			->append_js('module::admin.js');
	}

	// --------------------------------------------------------------------------

	/**
	 * List all existing contacts
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{

		// Set the title
		$this->template->title(lang('people:title:contacts'));

		// Set some extras
		$extra = array(
			'title'		=> lang('people:title:contacts'),
			'buttons'	=> array(
				array(
					'label' 	=> lang('global:view'),
					'url' 		=> 'admin/people/contacts/view/-entry_id-',
					),
				array(
					'label' 	=> lang('global:edit'),
					'url' 		=> 'admin/people/contacts/edit/-entry_id-',
					),
				array(
					'label'		=> lang('global:delete'),
					'url' 		=> 'admin/people/contacts/delete/-entry_id-',
					'confirm'	=> true,
					),
				),
			'filters'	=> array(),
			);
		
		$this->streams->cp->entries_table('contacts', 'people', $this->settings->get('records_per_page'), 'admin/people/contacts/index', true, $extra);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Create a new contact
	 *
	 * @access public
	 * @return void
	 */
	public function create()
	{

		// Set the title
		$this->template->title(lang('people:title:create_contact'));

		// Make the name
		if ( ! empty($_POST) ) $_POST['name'] = $_POST['first_name'].' '.$_POST['last_name'];

		/* Start normal Streams_Core stuff
		-----------------------------------*/

		// Set some shit
		$extra = array(
			'return'			=> 'admin/people/contacts/view/-id-',
			'title'				=> lang('people:title:create_contact'),
		);


		// Build it
		$this->streams->cp->entry_form('contacts', 'people', $mode = 'new', null, true, $extra, array(), $this->tabs, $hidden = array('str_id'), $defaults = array('str_id' => rand_string(20)));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Edit a contact
	 *
	 * @access public
	 * @return void
	 */
	public function edit($id)
	{

		// Set the title
		$this->template->title(lang('people:title:edit_contact'));

		// Make the name
		if ( ! empty($_POST) ) $_POST['name'] = $_POST['first_name'].' '.$_POST['last_name'];

		/* Start normal Streams_Core stuff
		-----------------------------------*/

		// Set some shit
		$extra = array(
			'return'			=> 'admin/people/contacts/view/-id-',
			'title'				=> lang('people:title:edit_contact'),
		);


		// Build it
		$this->streams->cp->entry_form('contacts', 'people', $mode = 'edit', $id, true, $extra, array('str_id'), $this->tabs);
	}

	// --------------------------------------------------------------------------

	/**
	 * View a contact
	 *
	 * @access	public
	 * @return	void
	 */
	public function view($id)
	{

		// From cancelling a form?
		if ( $id == '-id-' ) redirect(site_url('admin/people/contacts'));


		// Get the entry
		$contact = $this->streams->entries->get_entry($id, 'contacts', 'people');

		// Get the company too
		if ( ! empty($contact->company) )
		{

			// Get the company ID
			$company_id = $this->db->select('company')->where('id', $id)->limit(1)->get('people_contacts')->row(0)->company;

			// Load the company
			$company = $this->streams->entries->get_entry($company_id, 'companies', 'people');
		}
		else
		{
			$company = array();
		}

		$this->template->build('admin/contacts/view', array('contact' => $contact, 'company' => $company));
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a contact
	 *
	 * @access	public
	 * @return	void
	 */
	public function delete($id)
	{

		// Delete the entry
		$this->streams->entries->delete_entry($id, 'contacts', 'people');

		// Delete search index
		$this->db->delete('search_index', array('module' => 'people', 'entry_key' => 'contact', 'entry_id' => $id));

		redirect(site_url('admin/people/contacts'));
	}
}