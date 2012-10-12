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
class companies extends Admin_Controller
{
	
	// Set the section	
	protected $section = 'companies';

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
				'title' 	=> lang('people:tab:company_information'),
				'id'		=> 'contact-information-tab',
				'fields'	=> array('str_id', 'profile_image', 'name', 'company', 'phone', 'mobile', 'fax', 'email', 'website'),
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
				'fields'	=> array('source', 'industry', 'industry', 'user', 'background', 'keywords'),
				),
			array(
				'title' 	=> lang('people:tab:files'),
				'id'		=> 'files-tab',
				'fields'	=> array('company_files'),
				),
			);

		// Always load these
		$this->template
			->append_css('module::admin.css')
			->append_js('module::admin.js');
	}

	// --------------------------------------------------------------------------

	/**
	 * List all existing companies
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{

		// Set the title
		$this->template->title(lang('people:title:companies'));

		// Set some extras
		$extra = array(
			'title'		=> lang('people:title:companies'),
			'buttons'	=> array(
				array(
					'label' 	=> lang('global:view'),
					'url' 		=> 'admin/people/companies/view/-entry_id-',
					),
				array(
					'label' 	=> lang('global:edit'),
					'url' 		=> 'admin/people/companies/edit/-entry_id-',
					),
				array(
					'label'		=> lang('global:delete'),
					'url' 		=> 'admin/people/companies/delete/-entry_id-',
					'confirm'	=> true,
					),
				),
			'filters'	=> array(),
			);
		
		$this->streams->cp->entries_table('companies', 'people', $this->settings->get('records_per_page'), 'admin/people/companies/index', true, $extra);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Create a new company
	 *
	 * @access public
	 * @return void
	 */
	public function create()
	{

		// Set the title
		$this->template->title(lang('people:title:create_company'));


		/* Start normal Streams_Core stuff
		-----------------------------------*/

		// Set some shit
		$extra = array(
			'return'			=> 'admin/people/companies/view/-id-',
			'title'				=> lang('people:title:create_company'),
		);


		// Build it
		$this->streams->cp->entry_form('companies', 'people', $mode = 'new', null, true, $extra, array(), $this->tabs, $hidden = array('str_id'), $defaults = array('str_id' => rand_string(20)));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Edit a company
	 *
	 * @access public
	 * @return void
	 */
	public function edit($id)
	{

		// Set the title
		$this->template->title(lang('people:title:edit_company'));



		/* Start normal Streams_Core stuff
		-----------------------------------*/

		// Set some shit
		$extra = array(
			'return'			=> 'admin/people/companies/view/-id-',
			'title'				=> lang('people:title:edit_company'),
		);


		// Build it
		$this->streams->cp->entry_form('companies', 'people', $mode = 'edit', $id, true, $extra, array('str_id'), $this->tabs);
	}

	// --------------------------------------------------------------------------

	/**
	 * View a company
	 *
	 * @access	public
	 * @return	void
	 */
	public function view($id)
	{

		// From cancelling a form?
		if ( $id == '-id-' ) redirect(site_url('admin/people/companies'));


		// Get the entry
		$company = $this->streams->entries->get_entry($id, 'companies', 'people');

		// Get any contacts
		$contacts = $this->streams->entries->get_entries(
			array(
				'stream' => 'contacts',
				'namespace' => 'people',
				'where' => '`company` = '.$id,
				)
			);

		$this->template->build('admin/companies/view', array('company' => $company, 'contacts' => $contacts));
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a company
	 *
	 * @access	public
	 * @return	void
	 */
	public function delete($id)
	{

		// Delete the entry
		$this->streams->entries->delete_entry($id, 'companies', 'people');

		// Delete search index
		$this->db->delete('search_index', array('module' => 'people', 'entry_key' => 'company', 'entry_id' => $id));

		redirect(site_url('admin/people/companies'));
	}
}