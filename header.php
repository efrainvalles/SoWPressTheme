<!DOCTYPE html>
<html lang="en"> 
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Simple Theme for SoW">
    <meta name="author" content="https://efrainvalles.com">    
    <link rel="shortcut icon" href="/test/wordpress/wp-content/themes/SoWPressTheme/assets/images/school.svg"> 
    
    
	<?php
        wp_head();
    ?>
</head> 

<body>
    
    <header class="header text-center">	    

        
	    <nav class="navbar navbar-expand-lg navbar-dark" >
           
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>

			<div id="navigation" class="collapse navbar-collapse flex-column" >
                <?php

                    echo '<h1>' . get_bloginfo('name') . '</h1>';
                ?>
			
				





			
				<hr>
				<ul class="social-list list-inline py-3 mx-auto">
					<li class="list-inline-item"><a href="https://twitter.com/efrainjvalles"><i class="fab fa-twitter fa-fw"></i></a></li>
					<li class="list-inline-item"><a href="https://www.linkedin.com/in/efrainvalles/"><i class="fab fa-linkedin-in fa-fw"></i></a></li>
					<li class="list-inline-item"><a href="https://github.com/efrainvalles"><i class="fab fa-github-alt fa-fw"></i></a></li>

				</ul>

			</div>

         
		</nav>
        <?php 
            dynamic_sidebar('sidebar-1');
        ?>
    </header>
    <div class="main-wrapper">
	    <header class="page-title theme-bg-light text-center gradient py-5">
			<h1 class="heading"><?php the_title(); ?></h1>
		</header>