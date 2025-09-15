<?php
// Enqueue Bootstrap & theme styles
function travers_enqueue_scripts() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'travers_enqueue_scripts');

// Register Portfolio Custom Post Type
function travers_register_portfolio() {
    $args = array(
        'label' => 'Portfolio',
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-portfolio'
    );
    register_post_type('portfolio', $args);
}
add_action('init', 'travers_register_portfolio');
add_theme_support('post-thumbnails');
add_image_size('portfolio-thumb', 400, 300, true); // cropped

// Insert demo portfolio projects (only runs once)
function travers_insert_demo_projects() {
    // Run only once
    if (get_option('travers_demo_content_added')) return;

    // Example projects data
    $projects = [
        [
            'title' => 'E-Commerce Website',
            'content' => 'A modern online store built with WooCommerce and Bootstrap. Features include product filtering, cart, and checkout.',
            'image' => 'https://picsum.photos/600/400?random=1'
        ],
        [
            'title' => 'Portfolio Showcase',
            'content' => 'A clean and responsive personal portfolio site showcasing projects, skills, and a contact form.',
            'image' => 'https://picsum.photos/600/400?random=2'
        ],
        [
            'title' => 'Business Landing Page',
            'content' => 'A professional landing page for a small business, including services, testimonials, and a contact section.',
            'image' => 'https://picsum.photos/600/400?random=3'
        ]
    ];

    foreach ($projects as $proj) {
        // Create post
        $post_id = wp_insert_post([
            'post_title'   => $proj['title'],
            'post_content' => $proj['content'],
            'post_status'  => 'publish',
            'post_type'    => 'portfolio'
        ]);

        // Add featured image
        if ($post_id && !is_wp_error($post_id)) {
            $image_url  = $proj['image'];
            $image_name = basename($image_url);

            // Download image to media library
            $upload_dir = wp_upload_dir();
            $image_data = file_get_contents($image_url);
            $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
            $filename = basename($unique_file_name);

            if (wp_mkdir_p($upload_dir['path'])) {
                $file = $upload_dir['path'] . $filename;
            } else {
                $file = $upload_dir['basedir'] . $filename;
            }

            file_put_contents($file, $image_data);

            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = [
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name($filename),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ];

            $attach_id = wp_insert_attachment($attachment, $file, $post_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);
            set_post_thumbnail($post_id, $attach_id);
        }
    }

    // Mark demo content as inserted
    update_option('travers_demo_content_added', true);
}
add_action('after_setup_theme', 'travers_insert_demo_projects');

// Highlight active nav item on scroll
function travers_scrollspy() {
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      const sections = document.querySelectorAll("section[id]");
      const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

      window.addEventListener("scroll", () => {
        let current = "";
        sections.forEach(section => {
          const sectionTop = section.offsetTop - 80;
          if (pageYOffset >= sectionTop) {
            current = section.getAttribute("id");
          }
        });

        navLinks.forEach(link => {
          link.classList.remove("active");
          if (link.getAttribute("href") === "#" + current) {
            link.classList.add("active");
          }
        });
      });
    });
    </script>
    <style>
      .navbar .nav-link.active {
        font-weight: bold;
        color: #0d6efd !important; /* Bootstrap primary */
      }
    </style>
    <?php
}
add_action('wp_footer', 'travers_scrollspy');
