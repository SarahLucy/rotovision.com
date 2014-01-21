<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<div id="comments">
	<a name="comments"></a>
	<?php 
	if ( have_comments() ) : 
		?>
		<h2 class="commentsHeader">Comments</h2>
		
		<ol class="commentlist">
			<?php wp_list_comments('callback=custom_comment'); ?>
		</ol>
	
	 	<?php 
	 else : // this is displayed if there are no comments so far ?>
	
		<?php 
		if ('open' == $post->comment_status) :
			
	
		else : // comments are closed
			?>
			<p class="nocomments">Comments are closed.</p>
	
			<?php 
		endif; ?>
		<?php 
	endif; ?>
	
	
	<?php 
	if ('open' == $post->comment_status) : 
		?>
		<div id="respond">
	
			<h3><?php comment_form_title( 'Post a comment', 'Leave a Reply to %s' ); ?></h3>
	
			<div class="cancel-comment-reply">
				<small><?php cancel_comment_reply_link(); ?></small>
			</div>

			<?php 
			if ( get_option('comment_registration') && !$user_ID ) : 
				?>
				<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
				<?php 
			else : 
				?>

				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
					<?php
					if ( $user_ID ) : 
						?>
						<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Click here to log out</a>
						</p>
						<?php
					endif;
					?>
					<p>* = required</p>
					<fieldset>
						<?php 
						if ( !$user_ID ) : 
							?>
							
							<label for="author">Name <?php if ($req) echo "*"; ?></label>
							<br/>
							<input class="textfield" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
							<br/>
							<label for="email">Email (will not be published)<?php if ($req) echo "*"; ?></label></th>
							<input class="textfield" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
							<br/>
							<label for="url">Website</label>
							<br/>
							<input class="textfield" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
							<br/>
							
							<?php 
						endif; 
						?>
	
						<label for="comment">Your comment</label>
						<br/>
						<textarea class="field" name="comment" id="comment" cols="25" rows="10" tabindex="4"></textarea>
					
						<input name="submit" type="submit" id="submit" tabindex="5" value="Post" class="button submit"/>
						<?php comment_id_fields(); ?>
					
						<?php do_action('comment_form', $post->ID); ?>
					</fieldset>
				</form>

				<?php 
			endif; // If registration required and not logged in 
			?>
		</div>
	
		<?php 
	endif; // if you delete this the sky will fall on your head 
	?>
</div>