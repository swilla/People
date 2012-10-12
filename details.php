<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_People extends Module {

	public $version = '0.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'People'
			),
			'description' => array(
				'en' => 'Manage your contact and company relationships.'
			),
			'skip_xss' => false,
			'default_install' => false,
			'frontend' => true,
			'backend' => true,
			'menu' => 'Applications',
			'sections' => array(
				
				'contacts' => array(
					'name' 	=> 'people:section:contacts',
					'uri' 	=> 'admin/people/contacts',
					'shortcuts' => array(
						'create_contact' => array(
							'name' 	=> 'people:button:create_contact',
							'uri' 	=> 'admin/people/contacts/create',
							'class' => 'add'
							),
						'create_company' => array(
							'name' 	=> 'people:button:create_company',
							'uri' 	=> 'admin/people/companies/create',
							'class' => 'add'
							),
						),
					),// eof contacts section

				'companies' => array(
					'name' 	=> 'people:section:companies',
					'uri' 	=> 'admin/people/companies',
					'shortcuts' => array(
						'create_contact' => array(
							'name' 	=> 'people:button:create_contact',
							'uri' 	=> 'admin/people/contacts/create',
							'class' => 'add'
							),
						'create_company' => array(
							'name' 	=> 'people:button:create_company',
							'uri' 	=> 'admin/people/companies/create',
							'class' => 'add'
							),
						),
					),// eof companies section

				),// Eof sections
		);
	}

	public function install()
	{

		// Let's do this...
		$this->load->helper('people/people');
		$this->lang->load('people/people');
		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		$this->load->library('files/Files');



		/* Install settings
		----------------------------------------------------------------------------*/

		/* Remove any old settings
		$this->db->delete('settings', array('module' => 'store'));

		$settings = array(
			array(
				'slug' => 'payments_mode',
				'title' => lang('people:settings:payments_mode'),
				'description' => lang('people:settings:payments_mode_instructions'),
				'`default`' => 'test',
				'`value`' => 'test',
				'type' => 'select',
				'`options`' => 'test='.lang('people:settings:payments_mode_test').'|production='.lang('people:settings:payments_mode_production').'',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'payments'
				),
			array(
				'slug' => 'payments_force_ssl',
				'title' => lang('people:settings:force_ssl'),
				'description' => lang('people:settings:force_ssl_instructions'),
				'`default`' => '0',
				'`value`' => '0',
				'type' => 'select',
				'`options`' => '1='.lang('people:misc:enabled').'|0='.lang('people:misc:disabled'),
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'payments'
				),
			array(
				'slug' => 'payments_ssl_domain',
				'title' => lang('people:settings:ssl_domain'),
				'description' => lang('people:settings:ssl_domain_instructions'),
				'`default`' => '',
				'`value`' => str_replace(array('http://', 'https://'), array('',''), strtolower(trim(BASE_URL, '/'))),
				'type' => 'text',
				'`options`' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'payments'
				),
			);// Eof settings
		
		// Try installing the settings
		foreach ($settings as $setting)
		{
			log_message('debug', '-- Settings: installing '.$setting['slug']);

			if ( ! $this->db->insert('settings', $setting))
			{
				log_message('debug', '-- -- could not install '.$setting['slug']);
				return false;
			}
		}*/



		
		/* Install System Folders
		----------------------------------------------------------------------------*/


		// Add the "People Module" folder
		$folders['people_module'] = $this->files->create_folder(0, lang('people:folder:people_module'), 'local', '');

		// Add the "Profile Images" folder
		$folders['profile_images'] = $this->files->create_folder($folders['people_module']['data']['id'], lang('people:folder:profile_images'), 'local', '');

		// Add the "Contacts" folder
		$folders['contacts'] = $this->files->create_folder($folders['people_module']['data']['id'], lang('people:folder:contacts'), 'local', '');

		// Add the "Companies" folder
		$folders['companies'] = $this->files->create_folder($folders['people_module']['data']['id'], lang('people:folder:companies'), 'local', '');





		/* Install Streams Data
		----------------------------------------------------------------------------*/

		// Load streams driver
		$this->load->driver('Streams');

		// Add Contacts Entries
		$this->streams->streams->add_stream('Contacts', 'contacts', 'people', 'people_', NULL);
		$this->streams->streams->update_stream('contacts', 'people', array('stream_prefix' => 'people_', 'view_options' => array('first_name', 'last_name')));

		// Add Companies Logs
		$this->streams->streams->add_stream('Companies', 'companies', 'people', 'people_', NULL);
		$this->streams->streams->update_stream('companies', 'people', array('stream_prefix' => 'people_', 'view_options' => array('name')));

		// Get some info for later
		$streams['companies'] = $this->streams->streams->get_stream('companies', 'people');


		// Build the fields
		$fields = array(
			array(
				'name'			=> 'lang:people:str_id',
				'slug'			=> 'str_id',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:profile_image',
				'slug'			=> 'profile_image',
				'namespace'		=> 'people',
				'type'			=> 'image',
				'extra'			=> array('folder' => $folders['profile_images']['data']['id'], 'resize_width' => '150'),
				),
			

			/* Contact Information */
			array(
				'name'			=> 'lang:people:name',
				'slug'			=> 'name',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			
			array(
				'name'			=> 'lang:people:first_name',
				'slug'			=> 'first_name',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:last_name',
				'slug'			=> 'last_name',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:title',
				'slug'			=> 'title',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:company',
				'slug'			=> 'company',
				'namespace'		=> 'people',
				'type'			=> 'relationship',
				'extra'		 	=> array('choose_stream' => $streams['companies']->id, 'link_uri' => 'admin/people/companies/-entry_id-'),
				),
			array(
				'name'			=> 'lang:people:phone',
				'slug'			=> 'phone',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:mobile',
				'slug'			=> 'mobile',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:fax',
				'slug'			=> 'fax',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:email',
				'slug'			=> 'email',
				'namespace'		=> 'people',
				'type'			=> 'email',
				),
			array(
				'name'			=> 'lang:people:website',
				'slug'			=> 'website',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),


			/* Address */
			array(
				'name'			=> lang('people:street'),
				'slug'			=> 'street',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:street_extra'),
				'slug'			=> 'street_extra',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:city'),
				'slug'			=> 'city',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:state'),
				'slug'			=> 'state',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:postal_code'),
				'slug'			=> 'postal_code',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:country'),
				'slug'			=> 'country',
				'namespace'		=> 'people',
				'type'			=> 'country',
				'extra'			=> array('default_value' => 'US'),
				),



			/* Billing Address */
			array(
				'name'			=> lang('people:billing_street'),
				'slug'			=> 'billing_street',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:billing_street_extra'),
				'slug'			=> 'billing_street_extra',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:billing_city'),
				'slug'			=> 'billing_city',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:billing_state'),
				'slug'			=> 'billing_state',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:billing_postal_code'),
				'slug'			=> 'billing_postal_code',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> lang('people:billing_country'),
				'slug'			=> 'billing_country',
				'namespace'		=> 'people',
				'type'			=> 'country',
				'extra'			=> array('default_value' => 'US'),
				),


			/* Social */
			array(
				'name'			=> 'lang:people:facebook',
				'slug'			=> 'facebook',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:twitter',
				'slug'			=> 'twitter',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),
			array(
				'name'			=> 'lang:people:linkedin',
				'slug'			=> 'linkedin',
				'namespace'		=> 'people',
				'type'			=> 'text',
				),


			/* Other */
			array(
				'name'			=> 'lang:people:source',
				'slug'			=> 'source',
				'namespace'		=> 'people',
				'type'			=> 'choice',
				'extra'		 	=> array('choice_type' => 'dropdown', 'choice_data' => lang('people:choice:source')),
				),
			array(
				'name'			=> 'lang:people:industry',
				'slug'			=> 'industry',
				'namespace'		=> 'people',
				'type'			=> 'choice',
				'extra'		 	=> array('choice_type' => 'dropdown', 'choice_data' => lang('people:choice:industry')),
				),
			array(
				'name'			=> 'lang:people:user',
				'slug'			=> 'user',
				'namespace'		=> 'people',
				'type'			=> 'user',
				),
			array(
				'name'			=> 'lang:people:background',
				'slug'			=> 'background',
				'namespace'		=> 'people',
				'type'			=> 'textarea',
				),
			array(
				'name'			=> 'lang:people:keywords',
				'slug'			=> 'keywords',
				'namespace'		=> 'people',
				'type'			=> 'keywords',
				),
			);

		// Add all the fields
		$this->streams->fields->add_fields($fields);



		/*
		 * Add the folder field_types
		----------------------------------------------------------------------*/

		// Get the IDs we need
		$fields['first_name'] = $this->db->select('id')->where('field_namespace', 'people')->where('field_slug', 'first_name')->limit(1)->get('data_fields')->row(0);
		$fields['last_name'] = $this->db->select('id')->where('field_namespace', 'people')->where('field_slug', 'last_name')->limit(1)->get('data_fields')->row(0);
		$fields['name'] = $this->db->select('id')->where('field_namespace', 'people')->where('field_slug', 'name')->limit(1)->get('data_fields')->row(0);

		// Add em up
		$fields = array(
			array(
				'name'			=> 'lang:people:contact_files',
				'slug'			=> 'contact_files',
				'namespace'		=> 'people',
				'type'			=> 'folder',
				'extra'		 	=> array('parent_folder' => $folders['people_module']['data']['id'], 'naming_format' => $fields['first_name']->id.','.$fields['last_name']->id, 'when_deleted' => 'delete'),
				),
			array(
				'name'			=> 'lang:people:company_files',
				'slug'			=> 'company_files',
				'namespace'		=> 'people',
				'type'			=> 'folder',
				'extra'		 	=> array('parent_folder' => $folders['people_module']['data']['id'], 'naming_format' => $fields['name']->id, 'when_deleted' => 'delete'),
				),
			);

		// Add all the fields
		$this->streams->fields->add_fields($fields);




		/* Contacts assignments
		-----------------------------------------------------------*/
		$this->streams->fields->assign_field('people', 'contacts', 'str_id', 						array('required' => true, 'unique' => true, 'instructions' => lang('people:instructions:str_id')));
		$this->streams->fields->assign_field('people', 'contacts', 'name',							array('required' => true, 'title_column' => true, 'instructions' => lang('people:instructions:name')));
		$this->streams->fields->assign_field('people', 'contacts', 'first_name', 					array('required' => true, 'instructions' => lang('people:instructions:first_name')));
		$this->streams->fields->assign_field('people', 'contacts', 'last_name',						array('instructions' => lang('people:instructions:last_name')));
		$this->streams->fields->assign_field('people', 'contacts', 'title', 						array('instructions' => lang('people:instructions:title')));
		$this->streams->fields->assign_field('people', 'contacts', 'company', 						array('instructions' => lang('people:instructions:company')));
		$this->streams->fields->assign_field('people', 'contacts', 'phone', 						array('instructions' => lang('people:instructions:phone')));
		$this->streams->fields->assign_field('people', 'contacts', 'mobile', 						array('instructions' => lang('people:instructions:mobile')));
		$this->streams->fields->assign_field('people', 'contacts', 'email', 						array('instructions' => lang('people:instructions:email')));
		$this->streams->fields->assign_field('people', 'contacts', 'website', 						array('instructions' => lang('people:instructions:website')));
		$this->streams->fields->assign_field('people', 'contacts', 'street', 						array('instructions' => lang('people:instructions:street')));
		$this->streams->fields->assign_field('people', 'contacts', 'street_extra',					array('instructions' => lang('people:instructions:street_extra')));
		$this->streams->fields->assign_field('people', 'contacts', 'city',							array('instructions' => lang('people:instructions:city')));
		$this->streams->fields->assign_field('people', 'contacts', 'state',							array('instructions' => lang('people:instructions:state')));
		$this->streams->fields->assign_field('people', 'contacts', 'postal_code',					array('instructions' => lang('people:instructions:postal_code')));
		$this->streams->fields->assign_field('people', 'contacts', 'country',						array('instructions' => lang('people:instructions:country')));
		$this->streams->fields->assign_field('people', 'contacts', 'billing_street', 				array('instructions' => lang('people:instructions:billing_street')));
		$this->streams->fields->assign_field('people', 'contacts', 'billing_street_extra',			array('instructions' => lang('people:instructions:billing_street_extra')));
		$this->streams->fields->assign_field('people', 'contacts', 'billing_city',					array('instructions' => lang('people:instructions:billing_city')));
		$this->streams->fields->assign_field('people', 'contacts', 'billing_state',					array('instructions' => lang('people:instructions:billing_state')));
		$this->streams->fields->assign_field('people', 'contacts', 'billing_postal_code',			array('instructions' => lang('people:instructions:billing_postal_code')));
		$this->streams->fields->assign_field('people', 'contacts', 'billing_country',				array('instructions' => lang('people:instructions:billing_country')));
		$this->streams->fields->assign_field('people', 'contacts', 'facebook',						array('instructions' => lang('people:instructions:facebook')));
		$this->streams->fields->assign_field('people', 'contacts', 'twitter',						array('instructions' => lang('people:instructions:twitter')));
		$this->streams->fields->assign_field('people', 'contacts', 'linkedin',						array('instructions' => lang('people:instructions:linkedin')));
		$this->streams->fields->assign_field('people', 'contacts', 'source', 						array('instructions' => lang('people:instructions:source')));
		$this->streams->fields->assign_field('people', 'contacts', 'user',	 						array('instructions' => lang('people:instructions:user')));
		$this->streams->fields->assign_field('people', 'contacts', 'background',					array('instructions' => lang('people:instructions:background')));
		$this->streams->fields->assign_field('people', 'contacts', 'keywords', 						array('instructions' => lang('people:instructions:keywords')));
		$this->streams->fields->assign_field('people', 'contacts', 'contact_files',					array('instructions' => lang('people:instructions:contact_files')));
		$this->streams->fields->assign_field('people', 'contacts', 'profile_image',					array('instructions' => lang('people:instructions:profile_image')));

		


		/* Payments assignments
		-----------------------------------------------------------*/
		$this->streams->fields->assign_field('people', 'companies', 'str_id', 						array('required' => true, 'unique' => true, 'instructions' => lang('people:instructions:str_id')));
		$this->streams->fields->assign_field('people', 'companies', 'name', 						array('required' => true, 'title_column' => true, 'unique' => true, 'instructions' => lang('people:instructions:name')));
		$this->streams->fields->assign_field('people', 'companies', 'phone', 						array('instructions' => lang('people:instructions:phone')));
		$this->streams->fields->assign_field('people', 'companies', 'mobile', 						array('instructions' => lang('people:instructions:mobile')));
		$this->streams->fields->assign_field('people', 'companies', 'email', 						array('instructions' => lang('people:instructions:email')));
		$this->streams->fields->assign_field('people', 'companies', 'website', 						array('instructions' => lang('people:instructions:website')));
		$this->streams->fields->assign_field('people', 'companies', 'street', 						array('instructions' => lang('people:instructions:street')));
		$this->streams->fields->assign_field('people', 'companies', 'street_extra',					array('instructions' => lang('people:instructions:street_extra')));
		$this->streams->fields->assign_field('people', 'companies', 'city',							array('instructions' => lang('people:instructions:city')));
		$this->streams->fields->assign_field('people', 'companies', 'state',						array('instructions' => lang('people:instructions:state')));
		$this->streams->fields->assign_field('people', 'companies', 'postal_code',					array('instructions' => lang('people:instructions:postal_code')));
		$this->streams->fields->assign_field('people', 'companies', 'country',						array('instructions' => lang('people:instructions:country')));
		$this->streams->fields->assign_field('people', 'companies', 'facebook',						array('instructions' => lang('people:instructions:facebook')));
		$this->streams->fields->assign_field('people', 'companies', 'twitter',						array('instructions' => lang('people:instructions:twitter')));
		$this->streams->fields->assign_field('people', 'companies', 'linkedin',						array('instructions' => lang('people:instructions:linkedin')));
		$this->streams->fields->assign_field('people', 'companies', 'source', 						array('instructions' => lang('people:instructions:source')));
		$this->streams->fields->assign_field('people', 'companies', 'industry', 					array('instructions' => lang('people:instructions:industry')));
		$this->streams->fields->assign_field('people', 'companies', 'background',					array('instructions' => lang('people:instructions:background')));
		$this->streams->fields->assign_field('people', 'companies', 'keywords', 					array('instructions' => lang('people:instructions:keywords')));
		$this->streams->fields->assign_field('people', 'companies', 'company_files',				array('instructions' => lang('people:instructions:company_files')));
		$this->streams->fields->assign_field('people', 'companies', 'profile_image',				array('instructions' => lang('people:instructions:profile_image')));



		/* Set up some keys for back-end tables
		-----------------------------------------------------------*/
		
		// For products
		//$this->db->query('ALTER TABLE `'.$this->db->dbprefix('store_products').'` ADD INDEX `Product Name` (`name`)');
		



		// Good to go
		return true;
	}

	public function uninstall()
	{

		/*	Remove Module Settings
		------------------------------------------------------------------*/

		// Delete calendars module settings
		$this->db->delete('settings', array('module' => 'people'));



		/*	Remove Streams Data
		------------------------------------------------------------------*/

		// Load the Streams Core
		$this->load->driver('Streams');

		// Remove streams and destruct everything
		$this->streams->utilities->remove_namespace('people');



		/*	Remove Search Data
		------------------------------------------------------------------*/

		$this->db->delete('search_index', array('module' => 'people'));


		// Weeeeeeee
		return true;
	}


	public function upgrade($old_version)
	{
		// Load the Streams Core
		$this->load->driver('Streams');

		return true;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "";
	}
}
/* End of file details.php */
