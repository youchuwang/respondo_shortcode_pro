<?php
include("../../../../wp-config.php");
$args = array(
    'post_type' => 'page',
    'post_status' => 'publish'
);
$pages = get_pages($args);
if (is_wp_error($pages)) {
    echo 'error';
} else {
    ?>
    <select name='view_more_url' class='attr-info' style='float: left'>
        <option value="">No</option>
        <?php
        foreach ($pages as $page) {
            ?>
            <option value="<?php echo get_page_link($page->ID) ?>"><?php echo $page->post_title; ?></option>
            <?php
        }
        ?>
    </select>
    <?php
}
?>