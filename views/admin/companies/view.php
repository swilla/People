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
						<a href="#comments-tab" title="<?php echo lang('people:tab:comments'); ?>">
							<span><?php echo lang('people:tab:comments'); ?> <span class="count">(<?php //echo count_comments($company->id, 'companies-company', true); ?>)</span></span>
						</a>
					</li>

					<li>
						<a href="#tasks-tab" title="<?php echo lang('people:tab:tasks'); ?>">
							<span><?php echo lang('people:tab:tasks'); ?> <span class="count">(<?php //echo count_tasks($company->id, 'companies-company', true); ?>)</span></span>
						</a>
					</li>
				
				</ul>

				
				<!-- Comments -->
				<div class="form_inputs" id="comments-tab">
				
					<fieldset>

						<?php //echo display_comments($company->id, 'companies-company'); ?>

					</fieldset>

				</div>


				<!-- Tasks -->
				<div class="form_inputs" id="tasks-tab">
				
					<fieldset>

						<?php //echo display_tasks($company->id, 'companies-company'); ?>

					</fieldset>

				</div>


			</div>

		</section>
		<!-- /Left Portion -->


		<!-- Right Portion -->
		<aside class="right">

			<!-- Edit this company -->
			<p class="ntm"><?php echo anchor(site_url('admin/people/companies/edit/'.$company->id), lang('people:link:edit_this_company'), 'style="color:red;"'); ?></p>

			

			<!-- Tasks - Mini-Heading -->
			<div class="mini-heading"><span><?php echo lang('people:title:tasks'); ?></span></div>

			<!-- Small Tasks List -->
			<?php if( module_installed('tasks') ): ?>
			<?php echo display_tasks($company->id, 'companies-company', false); ?>
			<?php else: ?>
			<p><?php echo lang('people:error_install_tasks'); ?></p>
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