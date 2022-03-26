<div class="container">
<div class="post mb-5">
    <div class="media">
    <h1><?php the_title(); ?></h1>
    <p>
        Article Name:         <?php
        // Article Field
        $field_value = get_post_meta(get_the_ID(), 'article_name', true);
        echo esc_html($field_value);
        ?>
    </p>
    <p>
    Publisher Name:         <?php
        // Publisher Field
        $field_value = get_post_meta(get_the_ID(), 'article_publisher', true);
        echo esc_html($field_value);
        ?>
    </p>
    Article Link:         
    <a href='<?php
        // Publisher Link
        $field_value = get_post_meta(get_the_ID(), "article_link", true);
        echo esc_html($field_value);
        ?>'>
    <?php
        // Publisher Link
        $field_value = get_post_meta(get_the_ID(), 'article_link', true);
        echo esc_html($field_value);
        ?></a>
    </p>
		</div><!--//media-body-->
	</div><!--//media-->
</div>
</div>
