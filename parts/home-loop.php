<?php
/**
 * Grab latest youtube vid see custom-functions.php for video id retrival
 */
?>
<div class="row">
  <div class="large-6 columns">
      <h5>Latest Video</h5>
      <div class="flex-video">
				<iframe width="420" height="315" src="http://www.youtube.com/embed/<?php echo youtubevidid(); ?>?controls=0&modestbranding=1&rel=0&showinfo=0&hd=1;" frameborder="0" allowfullscreen=""></iframe>
			</div>
      <p class="text-right">
        <a href="/tobacco-tv">Watch more</a>
      </p>
  </div>
  <div class="large-6 columns">
      <div class="row">
        <div class="large-6 columns">
          <h5>Latest News</h5>
          <ul>
              <?php $posts_query = new WP_Query('posts_per_page=5');
                  while ($posts_query->have_posts()) : $posts_query->the_post();
              ?>
              <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
              <?php endwhile; wp_reset_query(); ?>
          </ul>
        </div>
        <div class="large-6 columns">
          <!-- Begin MailChimp Signup Form -->
          <div id="mc_embed_signup">
          <form action="//gqtobaccos.us7.list-manage.com/subscribe/post?u=6eaf089598e10394ddd55ffd4&amp;id=fe01711b66" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
              <div id="mc_embed_signup_scroll">
                    <h5>Newletter signup</h5>
                <div class="mc-field-group">
                    <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
                </label>
                    <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                </div>
                <div class="mc-field-group">
                    <label for="mce-FNAME">First Name </label>
                    <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
                </div>
                <div class="mc-field-group">
                    <label for="mce-LNAME">Last Name </label>
                    <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
                </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_6eaf089598e10394ddd55ffd4_fe01711b66" tabindex="-1" value=""></div>
                    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button expand"></div>
              </div>
          </form>
          </div>
          <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
          <!--End mc_embed_signup-->
        </div>
      </div>
  </div>
</div>
