<?php

include("../../../../wp-config.php");
global $sub;

$args = array();
if ($_REQUEST['taxonomy']) {
    $args = array(
        'type' => $_REQUEST['post_type'],
        'taxonomy' => $_REQUEST['taxonomy'],
        'hide_empty' => 0
    );
} else {
    $args = array(
        'hide_empty' => 0
    );
}
$cats = get_categories($args);
$error = $cats['errors']['invalid_taxonomy'][0];
if ($error) {
    echo 'error';
} else {
    echo "<select name='category' class='attr-info' style='float: left'>";
    echo '<option value="">All Categories</option>';
    foreach ($cats as $cat) :
        $sub = '';
        if (!$cat->parent) {
            echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
            process_cat_tree($cat->term_id);
        }
    endforeach;
    echo "</select>";
}

function process_cat_tree($cat) {
    global $sub;
    $args = array();
    if ($_REQUEST['taxonomy']) {
        $args = array(
            'type' => $_REQUEST['post_type'],
            'taxonomy' => $_REQUEST['taxonomy'],
            'parent' => $cat,
            'hide_empty' => 0
        );
    } else {
        $args = array(
            'parent' => $cat,
            'hide_empty' => 0
        );
    }
    $next = get_categories($args);
    $error = $next['errors']['invalid_taxonomy'][0];
    if (!$error) {
        if ($next) :
            //$sub .= '-';
            foreach ($next as $cat) :
                echo '<option value="' . $cat->slug . '">' . $sub . $cat->name . '</option>';
                process_cat_tree($cat->term_id);
            endforeach;
        endif;
    }
}

?>