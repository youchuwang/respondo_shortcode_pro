<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shortcodes
 *
 */
if (!class_exists("respondoShortcodeSLS")):

    class respondoShortcodeSLS extends shortcodesListSLS {

        function __construct() {
            add_action('admin_init', array($this, 'action_admin_init'));
        }

        function action_admin_init() {
            if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
                add_filter('mce_buttons', array(&$this, 'filter_mce_button'));
                add_filter('mce_external_plugins', array(&$this, 'filter_mce_plugin'));
                add_filter('admin_footer', array(&$this, 'render'));

                wp_enqueue_style('respondo-sls', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/admin.css');
                wp_enqueue_script('respondo-sls-admin', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/admin.js');
                wp_enqueue_style('farbtastic');
                wp_enqueue_script('farbtastic');

//font awesome
                wp_enqueue_style('font-awesome', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome.min.css');
                wp_enqueue_style('font-awesome-corp', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-corp.css');
                wp_enqueue_style('font-awesome-ext', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-ext.css');
                wp_enqueue_style('font-awesome-social', RESPONDO_SHORTCODE_PLUGIN_URL . 'css/font-awesome-social.css');

                $wp_version = get_bloginfo('version');
                if ($wp_version < 3.5) {
                    wp_enqueue_script('respondo-sls-admin-media-less-3.5', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/admin-media-less-3.5.js');
                } else {
                    wp_register_script('respondo-media', RESPONDO_SHORTCODE_PLUGIN_URL . 'js/admin-media-3.5.js', array('jquery'), '1.0.0', true);
                    wp_localize_script('respondo-media', 'respondo_media', array(
                        'title' => __('Upload or Choose Your Custom Image File', 'rs_shortcode'),
                        'button' => __('Insert Image into Input Field', 'rs_shortcode')
                            )
                    );
                    wp_enqueue_script('respondo-media');
                }
            }
        }

        function filter_mce_button($buttons) {
            array_push($buttons, '|', 'sc_for_twitter_bootscrap_sls_button');
            return $buttons;
        }

        function filter_mce_plugin($plugins) {
            $plugins['sc_for_twitter_bootscrap_sls'] = RESPONDO_SHORTCODE_PLUGIN_URL . 'js/respondo-shortcode.js';
            return $plugins;
        }

        function render() {
            $xmlfilename = apply_filters('templ_theme_options_xmlpath_filter', RESPONDO_SHORTCODE_PLUGIN_PATH . 'xml/shortcodes.xml');
            if (file_exists($xmlfilename))
                $rawdata = implode('', file($xmlfilename));
            if ($rawdata) {
                $shortcode_group = array();
                $shortcodes_obj = new SimpleXMLElement($rawdata);

                foreach ($shortcodes_obj->optgroup as $ppval) {
                    $ppkey = (string) $ppval->attributes()->id;
                    $shortcode_group[$ppkey]['label'] = (string) $ppval->attributes()->label;
                    $data = get_object_vars($ppval);

                    if ($data['shortcode']) {
                        $shortcode_a = array();

                        if (is_array($data['shortcode']))
                            $shortcode_a = $data['shortcode'];
                        else
                            $shortcode_a[0] = $data['shortcode'];
                        $tmp = array();
                        foreach ($shortcode_a as $pval) {
                            $pkey = (string) $pval->attributes()->id;
                            $tmp[$pkey] = (string) $pval->attributes()->label;
                            $shortcode_group[$ppkey]['sc'] = $tmp;
                        }
                    }
                }
            }
            ?>
            <style>
                #TB_ajaxContent {
                    padding: 0px;
                }
            </style>
            <div id="tb-shortcodes-form-sls" style="display: none">
                <div id="shortcodes-form-sls">
                    <div class="nav-sls">
                        <input type="button" id="shortcode-cancel-sls" name="shortcode-cancel-sls" class="btn" value="Cancel" style="float: left;" />
                        <select name="shortcodes-list-select-sls" id="shortcodes-list-select-sls" style="float: left; margin: 2px 0px 0px 178px; width: 150px">
                            <option value="0">Select Shortcode</option>
                            <?php $this->options_admin($shortcode_group); ?>
                        </select>
                        <input type="button" id="shortcode-submit-sls" name="shortcode-submit-sls" class="btn-info" value="Insert" style="display: none; float: right;" />
                    </div>
                    <div class="clear"></div>
                    <div id="shortcode-generator-sls" style="margin: 0px 20px">
                        <?php
                        foreach ($shortcode_group as $data_a) {
                            if ($data_a['sc']) {
                                foreach ($data_a['sc'] as $key => $data) {
                                    $tmp = array();
                                    $tmp['key'] = $key;
                                    $tmp['title'] = $data;
                                    $this->inter_admin($tmp, $this->get_selected_obj($shortcodes_obj, $key));
                                }
                            }
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                    <div id="color-picker-int" style="display: none"></div>
                    <input type="hidden" name="plugin_url_ajax_rs" id="plugin_url_ajax_rs" value="<?php echo plugins_url() ?>/respondo-shortcode-pro/ajax/" />
                </div>
            </div>

            <?php
        }

        function get_selected_obj($shortcodes_obj, $sc_id) {
            foreach ($shortcodes_obj->optgroup as $ppval) {
                $data = get_object_vars($ppval);
                if ($data['shortcode']) {
                    $shortcode_a = array();

                    if (is_array($data['shortcode']))
                        $shortcode_a = $data['shortcode'];
                    else
                        $shortcode_a[0] = $data['shortcode'];

                    foreach ($shortcode_a as $pval) {
                        $data1 = get_object_vars($pval);
                        $pkey = (string) $pval->attributes()->id;
                        if ($sc_id == $pkey) {
                            return $data1;
                            break;
                        }
                    }
                }
            }
        }

        function options_admin($shortcode_group) {
			global $respondoshortcode_full_width_extension;
			global $respondoshortcode_slider_pro_extension;
			global $respondoshortcode_animation_extension;
			global $respondoshortcode_gallery_gird_extension;
			global $respondoshortcode_advanced_image_extension;
			global $respondoshortcode_pro_page_extension;
			
            foreach ($shortcode_group as $data_a) {
					if( $data_a['label'] == 'Premium Shortcodes' ) {
						if( (!isset($respondoshortcode_full_width_extension) || $respondoshortcode_full_width_extension != 'activated') && ( !isset($respondoshortcode_slider_pro_extension) || $respondoshortcode_slider_pro_extension != 'activated' ) && ( !isset($respondoshortcode_animation_extension) || $respondoshortcode_animation_extension != 'activated' ) && ( !isset($respondoshortcode_gallery_gird_extension) || $respondoshortcode_gallery_gird_extension != 'activated' )){
							continue;
						}
					}
					
					if( $data_a['label'] == 'Advanced Images' ) {
						if( (!isset($respondoshortcode_advanced_image_extension) || $respondoshortcode_advanced_image_extension != 'activated') ) {
							continue;
						}
					}
					
					if( $data_a['label'] == 'Pro Pages' ) {
						if( !isset($respondoshortcode_pro_page_extension) ) {
							continue;
						}
					}
                ?>
                <optgroup label="<?php echo $data_a['label'] ?>">
                    <?php
                    if ($data_a['sc']) {
                        foreach ($data_a['sc'] as $key => $data) {
							if( $data_a['label'] == 'Premium Shortcodes' ) {
								if( $key == 'full-width' ){
									if( !isset($respondoshortcode_full_width_extension) || $respondoshortcode_full_width_extension != 'activated' ) {
										continue;
									}
								}
								
								if( $key == 'gallery_group' || $key == 'blog_gallery_group' ){
									if( !isset($respondoshortcode_slider_pro_extension) || $respondoshortcode_slider_pro_extension != 'activated' ){
										continue;
									}
								}
								
								if( $key == 'transition' ){
									if( !isset($respondoshortcode_animation_extension) || $respondoshortcode_animation_extension != 'activated' ){
										continue;
									}
								}
								
								if( $key == 'gallery-grid' ){
									if( !isset($respondoshortcode_gallery_gird_extension) || $respondoshortcode_gallery_gird_extension != 'activated' ){
										continue;
									}
								}
							}
						
                            ?>
                            <option value="<?php echo $key ?>"><?php _e($data, "rs_shortcode"); ?></option>
                            <?php
                        }
                    }
                    ?>
                </optgroup>
                <?php
            }
        }

        function inter_admin($key, $xml_obj) {
            ?>
            <div id="<?php echo $key["key"] ?>" class="shortcode_ctrl" style="display: none;">
                <?php
                $desc_str_a = array();
                if (is_array($xml_obj['descript']))
                    $desc_str_a = $xml_obj['descript'];
                else
                    $desc_str_a[0] = $xml_obj['descript'];
                ?>
                <div class="sc_title"><?php _e($desc_str_a[0], 'rs_shortcode'); ?></div>
                <?php
                if ($desc_str_a[1]) {
                    ?>
                    <div style="clear: both; font-size: 11px; padding-left: 10px;">(<?php _e($desc_str_a[1], 'rs_shortcode'); ?>)</div>
                    <?php
                }
                ?>
                <hr/>
                <div class="h_20"></div>
                <div class="root_datas">
                    <?php
                    if ($xml_obj['pitem_grp']) {
                        $pitme_data = get_object_vars($xml_obj['pitem_grp']);
                        if ($pitme_data['pitem']) {
                            $idx = 0;
                            $p_ary = array();
                            if (is_array($pitme_data['pitem'])) {
                                $p_ary = $pitme_data['pitem'];
                            } else {
                                $p_ary[0] = $pitme_data['pitem'];
                            }

                            foreach ($p_ary as $pitem_obj) {
                                $man_str = '';
                                if ((string) $pitem_obj->attributes()->required == 'required')
                                    $man_str = '<span class="star">*</span>';
                                $label = (string) $pitem_obj->attributes()->label;
                                if ($label) {
                                    ?>
                                    <div class="title"><?php _e($label, 'rs_shortcode') ?> <?php echo $man_str; ?></div>
                                    <?php
                                }
                                ?>
                                <div class="ctrl">
                                    <?php echo str_replace('%%textarea%%', '', (string) $pitem_obj->ctrl->asXML()); ?>
                                    <?php
                                    if ($pitem_obj->descript != "") {
                                        ?>
                                        <div class="clear"></div>
                                        <div class="descript"><?php _e($pitem_obj->descript, 'rs_shortcode') ?></div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($idx % 2) {
                                    ?>
                                    <div class="h_20"></div>
                                    <?php
                                }
                                $idx++;
                            }
                        }
                    }
                    ?>
                </div>
                <?php
                if ($xml_obj['citem_grp']) {
                    $tmp_d = get_object_vars($xml_obj['citem_grp']);
                    $defalt = (string) $xml_obj['citem_grp']->attributes()->default;
                    $clear = (integer) $xml_obj['citem_grp']->attributes()->clear;
                    if ($clear == 0)
                        $clear = 2;
                    $sub_shortcode = (string) $xml_obj['citem_grp']->attributes()->sub_shortcode;
                    ?>
                    <input type="hidden" name="sub_shortcode" value="<?php echo $sub_shortcode ?>" />
                    <div class="h_20"></div>
                    <?php
                    if ($tmp_d['descript']) {
                        ?>
                        <div class="sub_data_grp_desc">
                            <?php _e($tmp_d['descript']); ?>
                        </div>
                        <div class="h_20"></div>
                        <?php
                    }
                    //sub controls
                    $citme_data = get_object_vars($xml_obj['citem_grp']);
                    if ($citme_data['citem']) {
                        $ctrl_str = '<div class="sub_data_grp" style="float: left">';
                        $idx = 1;
                        $c_ary = array();
                        if (is_array($citme_data['citem'])) {
                            $c_ary = $citme_data['citem'];
                        } else {
                            $c_ary[0] = $citme_data['citem'];
                        }

                        foreach ($c_ary as $citem_obj) {
                            $man_str = '';
                            if ((string) $citem_obj->attributes()->required == 'required')
                                $man_str = '<span class="star">*</span>';
                            $label = (string) str_replace('%num%', '<span class="number"></span>', (string) $citem_obj->attributes()->label);
                            if ($label) {
                                $ctrl_str .= '<div class="title">';
                                $ctrl_str .= $label . $man_str;
                                $ctrl_str .= '</div>';
                            }
                            $ctrl_str .= '<div class="ctrl">';
                            $ctrl_str .= str_replace('%%textarea%%', '', (string) $citem_obj->ctrl->asXML());
                            if ($citem_obj->descript) {
                                $ctrl_str .= '<div class="clear"></div>';
                                $ctrl_str .= '<div class="descript">';
                                $ctrl_str .= $citem_obj->descript;
                                $ctrl_str .= '</div>';
                            }
                            $ctrl_str .= '</div>';
                            if (($idx != 1) && ($idx % $clear) == 0)
                                $ctrl_str .= '<div class="clear"></div>';
                            $idx++;
                        }
                        $default_str = $ctrl_str . '</div><div class="h_10"></div>';
                        $ctrl_str .= '</div><div class="del" onClick="del_item_rs(this, \'' . $key["key"] . '\')"></div><div class="h_10"></div>';
                        ?>
                        <div class="add_items">
                            <?php
                            for ($i = 0; $i < $defalt; $i++) {
                                //$default_str = str_replace('%php-num%', $i+1, $default_str);
                                echo $default_str;
                            }
                            ?>
                        </div>
                        <?php
                        // button
                        _e($xml_obj['citem_grp']->add_btn->asXML());
                        ?>
                        <div class="clear"></div><div class="h_20"></div>
                        <div class="add_item_tmp" style="display: none">
                            <div>
                                <?php echo $ctrl_str; ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        }

    }

    new respondoShortcodeSLS();

endif;
?>