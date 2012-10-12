<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * People Module
 *
 * @author 		Ryan Thompson - AI Web Systems, Inc.
 * @subpackage 	People Module
 * @category 	Modules
 */
class Dashboard extends Admin_Controller
{
	
	// Set the current section
	protected $section  = 'dashboard';
	

	public function __construct()
	{
		parent::__construct();
		
		// Load all the required classes
		$this->lang->load('people');
		$this->load->helper('people');
		$this->load->driver('streams');
	}

	/**
	 * Todo
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{

		// Not ready for this..
		redirect(site_url('admin/people/contacts'));
		return false;
	}
}

