<div class="one_whole">

	<section class="title">
		<h4><?php echo lang('people:title:view_contact'); ?></h4>
	</section>

	<section class="item entry-view-wrapper">
		
		<!-- Left Portion -->
		<section class="left">

			<!-- Profile Image -->
			<?php if ( ! empty($company->profile_image) ):?>
				<?php //echo site_url('files/thumb/'.$company->profile_image); ?>
				<img src="<?php echo $this->module_details['path'].'/img/no-image.png'; ?>" class="profile-image">
			<?php else: ?>
				<img src="<?php echo $this->module_details['path'].'/img/no-image.png'; ?>" class="profile-image">
			<?php endif; ?>

			<!-- Name -->
			<h1 class="name"><?php echo $contact->first_name.' '.$contact->last_name; ?></h1>

			<!-- Title / Company -->
			<p><?php echo $contact->title.( ( ! empty($contact->title) AND is_object($company) ) ? lang('people:misc:at_spacer') : '').(is_object($company)?anchor(site_url('admin/people/companies/view/'.$company->id), $company->name):null); ?></p>

			<br>

			<div class="tabs">

				<ul class="tab-menu">
				
					<li>
						<a href="#comments-tab">
							<span><?php echo lang('comments:title'); ?></span>
						</a>
					</li>

					<!-- Tasks Tab -->
					<?php if( module_installed('tasks') ): ?>
					<li>
						<a href="#tasks-tab">
							<span><?php echo lang('tasks:title:tasks'); ?></span>
						</a>
					</li>
					<?php endif; ?>
				
				</ul>

				
				<!-- Comments -->
				<div class="form_inputs" id="comments-tab">
				
					<fieldset>

						<?php

							$this->load->library(
								'comments/comments',
								array(
									'module' => 'people',
									'singular' => 'contact',
									'plural' => 'contacts',
									'entry_id' => $contact->id,
									'entry_title' => $contact->first_name.' '.$contact->last_name
									)
								);

							echo $this->comments->display();

							echo $this->comments->form();
						?>

					</fieldset>

				</div>


				<!-- Tasks -->
				<?php if( module_installed('tasks') ): ?>
				<div class="form_inputs" id="tasks-tab">
				
					<fieldset>

						<?php

							$this->load->library('tasks/tasks', array('module' => 'people', 'singular' => 'contact', 'plural' => 'contacts', 'entry_id' => $contact->id));

							echo $this->tasks->display();

							echo '<br>';

							echo '<h4>'.lang('tasks:title:create_task').'</h4>';

							echo $this->tasks->form();
						?>

					</fieldset>

				</div>
				<?php endif; ?>


			</div>

		</section>
		<!-- /Left Portion -->


		<!-- Right Portion -->
		<aside class="right">

			<!-- Edit this contact -->
			<p class="ntm"><?php echo anchor(site_url('admin/people/contacts/edit/'.$contact->id), lang('people:link:edit_this_contact'), 'style="color:red;"'); ?></p>

			

			<!-- Tasks - Mini-Heading -->
			<div class="mini-heading"><span><?php echo lang('tasks:title:tasks'); ?></span></div>

			<!-- Small Tasks List -->
			<?php if( module_installed('tasks') ): ?>

				<?php echo $this->tasks->display(); ?>

				<br>

			<?php else: ?>
				<p><?php echo lang('people:error_install_tasks'); ?></p>
			<?php endif; ?>
			<!-- /Small Tasks List -->



			<!-- Contact Information - Mini-Heading -->
			<div class="mini-heading"><span><?php echo lang('people:title:contact_information'); ?></span></div>

			<!-- Email -->
			<?php if ( ! empty($contact->email) ) : ?>
				<p><?php echo anchor('mailto:'.$contact->email, $contact->email); ?> <span class="muted"><?php echo lang('people:email'); ?></span></p>
			<?php endif; ?>

			<!-- Phone -->
			<p>
			<?php if ( ! empty($contact->phone) ) : ?>
				<?php echo $contact->phone; ?> <span class="muted"><?php echo lang('people:phone'); ?></span><br>
			<?php endif; ?>

			<!-- Mobile -->
			<?php if ( ! empty($contact->mobile) ) : ?>
				<?php echo $contact->mobile; ?> <span class="muted"><?php echo lang('people:mobile'); ?></span>
			<?php endif; ?>
			</p>

			<!-- Website -->
			<?php if ( ! empty($contact->website) ) : ?>
				<p><?php echo anchor($contact->website, $contact->website); ?> <span class="muted"><?php echo lang('people:website'); ?></span></p>
			<?php endif; ?>

			<!-- Address -->
			<?php if ( ! empty($contact->street) ) : ?>
				<p>
					<span class="muted"><?php echo lang('people:title:address'); ?></span>
					<br>
					<a 
						href="https://maps.google.com/maps?q=<?php echo urlencode($contact->street.' '.$contact->city.', '.$contact->state.' '.$contact->postal_code.' '.$contact->country); ?>" 
						style="background-image:url(https://maps.google.com/maps/api/staticmap?center=<?php echo str_replace('+', '%20', urlencode($contact->street.' '.$contact->city.', '.$contact->state.' '.$contact->postal_code.' '.$contact->country)); ?>&amp;size=189x90&amp;sensor=false&amp;maptype=terrain&amp;markers=size:small|color:red|<?php echo str_replace('+', '%20', urlencode($contact->street.' '.$contact->city.', '.$contact->state.' '.$contact->postal_code.' '.$contact->country)); ?>);"
						class="map"
						target="_blank">
					</a>
					<br>
					<?php echo $contact->street; ?><br>
					<?php if ( ! empty($contact->street_extra) ) echo '<br>'.$contact->street_extra; ?>
					<?php echo $contact->city; ?>, <?php echo $contact->state; ?> <?php echo $contact->postal_code; ?>
				</p>
			<?php endif; ?>

			<!-- Billing Address -->
			<?php if ( ! empty($contact->billing_street) ) : ?>
				<p>
					<span class="muted"><?php echo lang('people:title:billing_address'); ?></span>
					<br>
					<a 
						href="https://maps.google.com/maps?q=<?php echo urlencode($contact->billing_street.' '.$contact->billing_city.', '.$contact->billing_state.' '.$contact->billing_postal_code.' '.$contact->billing_country); ?>" 
						style="background-image:url(https://maps.google.com/maps/api/staticmap?center=<?php echo str_replace('+', '%20', urlencode($contact->billing_street.' '.$contact->billing_city.', '.$contact->billing_state.' '.$contact->billing_postal_code.' '.$contact->billing_country)); ?>&amp;size=189x90&amp;sensor=false&amp;maptype=terrain&amp;markers=size:small|color:red|<?php echo str_replace('+', '%20', urlencode($contact->billing_street.' '.$contact->billing_city.', '.$contact->billing_state.' '.$contact->billing_postal_code.' '.$contact->billing_country)); ?>);"
						class="map"
						target="_blank">
					</a>
					<br>
					<?php echo $contact->billing_street; ?><br>
					<?php if ( ! empty($contact->billing_street_extra) ) echo '<br>'.$contact->billing_street_extra; ?>
					<?php echo $contact->billing_city; ?>, <?php echo $contact->billing_state; ?> <?php echo $contact->billing_postal_code; ?>
				</p>
			<?php endif; ?>

			<!-- Background -->
			<?php if ( ! empty($contact->background) ) : ?>
				<p><span class="muted"><?php echo lang('people:background'); ?><br></span><?php echo nl2br($contact->background); ?></p>
			<?php endif; ?>

			

			<!-- Company Details -->
			<?php if ( is_object($company) ): ?>
			<div class="mini-heading"><span><strong><?php echo $company->name.'</strong> '.lang('people:label_information'); ?></span></div>

			<!-- Email -->
			<?php if ( ! empty($company->email) ) : ?>
				<p><?php echo anchor('mailto:'.$company->email, $company->email); ?> <span class="muted"><?php echo lang('people:email'); ?></span></p>
			<?php endif; ?>

			<!-- Phone -->
			<?php if ( ! empty($company->phone) ) : ?>
				<p><?php echo $company->phone; ?> <span class="muted"><?php echo lang('people:phone'); ?></span></p>
			<?php endif; ?>

			<!-- Website -->
			<?php if ( ! empty($company->website) ) : ?>
				<p><?php echo anchor($company->website, $company->website); ?> <span class="muted"><?php echo lang('people:website'); ?></span></p>
			<?php endif; ?>

			<!-- Address -->
			<?php if ( ! empty($company->street) ) : ?>
				<p>
					<span class="muted"><?php echo lang('people:title:address'); ?></span>
					<br>
					<a 
						href="https://maps.google.com/maps?q=<?php echo urlencode($company->street.' '.$company->city.', '.$company->state.' '.$company->postal_code.' '.$company->country); ?>" 
						style="background-image:url(https://maps.google.com/maps/api/staticmap?center=<?php echo str_replace('+', '%20', urlencode($company->street.' '.$company->city.', '.$company->state.' '.$company->postal_code.' '.$company->country)); ?>&amp;size=189x90&amp;sensor=false&amp;&zoom=13&amp;maptype=terrain&amp;markers=size:small|color:red|<?php echo str_replace('+', '%20', urlencode($company->street.' '.$company->city.', '.$company->state.' '.$company->postal_code.' '.$company->country)); ?>);"
						class="map"
						target="_blank">
					</a>
					<br>
					<?php echo $company->street; ?>
					<?php if ( ! empty($company->street_extra) ) echo '<br>'.$company->street_extra; ?>
					<?php echo $company->city; ?>, <?php echo $company->state; ?> <?php echo $company->postal_code; ?>
				</p>
			<?php endif; ?>

			<!-- Background -->
			<?php if ( ! empty($company->background) ) : ?>
				<p><span class="muted"><?php echo lang('people:background'); ?><br></span><?php echo nl2br($company->background); ?></p>
			<?php endif; ?>
			<?php endif; ?>

		</aside>
		<!-- /Right Portion -->

	<div class="clearfix"></div>
	</section>

</div>	