<?php
if (!class_exists("shortcodesListSLS")):

    class shortcodesListSLS {

        var $style = '';

        function __construct() {
            if (function_exists('add_image_size')) {
                add_image_size('category-thumb', 165, 72, true); //300 pixels wide (and unlimited height)
                add_image_size('blog-slider-thumb', 960, 480, true); //300 pixels wide (and unlimited height)
            }

			/*--------------------------------------*/
			/*    Clean up Shortcodes
			/*--------------------------------------*/
			function wpex_clean_shortcodes($content){   
				$array = array (
					'<p>[' => '[', 
					']</p>' => ']', 
					']<br />' => ']'
				);
				$content = strtr($content, $array);
				return $content;
			}
			add_filter('the_content', 'wpex_clean_shortcodes');

            add_filter('the_excerpt', 'do_shortcode');
            add_filter('widget_text', 'do_shortcode');
            add_action('wp_footer', array(&$this, 'insert_footer'), 100);

            add_action('wp_enqueue_scripts', array(&$this, 'js_css'));

            add_filter('the_content', array(&$this, 'precontent_strip_shortcode'));
            add_action('respondo_precontent_hook', array(&$this, 'precontent_respondo_output'), 5);
			
//Event
			add_shortcode('rs-event', array(&$this, 'event'));
//Responsive iFrame
			add_shortcode('rs-responsive-iframe', array(&$this, 'responsive_iframe'));
//Scaffolding
            add_shortcode('rs-columns', array(&$this, 'columns'));

            add_shortcode('rs-one_twelth', array(&$this, 'one_twelth'));
            add_shortcode('rs-one_sixth', array(&$this, 'one_sixth'));
            add_shortcode('rs-three_twelths', array(&$this, 'three_twelths'));
            add_shortcode('rs-one_third', array(&$this, 'one_third'));
            add_shortcode('rs-five_twelths', array(&$this, 'five_twelths'));
            add_shortcode('rs-one_half', array(&$this, 'one_half'));
            add_shortcode('rs-seven_twelths', array(&$this, 'seven_twelths'));
            add_shortcode('rs-two_thirds', array(&$this, 'two_thirds'));
            add_shortcode('rs-nine_twelths', array(&$this, 'nine_twelths'));
            add_shortcode('rs-five_sixths', array(&$this, 'five_sixths'));
            add_shortcode('rs-eleven_twelths', array(&$this, 'eleven_twelths'));
            add_shortcode('rs-full_width', array(&$this, 'full_width'));
            add_shortcode('rs-one_quarter', array(&$this, 'one_quarter'));
            add_shortcode('rs-three_quarters', array(&$this, 'three_quarters'));

            add_shortcode('rs-column_in_column', array(&$this, 'columns'));

            add_shortcode('rs-one_twelth_cic', array(&$this, 'one_twelth_cic'));
            add_shortcode('rs-one_sixth_cic', array(&$this, 'one_sixth_cic'));
            add_shortcode('rs-three_twelths_cic', array(&$this, 'three_twelths_cic'));
            add_shortcode('rs-one_third_cic', array(&$this, 'one_third_cic'));
            add_shortcode('rs-five_twelths_cic', array(&$this, 'five_twelths_cic'));
            add_shortcode('rs-one_half_cic', array(&$this, 'one_half_cic'));
            add_shortcode('rs-seven_twelths_cic', array(&$this, 'seven_twelths_cic'));
            add_shortcode('rs-two_thirds_cic', array(&$this, 'two_thirds_cic'));
            add_shortcode('rs-nine_twelths_cic', array(&$this, 'nine_twelths_cic'));
            add_shortcode('rs-five_sixths_cic', array(&$this, 'five_sixths_cic'));
            add_shortcode('rs-eleven_twelths_cic', array(&$this, 'eleven_twelths_cic'));
            add_shortcode('rs-full_width_cic', array(&$this, 'full_width_cic'));
            add_shortcode('rs-one_quarter_cic', array(&$this, 'one_quarter_cic'));
            add_shortcode('rs-three_quarters_cic', array(&$this, 'three_quarters_cic'));
//Components
            add_shortcode('rs-single_button_group', array(&$this, 'single_button_group'));
            add_shortcode('rs-single_button', array(&$this, 'single_button'));

            add_shortcode('rs-split_button_group', array(&$this, 'split_button_group'));
            add_shortcode('rs-split_button', array(&$this, 'split_button'));

            add_shortcode('rs-basic_tabs_container', array(&$this, 'basic_tabs_container'));
            add_shortcode('rs-tab', array(&$this, 'basic_tab'));

            add_shortcode('rs-basic_pills_container', array(&$this, 'basic_pills_container'));
            add_shortcode('rs-pills', array(&$this, 'basic_pills'));

            add_shortcode('rs-accordion_stacked_tabs_container', array(&$this, 'accordion_stacked_tabs_container'));
            add_shortcode('rs-accordion_stacked_tabs', array(&$this, 'accordion_stacked_tabs'));

            add_shortcode('rs-accordion_stacked_pills_container', array(&$this, 'accordion_stacked_pills_container'));
            add_shortcode('rs-accordion_stacked_pills', array(&$this, 'accordion_stacked_pills'));

            add_shortcode('rs-divider', array(&$this, 'divider'));
            add_shortcode('rs-highlight', array(&$this, 'highlight'));
            add_shortcode('rs-badges', array(&$this, 'badges'));

            add_shortcode('rs-alerts', array(&$this, 'alerts'));
            add_shortcode('rs-progress_bar', array(&$this, 'progress_bar'));
            add_shortcode('rs-services_group', array(&$this, 'services_group'));
            add_shortcode('rs-service', array(&$this, 'service'));

//Base CSS
            add_shortcode('rs-box_content', array(&$this, 'box_content'));
            add_shortcode('rs-button', array(&$this, 'button'));
            add_shortcode('rs-image', array(&$this, 'image'));
            add_shortcode('rs-insert_icon', array(&$this, 'insert_icon'));
            add_shortcode('rs-list_icon', array(&$this, 'list_icon'));
//More Shortcodes
            add_shortcode('rs-space', array(&$this, 'space'));
			add_shortcode('rs-header', array(&$this, 'header'));
			add_shortcode('rs-responsive', array(&$this, 'responsive'));
            add_shortcode('rs-testimonial', array(&$this, 'testimonial'));
            add_shortcode('rs-blog_posts', array(&$this, 'blog_posts'));
            add_shortcode('rs-blog_posts_2', array(&$this, 'blog_posts_2'));
            add_shortcode('rs-blog_slider', array(&$this, 'blog_slider'));

            add_shortcode('rs-portfolio', array(&$this, 'portfolio'));
            add_shortcode('rs-precontent', array(&$this, 'precontent'));
            add_shortcode('rs-box_wh_content', array(&$this, 'box_wh_content'));
            add_shortcode('rs-box_wh_content_title', array(&$this, 'box_wh_content_title'));
        }

        function js_css() {
            if (!is_admin()) {
                wp_enqueue_style('bootstrap', RESPONDO_SHORTCODE_PLUGIN_URL . 'bootstrap/css/bootstrap.min.css');
                wp_enqueue_style('bootstrap-responsive', RESPONDO_SHORTCODE_PLUGIN_URL . 'bootstrap/css/bootstrap-responsive.min.css');

//google font
                wp_enqueue_style('google-font-play', 'http://fonts.googleapis.com/css?family=Play:400,700');

//font awesome
                wp_enqueue_style('font-awesome', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome.min.css');
                wp_enqueue_style('font-awesome-corp', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-corp.css');
                wp_enqueue_style('font-awesome-ext', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-ext.css');
                wp_enqueue_style('font-awesome-social', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-social.css');
                wp_enqueue_style('font-awesome-ie7', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-ie7.min.css');
                wp_enqueue_style('font-awesome-more-ie7', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-social.css');
                wp_enqueue_script(jquery);
//wp_enqueue_script('jquery-min-last', 'http://code.jquery.com/jquery.min.js');
                wp_enqueue_script('bootstrap', RESPONDO_SHORTCODE_PLUGIN_URL . 'bootstrap/js/bootstrap.min.js');
                wp_enqueue_script('front-rs', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/front.js');
                wp_enqueue_style('front-rs', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/front.css');
                wp_enqueue_style('front-responsive-rs', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/front-responsive.css');
				wp_enqueue_style('collageplus-js', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/jquery.collagePlus.js');
				wp_enqueue_style('collageplus-min-js', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/jquery.collagePlus.min.js');
				wp_enqueue_style('collageplus-jquery-json', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/collageplus.jquery.json');
				wp_enqueue_style('collagecaption-js', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/jquery.collageCaption.js');
				wp_enqueue_style('collagecaption-min-js', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/jquery.collageCaption.min.js');
				wp_enqueue_style('removewhitespace-js', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/jquery.removeWhitespace.js');
				wp_enqueue_style('removewhitespace-min-js', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/jquery.removeWhitespace.min.js');
            }
        }

        function insert_footer() {
            ?>
            <script>if(jQuery('.carousel').length > 0) {jQuery('.carousel').carousel();}</script>
            <?php 
        }

		// event shortcode		
		function event( $attr, $content = null ){
			ob_start();
			$bkg_color = '#FFFFFF';
			$txt_color = '#333333';
			$brd_color = '#D9D9D9';
			
			if( isset( $attr['bkg_color'] ) || $attr['bkg_color'] != '' ) {
				$bkg_color = $attr['bkg_color'];
			}
			
			if( isset( $attr['txt_color'] ) || $attr['txt_color'] != '' ) {
				$txt_color = $attr['txt_color'];
			}
			
			if( isset( $attr['brd_color'] ) || $attr['brd_color'] != '' ) {
				$brd_color = $attr['brd_color'];
			}
			?>
			<h2>Upcoming Events</h2>
			<div class="row-fluid">
			<?php 
				$args = array(
					'post_type' => 'events',
					'posts_per_page' => -1
				);
				
				$the_query = new WP_Query( $args );
				
				$event_list = array();
				$now_mktime = mktime(0, 0, 0, date("m"),   date("d"),   date("Y"));
				
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$start_date = get_post_meta( get_the_id(), 'event-date-start', true );

					list( $m, $d, $y ) = explode( '/', $start_date );
					$mk = mktime( 0, 0, 0, $m, $d, $y );
					
					if( $mk >= $now_mktime ) {
						$event_list[] = array( 'id' => get_the_id(), 'date' => $mk );
					}
				}

				for( $i = 0; $i < sizeof( $event_list ) -1 ; $i++ ){
					for( $j = $i + 1; $j < sizeof( $event_list ); $j++ ){
						if( $event_list[$i]['date'] > $event_list[$j]['date'] ) {
							
							$temp_id = $event_list[$i]['id'];
							$temp_date = $event_list[$i]['date'];
							
							$event_list[$i]['id'] = $event_list[$j]['id'];
							$event_list[$i]['date'] = $event_list[$j]['date'];
							
							$event_list[$j]['id'] = $temp_id;
							$event_list[$j]['date'] = $temp_date;
						}
					}
				}
				
				$count = sizeof( $event_list ) > 4 ? 4 : sizeof( $event_list );
				for( $i = 0; $i < $count; $i ++ ) {
					$event_post = get_post( $event_list[$i]['id'] ); 
					$title = $event_post->post_title;
					$start_date = get_post_meta( $event_list[$i]['id'], 'event-date-start', true );
					$content = $event_post->post_content;
					if( strlen($content) > 200 ) {
						$content = $this->get_excerpt_str( $content, 20 ) . '...';
					}
					list( $m, $d, $y ) = explode( '/', $start_date );
					$mk = mktime( 0, 0, 0, $m, $d, $y );
					$start_date = date( 'd F Y', $mk );
			?>
				<div class="span3">
					<div style="background-color:<?php echo $bkg_color; ?>; color:<?php echo $txt_color; ?>; border-color:<?php echo $brd_color; ?>" class="basic_block_rs">
						<p><strong><a class="rs-event-title" href="<?php echo get_permalink( $event_list[$i]['id'] ); ?>"><span><?php echo $title; ?></span></a><br></strong><?php echo $start_date; ?></p>
						<p><?php echo $content; ?></p>
					</div>
				</div>
			<?php
				}
			?>
			</div>
			<?php
			$output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
		}
		
		function responsive_iframe($attr, $content = null) {
			ob_start();
			?>
			<div class="responsive-container"><?php echo $content; ?></div>
			<?php
			$output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
		}
		
        function columns($attr, $content = null) {
            ob_start();
            ?>
            <div class="row-fluid"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_twelth($attr, $content = null) {
            ob_start();
            ?>
            <div class="span1"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_sixth($attr, $content = null) {
            ob_start();
            ?>
            <div class="span2"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function three_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span3"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_third($attr, $content = null) {
            ob_start();
            ?>
            <div class="span4"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function five_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span5"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_half($attr, $content = null) {
            ob_start();
            ?>
            <div class="span6"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function seven_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span7"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function two_thirds($attr, $content = null) {
            ob_start();
            ?>
            <div class="span8"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function nine_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span9"> <?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function five_sixths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span10"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function eleven_twelths($attr, $content = null) {
            ob_start();
            ?>
            <div class="span11"><?php echo do_shortcode($content);?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }
		
        function full_width($attr, $content = null) {
            ob_start();
            ?>
            <div class="span12"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_quarter($attr, $content = null) {
            ob_start();
            ?>
            <div class="span3"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function three_quarters($attr, $content = null) {
            ob_start();
            ?>
            <div class="span9"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function columns_in_columns($attr, $content = null) {
            ob_start();
            ?>
            <div class="row-fluid"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_twelth_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span1"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_sixth_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span2"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function three_twelths_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span3"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_third_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span4"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function five_twelths_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span5"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_half_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span6"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function seven_twelths_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span7"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function two_thirds_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span8"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function nine_twelths_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span9"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function five_sixths_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span10"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function eleven_twelths_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span11"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function full_width_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span12"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function one_quarter_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span3"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function three_quarters_cic($attr, $content = null) {
            ob_start();
            ?>
            <div class="span9"><?php
                echo do_shortcode($content);
                ?></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

//shortcode in frontend
        var $single_button_group_idex = 0;

        function single_button_group($attr, $content = null) {
            ob_start();
            $class = '';
            if ($attr['size'])
                $class = $attr['size'];
            if ($attr['type'])
                $class .= ' ' . $attr['type'];
            if ($attr['position'] == 'right')
                $pclass .= 'right-rs-btn-resp';
            else
                $pclass .= 'left-rs-btn-resp';

            if ($attr['new_win'] == "yes") {
                $link_suf = 'href="window.open(\'';
                $link_pre = '\')"';
                $target = 'target="_blank"';
            } else {
                $link_suf = 'onClick="window.location.href = \'';
                $link_pre = '\'"';
                $target = '';
            }

            do_shortcode($content);
            $tmp = $this->single_button_str; //do_shortcode($content);
            $tmp = str_replace('rs%type%rs', $attr['type'], $tmp);
            $tmp = str_replace('rs%class%rs', $class, $tmp);
//$tmp = str_replace('rs%onclick_suf%rs', $link_suf, $tmp);
//$tmp = str_replace('rs%onclick_pre%rs', $link_pre, $tmp);
            $tmp = str_replace('rs%target%rs', $target, $tmp);

            $gtmp_a = explode('rs%great-split%rs', $tmp);
            $b_str = '';
            $li_str = '';
            foreach ($gtmp_a as $tmp) {
                $tmp_a = explode('rs%split%rs', $tmp);
                $b_str .= $tmp_a[0];
                $li_str .= $tmp_a[1];
            }

            $class_tmp = '';
            if ($attr['class'])
                $class_tmp = $attr['class'];
            ?>
            <div class="<?php echo $pclass; ?>">
                <div class="btn-group rs-btn-subgroup <?php echo $class_tmp; ?>"><?php echo $b_str; ?></div>
                <div class="navbar navbar-inverse rs-btn-subgroup-nav">
                    <div class="navbar-inner <?php echo $attr['type'] ?>">
                        <a type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target="#rs-btn-collapse<?php echo $this->single_button_group_idex ?>"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>
                        <nav id="rs-btn-collapse<?php echo $this->single_button_group_idex ?>" class="nav-collapse collapse">
                            <ul class="nav">
                                <?php echo $li_str; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <?php
            if ($attr['wrap'] == 'no')
                echo '<div class="clear"></div>';
            ++$this->single_button_group_idex;
            $this->single_button_str = '';
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $single_button_str = '';

        function single_button($attr, $content = null) {
            $label = '';
            $link = '';

            if ($attr['label'])
                $label = $attr['label'];
            if ($attr['link'])
                $link = $attr['link'];

            $this->single_button_str .= '<a href="' . $link . '" rs%target%rs class="btn rs%class%rs">' . $label . '</a>rs%split%rs<li><a href="' . $link . '" rs%target%rs class="btn rs%type%rs">' . $label . '</a></li>rs%great-split%rs';
        }

        function split_button_group($attr, $content = null) {
            $label = 'button';
            if ($attr['label'])
                $label = $attr['label'];

            $class = 'btn';
            if ($attr['size'])
                $class .= ' ' . $attr['size'];
            if ($attr['type'])
                $class .= ' ' . $attr['type'];
            if ($attr['position'] == 'right')
                $postion .= ' pull-right';
            else
                $postion .= ' pull-left';
            ob_start();
            ?>
            <div class="btn-group <?php echo $postion . ' ' . $attr['class']; ?> ">
                <button class="dropdown-toggle <?php echo $class ?>" data-toggle="dropdown"><?php _e($label); ?><span class="caret"></span></button><ul class="dropdown-menu"><?php echo do_shortcode($content); ?></ul>
            </div>
            <?php
            if ($attr['wrap'] == 'no')
                echo '<div class="clear"></div>';
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function split_button($attr, $content = null) {
            $divider = '';
            $label = 'link';
            if ($attr['divider'])
                $divider = $attr['divider'];
            if ($attr['label'])
                $label = $attr['label'];
            ob_start();
            if ($divider) {
                ?><li class="divider"></li><?php
            } else {
                $link = '';
                if ($attr['link'])
                    $link = $attr['link'];
                ?><li><a href="<?php echo $link ?>"><?php _e($label); ?></a></li><?php
            }
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $basic_tabs_idex_p = 0;
        var $basic_tabs_idex_c = 0;

        function basic_tabs_container($attr, $content = null) {
            ob_start();
            $tmp = do_shortcode($content);

            $style = '';

            if ($attr['style'] == 'straight') {
                $style = 'straight';
            }
            $position = '';
            if ($attr['position'] == 'tabs-left')
                $position = 'tabs-left';
            if ($attr['position'] == 'tabs-right')
                $position = 'tabs-right';
            if ($attr['position'] == 'tabs-below')
                $position = 'tabs-below';

            $gtmp_a = explode('rs%basic-tab-group%rs', $tmp);
            $tabs = '';
            $content = '';
            foreach ($gtmp_a as $tmp) {
                $tmp_a = explode('rs%basic-tab%rs', $tmp);
                $tabs .= $tmp_a[0];
                $content .= $tmp_a[1];
            }
            ?>
            <style>
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content > .tab-pane {
                    margin: 10px;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs > .active > a, 
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs > .active > a:hover {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                    border-bottom-color: transparent !important;
                    color: <?php echo $attr['act_txt_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs {
                    border-bottom-color: <?php echo $attr['brd_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs > .active > a, 
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs > .active > a:hover {
                    background-color: <?php echo $attr['act_bg_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav > li > a {
                    color: <?php echo $attr['inact_txt_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav > li > a:hover,
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav > li > a:focus {
                    background-color: <?php echo $attr['hov_bg_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav > li > a:hover,
                #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav > li > a:active {
                    color: <?php echo $attr['hov_txt_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-below .nav-tabs > .active > a,
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-below .nav-tabs > .active > a:hover {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                    border-top-color: transparent !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-below .nav-tabs {
                    border-top-color: <?php echo $attr['brd_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-left .nav-tabs > .active > a,
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-left .nav-tabs > .active > a:hover {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                    border-right-color: transparent !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-left .nav-tabs {
                    border-right-color: <?php echo $attr['brd_color'] ?> !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-right .nav-tabs > .active > a,
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-right .nav-tabs > .active > a:hover {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                    border-left-color: transparent !important;
                }
                #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-right .nav-tabs {
                    border-left-color: <?php echo $attr['brd_color'] ?> !important;
                }
                <?php
                if ($style == 'straight') {
                    ?>
                    #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs>li>a {
                        -webkit-border-radius: 0px !important;
                        -moz-border-radius: 0px !important;
                        border-radius: 0px !important;
                        border: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        background-color: <?php echo $attr['tab_bg_color'] ?>
                    }
                    #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content {
                        background-color: <?php echo $attr['act_bg_color'] ?>;
                    }
                    <?php
                    if ($position == 'tabs-below') {
                        ?>
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs>li>a {
                            margin-right: -1px;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?>.tabs-below .tab-content {
                            margin-bottom: 0px !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content {
                            border-right: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-left: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-top: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        }
                        <?php
                    } else if ($position == 'tabs-left') {
                        ?>
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content {
                            border: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs>li>a {
                            margin-right: -2px;
                            margin-bottom: 0px !important;
                            border: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> ul.nav-tabs {
                            margin-right: 0px !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content {
                            border-bottom: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-right: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-top: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        }
                        <?php
                    } else if ($position == 'tabs-right') {
                        ?>
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content {
                            border: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs>li>a {
                            margin-left: -2px;
                            margin-bottom: 0px !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> ul.nav-tabs {
                            margin-left: 0px !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content {
                            border-bottom: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-left: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-top: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        }
                        <?php
                    } else {
                        ?>
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .nav-tabs>li>a {
                            margin-right: -1px;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> ul.nav-tabs {
                            margin-bottom: 0px !important;
                        }
                        #tabbable<?php echo $this->basic_tabs_idex_p ?> .tab-content {
                            border-right: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-left: 1px solid <?php echo $attr['brd_color'] ?> !important;
                            border-bottom: 1px solid <?php echo $attr['brd_color'] ?> !important;
                        }
                        <?php
                    }
                }
                ?>
            </style>
            <div id="tabbable<?php echo $this->basic_tabs_idex_p ?>" class="rs-basic_tabs tabbable <?php echo $position . ' ' . $attr['class'] ?>">
                <?php
                if ($attr['position'] == 'tabs-below') {
                    ?>
                    <div class="tab-content">
                        <?php
                        echo do_shortcode($content);
                        ?>
                    </div>
                    <ul class="nav nav-tabs">
                        <?php echo $tabs ?>
                    </ul>
                    <?php
                } else {
                    ?>
                    <ul class="nav nav-tabs">
                        <?php echo $tabs ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        echo do_shortcode($content);
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
            ++$this->basic_tabs_idex_p;
            $this->basic_tabs_idex_c = 0;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function basic_tab($attr, $content = null) {
            $active = '';
            if ($this->basic_tabs_idex_c == 0) {
                $active = 'active';
            }
            $str .= '<li class="' . $active . '"><a data-toggle="tab" href="#rs-basic-tab' . $this->basic_tabs_idex_p . $this->basic_tabs_idex_c . '">' . $attr['label'] . '</a></li>';
            $str .= 'rs%basic-tab%rs<div id="rs-basic-tab' . $this->basic_tabs_idex_p . $this->basic_tabs_idex_c . '" class="tab-pane ' . $active . '">' . $content . '</div>';
            $str .= 'rs%basic-tab-group%rs';
            ++$this->basic_tabs_idex_c;
            ob_start();
            echo $str;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $basic_pills_container_idex = 0;
        var $basic_pills_idex = 0;

        function basic_pills_container($attr, $content) {
            ob_start();
            $tmp = do_shortcode($content);
            $position = '';
            if ($attr['position'] == 'pull-right')
                $position = $attr['position'];
            $tmp = str_replace('rs%position-basic-pills%rs', $position, $tmp);
            ?>
            <style>
                #nav-pills<?php echo $this->basic_pills_container_idex; ?>.nav-pills > .active > a, 
                #nav-pills<?php echo $this->basic_pills_container_idex; ?>.nav-pills > .active > a:hover, 
                #nav-pills<?php echo $this->basic_pills_container_idex; ?>.nav-pills > .active > a:focus {
                    color: <?php echo $attr['act_txt_color']; ?> !important;
                    background-color: <?php echo $attr['act_bg_color']; ?> !important;
                }
                #nav-pills<?php echo $this->basic_pills_container_idex; ?>.nav > li > a:hover {
                    color: <?php echo $attr['hov_txt_color']; ?> !important;
                    background-color: <?php echo $attr['hov_bg_color']; ?> !important;
                }
            </style>
            <ul id="nav-pills<?php echo $this->basic_pills_container_idex; ?>" class="nav nav-pills <?php echo $attr['class']; ?>">
                <?php echo $tmp; ?>
            </ul>
            <?php
            ++$this->basic_pills_container_idex;
            $this->basic_pills_idex = 0;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function basic_pills($attr, $content) {
            $active = '';
            if ($this->basic_pills_idex == 0)
                $active = 'active';
            $output_string = '
            <li class="' . $active . ' rs%position-basic-pills%rs">
                <a href="' . $attr['link'] . '">' . $attr['label'] . '</a>
            </li>
                ';
            ++$this->basic_pills_idex;

            return $output_string;
        }

        var $accordion_stacked_tabs_idex_p = 0;
        var $accordion_stacked_tabs_idex_c = 0;

        function accordion_stacked_tabs_container($attr, $content) {
            ob_start();
            ?>
            <style>
                #accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.nav-tabs.nav-stacked>li>a {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container .accordion-body {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container .accordion-body.in.collapse {
                    border-bottom: 1px solid <?php echo $attr['brd_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container.nav-tabs.nav-stacked>li:last-child .accordion-body.in.collapse {
                    border-bottom-width: 0px !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container.nav-tabs.nav-stacked>li:last-child .accordion-inner {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container.nav-tabs.nav-stacked>li span.minus-icon {
                    color: <?php echo $attr['mns_sign_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container.nav-tabs.nav-stacked>li>a {
                    background-color: <?php echo $attr['act_bg_color'] ?> !important;
                    color: <?php echo $attr['act_txt_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container.nav-tabs.nav-stacked>li>a.collapsed {
                    background-color: <?php echo $attr['inact_bg_color'] ?> !important;
                    color: <?php echo $attr['inact_txt_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container.nav-tabs.nav-stacked>li>a:hover,
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container.nav-tabs.nav-stacked>li>a:focus
                {
                    background-color: <?php echo $attr['hover_bg_color'] ?> !important;
                    color: <?php echo $attr['hover_txt_color'] ?> !important;
                }
                ul#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>.accordion_stacked_tabs_container .accordion-body .accordion-inner {
                    background-color: <?php echo $attr['ctn_bg_color'] ?> !important;
                    color: <?php echo $attr['ctn_txt_color'] ?> !important;
                }
            </style>
            <ul class="nav nav-tabs nav-stacked <?php echo $attr['class'] ?> accordion_stacked_tabs_container" id="accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>"><?php echo do_shortcode($content); ?></ul>
            <?php
            ++$this->accordion_stacked_tabs_idex_p;
            $this->accordion_stacked_tabs_idex_c = 0;

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function accordion_stacked_tabs($attr, $content) {
            if ($attr['default_tab'] == 'default') {
                $active = 'in';
            } else {
                $collapsed = 'collapsed';
            }
            ob_start();
            ?>
            <li><a href="#accordion_stacked_tabs<?php echo $this->accordion_stacked_tabs_idex_p . $this->accordion_stacked_tabs_idex_c ?>" data-toggle="collapse" class="<?php echo $collapsed ?>" data-parent="#accordion_stacked_tabs_container<?php echo $this->accordion_stacked_tabs_idex_p ?>"><?php echo $attr['label']; ?><span class="minus-icon"> &minus; </span></a><div id="accordion_stacked_tabs<?php echo $this->accordion_stacked_tabs_idex_p . $this->accordion_stacked_tabs_idex_c ?>" class="accordion-body collapse <?php echo $active; ?>"><div class="accordion-inner"><?php _e(do_shortcode($content)); ?></div></div></li>
            <?php
            ++$this->accordion_stacked_tabs_idex_c;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $accordion_stacked_pills_idex_p = 0;
        var $accordion_stacked_pills_idex_c = 0;

        function accordion_stacked_pills_container($attr, $content) {
            ob_start();
            ?>
            <style>
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li span.minus-icon {
                    color: <?php echo $attr['mns_sign_color'] ?> !important;
                }
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li div.accordion-inner {
                    color: <?php echo $attr['ctn_txt_color'] ?> !important;
                }
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li >a {
                    background-color: <?php echo $attr['act_bg_color'] ?> !important;
                    color: <?php echo $attr['act_txt_color'] ?> !important;
                }
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li a.collapsed {
                    background-color: <?php echo $attr['inact_bg_color'] ?> !important;
                    color: <?php echo $attr['inact_txt_color'] ?> !important;
                }
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li >a:hover,
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li >a:focus {
                    background-color: <?php echo $attr['hover_bg_color'] ?> !important;
                    color: <?php echo $attr['hover_txt_color'] ?> !important;
                }
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li a.collapsed:hover,
                ul#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>.accordion_stacked_pills_container.nav-pills.nav-stacked>li a.collapsed:focus {
                    background-color: <?php echo $attr['hover_bg_color'] ?> !important;
                    color: <?php echo $attr['hover_txt_color'] ?> !important;
                }
            </style>
            <ul class="nav nav-pills nav-stacked <?php echo $attr['class'] ?> accordion_stacked_pills_container" id="accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_p ?>">
                <?php echo do_shortcode($content); ?>
            </ul>
            <?php
            ++$this->accordion_stacked_pills_idex_p;
            $this->accordion_stacked_pills_idex_c = 0;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function accordion_stacked_pills($attr, $content) {
            if ($attr['default_tab'] == 'default') {
                $active = 'in';
            } else {
                $collapsed = 'collapsed';
            }
            ob_start();
            ?>
            <li><a href="#accordion_stacked_pills<?php echo $this->accordion_stacked_pills_idex_p . $this->accordion_stacked_pills_idex_c ?>" data-toggle="collapse" class="rs-accordion_stacked_pills <?php echo $collapsed ?>" data-parent="#accordion_stacked_pills_container<?php echo $this->accordion_stacked_pills_idex_c ?>"><?php echo $attr['label']; ?><span class="minus-icon"> &minus; </span></a><div id="accordion_stacked_pills<?php echo $this->accordion_stacked_pills_idex_p . $this->accordion_stacked_pills_idex_c ?>" class="accordion-body collapse <?php echo $active; ?>"><div class="accordion-inner"><?php _e(do_shortcode($content)); ?></div></div></li>
            <?php
            ++$this->accordion_stacked_pills_idex_c;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function divider($attr, $content) {
            ob_start();
            $style = 'border-top-style: ' . $attr['type'] . ';';

            $width = $attr['brd_width'];
            switch ($attr['type']) {
                case 'solid':
                    if ($width < 1)
                        $width = 1;
                    break;
                case 'dotted':
                    if ($width < 3)
                        $width = 3;
                    break;
                case 'dashed':
                    if ($width < 2)
                        $width = 2;
                    break;
                case 'double':
                    if ($width < 3)
                        $width = 3;
                    break;
                case 'groove':
                    if ($width < 3)
                        $width = 3;
                    break;
                case 'ridge':
                    if ($width < 3)
                        $width = 3;
                    break;
                case 'inset':
                    if ($width < 2)
                        $width = 2;
                    break;
                case 'outset':
                    if ($width < 2)
                        $width = 2;
                    break;
            }

            $style .= 'border-top-width: ' . $width . 'px;';

            $tmp = '';
            if ($attr['brd_color'])
                $tmp = $attr['brd_color'];
            else
                $tmp = '#333333';
            $style .= 'border-top-color: ' . $tmp . ';';
            ?>
            <div class="divider-rs" style="<?php echo $style; ?>"></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function highlight($attr, $content) {
            ob_start();

            if ($attr['type'] == 'label-success' || $attr['type'] == 'label-warning' || $attr['type'] == 'label-important' || $attr['type'] == 'label-info' || $attr['type'] == 'label-inverse') {
                $type = $attr['type'];
            }
            ?>
            <span class="label <?php echo $type . ' ' . $attr['class']; ?>"><?php _e($attr['label']); ?></span>
            <?php
            if ($attr['wrap'] == 'no')
                echo '<div class="clear"></div>';

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function badges($attr, $content) {
            if ($attr['type'] == 'badge-success' || $attr['type'] == 'badge-warning' || $attr['type'] == 'badge-important' || $attr['type'] == 'badge-info' || $attr['type'] == 'badge-inverse') {
                $type = $attr['type'];
            }
            ob_start();
            ?>
            <span class="badge <?php echo $type . ' ' . $attr['class']; ?>"><?php _e($attr['label']); ?></span>
            <?php
            if ($attr['wrap'] == 'no')
                echo '<div class="clear"></div>';
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function alerts($attr, $content) {
            ob_start();

            $type = '';

            if ($attr['type'] == 'alert-success' || $attr['type'] == 'alert-danger' || $attr['type'] == 'alert-info') {
                $type = $attr['type'];
            }
            ?>
            <div class="alert <?php echo $type ?> fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading"><?php _e($attr['label']) ?></h4>
                <p><?php _e($content) ?></p>
            </div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function progress_bar($attr, $content) {
            ob_start();
            $percent = $attr['percent'] . '%';

            $option = '';
            if ($attr['option'] == 'progress-striped' || $attr['option'] == 'progress-striped active') {
                $option = $attr['option'];
            }
            $style = '';
            if ($attr['style'] == 'progress-danger' || $attr['style'] == 'progress-success' || $attr['style'] == 'progress-info' || $attr['style'] == 'progress-warning') {
                $style = $attr['style'];
            }
            ?>
            <div class="progress <?php echo $option . ' ' . $style; ?>">
                <div class="bar" style="width: <?php echo $percent ?>;"></div>
            </div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $service_idex = 0;
        var $service_num = 0;

        function services_group($attr, $content) {
            $this->service_idex = 0;

            $this->service_num = $attr['column'];
            ob_start();
            $content_tmp = do_shortcode($content);

            echo do_shortcode($content_tmp);
            echo '</div>';

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function service($attr, $content) {
            ob_start();
            $output_string = '';

            if ($this->service_num != 1 && $this->service_num != 2 && $this->service_num != 3 && $this->service_num != 4 && $this->service_num != 6) {
                $this->service_num = 1;
            }

            if ($this->service_idex != 0)
                if (($this->service_idex % $this->service_num) == 0)
                    $output_string .= '</div>';
            if (($this->service_idex % $this->service_num) == 0)
                $output_string .= '<div class="row-fluid rs-service">';

            switch ($this->service_num) {
                case 2:
                    $span_num = 6;
                    break;
                case 3:
                    $span_num = 4;
                    break;
                case 4:
                    $span_num = 3;
                    break;
                case 6:
                    $span_num = 2;
                    break;
                default :
                    $span_num = 12;
                    break;
            }

            $tmp = trim($attr['link']);
            $link = '';
            if ($tmp != '' && $tmp != '#')
                $link = $attr['link'];
            $output_string .= '<div class="media span' . $span_num . '">';
            if ($link) {
                if ($attr['img_url']) {
                    $output_string .= '<a class="rs-a-img ' . $attr['position'] . '" href="' . $attr['link'] . '">';
                    $output_string .= '<img class="media-object rs-service-img-size' . $attr['size'] . '" src="' . $attr['img_url'] . '" />';
                    $output_string .= '</a>';
                }
                if ($attr['icon_nm']) {
                    $output_string .= '<a class="rs-a-icon ' . $attr['position'] . '" href="' . $attr['link'] . '">';
                    if ($attr['size'])
                        $output_string .= '<i class="' . $attr['position'] . ' ' . $attr['icon_nm'] . '" style="font-size:' . $attr['size'] . 'px; color:' . $attr['icon_color'] . '"></i>';
                    else
                        $output_string .= '<i class="' . $attr['position'] . ' ' . $attr['icon_nm'] . '" style="color:' . $attr['icon_color'] . '"></i>';
                    $output_string .= '</a>';
                }
            } else {
                if ($attr['img_url'])
                    $output_string .= '<img class="media-object ' . $attr['position'] . ' rs-service-img-size' . $attr['size'] . '" src="' . $attr['img_url'] . '" />';
                if ($attr['icon_nm']) {
                    if ($attr['size'])
                        $output_string .= '<i class="' . $attr['position'] . ' ' . $attr['icon_nm'] . '" style="font-size:' . $attr['size'] . 'px; color:' . $attr['icon_color'] . '"></i>';
                    else
                        $output_string .= '<i class="' . $attr['position'] . ' ' . $attr['icon_nm'] . '" style="color:' . $attr['icon_color'] . '"></i>';
                }
            }

            $output_string .= '<div class="media-body"><h4 class="media-heading">';
            if ($link)
                $output_string .= '<a class="rs-title-a" href="' . $attr['link'] . '">';
            $output_string .= $attr['title'];
            if ($link)
                $output_string .= '</a>';
            $output_string .= '</h4>' . $content;
            $output_string .= '</div></div>';

            echo $output_string;
            $output_string = ob_get_contents();
            ob_end_clean();
            ++$this->service_idex;
            return $output_string;
        }

        var $box_content_idx = 0;

        function box_content($attr, $content) {
            ob_start();
            $style = '';
            $box_content = '';
			$print_html = '';
            $link = '';
            $link2 = '';
            $tmp = trim($attr['link']);
            if ($tmp != '') {
                    if ($attr['new_win'] == "yes") {
                        $link3 .= ' target="_blank"';
                    }
            }            $do_shortcode = do_shortcode($content);
            if ($attr['style'] == 'basic_block') {
                if ($attr['bkg_color'])
                    $style .= 'background-color: ' . $attr['bkg_color'];
                if ($attr['txt_color'])
                    $style .= '; color: ' . $attr['txt_color'];
                if ($attr['brd_color'])
                    $style .= '; border-color: ' . $attr['brd_color'];
				if ($attr['link'])
					$link .= '<a class="basic_block_link" href="' . $tmp . '" ' . $link3 . '>';
				if ($attr['link'])
					$link2 .= '</a>';
                $box_content = '' . $link . '<div class="basic_block_rs" style="' . $style . '">' . $do_shortcode . '</div>' . $link2 . '';
            } else if ($attr['style'] == 'lined_paper') {
                if ($attr['bkg_color'])
                    $style .= 'background-color: ' . $attr['bkg_color'];
                if ($attr['txt_color'])
                    $style .= '; color: ' . $attr['txt_color'];
                if ($attr['brd_color']) {
                    $style .= '; border-color: ' . $attr['brd_color'];
                    $style .= '; background: -webkit-linear-gradient(top, ' . $attr['brd_color'] . ' 0%, ' . $attr['bkg_color'] . ' 8%) 0 4px; ';
                    $style .= '; background: -webkit-gradient(linear, 0 0, 0 100%, from(' . $attr['brd_color'] . '), color-stop(4%, ' . $attr['bkg_color'] . ')) 0 4px; ';
                    $style .= 'background: -moz-linear-gradient(top, ' . $attr['brd_color'] . ' 0%, ' . $attr['bkg_color'] . ' 8%) 0 4px; ';
                    $style .= 'background: -ms-linear-gradient(top, ' . $attr['brd_color'] . ' 0%, ' . $attr['bkg_color'] . ' 8%) 0 4px;';
                    $style .= 'background: -o-linear-gradient(top, ' . $attr['brd_color'] . ' 0%, ' . $attr['bkg_color'] . ' 8%) 0 4px;';
                    $style .= 'background: linear-gradient(top, ' . $attr['brd_color'] . ' 0%, ' . $attr['bkg_color'] . ' 8%) 0 4px;';


                    $style .= '; -webkit-background-size: 100% 20px; -moz-background-size: 100% 20px; -ms-background-size: 100% 20px; -o-background-size: 100% 20px; background-size: 100% 20px;';
                }

                $box_content = '<div id="lined_paper_rs' . $this->box_content_idx . '" class="lined_paper_rs"><div class="paper" style="' . $style . '">';
                $box_content .= $do_shortcode;
                $box_content .= '</div></div>';
            } else if ($attr['style'] == 'box_in_box') {
                if ($attr['bkg_color'])
                    $style .= 'background-color: ' . $attr['bkg_color'];
                if ($attr['txt_color'])
                    $style .= '; color: ' . $attr['txt_color'];
                if ($attr['brd_color'])
                    $style .= '; border-color: ' . $attr['brd_color'];

                $out_style = '';
                if ($attr['out_bkg_color'])
                    $out_style .= 'background-color: ' . $attr['out_bkg_color'];
                ;
                if ($attr['out_brd_color'])
                    $out_style .= ';border-color:' . $attr['out_brd_color'];
                ;
                if ($attr['width_btw_brd'])
                    $out_style .= ';padding: ' . $attr['width_btw_brd'] . 'px';
                $box_content = '<div class="rs-out-basic-block" style="' . $out_style . '"><div class="basic_block_rs" style="' . $style . '">' . $do_shortcode . '</div></div>';
            }

            if ($attr['style'] == 'lined_paper') {
                $tmp = '<style>';
                $tmp .= '#lined_paper_rs' . $this->box_content_idx . '.lined_paper_rs .paper::before {';
                $tmp .= 'border-color: transparent ' . $attr['brd_color'] . ';';
                $tmp .= '}';
                $tmp .= '</style>';
                $box_content = $tmp . $box_content;
            }

            echo do_shortcode($box_content);
            ++$this->box_content_idx;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function button($attr, $content) {
            $class = 'btn';
            if ($attr['size'])
                $class .= ' ' . $attr['size'];
            if ($attr['type'])
                $class .= ' ' . $attr['type'];
            if ($attr['full_width'] == 'yes') {
                $class .= ' btn-block';
            } else {
                if ($attr['position'] == 'right')
                    $class .= ' pull-right';
                elseif ($attr['position'] == 'left')
                    $class .= ' pull-left';
//elseif ($attr['position'] != 'center')
            }
            if ($attr['custom_type'])
                $class .= ' ' . $attr['custom_type'];

            $link = '';
            $tmp = trim($attr['link']);
            if ($tmp != '') {
                if ($tmp != '#') {
                    $link .= 'href="' . $tmp . '"';
                    if ($attr['new_win'] == "yes") {
                        $link .= ' target="_blank"';
                    }
                }
            }

            $label = 'button';
            if ($attr['label'])
                $label = $attr['label'];

            ob_start();

            $style = '';
            if ($attr['btn_txt_color'])
                $style .= 'color:' . $attr['btn_txt_color'] . ';';
            if ($attr['btn_bkg_color'])
                $style .= 'background-color:' . $attr['btn_bkg_color'] . ';';


            $button = '';
            if ($attr['position'] == 'center')
                $button .= '<div class="rs-button-center">'; //btn-block
            $button .= '<a ' . $link . ' class="' . $class . ' button-rs" style="' . $style . '">';
//echo do_shortcode($content);
            $button .= $label;
            $button .= '</a>';
            if ($attr['position'] == 'center')
                $button .= '</div>';
            if ($attr['wrap'] == 'no')
                $button .= '<div class="clear"></div>';

            echo $button;

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function image($attr, $content) {
            ob_start();

            $style = '';
            $tmp = trim($attr['margin']);
            if ($tmp)
                $style .= 'margin:' . $tmp . ';';

            $img_style = '';
            $tmp = trim($attr['height']);
            if ($tmp)
                $img_style .= 'height:' . $tmp . 'px;';

            $tmp = trim($attr['width']);
            if ($tmp)
                $img_style .= 'width:' . $tmp . 'px;';

            $img_class = '';
            if ($attr['type'] == 'img-rounded' || $attr['type'] == 'img-circle') {
                $img_class = $attr['type'];
            }
			
            $rs_imgs = '';
            if ($attr['border'] == 'img-polaroid') {
                $rs_imgs = 'rs-imgs';
            } else if ($attr['border'] == 'default') {
				$rs_imgs = 'rs-no-border';
			}

            $tmp = trim($attr['width']);
            if ($tmp)
                $rs_imgs = '';

            $link = '';
            $tmp = trim($attr['link']);
            if ($tmp != '') {
                if ($tmp != '#') {
                    $link .= 'href="' . $tmp . '"';
                    if ($attr['new_win'] == "yes") {
                        $link .= ' target="_blank"';
                    }
                }
            }

            $pos = '';

            if ($attr['pos'] == 'pull-left' || $attr['pos'] == 'pull-right') {
                $pos = $attr['pos'];
            }
            if ($attr['wrap'] == 'no') {
                $pos .= ' wrap-no';
            }

            if ($attr['pos'] == 'center')
                $image .= '<div class="rs-image-center">';

            if ($link) {
                $thumbnail = '';
                if ($attr['type'] == 'img-circle')
                    $thumbnail = 'rs-a-img-circle thumbnail';
                else
                    $thumbnail = 'thumbnail';

                if ($attr['border'] == 'img-polaroid') {
                    $thumbnail .= ' ' . $attr['border'];
				} else if ($attr['border'] == 'default') {
					$thumbnail .= ' rs-no-border';
				}
				
                if ($attr['type'] == 'primary')
                    $thumbnail .= ' primary';
                $image .= '<a ' . $link . ' style="' . $style . '" class="rs-gen-img ' . $thumbnail . ' ' . $pos . '"><img src="' . $attr['img_url'] . '" class="' . $rs_imgs . ' ' . $img_class . '" alt="' . $attr['alt'] . '" title="' . $attr['alt'] . '" style="' . $img_style . '"></a>';
            } else {
                if ($attr['border'] == 'img-polaroid') {
                    $img_class .= ' ' . $attr['border'];
                } else if ($attr['border'] == 'default') {
					$img_class .= ' rs-no-border';
				}
                $img_class .= ' thumbnail ' . $pos;
                $image .= '<div style="' . $style . '" class="rs-gen-img ' . $img_class . ' ' . $thumbnail . '"><img src="' . $attr['img_url'] . '" class="' . $rs_imgs . ' ' . $attr['type'] . '" alt="' . $attr['alt'] . '" title="' . $attr['alt'] . '" style="' . $img_style . '"></div>';
            }
            if ($attr['pos'] == 'center')
                $image .= '</div>';
            if ($attr['wrap'] == 'no')
                $image .= '<div class="clear"></div>';

            echo $image;

            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $list_icon = 0;

        function list_icon($attr, $content) {
            ob_start();
			
            $style = '';
			$line_height = '';
            if ($attr['txt_color']) {
                $style .= 'color:' . $attr['txt_color'] . ';';
            }
            if ($attr['txt_size']) {
                $style .= 'font-size:' . $attr['txt_size'] . 'px;';
				$line_height = 'style="line-height:' . $attr['txt_size'] . 'px;"';
            }
			
			$content = str_ireplace( '<li>', '<li><i class="' . $attr['option'] . '" style="' . $style . '"></i><span class="rs-list-content" ' . $line_height  . '>', $content );
			$content = str_ireplace( '</li>', '</span></li>', $content );
			
            /*if ($attr['txt_size']) {
               ?>
                <style>
                    #rs-list-icon<?php echo $this->list_icon ?> li:hover i {
                        color: <?php echo $attr['hover_color'] ?> !important;
                    }
                </style>
                <?php
            }*/
            ?>
            <div id='rs-list-icon<?php echo $this->list_icon ?>' class="rs-<?php echo $attr['option'] ?> rs-list-icon">
                <?php echo $content ?>
            </div>
            <?php
            ++$this->list_icon;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $insert_icon = 0;
		
        function insert_icon($attr, $content) {
            ob_start();
//$do_shortcode = do_shortcode($content);
            $style = '';
            if ($attr['txt_size'])
                $style .= 'font-size:' . $attr['txt_size'] . 'px;';
            if ($attr['txt_color'])
                $style .= 'color:' . $attr['txt_color'] . ';';
			if ($attr['new_win']=="yes")
				$target .='target=_blank';
			
			$print_html = '';
			
            $tmp = trim($attr['link']);
			
			$a_id = '';
			$i_id = '';
			
			if ($tmp != '') {
				$a_id = 'id="rs-insert-icon' . $this->insert_icon . '"';
			}
			
            if ($tmp != '')
               $print_html .= '<a ' . $target . ' ' . $a_id . ' href="' . $tmp . '" class="rs-icon rs-insert-icon">';
				
            $print_html .= '<i ' . $i_id . ' class="' . $attr['option'] . '" style="' . $style . '"></i>';
			
            if ($tmp != '')
               $print_html .= '</a>';
			
			if ($attr['txt_size'] && $attr['hover_color'] && $attr['txt_color']) {
                //$print_html .= '<script language="javascript">jQuery(document).ready(function(){jQuery("#rs-insert-icon' . $this->insert_icon . '").hover(function(){this.style.color="' . $attr['hover_color'] . '"},function(){this.style.color="' . $attr['txt_color'] . '"})})
                //$print_html .= '<style>#rs-insert-icon' . $this->insert_icon . ':hover i{color:' . $attr['hover_color'] . '!important;} a.rs-insert-icon:hover {opacity:1;}</style>';
            }
			
			echo $print_html;
			
			++$this->insert_icon;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function space($attr, $content) {
            ob_start();
            ?>
            <div class="space" style="margin-top: <?php echo $attr['space']; ?>px;"></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }
		
		var $respondo_header_index = 0;
		
		function parse_shortcode_content( $content ) {
			$content = trim( do_shortcode( shortcode_unautop( $content ) ) );
			if ( substr( $content, 0, 4 ) == '' )
				$content = substr( $content, 4 );
			if ( substr( $content, -3, 3 ) == '' )
				$content = substr( $content, 0, -3 );
			$content = str_replace( array( '<p></p>' ), '', $content );
			$content = str_replace( array( '<p>  </p>' ), '', $content );

			return $content;
		}

		function header($attr, $content) {
            ob_start();
			$this->respondo_header_index++;
			// $content = strip_tags( $this->parse_shortcode_content($content) );
			$content = strip_tags( do_shortcode($content) );
			?>
            <style>@media screen and (min-width:800px) {<?php echo $attr['type']; ?>.rs-header<?php echo $this->respondo_header_index; ?>{font-size:<?php echo $attr['fontsize']; ?>px;line-height:<?php echo $attr['lineheight']; ?>px;display:block;}}<?php echo $attr['type']; ?>.rs-header<?php echo $this->respondo_header_index; ?>{text-align:<?php echo $attr['align']; ?>;color:<?php echo $attr['font_color']; ?>;font-style:<?php echo $attr['font_style']; ?>;text-decoration:<?php echo $attr['text_decoration']; ?>;font-weight:<?php echo $attr['font_weight']; ?>;}</style><<?php echo $attr['type']; ?> class="rs-header<?php echo $this->respondo_header_index; ?>"><?php echo $content; ?></<?php echo $attr['type']; ?>>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

		var $responsive_container_index = 0;
		
		function responsive($attr, $content) {
            ob_start();
			$this->responsive_container_index++;
            ?>
			<?php if( $attr['display'] == 'hide' ) { ?><style>@media screen and (max-width: <?php echo $attr['width']; ?>px) {div#responsive_container<?php echo $this->responsive_container_index; ?> {display:none;} }</style><?php } else { ?><style>@media screen and (min-width: <?php echo $attr['width']; ?>px) {div#responsive_container<?php echo $this->responsive_container_index; ?> {display:none;} }</style><?php } ?><div id="responsive_container<?php echo $this->responsive_container_index; ?>"><?php echo do_shortcode($content); ?></div>
			<?php
			$output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
		}
		
        var $testimonial = 0;

        function testimonial($attr, $content) {
            ob_start();
            ++$this->testimonial;
            ?>
            <style>
                #testimonial_rs<?php echo $this->testimonial ?>.testimonial_rs .content {
                    color: <?php echo $attr['txt_color'] ?> !important;
                    background-color: <?php echo $attr['bkg_color'] ?> !important;
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                }
                #testimonial_rs<?php echo $this->testimonial ?>.testimonial_rs .point_rs_grp .point_rs_brd::before {
                    border-color: <?php echo $attr['brd_color'] ?> !important;
                    border-right-color: transparent !important;
                    border-bottom-color: transparent !important;
                }
                #testimonial_rs<?php echo $this->testimonial ?>.testimonial_rs .point_rs_grp .point_rs_bg::before {
                    border-color: <?php echo $attr['bkg_color'] ?> !important;
                    border-right-color: transparent !important;
                    border-bottom-color: transparent !important;
                }
            </style>
            <div class="clear"></div>
            <div id="testimonial_rs<?php echo $this->testimonial ?>" class="testimonial_rs">
                <div class="content"><?php echo do_shortcode($content); ?></div>
                <div class="clear"></div>
                <div class="point_rs_grp"><div class="point_rs_brd"></div><div class="point_rs_bg"></div></div>
                <div class="user_icon"></div>
                <div class="meta">
                    <?php
                    $meta = '<strong>' . $attr['name'] . '</strong>';
                    $tmp = trim($attr['job_title']);
                    if ($tmp)
                        $meta .= '&nbsp;&nbsp;&nbsp;&nbsp;<span>' . $tmp . '</span>';

                    $a_tmp = trim($attr['link']);
                    $space = '&nbsp;&nbsp;&nbsp;&nbsp;';

                    if ($a_tmp)
                        $meta .= $space . '<a href="' . $attr['link'] . '">';
                    $tmp = trim($attr['company']);

                    if ($tmp) {
                        if (!$a_tmp)
                            $meta .= $space;
                        $meta .= '<span>' . $attr['company'] . '</span>';
                    }

                    if ($a_tmp)
                        $meta .= '</a>';

                    echo $meta;
                    ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function blog_posts($attr, $content) {
            ob_start();

            $class = 'row-fluid';

            /*
             * Blog Shortcode Working
             */
            if ($attr['number_of_columns'] == 'full')
                $class = 'row-fluid rs-blog-post fullblog';
            $order_v = $attr['order'];

            switch ($order_v) {
                case 'ascending_date':
                    $orderby = 'post_date';
                    $order = 'ASC';
                    break;
                case 'descending_date':
                    $orderby = 'post_date';
                    $order = 'DESC';
                    break;
                case 'ascending_alpha':
                    $orderby = 'post_title';
                    $order = 'ASC';
                    break;
                case 'descending_alpha':
                    $orderby = 'post_title';
                    $order = 'DESC';
                    break;
                default :
                    $orderby = '';
                    $order = '';
                    break;
            }

            $category_slug = $attr['category'];
            $category_id = 0;
            if ($category_slug) {
                $idObj = get_category_by_slug($category_slug);
                $category_id = $idObj->term_id;
            }

            $number_of_display_blog = trim($attr['number_of_display_blog']);
            $pos_f_img = $attr['pos_f_img'];
            $number_of_columns = $attr['number_of_columns'];
            $image_sh = $attr['image_sh'];
            $excerpt_sh = $attr['excerpt_sh'];
            $title_sh = $attr['title_sh'];
            $meta_sh = $attr['meta_sh'];
            $divider_b_ttl_fimg = $attr['divider_b_ttl_fimg'];

            if ($image_sh == 'hide' && $excerpt_sh == 'hide' && $title_sh == 'hide' && $meta_sh == 'hide')
                return;
            ?>
            <div class="clear"></div>
            <div class="<?php echo $class; ?>">
                <?php
                global $wpdb;
                $sql_str = "SELECT DISTINCT(ID) AS ID FROM " . $wpdb->prefix . "posts AS posts INNER JOIN " . $wpdb->prefix . "term_relationships AS term_relationships WHERE posts.post_status='publish' AND posts.post_type='post' AND posts.ID=term_relationships.object_id ";
                if ($category_id)
                    $sql_str .= " AND term_relationships.term_taxonomy_id=" . $category_id;
                if ($order)
                    $sql_str .= " ORDER BY " . $orderby . " " . $order;

                if ($number_of_display_blog == '' || $number_of_display_blog < 0)
                    $number_of_display_blog = 4;

                if ($number_of_display_blog > 0)
                    $sql_str .= " LIMIT 0," . $number_of_display_blog;

                //echo $sql_str;
                $myposts = array();
                $myposts = $wpdb->get_results($sql_str);

                $blog_posts_idex = 0;
                if (count($myposts) != 0) {
                    foreach ($myposts as $post1) :
                        $args = array('page_id' => $post1->ID);
                        $post2 = get_posts($args);
                        $post = $post2[0];
                        setup_postdata($post);
                        if ($number_of_columns == '2' || $number_of_columns == '3' || $number_of_columns == '4') {
                            if ($blog_posts_idex == 0)
                                echo '<div class="row-fluid rs-blog-post">';

                            if (($blog_posts_idex % $number_of_columns) == 0)
                                echo '</div><div class="row-fluid rs-blog-post">';

                            echo '<div class="span' . (12 / $number_of_columns) . '">';
                        }
                        ?>
                        <div class="<?php echo ($number_of_columns == 'full') ? 'blog-single-post rssc' : 'rs-container' ?>">
                            <?php
                            $title_section = '';
                            if ($title_sh != 'hide') {
                                $title_section .= '<section>';
                                $tmp = '';
                                if ($divider_b_ttl_fimg == 'no')
                                    $tmp = 'no';
                                $title_section .= '<div class="page-header rs-bhead ' . $tmp . '">';
                                $title_section .= '<h2><a href="' . get_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a></h2>';
                                $title_section .= '</div>';
                                $title_section .= '</section>';
                            }
                            if ($meta_sh == 'show' && $number_of_columns == 'full') {
                                $author_url = get_author_posts_url(get_the_author_meta($post->post_author));
                                $post_date = date(get_option('date_format'), strtotime($post->post_date));

                                $categories = get_the_category($post->ID);
                                $separator = ', ';
                                $cate_str = '';
                                if ($categories) {
                                    $idx = 1;
                                    foreach ($categories as $category) {
                                        $cate_str .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '">' . $category->cat_name . '</a>';
                                        if (count($categories) != $idx)
                                            $cate_str .= $separator;
                                        ++$idx;
                                    }
                                }

                                $comment_cnt = 0;
                                $comment_cnt = wp_count_comments($post->ID)->total_comments;

                                $meta_str = '
                                <div class="clearfix"></div>
                                <div class="meta-post" style="float: left; width: 100%">
                                    <ul>
                                        <li><i class="icon-user"></i> By <a href="' . $author_url . '">' . get_the_author_meta('display_name', $post->post_author) . '</a></li>
                                        <li><i class="icon-calendar"></i> ' . $post_date . '</li>
                                        <li><i class="icon-comment"></i> ' . $comment_cnt . ' Comments</li>
                                        <li><i class="icon-align-justify"></i> ' . $cate_str . '</li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
';
                            }
                            if ($image_sh != 'hide') {
                                if (has_post_thumbnail($post->ID)) {
                                    $tmp = '';
                                    if ($attr['img_type'] == 'img-rounded' || $attr['img_type'] == 'img-circle') {
                                        $tmp .= $attr['img_type'];
                                    }

                                    if ($tmp)
                                        $img_attr = array('class' => $tmp);

                                    if ($number_of_columns == 'full' || $pos_f_img == 'bottom')
                                        echo $title_section;

                                    $thumbnail = '';
                                    if ($attr['img_type'] == 'img-circle')
                                        $thumbnail = 'rs-a-img-circle';
                                    if ($attr['img_type'] == 'img-rounded')
                                        $thumbnail = 'rs-a-img-rounded ';
                                    if ($attr['img_type'] == 'primary')
                                        $thumbnail = 'rs-a-img-primary';
                                    if ($attr['img_border'] == 'img-polaroid')
                                        $thumbnail .= ' rs-imgs ' . $attr['img_border'];

                                    $thumbnail .= ' thumbnail';

                                    if ($number_of_columns == 'full')
                                        echo $meta_str;
                                    ?>
                                    <div class = "rs-blog-f-img">
                                        <?php
                                        if ($number_of_columns != 'full')
                                            echo $meta_str;
                                        if ($attr['img_border'] == 'img-polaroid') {
                                            $thumbnail .= ' rs-imgs ' . $attr['img_border'];
                                        }
                                        ?><a href = "<?php echo get_permalink($post->ID); ?>" class = "rs-above <?php echo $thumbnail ?>"><?php echo get_the_post_thumbnail($post->ID, 'full', $img_attr) ?></a></div>
                                        <?php
                                        if (($number_of_columns != 'full') && ($pos_f_img == 'top'))
                                            echo $title_section;
                                    } else {
                                        echo $title_section . $meta_str;
                                    }
                                } else {
                                    echo $title_section . $meta_str;
                                }
                                if ($meta_sh == 'show' && $number_of_columns != 'full') {
                                    $author_url = get_author_posts_url(get_the_author_meta($post->post_author));
                                    $post_date = date(get_option('date_format'), strtotime($post->post_date));

                                    $categories = get_the_category($post->ID);
                                    $separator = ', ';
                                    $cate_str = '';
                                    if ($categories) {
                                        $idx = 1;
                                        foreach ($categories as $category) {
                                            $cate_str .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '">' . $category->cat_name . '</a>';
                                            if (count($categories) != $idx)
                                                $cate_str .= $separator;
                                            ++$idx;
                                        }
                                    }

                                    $comment_cnt = 0;
                                    $comment_cnt = wp_count_comments($post->ID)->total_comments;
                                    ?>
                                <div class="meta-post" style="float: left; width: 100%">
                                    <ul>
                                        <li><i class="icon-user"></i><div class="meta-item"><?php _e('By', 'rs_shortcode'); ?> <a href="<?php echo $author_url; ?>"><?php the_author_meta('display_name'); ?></a></div></li>
                                        <li><i class="icon-calendar"></i><div class="meta-item"><?php echo $post_date; ?></div></li>
                                        <li><i class="icon-comment"></i><div class="meta-item"><?php _e($comment_cnt); ?> <?php _e('Comments', 'rs_shortcode'); ?></div></li>
                                        <li><i class="icon-align-justify"></i><div class="meta-item"><?php echo $cate_str; ?></div></li>
                                    </ul>
                                </div><div class="clear"></div><?php
                            }

                            //the_content();
                            if ($excerpt_sh != 'hide') {
                                $tmp = do_shortcode( str_replace( array("\r\n", "\n", "\r"), "", get_the_content($post->ID)) );
                               echo $this->get_excerpt_str($tmp, 50) . "[...]";
                            }
                            ?>
                        </div>
                        <?php
                        if ($number_of_columns == '2' || $number_of_columns == '3' || $number_of_columns == '4') {
                            echo '</div>';
                        }
                        ++$blog_posts_idex;
                    endforeach;
                    if ($number_of_columns == '2' || $number_of_columns == '3' || $number_of_columns == '4') {
                        echo '</div>';
                    }
                }
                ?>
            </div><div class="clear"></div><?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $blog_posts_2_idex = 0;

        function blog_posts_2($attr, $content) {
            ob_start();
            global $wpdb;
            $sql_str = "SELECT DISTINCT(ID) AS ID FROM " . $wpdb->prefix . "posts AS posts INNER JOIN " . $wpdb->prefix . "term_relationships AS term_relationships WHERE posts.post_status='publish' AND posts.post_type='post' AND posts.ID=term_relationships.object_id ";
            $category_slug = $attr['category'];
            $category_id = 0;
            $category_name = '';
            $category_url = '';
            if ($category_slug) {
                $tmp_obj = get_category_by_slug($category_slug);
                $category_id = $tmp_obj->term_id;
                $category_name = $tmp_obj->name;
                $category_url = get_category_link($category_id);
            }

            if ($category_id)
                $sql_str .= " AND term_relationships.term_taxonomy_id=" . $category_id;
            $sql_str .= " ORDER BY post_date DESC";

            $number_of_display_blog = $attr['number_of_display_blog'];

            $sql_str .= " LIMIT 0," . $number_of_display_blog;
            $post_list = array();
            $post_list = $wpdb->get_results($sql_str);

            $post_cnt = count($post_list);
            ?>
            <style>
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box {
                    border: 1px solid <?php echo $attr['border_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .news_box_heading {
                    border-bottom: 1px solid <?php echo $attr['border_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_list {
                    border-top: 1px solid <?php echo $attr['border_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .news_box_heading {
                    background-color: <?php echo $attr['cate_bg_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .news_box_heading h2 a {
                    color: <?php echo $attr['cate_tt_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .news_box_heading a:focus,
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .news_box_heading a:hover {
                    color: <?php echo $attr['cate_tt_hover_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_item {
                    background-color: <?php echo $attr['cont_bg_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_item h4 a {
                    color: <?php echo $attr['cont_tt_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_item a:focus,
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_item a:hover {
                    color: <?php echo $attr['cont_tt_hover_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_contents {
                    color: <?php echo $attr['cont_txt_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_metas {
                    color: <?php echo $attr['meta_txt_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_metas a {
                    color: <?php echo $attr['meta_txt_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_metas a:focus,
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_metas a:hover {
                    color: <?php echo $attr['meta_txt_hover_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_list {
                    background-color: <?php echo $attr['posts_list_bg_color']; ?> !important;
                    color: <?php echo $attr['posts_list_txt_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_list ul li a {
                    color: <?php echo $attr['posts_list_txt_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_list ul li a:focus,
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_list ul li a:hover {
                    color: <?php echo $attr['posts_list_txt_hover_color']; ?> !important;
                }
                #blog_posts_2_<?php echo $this->blog_posts_2_idex ?> .news_box .recent_news_list .pos-left ul {
                    border-right-color: <?php echo $attr['split_line_color']; ?> !important;
                }
            </style>
            <div id="blog_posts_2_<?php echo $this->blog_posts_2_idex ?>" class="row-fluid box_outer rs-blog-posts-2">
                <div class="news_box" style="<?php echo ($attr['border_radius']) ? 'border-radius: ' . $attr['border_radius'] . 'px' : '' ?>">
                    <div class="news_box_heading"><h2>
                            <?php
                            if ($category_id) {
                                ?>
                                <a href="<?php echo $category_url ?>"><?php _e($category_name); ?></a>
                                <?php
                            } else {
                                _e('All Categories', 'rs_shortcode');
                            }
                            ?>
                        </h2></div>
                    <?php
                    if ($post_cnt != 0) {
                        foreach ($post_list as $post) :
                            $args = array('page_id' => $post->ID);
                            $post2 = get_posts($args);
                            $post = $post2[0];
                            setup_postdata($post);
                            ?>
                            <div class="recent_news_item">
                                <h4><a href="<?php _e(get_permalink($post->ID)); ?>"><?php _e(get_the_title($post->ID)); ?></a></h4>
                                <?php
                                if (has_post_thumbnail($post->ID)) {
                                    $img_attr = array(
                                        'alt' => get_the_title(),
                                        'title' => get_the_title(),
                                        'class' => 'blog-posts-2-img'
                                    );
                                    ?>
                                    <div class="recent_news_img pull-left"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_post_thumbnail($post->ID, '', array('class' => 'thumbnail')); ?></a></div>
                                    <?
                                }
                                ?>
                                <div class="recent_news_contents">
                                    <p>
                                        <?php
                                        $tmp = do_shortcode( str_replace( array("\r\n", "\n", "\r"), "", get_the_content($post->ID)) );
                                        echo $this->get_excerpt_str($tmp, 60) . "[...]";
                                        ?>
                                    </p>
                                </div><div class="clearfix"></div><div class="recent_news_metas"><span class="news_date"><i class="icon-calendar"></i>&nbsp;&nbsp;<?php echo date(get_option('date_format'), strtotime($post->post_date)); ?></span><span class="news_comments_count"><i class="icon-comment"></i>&nbsp;&nbsp;<a href="<?php _e(get_permalink($post->ID)); ?>/#comments">(<?php echo wp_count_comments($post->ID)->total_comments ?>) comments</a></span></div>
                            </div>
                            <?php
                            break;
                        endforeach;
                        if ($post_cnt > 1) {
                            ?><div class="clearfix"></div><div class="recent_news_list">
                                <div class="pos-left">
                                    <ul>
                                        <?php
                                        $news_idx = 0;
                                        foreach ($post_list as $post) :
                                            $args = array('page_id' => $post->ID);
                                            $post2 = get_posts($args);
                                            $post = $post2[0];
                                            setup_postdata($post);
                                            $tmp = round($number_of_display_blog / 2);

                                            if ($news_idx > 0 && $news_idx < $tmp) {
                                                ?>
                                                <li><i class="icon-angle-right"></i><span class="rs-list-content"><a title="<?php _e(get_the_title($post->ID)); ?>" href="<?php _e(get_permalink($post->ID)); ?>"><?php _e(get_the_title($post->ID)); ?></a></span></li>
                                                <?php
                                            }
                                            ++$news_idx;
                                        endforeach;
                                        ?>
                                </div>
                                <div class="pos-right">
                                    <ul>
                                        <?php
                                        $news_idx = 0;
                                        foreach ($post_list as $post) :
                                            $args = array('page_id' => $post->ID);
                                            $post2 = get_posts($args);
                                            $post = $post2[0];
                                            setup_postdata($post);
                                            if ($news_idx > ($tmp - 1)) {
                                                ?>
                                                <li><i class="icon-angle-right"></i><span class="rs-list-content"><a title="<?php _e(get_the_title($post->ID)); ?>" href="<?php _e(get_permalink($post->ID)); ?>"><?php _e(get_the_title($post->ID)); ?></a></span></li>
                                                <?php
                                            }
                                            ++$news_idx;
                                        endforeach;
                                        ?>
                                    </ul>
                                </div><div class="clearfix"></div></div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="recent_news_item">There is no news in this category</div>
                        <?php
                    }
                    ?><div class="clearfix"></div></div>
            </div>
            <?php
            ++$this->blog_posts_2_idex;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        var $for_layerslider_idx = 0;

        function blog_slider($attr, $content) {
			ob_start();
            $category_slug = $attr['category'];
            $category_id = 0;
            if ($category_slug) {
                $tmp_obj = get_category_by_slug($category_slug);
                $category_id = $tmp_obj->term_id;
            }
            $args = array(
                'numberposts' => $attr['number_of_display_blog'],
                'post_type' => 'post',
                'orderby' => 'post_date',
                'category' => $category_id,
                'order' => 'DESC'
            );
            $posts = get_posts($args);
			
			$max_width = 0;
			$max_height = 0;
			if (count($posts)) {
                    foreach ($posts as $post) {
						setup_postdata($post);
						if (has_post_thumbnail($post->ID)) {
							$tn_id = get_post_thumbnail_id( $post->ID );

							$img = wp_get_attachment_image_src( $tn_id, 'full' );
							$max_width = $max_width < $img[1] ? $img[1] : $max_width;
							$max_height = $max_height < $img[2] ? $img[2] : $max_height;
						}
					}
			}
			
			if( $max_width == 0 ) $max_width = '960px';
			if( $max_height == 0 ) $max_height = '480px';
            ?>
            <script type='text/javascript' src='<?php echo RESPONDO_SHORTCODE_PLUGIN_URL ?>jquery_plugin/layerslider/js/jquery-easing-1.3.js'></script><script type='text/javascript' src='<?php echo RESPONDO_SHORTCODE_PLUGIN_URL ?>jquery_plugin/layerslider/js/layerslider.kreaturamedia.jquery.js'></script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery("#rs-blog-slider-<?php echo $this->for_layerslider_idx ?>").layerSlider({
                        width : '<?php echo $max_width; ?>',
                        height : '<?php echo $max_height; ?>',
                        responsive : true,
                        responsiveUnder : 0,
                        sublayerContainer : 0,
                        autoStart : true,
                        pauseOnHover : false,
                        firstLayer : 1,
                        animateFirstLayer : false,
                        randomSlideshow : false,
                        twoWaySlideshow : true,
                        loops : 0,
                        forceLoopNum : true,
                        autoPlayVideos : false,
                        autoPauseSlideshow : 'auto',
                        keybNav : true,
                        touchNav : true,
                        skin : 'glass',
                        skinsPath : '<?php echo RESPONDO_SHORTCODE_PLUGIN_URL ?>jquery_plugin/layerslider/skins/',
                        globalBGColor : 'white',
                        navPrevNext : false,
                        navStartStop : false,
                        navButtons : false,
                        hoverPrevNext : false,
                        hoverBottomNav : false,
                        thumbnailNavigation : 'always',
                        tnWidth : 100,
                        tnHeight : 60,
                        tnContainerWidth : '60%',
                        tnActiveOpacity : 35,
                        tnInactiveOpacity : 100,
                        imgPreload : true,
                        yourLogo : false,
                        yourLogoStyle : 'position: absolute; left: 10px; top: 10px; z-index: 99;',
                        yourLogoLink : false,
                        yourLogoTarget : '_self',
                        cbInit : function(element) { },
                        cbStart : function(data) { },
                        cbStop : function(data) { },
                        cbPause : function(data) { },
                        cbAnimStart : function(data) { },
                        cbAnimStop : function(data) { },
                        cbPrev : function(data) { },
                        cbNext : function(data) { }
                    });
                });
            </script>
            <link rel='stylesheet' href='<?php echo RESPONDO_SHORTCODE_PLUGIN_URL ?>jquery_plugin/layerslider/css/layerslider.css' type='text/css' media='all' />
            <div id="rs-blog-slider-<?php echo $this->for_layerslider_idx ?>" class="rs-for-layerslider ls-wp-container" style="width: 960px; height: 480px; margin: 0px auto; ">
                <?php
                if (count($posts)) {
                    foreach ($posts as $post) : setup_postdata($post);
                        ?>
                        <div class="ls-layer">
                            <?php
                            if (has_post_thumbnail($post->ID)) {
                                //$feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                                echo get_the_post_thumbnail($post->ID, 'full', array('class' => 'ls-bg'));
                            } else {
                                ?>
                                <img src="<?php echo RESPONDO_SHORTCODE_PLUGIN_URL; ?>jquery_plugin/layerslider/skins/glass/nothumb.png" class="ls-bg">
                                <?php
                            }
                            $p_pref = '<h2 class="ls-s2" style="position: absolute; left: ' . ($max_width * 0.05) . 'px; durationin : 1500; durationout : 1500; easingin : easeInOutQuint; easingout : easeInOutQuint; delayin : 0; delayout : 0; showuntil : 0; font-family: \'HelveticaNeue-Light\', \'Helvetica Neue Light\', Helvetica, Arial, Serif; padding: 10px 10px; height: 36px; line-height: 36px; text-shadow: none; font-size: 25px; font-weight: normal; background-color: ' . $attr['title_bg_color'] . '; white-space: nowrap; opacity:' . ($attr['title_bg_tpare'] / 100) . ';margin: 0px; top:';
                            $p_c = 'px;">';
                            $p_suf = '</p>';

                            $title_txt = get_the_title($post->ID);

                            $title_txt_a = explode(' ', $title_txt);

                            $idx = 0;
                            $title_con = '';
                            $title_con_a = array();
                            $idx_t = 0;
                            foreach ($title_txt_a as $word) {
                                $title_con .= ' ' . $word;
                                ++$idx;
                                if ($idx % 10 == 0) {
                                    $title_con_a[$idx_t] = $title_con;
                                    $title_con = '';
                                    ++$idx_t;
                                }
                            }

                            if ($idx % 10 != 0) {
                                $title_con_a[$idx_t] = $title_con;
                            }
                            $top = $max_height - 30;
                            $idx = count($title_con_a);

                            foreach ($title_con_a as $title_con) {
                                echo $p_pref . ($top - 60 * $idx) . $p_c . '<a href="' . get_permalink($post->ID) . '" style="color: ' . $attr['title_txt_color'] . '; " class="rs-title-blog-slider">' . $title_con . '</a>' . $p_suf;
                                --$idx;
                            }
                            ?>
                        </div>
                        <?php
                    endforeach;
                }
                ?>
            </div>
            <div class="clearfix"></div>
            <?php
            ++$this->for_layerslider_idx;
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function portfolio($attr, $content) {
            ob_start();

            $class = 'row-fluid';
            if ($attr['number_of_columns'] == 'full')
                $class = 'row-fluid rs-portfolio fullportfolio';

            $order_v = $attr['order'];
            switch ($order_v) {
                case 'ascending_date':
                    $orderby = 'post_date';
                    $order = 'ASC';
                    break;
                case 'descending_date':
                    $orderby = 'post_date';
                    $order = 'DESC';
                    break;
                case 'ascending_alpha':
                    $orderby = 'post_title';
                    $order = 'ASC';
                    break;
                case 'descending_alpha':
                    $orderby = 'post_title';
                    $order = 'DESC';
                    break;
                default :
                    $orderby = '';
                    $order = '';
                    break;
            }

            $category_slug = $attr['category'];
            $category_id = 0;
            if ($category_slug) {
                $idObj = get_term_by('slug', $category_slug, 'category-portfolio');
                $category_id = $idObj->term_id;
            }

            $number_of_display_portfolio = trim($attr['number_of_display_portfolio']);
            $pos_f_img = $attr['pos_f_img'];
            $number_of_columns = $attr['number_of_columns'];
            $image_sh = $attr['image_sh'];
            /*$excerpt_sh = $attr['excerpt_sh'];*/
            $title_sh = $attr['title_sh'];
            $divider_b_ttl_fimg = $attr['divider_b_ttl_fimg'];
            if ($image_sh == 'hide' && $excerpt_sh == 'hide' && $title_sh == 'hide')
                return;
            ?>
            <div class="clear"></div>
            <div class="<?php echo $class; ?>">
                <?php
                global $wpdb;
                $sql_str = "";
                if ($category_id) {
                    $sql_str = "SELECT DISTINCT(ID) AS ID FROM " . $wpdb->prefix . "posts AS posts INNER JOIN " . $wpdb->prefix . "term_relationships AS term_relationships WHERE posts.post_status='publish' AND posts.post_type='portfolio-item' AND posts.ID=term_relationships.object_id ";
                    $sql_str .= " AND term_relationships.term_taxonomy_id=" . $category_id;
                } else {
                    $sql_str = "SELECT ID FROM " . $wpdb->prefix . "posts WHERE post_status='publish' AND post_type='portfolio-item' ";
                }
                if ($order)
                    $sql_str .= " ORDER BY " . $orderby . " " . $order;

                if ($number_of_display_portfolio == '' || $number_of_display_portfolio < 0)
                    $number_of_display_portfolio = 4;

                if ($number_of_display_portfolio > 0)
                    $sql_str .= " LIMIT 0," . $number_of_display_portfolio;

                $myposts = array();
                $myposts = $wpdb->get_results($sql_str);
                $blog_posts_idex = 0;
                if (count($myposts) != 0) {
                    foreach ($myposts as $post1) :
                        $args = array('page_id' => $post1->ID, 'post_type' => 'portfolio-item',);
                        $post2 = get_posts($args);
                        $post = $post2[0];
                        setup_postdata($post);
                        if ($number_of_columns == '2' || $number_of_columns == '3' || $number_of_columns == '4') {
                            if ($blog_posts_idex == 0)
                                echo '<div class="row-fluid rs-portfolio">';
                            if (($blog_posts_idex % $number_of_columns) == 0)
                                echo '</div><div class="row-fluid rs-portfolio">';
                            echo '<div class="span' . (12 / $number_of_columns) . '">';}
                        $titls_section = '';
                        if ($title_sh != 'hide') {
                            $titls_section .= '<section>';
                            $tmp = '';
                            if ($divider_b_ttl_fimg == 'no')
                                $tmp = 'no';
                            if ($attr['title_alignment'] == 'left')
                                $title_align = 'rs-text-align-left';
                            if ($attr['title_alignment'] == 'center')
                                $title_align = 'rs-text-align-center';
                            if ($attr['title_alignment'] == 'right')
                                $title_align = 'rs-text-align-right';
                            $titls_section .= '<div class="page-header rs-phead ' . $tmp . ' ' . $title_align . '">';
                            $titls_section .= '<h2><a href="' . get_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a></h2>';
                            $titls_section .= '</div>';
                            $titls_section .= '</section>';
                        }
                        $tmp = do_shortcode(get_the_content($post->ID));
                        $excerpt_txt = $this->get_excerpt_str($tmp, 50);
                        if ($image_sh != 'hide') {
                            if (has_post_thumbnail($post->ID)) {
                                $tmp = '';
                                if ($attr['img_type'] == 'img-rounded' || $attr['img_type'] == 'img-circle') {
                                    $tmp .= $attr['img_type'];
                                }

                                if ($tmp)
                                    $img_attr = array('class' => $tmp);

                                if ($number_of_columns != 'full' && $pos_f_img == 'bottom')
                                    echo $titls_section;

                                $thumbnail = '';
                                if ($attr['img_type'] == 'img-circle')
                                    $thumbnail = 'rs-a-img-circle';
                                if ($attr['img_type'] == 'img-rounded')
                                    $thumbnail = 'rs-a-img-rounded ';
                                if ($attr['img_type'] == 'primary')
                                    $thumbnail = 'rs-a-img-primary';
                                if ($attr['img_border'] == 'img-polaroid')
                                    $thumbnail .= ' rs-imgs ' . $attr['img_border'];

                                $thumbnail .= ' thumbnail';?>
                                <?php //if ($excerpt_sh != 'hide') {
                                    ?>
                                    <?php
                               //} else {
                                    ?>
                                    <div class="rs-single-fw-folio">
                                    <div class="rs-portfolio-f-img">
                                        <a href="<?php echo get_permalink($post->ID); ?>" class="rs-above <?php echo $thumbnail ?>"><?php echo get_the_post_thumbnail($post->ID, 'full', $img_attr) ?></a>
                                    </div>
                                    <?php
                                }
                                if ($number_of_columns == 'full' || $pos_f_img == 'top')
                                    echo $titls_section;
                            //} else {
                              //  echo $titls_section;
                                //if ($excerpt_sh != 'hide')
                                  //  echo $excerpt_txt;
                          //  }
                        } else {
                            echo $titls_section;
                            if ($excerpt_sh != 'hide')
                                echo $excerpt_txt;
                        }
                        ?></div><div class="clear"></div><?php
                        if ($number_of_columns == '2' || $number_of_columns == '3' || $number_of_columns == '4') {
                            echo '</div>';
                        }
                        ++$blog_posts_idex;
                    endforeach;
                    if ($number_of_columns == '2' || $number_of_columns == '3' || $number_of_columns == '4') {
                        echo '</div>';
                    }
                }
                ?>
            </div><div class="clear"></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function precontent_strip_shortcode($content) {
            if (is_single() || is_page()) {
                $start = strpos($content, '[rs-precontent]');
                $end = strpos($content, '[/rs-precontent]');
                if (false !== $start && false !== $end) {
                    $content = substr_replace($content, '', $start, $end + strlen('[/rs-precontent]') - $start);
                }
            }

            return $content;
        }

        function precontent_respondo_output() {
            if (is_single() || is_page()) {
                global $post;
                $precontent = '';
                $start = strpos($post->post_content, '[rs-precontent]');
                $end = strpos($post->post_content, '[/rs-precontent]');
                if (false !== $start && false !== $end) {
                    $start = strpos($post->post_content, '[rs-precontent]') + strlen('[/rs-precontent]') - 1;
                    $end = strpos($post->post_content, '[/rs-precontent]') - $start;
                    $precontent = substr($post->post_content, $start, $end);
                }

                $show = ot_get_option('show-precontent');
                if ($show[0] !== 'hide' && $precontent != '') {
                    ?>
                    <div class="precontent"><div class="precontent-inner"><div class="container"><?php echo do_shortcode($precontent); ?></div></div></div>
                    <?php
                }
            }
        }

        function precontent($attr, $content) {
            return '';
        }

        function box_wh_content($attr, $content) {
            ob_start();
            $tmp = do_shortcode($content);
            $tmp_a = explode('rs%box_wh_content_title%rs', $tmp);

            $content_tmp = $tmp_a[0] . $tmp_a[2];
            $h_style = 'alpha';
            $bg_color = "";
            if ($attr['custom_type'] == "custom") {
                $h_top_clr = $attr['h_top_clr'];
                $h_bottom_clr = $attr['h_bottom_clr'];
                $bg_color = "filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" . $h_top_clr . "', endColorstr='" . $h_bottom_clr . "'); background-image: -khtml-gradient(linear, left top, left bottom, from(" . $h_top_clr . "), to(" . $h_bottom_clr . ")); background-image: -moz-linear-gradient(top, " . $h_top_clr . ", " . $h_bottom_clr . "); background-image: -ms-linear-gradient(top, " . $h_top_clr . ", " . $h_bottom_clr . "); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, " . $h_top_clr . "), color-stop(100%, " . $h_bottom_clr . ")); background-image: -webkit-linear-gradient(top, " . $h_top_clr . ", " . $h_bottom_clr . "); background-image: -o-linear-gradient(top, " . $h_top_clr . ", " . $h_bottom_clr . "); background-image: linear-gradient(" . $h_top_clr . ", " . $h_bottom_clr . ");";
            } else {
                $h_style = $attr['custom_type'];
            }
            ?>
            <div class="clear"></div>
            <div class="box_wh_content" style="background-color: <?php echo $attr['body_bkg_color']; ?>;">
                <div class="rs-header <?php echo $h_style; ?>" style="color: <?php echo $attr['title_txt_color']; ?>; font-size: 24px; <?php echo $bg_color; ?>">
                    <?php _e($tmp_a[1]); ?>
                </div>
                <div class="section" style="color: <?php echo $attr['body_txt_color']; ?>">
                    <?php _e(do_shortcode($content_tmp)); ?>
                </div>
            </div>
            <div class="clear"></div>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function box_wh_content_title($attr, $content) {
            ob_start();
            echo "rs%box_wh_content_title%rs";
            _e(do_shortcode($content));
            echo "rs%box_wh_content_title%rs";
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }

        function create_select_ctrl_array($name, $class, $style, $option_nm_a, $option_val_a, $select_val, $visible_option = 1, $js = '') {
            ?>
            <select name="<?php echo $name ?>" class="<?php echo $class ?>" style="<?php echo $style; ?>" <?php echo $js ?> size="<?php echo $visible_option ?>">
                <?php
                $idx = 0;
                foreach ($option_nm_a as $option_nm) {
                    $select_str = "";
                    if ($select_val == $option_val_a[$idx])
                        $select_str = "selected";
                    ?>
                    <option value="<?php echo $option_val_a[$idx] ?>" <?php echo $select_str; ?>><?php _e($option_nm, 'rs_shortcode') ?></option>
                    <?php
                    ++$idx;
                }
                ?>
            </select>
            <?php
        }

        function hex2rgb($hex) {
            $hex = str_replace("#", "", $hex);

            if (strlen($hex) == 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
            $rgb = array($r, $g, $b);
            return implode(",", $rgb); // returns the rgb values separated by commas
//return $rgb; // returns an array with the rgb values
        }

        function page_nav_blog_post($totalcount, $recordnum, $page = 1) {
            $buttonnum = 5;
            $prevflag = 1;
            $nextflag = 1;

            $pagenum = ceil($totalcount / $recordnum);
            $downvalue = $page - round($buttonnum / 2);

            $upvalue = $page + round($buttonnum / 2);
            if ($downvalue <= 0) {
                $downvalue = 1;
            }
            $upvalue = $downvalue + $buttonnum - 1;
            if ($upvalue > $pagenum) {
                $upvalue = $pagenum;
                $downvalue = $upvalue - $buttonnum + 1;
                if ($downvalue <= 0) {
                    $downvalue = 1;
                }
            }
            if ($page == 1)
                $prevflag = 0;
            if ($page == $pagenum)
                $nextflag = 0;
            if ($pagenum > 1) {
                ?>
                <section>
                    <div class="pagination" style="text-align: center;">
                        <ul>
                            <?php
                            if ($prevflag > 0) {
                                ?>
                                <li><a href="<?php echo $this->convertURL($page - 1); ?>">Previous</a></li>
                                <?php
                            } else {
                                ?>
                                <li class="disabled"><span>Previous</span></li>
                                <?php
                            }
                            for ($i = $downvalue; $i <= $upvalue; $i++) {
                                if ($page == $i) {
                                    ?>		
                                    <li class="active"><span><?php echo $i; ?></span></li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="<?php echo $this->convertURL($i); ?>"><?php echo $i; ?></a></li>
                                    <?php
                                }
                            }
                            if ($nextflag > 0) {
                                ?>
                                <li><a href="<?php echo $this->convertURL($page + 1); ?>">Next</a></li>
                                <?php
                            } else {
                                ?>
                                <li class="disabled"><span>Next</span></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </section>
                <?
            }
        }

        function get_excerpt_str($content, $view_num) {
            $content = strip_tags($content);
            $txt_a = explode(' ', $content);
            $return_txt = '';
            $idx = 0;
            foreach ($txt_a as $txt) {
                if ($idx > $view_num)
                    break;
                $return_txt .= $txt . ' ';
                ++$idx;
            }
            return $return_txt;
        }

        function convertURL($page) {
            $domain = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];

            $pos = strpos($domain, "pn=");
            if ($pos === false) {
                $complete = $domain;
            } else {
                $tmp_a = explode('pn=', $domain);
                $pre_url = substr($tmp_a[0], 0, -1);

                $pos = strpos($tmp_a[1], "&");
                if ($pos === false) {
                    $complete = $pre_url;
                } else {
                    $after_url = substr($tmp_a[1], $pos + 1);
                    $pos = strpos($pre_url, "?");
                    if ($pos === false)
                        $complete = $pre_url . '?' . $after_url;
                    else
                        $complete = $pre_url . '&' . $after_url;
                }
            }
            $pos = strpos($complete, "?");
            if ($pos === false)
                $complete = $complete . '?pn=' . $page;
            else
                $complete = $complete . '&pn=' . $page;

            return 'http://' . $complete;
        }

    }

    new shortcodesListSLS();

endif;
?>
