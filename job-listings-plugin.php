<?php
/**
 * Plugin Name: Job Listings Shortcode
 * Description: פלאגין להצגת משרות עם הרחבת פרטים וטופס הגשת מועמדות בפופאפ פנימי
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function job_listings_shortcode() {
    ob_start(); ?>

    <style>
        .job-listing {
            border: 2px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background: #f9f9f9;
            margin-bottom: 15px;
        }
        .job-listing h2 {
            cursor: pointer;
        }
        .job-details {
            display: none;
            margin-top: 10px;
        }
        .apply-frame {
            display: none;
            border-top: 2px solid #ddd;
            margin-top: 10px;
            padding-top: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #0073aa;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn.apply {
            background: #ff6600;
        }
    </style>

    <div class="job-listings">
        <?php
        $args = array('post_type' => 'job_listing', 'posts_per_page' => 10);
        $jobs_query = new WP_Query($args);
        if ($jobs_query->have_posts()) :
            while ($jobs_query->have_posts()) : $jobs_query->the_post(); ?>
                <div class="job-listing">
                    <h2 onclick="toggleDetails(this)"><?php the_title(); ?></h2>
                    <p><strong>מיקום:</strong> <?php echo get_post_meta(get_the_ID(), 'job_location', true); ?></p>
                    <div class="job-details">
                        <p><?php the_excerpt(); ?></p>
                        <a class="btn read-more" onclick="toggleApply(this)">📖 קרא עוד</a>
                        <div class="apply-frame">
                            <h3>הגשת מועמדות</h3>
                            <?php echo do_shortcode('[contact-form-7 id="123" title="Apply Job"]'); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        else :
            echo '<p>לא נמצאו משרות.</p>';
        endif;
        ?>
    </div>

    <script>
        function toggleDetails(element) {
            let details = element.nextElementSibling.nextElementSibling;
            details.style.display = (details.style.display === "block") ? "none" : "block";
        }
        function toggleApply(button) {
            let applyFrame = button.nextElementSibling;
            applyFrame.style.display = (applyFrame.style.display === "block") ? "none" : "block";
        }
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('JOBS', 'job_listings_shortcode');
