<div class="container">
<div class="post mb-5">
    <div class="media">
	<div class="media-body">
		<h1 class="title mb-1"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <h2><?php the_title(); ?></h1>
    <p>
        <?php
        // Your custom field!
        $field_value = get_post_meta(get_the_ID(), 'article_link', true);
        echo esc_html($field_value);
        ?>
    </p>

		</div><!--//media-body-->
	</div><!--//media-->
</div>
</div>