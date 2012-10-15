<div class="one_whole">

	<section class="title">
		<h4><?php echo lang('people:title:view_company'); ?></h4>
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
			<h1 class="name"><?php echo $company->name; ?></h1>

			<!-- Endustry -->
			<p><?php echo $company->industry; ?></p>

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
									'singular' => 'company',
									'plural' => 'companies',
									'entry_id' => $company->id,
									'entry_title' => $company->name
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

							$this->load->library('tasks/tasks', array('module' => 'people', 'singular' => 'company', 'plural' => 'companies', 'entry_id' => $company->id));

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

			<!-- Edit this company -->
			<p class="ntm"><?php echo anchor(site_url('admin/people/companies/edit/'.$company->id), lang('people:link:edit_this_company'), 'style="color:red;"'); ?></p>

			

			<!-- Tasks - Mini-Heading -->
			<div class="mini-heading"><span><?php echo lang('tasks:title:tasks'); ?></span></div>

			<!-- Small Tasks List -->
			<?php if( module_installed('tasks') ): ?>

				<?php echo $this->tasks->display(); ?>

				<br>

			<?php else: ?>

				<?php echo lang('people:notification:install_tasks'); ?>

				<br>

			<?php endif; ?>
			<!-- /Small Tasks List -->



			<!-- company Information - Mini-Heading -->
			<div class="mini-heading"><span><?php echo lang('people:title:company_information'); ?></span></div>

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
						style="background-image:url(https://maps.google.com/maps/api/staticmap?center=<?php echo str_replace('+', '%20', urlencode($company->street.' '.$company->city.', '.$company->state.' '.$company->postal_code.' '.$company->country)); ?>&amp;size=189x90&amp;sensor=false&amp;maptype=terrain&amp;markers=size:small|color:red|<?php echo str_replace('+', '%20', urlencode($company->street.' '.$company->city.', '.$company->state.' '.$company->postal_code.' '.$company->country)); ?>);"
						class="map"
						target="_blank">
					</a>
					<br>
					<?php echo $company->street; ?><br>
					<?php if ( ! empty($company->street_extra) ) echo '<br>'.$company->street_extra; ?>
					<?php echo $company->city; ?>, <?php echo $company->state; ?> <?php echo $company->postal_code; ?>
				</p>
			<?php endif; ?>

			<!-- Background -->
			<?php if ( ! empty($company->background) ) : ?>
				<p><span class="muted"><?php echo lang('people:background'); ?><br></span><?php echo nl2br($company->background); ?></p>
			<?php endif; ?>

			

			<!-- Contacts -->
			<?php if ( ! empty($contacts['entries']) ): ?>
			<div class="mini-heading"><span><strong><?php echo $company->name.'</strong> '.strtolower(lang('people:title:contacts')); ?></span></div>

				<!-- Loop Em -->
				<?php foreach( $contacts['entries'] as $contact ): ?>

				<p class="ntm"><?php echo anchor(site_url('admin/people/contacts/view/'.$contact['id']), $contact['first_name'].' '.$contact['last_name']).' <span style="color: #777;">'.$contact['title'].'</span>'; ?></p>

			<?php endforeach; ?>

			<?php endif; ?>
			<!-- /Contacts -->

		</aside>
		<!-- /Right Portion -->

	<div class="clearfix"></div>
	</section>

</div>	