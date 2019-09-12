<?php
require_once('../../../../wp-load.php');
$arg_isArchive = true;
?>
<?php get_header(); ?>
        <div class="span-27 last">
<?php

$vol = $_GET['vol'];
$num = $_GET['num'];

$issue = json_encode(array('volume' => intval(arabic($vol)), 'number' => intval($num)));
$post_ids = $wpdb->get_col("select post_id from wp_postmeta where meta_key = '_arg_issue' and meta_value = '$issue'");
?>
<?php if (count($post_ids) > 0): foreach ($post_ids as $post_id): $post = get_post($post_id); setup_postdata($post); ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php the_excerpt(); ?>
<?php endforeach; else:?>
            <h3>No results</h3>
            <p>No posts were found matching your criteria.</p>
<?php endif; ?>
        </div>
<?php get_footer(); ?>

<?php

function arabic($num) {
    $num = strtolower($num);

    $roman_numerals = array(
        'm' => 1000, 'cm' => 900, 'd' => 500, 'cd' => 400,
        'c' => 100, 'xc' => 90, 'l' => 50, 'xl' => 40, 'x' => 10, 'ix' => 9,
        'v' => 5, 'iv' =>4, 'i' => 1
    );

    $res = 0;
    for ($i = 0; $i < strlen($num); $i++) {
        if (($i < (strlen($num) - 1)) && $roman_numerals[$num[$i] . $num[$i + 1]]) {
            $res += $roman_numerals[$num[$i] . $num[($i++) + 1]];
        } else if ($roman_numerals[$num[$i]]) {
            $res += $roman_numerals[$num[$i]];
        }
    }

    return $res;
}

?>