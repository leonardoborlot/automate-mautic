<?php
/**
 * Handle rules panel
 *
 * @package automate-mautic
 * @since 1.0.0
 */

?>
<div id="ap-mautic-post-meta" class="ap-settings-form wp-core-ui">
	<form class="ap-mautic-post-meta" action="#" method="post">
		<?php
		if ( isset( $_GET['post'] ) ) {
			$post_id = esc_attr( $_GET['post'] );
			$rule_title = get_the_title( $post_id );
		} else {
			$rule_title = '';
		}
		?>
		<div class="wrap">
			<input type="text" name="ampw_rule_title" class="ampw_rule_title" value="<?php echo $rule_title; ?>" placeholder="Enter Rule Title">
		</div>
		<?php
		if ( isset( $_GET['action'] ) &&  'edit' == $_GET['action'] ) {
			if ( isset( $_GET['post'] ) ) {
				$post_id = esc_attr( $_GET['post'] );
			}
			$meta_conditions = get_post_meta( $post_id, 'ampw_rule_condition' );
			if ( isset( $meta_conditions[0] ) ) {
				$meta_conditions = unserialize( $meta_conditions[0] );
			}
			$meta_actions = get_post_meta( $post_id, 'ampw_rule_action' );
			if ( isset( $meta_actions[0] ) ) {
				$meta_actions = unserialize( $meta_actions[0] );
			}
		?>
		<div class="ap-mautic-form-content">
		
				<div class="ap-mautic-metabox">
					<div class="conditions">
						<h4> <?php _e( 'Trigger', 'automate-mautic' ) ?> </h4>
						<div id="ap-mautic-sortable-condition" class="ap-mautic-item-wrap">
					<?php
					if ( ! empty( $meta_conditions ) ) {
						foreach ( $meta_conditions as $order => $meta_condition ) :
					?>
						<fieldset class="ui-state-new" id="item-<?php echo $order; ?>">
							<span class="dashicons dashicons-minus remove-item"></span>
							<span class="dashicons dashicons-editor-justify sort-items"></span>

							<?php APMautic_RulePanel::get_all_conditions_list( $meta_condition[0] );

							if ( 'CP' == $meta_condition[0] ) : ?>

								<div class="first-condition">
									<?php APMautic_RulePanel::get_comment_condition_sublist( $meta_condition[1] ); ?>
								</div>
									<div class="second-condition">
										<?php
										if ( 'os_page' == $meta_condition[1] ) {
											APMautic_RulePanel::select_all_pages( $meta_condition[2] );
										} elseif ( 'os_post' == $meta_condition[1] ) {
											APMautic_RulePanel::select_all_posts( $meta_condition[2] );
										}
										echo '</div>';
								endif;

							if ( 'UR' == $meta_condition[0] ) :
								echo '<div class="first-condition"></div>';
								echo '<div class="second-condition"></div>';
								endif;
									$action = 'new_condition_' . $meta_condition[0];
									do_action( $action, $meta_condition );
							echo '</fieldset>';
						endforeach;
					}
						?>
					</div>
					<fieldset class="ap-mautic-add-condition add-new-item">
						<div>
							<span class="dashicons dashicons-plus-alt ap-mautic-new-icon"></span><?php _e( ' Add new condition', 'automate-mautic' ); ?>
						</div>
					</fieldset>
					</div>
						<div class="actions">
							<h4> <?php _e( 'Action', 'automate-mautic' ) ?> </h4>
							<div id="ampw-sortable-action" class="ap-mautic-item-wrap">
							<?php
							if ( ! empty( $meta_actions ) ) {

								foreach ( $meta_actions as $order => $meta_action ) :
							?>
								<fieldset class="ui-state-new">
									<span class="dashicons dashicons-minus remove-item"></span>
									<span class="dashicons dashicons-editor-justify sort-items"></span> 
						
									<div class="first-action">
										<?php APMautic_RulePanel::get_all_actions_list( $meta_action[0] ); ?>
									</div>
							<?php
							if ( 'add_segment' == $meta_action[0] || 'remove_segment' == $meta_action[0] ) {
							?>
							<div class="second-action">
								<input type="hidden" name="pm_action[]" value="segment">
								<?php APMautic_Services::select_all_segments( $meta_action[1] ); ?>
							</div>
							<?php } elseif ( 'add_tag' == $meta_action[0] ) { ?>
									<div class="second-action">
										<input type="hidden" name="pm_action[]" value="tag">
										<input type="text" name="ss_seg_action[]" value="<?php echo $meta_action[1]; ?>">
									</div>
							<?php
}
							?>
								</fieldset>
							<?php
							endforeach;
							}
							?>
							</div>
							<fieldset class="add-new-item">
								<div>
									<span class="dashicons dashicons-plus-alt ap-mautic-add-action ap-mautic-new-icon"></span><span class="ap-mautic-add-action"><?php _e( ' Add new action', 'automate-mautic' ); ?></span>
								</div>
							</fieldset>
						</div>
				</div>
			</div>

			<p class="submit">
				<input type="submit" value="Update Rule" class="button button-primary button-large" name="edit_the_rule">
				<a href="<?php APMautic_AdminSettings::render_page_url( '&tab=all_rules' ) ?>" ><?php _e( '« Back to All Rules', 'automate-mautic' ); ?></a>
				<span class="refresh-mautic-data-wrap"><span class="spinner ap_mautic_spinner"></span><a type="button" name="refresh-mautic" id="refresh-mautic" class="refresh-mautic-data"><?php _e( 'Refresh Mautic Data', 'automate-mautic' ); ?></a><span>
			</p>
			<?php wp_nonce_field( 'apmauticpmeta', 'ap-mautic-post-meta-nonce' ); ?>
				<?php
		} // End if().
		else {
		?>
		<!-- default fields -->
		<div class="ap-mautic-form-content">
		<div class="ap-mautic-metabox">
		<div class="conditions">
			<h4> <?php _e( 'Trigger', 'automate-mautic' ) ?> </h4>
			<div id="ap-mautic-sortable-condition" class="ap-mautic-item-wrap">
				<fieldset class="ui-state-default" id="item-1">
					<span class="dashicons dashicons-minus remove-item"></span>
					<span class="dashicons dashicons-editor-justify sort-items"></span> 
						<?php APMautic_RulePanel::get_all_conditions_list(); ?>
					<div class="first-condition"></div>
					<div class="second-condition"></div>
				</fieldset>
			</div>
			<fieldset class="ap-mautic-add-condition add-new-item">
				<div>
					<span class="dashicons dashicons-plus-alt ap-mautic-new-icon"></span><?php _e( ' Add new condition', 'automate-mautic' ); ?>
				</div>
			</fieldset>
		</div>
		<div class="actions">
			<h4> <?php _e( 'Action', 'automate-mautic' ) ?> </h4>
			<div id="ampw-sortable-action" class="ap-mautic-item-wrap">
				<fieldset class="ui-state-default">
					<span class="dashicons dashicons-minus remove-item"></span>
					<span class="dashicons dashicons-editor-justify sort-items"></span> 
					<div class="first-action">
						<?php APMautic_RulePanel::get_all_actions_list(); ?>
					</div>
					<div class="second-action">
						<input type="hidden" name="pm_action[]" value="segment">
						<?php APMautic_Services::select_all_segments(); ?>
					</div>
				</fieldset>
			</div>
				<fieldset class="add-new-item">
					<div>
						<span class="dashicons dashicons-plus-alt ap-mautic-add-action ap-mautic-new-icon"></span><span class="ap-mautic-add-action"><?php _e( ' Add new action', 'automate-mautic' ); ?></span>
					</div>
				</fieldset>
		</div>
		</div>
		<!-- default fields end -->
		</div>
		<p class="submit">
		<input type="submit" value="Add Rule" class="button button-primary button-large" name="add_new_rule">
		<span class="refresh-mautic-data-wrap"><span class="spinner ap_mautic_spinner"></span><a type="button" name="refresh-mautic" id="refresh-mautic" class="refresh-mautic-data"><?php _e( 'Refresh Mautic Data', 'automate-mautic' ); ?></a><span>
		</p>
		<?php wp_nonce_field( 'apmauticpmeta', 'ap-mautic-post-meta-nonce' ); ?>
		<?php }	?>
	</form>
</div>
