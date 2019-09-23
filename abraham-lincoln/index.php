<?php
/**
 * The main template file - modified by djt and kmtt
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package   WordPress
 * @subpackage  Abraham Lincoln
 * @since     Abraham Lincoln 0.1.0
 */
?>
  <?php get_header(); ?>
  <!-- Post info in the image part will not work yet, because it is not a loop -->
  <?php
    //286 is the category ID for the primary post
    $category = 286;
    $args = array(
        'category' => $category
    );

    $top_posts = get_posts($args);
    echo "<!-- total " . count($top_posts) . " posts -->";
    $post = $top_posts[0];
  ?>
    <!-- This is the current test code for ADSENSE -->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Custom -->
    <ins class="adsbygoogle" style="display:none" data-ad-client="ca-pub-5080169411515747" data-ad-slot="6638954115" data-ad-format="auto"></ins>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({});

    </script>
    <!-- End test code for ADSENSE -->
    <div class="row" style = "margin-top:10px">
      <div class="row content top">
    <!--- start code for bootstap carousel---->

      <div id="articleCarousel" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <ol class="carousel-indicators">
          <li data-target="#articleCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#articleCarousel" data-slide-to="1"></li>
          <li data-target="#articleCarousel" data-slide-to="2"></li>
          <li data-target="#articleCarousel" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
        <!-- First article-->
          <div class="item active">
            <div class="col-md-8" style = "max-height: 450px">
              <img src="<?php echo abraham_get_photo($post, 700, '', '', true); ?>" alt="article1" style="width:100%;">
            </div>
            <div class = "col-md-4" style = "min-height: 380px">
              <div class="media-body" >
                <h2><span><a href="<?php esc_url(the_permalink()); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark">
                      <?php echo str_replace(":", ":<br>", get_the_title()); ?>
                    </a></span></h2>
                  <h5><span><?php the_time('F j'); ?> <?php abraham_display_author(false); ?></span></h5>
                  <?php if (function_exists('the_subheading')) { the_subheading('<p>', '</p>'); } ?>
              </div>
          </div>
          </div>
          <!-- Next 3 articles-->
          <?php
              //86 is the category ID for Secondary Posts
              $category = 86;
              $excluded_categories = (87);
              $args = array(
                  'category' => $category,
                  'category__not_in' => $excluded_categories
              );
              $top_posts = get_posts($args);
              $count = 0;
              foreach ($top_posts as $post) {
                if($count < 5) {
              ?>
          <div class="item">
              <div class="col-md-8" style = "max-height: 450px">
                <img src="<?php echo abraham_get_photo($post, 185, '', '', true); ?>" style="width:100%;">
              </div>
              <div class = "col-md-4" style = "min-height: 380px">
                <div class="media-body">
                  <h2><span><a href="<?php esc_url(the_permalink()); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark">
                        <?php echo str_replace(":", ":<br>", get_the_title()); ?>
                      </a></span></h2>
                  <h5><span><?php the_time('F j'); ?> <?php abraham_display_author(false); ?></span></h5>
                  <?php if (function_exists('the_subheading')) { the_subheading('<p>', '</p>'); } ?>
                </div>
              </div>
          </div>
          <?php } $count++; } ?>
          <div class = "col-xs-4 pull-right" style = "vertical-align: bottom;">
          <a class="left" href="#articleCarousel" data-slide="prev" style = "color:#231F20; text-decoration: none;">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right" href="#articleCarousel" data-slide="next" style = "color:#231F20;">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
          </div>
        </div>

      </div>
    <!--- end code for bootstap carousel---->
</div>
</div>


    <?php
    //code for collapsing section columns
$first_row = array(
  array("section" => "News",    "id" => 3, "link" => "/section/news"),
  array("section" => "Features","id" => 4, "link" => "/section/features"),
  array("section" => "Sports",  "id" => 5, "link" => "/section/sports"),
  array("section" => "Arts & Culture",    "id" => 6, "link" => "/section/arts")
);
$second_row = array(
  array("section" => "Letters to the Editor","id" => 13, "link" => "/section/wespeaks"),
  array("section" => "Opinion", "id" => 16, "link" => "/section/opinion")
  /* array("section" => "Food",    "id" => 75) */
  //the fourth column is the PDF viewer
);
//columns should be generated by loops
?>
<div class = "row row_one">
      <?php
          foreach ($first_row as $column) {
        ?>
        <div class="col-sm-3">
          <div class="box">
            <h2 style = "height: 55px; padding: 20px;" >
              <a href="<?php echo $column["link"]; ?>">
                <?php echo $column["section"]; ?>
              </a>
            </h2>
            <?php
              $query = new WP_Query(array('category__and'=>array($column["id"], 87),
                                             'numberposts'=>1));
              $count = 0;
              while ( $query->have_posts() ) {
                $query->the_post();
                $top_post = get_post();
                $post = $top_post;
                if($count == 0) {
                  echo '<ul class = "dropdown">';
                  echo "<li style = 'display: block; margin: auto'><img width='263' src='". abraham_get_photo($post, 263, '', '', true)  . "'></li>";

                }
                echo '<li style = "padding: 8px"><a href="' . get_permalink() . '" title="Look '.get_the_title().'" ><strong>' .   get_the_title().'</strong></a>' . abraham_get_author(true) . '</li> ';
              }

              $args = array(
                  'category' => $column["id"],
                  'category__not_in' => array(86, 87, 89),
                  'numberposts' => 2,
                  'orderby' => 'post_date',
                  'order' => 'DESC'
              );

              $cat_posts = get_posts($args);

    					foreach( $cat_posts as $post ){
                //image for the first one

    						echo '<li style = "padding: 8px"`><a href="' . get_permalink() . '" title="Look '.get_the_title().'" ><strong>' .   get_the_title().'</strong></a>' . abraham_get_author(true) . '</li> ';
              }
    				?>
              </ul>
          </div>
        </div>
        <?php
          }
        ?>
            </div>
      <div class = "row">
            <?php
          foreach ($second_row as $column) {
        ?>
              <div class="col-sm-3">
                <div class="box">
                <h2 style = "height: 55px; padding: 20px;">
                    <a href="<?php echo $column["link"] ?>"><?php echo $column["section"]; ?></a>
                </h2>

        <?php
            echo '<ul class = "dropdown">';
            $args = array(
                'numberposts' => '3',
                'category' => $column["id"],
                'orderby' => 'post_date',
                'order' => 'DESC'
              );
  					$recent_posts = get_posts( $args );
  					foreach( $recent_posts as $post ){
      						echo '<li><a href="' . get_permalink() . '" title="Look '.get_the_title().'" ><strong>' .   get_the_title().'</strong></a>' . abraham_get_author(true) . '</li> ';
  					}
				?>


                           </ul>
                    </div>
              </div>
              <?php
          }
        ?>
                <div class="col-sm-3">
                  <div class="box">
                    <h2 style = "height: 55px; padding: 20px;">
                      <a href="/voices">Voices</a>
                    </h2>
                    <?php
              $args = array(
                'numberposts' => '3',
                'category' => 961,
                'orderby' => 'post_date',
                'order' => 'DESC'
              );
              $recent_posts = get_posts( $args );
              $count = 0;
              foreach( $recent_posts as $post ){
                if($count == 0) {
                  echo '<ul class = "dropdown">';
                  echo "<li><img width='263' src='". abraham_get_photo($post, 263, '', '', true)  . "'></li>";
                }
    						echo '<li><a href="' . get_permalink() . '" title="Look '.get_the_title().'" ><strong>' .   get_the_title().'</strong></a>' . abraham_get_author(true) . '</li> ';
                $count++;
              }
            ?>
                      </ul>
                  </div>
                </div>
                <?php twitter_feed(); ?>
  </div>
</div>
                <script type="text/javascript" charset="utf-8">
                  jQuery(document).ready(function() {
		$('.dropdown').height($('.row_one').height())
                    if ($(window).width() > 960) {
                      console.log("ready!");
                      var diff = $('.col-md-5').height() - $('.col-md-7').height();
                      var curr = $('.col-md-7 p').height();
                      $('.col-md-7 p').height(curr + diff + 10);
                      console.log(curr + diff + 10);
                    }
                  });

            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
            <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
