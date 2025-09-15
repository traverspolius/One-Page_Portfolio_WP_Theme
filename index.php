<?php get_header(); ?>

<!-- Hero / Intro -->
<header class="masthead bg-primary text-white text-center" id="home">
    <div class="container d-flex align-items-center flex-column">
  <img class="masthead-avatar mb-5 rounded-circle" src="<?php echo get_template_directory_uri(); ?>/assets/img/Profile-pic.jpg" alt="...">
  <h1 class="masthead-heading text-uppercase mb-0">Travers Polius</h1>
<!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
  <p>WordPress - PHP - MySQL - HTML - Bootstrap - JavaScript - Laravel</p>
        </div>
</header>

<!-- Portfolio -->
<section class="page-section portfolio" id="portfolio">
   <div class="container">
                <!-- Portfolio Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Portfolio</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
<div class="row justify-content-center">
  <?php
  $args = array(
    'post_type'      => 'portfolio',
    'posts_per_page' => -1
  );
  $portfolio = new WP_Query($args);

  if ($portfolio->have_posts()) :
    while ($portfolio->have_posts()) : $portfolio->the_post(); 
      $modal_id = 'modal-' . get_the_ID();
  ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        
        <!-- Thumbnail -->
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail('portfolio-thumb', ['class' => 'card-img-top']); ?>
        <?php else : ?>
          <!-- Optional fallback image -->
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/portfolio/game.png" class="card-img-top" alt="No image available">
        <?php endif; ?>
        
        <!-- Card body -->
        <div class="card-body text-center">
          <h5 class="card-title"><?php the_title(); ?></h5>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>">
            View Project
          </button>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?php the_title(); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>

  <?php endwhile; endif; wp_reset_postdata(); ?>
</div>
</div>
</section>

<!-- About -->
<section class="page-section bg-primary text-white mb-0" id="about">
            <div class="container">
                <!-- About Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>

<section class="container py-5">
  <p>
    Greetings, I am Travers Polius, an enthusiastic web developer residing in British Columbia, Canada. 
    Drawing upon my expertise in Full-Stack Web Development, I specialize in crafting responsive and user-centric websites. 
    My skills include:
  </p>

  <ul>
    <li><strong>Front-End Development:</strong> HTML, CSS, JavaScript, Bootstrap, jQuery, WordPress, Elementor</li>
    <li><strong>Back-End Development:</strong> PHP, Laravel, ASP.Net Core</li>
    <li><strong>Database Development:</strong> MySQL, MSSQL, PostgreSQL, Oracle</li>
    <li><strong>Version Control:</strong> Git</li>
  </ul>

  <p>I love turning ideas into functional, elegant websites that make a positive impact. Let's build something amazing together!</p>
</section>
  </div>
        </section>

      <?php 
get_footer();

?>