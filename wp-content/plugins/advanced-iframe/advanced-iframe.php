<?php
/*
Plugin Name: Advanced iFrame 
Plugin URI: http://www.tinywebgallery.com/blog/advanced-iframe
Version: 7.1.1
Text Domain: advanced-iframe
Domain Path: /languages
Author: Michael Dempfle
Author URI: http://www.tinywebgallery.com
Description: This plugin includes any webpage as shortcode in an advanced iframe or embeds the content directly.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
if (!class_exists('advancediFrame')) {
    class advancediFrame {
        
        var $adminOptionsName = 'advancediFrameAdminOptions';
        var $scriptsNeeded = false;
        /*
        * class constructor
        */
        function advancediFrame() {
        }

        /**
         *  wp init
         */
        function init() {
            $this->getAiAdminOptions();
        }

        /**
         *  wp activate
         */
        function activate() {
            $this->getAiAdminOptions();
        }

        /**
         * Set the iframe default
         */
        function iframe_defaults() {
            $iframeAdminOptions = array(
                'securitykey' => sha1(AUTH_KEY . time() ),
                'src' => '//www.tinywebgallery.com', 'width' => '100%',
                'height' => '600', 'scrolling' => 'none', 'marginwidth' => '0', 'marginheight' => '0',
                'frameborder' => '0', 'transparency' => 'true', 'content_id' => '', 'content_styles' => '',
                'hide_elements' => '', 'class' => '', 'shortcode_attributes' => 'true', 'url_forward_parameter' => '',
                'id' => 'advanced_iframe', 'name' => '',
                'onload' => '', 'onload_resize' => 'false', 'onload_scroll_top' => 'false',
                'additional_js' => '', 'additional_css' => '', 'store_height_in_cookie' => 'false',
                'additional_height' => '0', 'iframe_content_id' => '', 'iframe_content_styles' => '',
                'iframe_hide_elements' => '', 'version_counter' => '1', 'onload_show_element_only' => '' ,
                'include_url'=> '','include_content'=> '','include_height'=> '','include_fade'=> '',
                'include_hide_page_until_loaded' => 'false', 'donation_bottom' => 'false',
                'onload_resize_width' => 'false', 'resize_on_ajax' => '', 'resize_on_ajax_jquery' => 'true',
                'resize_on_click' => '', 'resize_on_click_elements' => 'a', 'hide_page_until_loaded' => 'false',
                'show_part_of_iframe' => 'false', 'show_part_of_iframe_x' => '100', 'show_part_of_iframe_y' => '100',
                'show_part_of_iframe_width' => '400', 'show_part_of_iframe_height' => '300',
                'show_part_of_iframe_new_window' => '' ,'show_part_of_iframe_new_url' => '',
                'show_part_of_iframe_next_viewports_hide' => 'false', 'show_part_of_iframe_next_viewports' => '',
                'show_part_of_iframe_next_viewports_loop' => 'false', 'style' => '',
                'use_shortcode_attributes_only' => 'false', 'enable_external_height_workaround' => 'false',
                'keep_overflow_hidden' => 'false', 'hide_page_until_loaded_external' => 'false',
                'onload_resize_delay' => '', 'expert_mode' => 'false',
                'show_part_of_iframe_allow_scrollbar_vertical' => 'false',
                'show_part_of_iframe_allow_scrollbar_horizontal' => 'false',
                'hide_part_of_iframe' => '', 'change_parent_links_target' => '',
                'change_iframe_links' => '','change_iframe_links_target' => '',
                'browser' => '', 'show_part_of_iframe_style' => '',
                'map_parameter_to_url' => '', 'iframe_zoom' => '',
                'accordeon_menu' => 'false',
                'show_iframe_loader' => 'false',
                'tab_visible' => '', 'tab_hidden' => '',
                'enable_responsive_iframe' => 'false',
                'allowfullscreen' => 'false', 'iframe_height_ratio' => '',
                'enable_lazy_load' => 'false', 'enable_lazy_load_threshold' => '3000',
                'enable_lazy_load_fadetime' => '0', 'enable_lazy_load_manual' => 'false',
                'pass_id_by_url' => '', 'include_scripts_in_footer' => 'true',
                'write_css_directly' => 'false', 'resize_on_element_resize' => '',
                'resize_on_element_resize_delay' => '250', 'add_css_class_parent' => 'false',
                'auto_zoom'  => 'false', 'auto_zoom_by_ratio' => '',
                'single_save_button' => 'true', 'enable_lazy_load_manual_element' => '',
                'alternative_shortcode' => '', 'show_menu_link' => 'true',
                'iframe_redirect_url' => '', 'install_date' => 0,
                'show_part_of_iframe_last_viewport_remove' => 'false',
                'load_jquery' => 'true', 'show_iframe_as_layer' => 'false',
                'add_iframe_url_as_param' => 'false', 'add_iframe_url_as_param_prefix' => '',
                'reload_interval' => '', 'iframe_content_css' => '',
                'additional_js_file_iframe' => '', 'additional_css_file_iframe' => '', 
                'add_css_class_iframe' => 'false', 'editorbutton' => 'securitykey',
                'iframe_zoom_ie8' => 'false', 'enable_lazy_load_reserve_space' => 'true',
                'hide_content_until_iframe_color' => '', 'use_zoom_absolute_fix' => 'false',
                'include_html' => '', 'enable_ios_mobile_scolling' => 'false',
                'sandbox' => '', 'show_iframe_as_layer_header_file' => '', 
                'show_iframe_as_layer_header_height' => '100', 'show_iframe_as_layer_header_position' => 'top',
                'resize_min_height' => '1', 'show_iframe_as_layer_full' => 'false',
                'demo' => 'false', 'show_part_of_iframe_zoom' => 'false',
                'external_height_workaround_delay' => '0',
                'add_document_domain' => 'false','document_domain' => '',
                'multi_domain_enabled' => 'false', 'check_shortcode' => 'false',
                'use_post_message' => 'false'
                );
            return $iframeAdminOptions;
        }

        function printError($message) {
         echo '   
           <div class="error">
              <p><strong>' . $message . '
                 </strong>
              </p>
           </div>';
        }

        /**
         * Get the admin options
         */
        function getAiAdminOptions() {
            $iframeAdminOptions = advancediFrame::iframe_defaults();  
            $devOptions = get_option("advancediFrameAdminOptions");
            if (!empty($devOptions)) {
                foreach ($devOptions as $key => $option)
                    $iframeAdminOptions[$key] = $option;
            }
            update_option("advancediFrameAdminOptions", $iframeAdminOptions);
            return $iframeAdminOptions;
        }

        /**
         *  loads the language files
         */
        function loadLanguage() {
            load_plugin_textdomain('advanced-iframe', false, dirname(plugin_basename(__FILE__)) . '/languages');
            $options = $this->getAiAdminOptions();
            if ($options['load_jquery'] === 'true') {
              wp_enqueue_script('jquery');
            }    
        }

        /* CSS and js for the admin area - only loaded when needed */
        function addAdminHeaderCode($hook) {
            if( $hook != 'settings_page_advanced-iframe' && $hook != 'toplevel_page_advanced-iframe') 
         		    return;
            $options = get_option('advancediFrameAdminOptions');
            // defaults
            extract(array('version_counter' => $options['version_counter']));       
            wp_enqueue_style('ai-css', plugins_url( 'css/ai.css' , __FILE__ ), false, $version_counter);
            // wp_enqueue_style('ai-css-print', plugins_url( 'css/ai-print.css' , __FILE__ ), false, $version_counter);
            wp_enqueue_script('ai-js',plugins_url( 'js/ai.js' , __FILE__ ), false, $version_counter);
            wp_enqueue_script('ai-search',plugins_url( 'js/findAndReplaceDOMText.js' , __FILE__ ), false, $version_counter); 
        }
        
        /* Add the Javascript for the iframe button above the editor. */
        function addAiButtonJs() {
            $options = get_option('advancediFrameAdminOptions');
            if  ($options['editorbutton'] == 'securitykey') {
              echo '<script type="text/javascript">
              jQuery(document).ready(function(){
                 jQuery("#insert-iframe-button").click(function() {
                    send_to_editor("[advanced_iframe securitykey=\"'.$options['securitykey']. '\"]");
                    return false;
                 });
              });
              </script>';
            }
        }

        /* Add iframe button above the editor. */
        function addAiButton(){
            $options = get_option('advancediFrameAdminOptions');
            if  ($options['editorbutton'] == 'securitykey') {
                echo '<a title="Insert Advanced iFrame" class="button insert-media add_media" id="insert-iframe-button" href="#">Add Advanced iFrame</a>';
            }
        }
        
        /* Adds a quicktags button - currently not used as the media button solution is used. */
        function advanced_iframe_add_quicktags() {
        if (wp_script_is('quicktags')){
            $options = get_option('advancediFrameAdminOptions');
            $editorbutton = $options['editorbutton'];
            if ($editorbutton == 'securitykey') {
              ?>
              <script type="text/javascript">
               QTags.addButton( 'ai_iframe', 'advanced iframe', '[advanced_iframe securitykey="<?php echo $options['securitykey']; ?>"]', '', '', 'Advanced iframe');
              </script>
          <?php
              }
            }
        }
        
         /* additional CSS for wp area */
        function addWpHeaderCode($atts) { 
              $options = get_option('advancediFrameAdminOptions');
              // defaults
              extract(array('additional_css' => $options['additional_css'],
                            'additional_js' => $options['additional_js'],
                            'version_counter' => $options['version_counter'],
                            'enable_lazy_load' => $options['enable_lazy_load'],
                            'include_scripts_in_footer' => $options['include_scripts_in_footer'], 
                            'add_css_class_parent' => $options['add_css_class_parent'],
                $atts));
              $to_footer = ($include_scripts_in_footer === 'true' && $add_css_class_parent === 'false');
  
              $older_version = version_compare(get_bloginfo('version'), '3.3') < 0; // wp < 3.3 - older version need to be included here
              $this->include_additional_files($additional_css, $additional_js, $version_counter, $older_version, $to_footer);

              $dep = ($options['load_jquery'] === 'true') ? array( 'jquery') : array();
              wp_enqueue_script('ai-js',plugins_url( 'js/ai.js' , __FILE__ ), $dep, $version_counter, $to_footer);
        }

        /**
         * Checks the parameter and returns the value. If only chars on the whitelist are in the request nothing is done
         * Otherwise it is returned encoded.
         */
        function param($param, $content = null) {
		    // get and post parameters are checked. if both are set the get parameter is used.
            $value = isset($_GET[$param]) ? $_GET[$param] : (isset($_POST[$param]) ? $_POST[$param] : '');

            $value_check = $value;
            // first we decode the param to be sure the it is not already encoded or doubleencoded as part of an attack
            while ($value_check != urldecode($value_check)) {
               $value_check = urldecode($value_check);
            }
            if( get_magic_quotes_gpc() ) {
	              $value_check = stripcslashes($value_check); 
	          }  
            // If all chars are in the whitelist no additional encoding is done!
            if (preg_match('/^[\.@a-zA-Z0-9À-ÖØ-öø-ÿ\/\:\-\|\)\(]*$/', $value_check)) {
                return $value;
            } else {
                return urlencode($value);
            }
        }
        
        function scale_value($value, $iframe_zoom) {
            if (strpos($value, '%') === false) {       
                return (intval($value) * floatval($iframe_zoom)) . 'px';      
            } else {
                $value = substr($value, 0, -1);  
                return (intval($value) * floatval($iframe_zoom)) . '%';    
            }
        }
        
        function addPx($value) {
             if (strpos($value, '-') === false && strpos($value, '+') === false ) {
               $value = trim($value);
               if (strpos($value, '%') === false && strpos($value, '%') === false && 
                   strpos($value, 'vw') === false && strpos(strtolower($value), 'vh') === false) { 
                  $value = $value . 'px';
               }
             }
             return $value;
        }

        /**
         *  renders the iframe script
         */
        function do_iframe_script($atts, $content = null) {
            global $aip_standalone, $iframeStandaloneDefaultOptions, $iframeStandaloneOptions ;

            $isValidBrowser = true;
            $html = ''; // the output
            
            include dirname(__FILE__) . '/includes/advanced-iframe-main-read-config.php';
           
            if (!$isValidBrowser) {
              return;
            }
                
            include dirname(__FILE__) . '/includes/advanced-iframe-main-css.php';
             // check if the ai_external.js does exist
            
            $script_name = dirname(__FILE__) . '/js/ai_external.js';
            if (!isset($aip_standalone) && !file_exists($script_name)) {
              $retValue = $this->saveExternalJsFile(false);
              if (!empty($retValue)) {
                  return $error_css . '<div class="errordiv">' . $retValue . '</div>';   
              }    
            }
           
            if ($options['securitykey'] != $securitykey && empty($alternative_shortcode)) {
                return $error_css . '<div class="errordiv">' . __('No valid security key found. Please use at least the following shortcode:<br>&#91;advanced_iframe securitykey="&lt;your security key - see settings&gt;"&#93;<br /> Please also check in the html mode that your shortcode does only contain normal spaces and not a &amp;nbsp; instead.  It is also possible that you use wrong quotes like &#8220; or &#8221;. Only &#34; is valid!', 'advanced-iframe') . '</div>';
            } else if ( $src == "not set" && empty($include_url) &&  empty($include_html)) {
                return $error_css . '<div class="errordiv">' . __('You have set "Use shortcode attributes only" (use_shortcode_attributes_only) to "true" which means that you have to specify all parameters as shortcode attributes. Please specify at least "securitykey" and "src". Examples are available in the administration.', 'advanced-iframe') . '</div>';
            } else {
              if (empty($include_url) && empty($include_html)) {
                include dirname(__FILE__) . '/includes/advanced-iframe-main-prepare.php'; 
                include dirname(__FILE__) . '/includes/advanced-iframe-main-iframe.php'; 
                include dirname(__FILE__) . '/includes/advanced-iframe-main-after-iframe.php';
              } else {
                include dirname(__FILE__) . '/includes/advanced-iframe-main-include-directly.php'; 
              }
              return $html;
            }
        }
        
        /**
         * Enqueue the additional js or css 
         */
        function include_additional_files($additional_css, $additional_js, $version_counter, $version, $to_footer) {
           if ($additional_css != '' && $version) {  // wp >= 3.3
               wp_enqueue_style( 'additional-advanced-iframe-css', $additional_css, false, $version_counter);
            }
            if ($additional_js != '' && $version) {  // wp >= 3.3 
                wp_enqueue_script( 'additional-advanced-iframe-js', $additional_js, false, $version_counter, $to_footer);
            }
        }

        function add_script_footer() {
             if (!$this->scriptsNeeded) {
               wp_dequeue_script('ai-js');
               wp_dequeue_script('additional-advanced-iframe-js');
               wp_dequeue_script('ai-change-js');
               wp_dequeue_script('ai-lazy-js');
             } else {   
               echo '<script type="text/javascript">if(window.aiModifyParent) {aiModifyParent();}</script>';
             }
        }

        function printAdminPage() {
            require_once('advanced-iframe-admin-page.php');
        }
        
        function saveExternalJsFile($backend = true) {
          $devOptions = $this->getAiAdminOptions();
          $template_name = dirname(__FILE__) . '/js/ai_external.template.js';
          
          $jquery_path =  site_url() . '/wp-includes/js/jquery/jquery.js';
          $resize_path =  plugins_url() . '/advanced-iframe/includes/scripts/jquery.ba-resize.min.js';
          
          $content = file_get_contents($template_name);
          $new_content = str_replace('PLUGIN_URL', plugins_url() . '/advanced-iframe', $content);
          $new_content = str_replace('PARAM_ID', $devOptions['id'], $new_content);
          $new_content = str_replace('PARAM_IFRAME_HIDE_ELEMENTS', $devOptions['iframe_hide_elements'], $new_content);
          $new_content = str_replace('PARAM_ONLOAD_SHOW_ELEMENT_ONLY', $devOptions['onload_show_element_only'], $new_content);
          $new_content = str_replace('PARAM_IFRAME_CONTENT_ID',  $devOptions['iframe_content_id'], $new_content);
          $new_content = str_replace('PARAM_IFRAME_CONTENT_STYLES',  $devOptions['iframe_content_styles'], $new_content);
          $new_content = str_replace('PARAM_CHANGE_IFRAME_LINKS_TARGET',  $devOptions['change_iframe_links_target'], $new_content);
          $new_content = str_replace('PARAM_CHANGE_IFRAME_LINKS',  $devOptions['change_iframe_links'], $new_content);
          
          $delay = empty($devOptions['external_height_workaround_delay']) ? '0' : $devOptions['external_height_workaround_delay'];
          $new_content = str_replace('PARAM_ENABLE_EXTERNAL_HEIGHT_WORKAROUND_DELAY', $delay, $new_content);
          
          $new_content = str_replace('PARAM_ENABLE_EXTERNAL_HEIGHT_WORKAROUND', $devOptions['enable_external_height_workaround'], $new_content);
          $new_content = str_replace('PARAM_KEEP_OVERFLOW_HIDDEN', $devOptions['keep_overflow_hidden'], $new_content);
          $new_content = str_replace('PARAM_HIDE_PAGE_UNTIL_LOADED_EXTERNAL', $devOptions['hide_page_until_loaded_external'], $new_content);
          $new_content = str_replace('PARAM_IFRAME_REDIRECT_URL', $devOptions['iframe_redirect_url'] , $new_content);
          $new_content = str_replace('PARAM_ENABLE_RESPONSIVE_IFRAME', $devOptions['enable_responsive_iframe'] , $new_content);
          $new_content = str_replace('PARAM_WRITE_CSS_DIRECTLY', $devOptions['write_css_directly'] , $new_content);
          $new_content = str_replace('PARAM_RESIZE_ON_ELEMENT_RESIZE_DELAY', $devOptions['resize_on_element_resize_delay'] , $new_content);
          $new_content = str_replace('PARAM_RESIZE_ON_ELEMENT_RESIZE', $devOptions['resize_on_element_resize'] , $new_content);
          $new_content = str_replace('PARAM_URL_ID', $devOptions['pass_id_by_url'] , $new_content);
          
          $new_content = str_replace('PARAM_JQUERY_PATH', $jquery_path , $new_content);
          $new_content = str_replace('PARAM_RESIZE_PATH', $resize_path , $new_content);
          $new_content = str_replace('PARAM_ADD_IFRAME_URL_AS_PARAM', $devOptions['add_iframe_url_as_param'], $new_content);
          $new_content = str_replace('PARAM_ADDITIONAL_CSS_FILE_IFRAME', $devOptions['additional_css_file_iframe'], $new_content);
          $new_content = str_replace('PARAM_ADDITIONAL_JS_FILE_IFRAME', $devOptions['additional_js_file_iframe'], $new_content);
          $new_content = str_replace('PARAM_ADD_CSS_CLASS_IFRAME', $devOptions['add_css_class_iframe'], $new_content);
          $new_content = str_replace('PARAM_TIMESTAMP', date("Y-m-d H:i:s"), $new_content);          
              
          $new_content = str_replace('MULTI_DOMAIN_ENABLED', $devOptions['multi_domain_enabled'], $new_content);
          $new_content = str_replace('USE_POST_MESSAGE', $devOptions['use_post_message'], $new_content);
          
          $asParts = parse_url( site_url() ); // PHP function
          $home_url = $asParts['scheme'] . '://' . $asParts['host'];
          $post_domain = ($devOptions['multi_domain_enabled'] == 'true') ? '*' : $home_url;
          $new_content = str_replace('POST_MESSAGE_DOMAIN', $post_domain, $new_content);
          
          $script_name = dirname(__FILE__) . '/js/ai_external.js';
          if (file_exists($script_name)) {
              @unlink($script_name);
          }
          $fh = fopen($script_name, 'w');
          if ($fh) {
              fwrite($fh, $new_content);
              fclose($fh);
          } else {
              $errorText = __('The file "advanced-iframe/js/ai_external.js" can not be saved. Please check the permissions of the js folder and save the settings again. This file is needed for the external workaround! If you don\'t use the external workaround please create a empty file with the name ai_external.js in the js folder of the plugin.', "advanced-iframe"); 
              if ($backend) {
                  printError($errorText);
              } else {
                  return $errorText; 
              }
          }
          return '';
        }
        
        
        function ai_startsWith($haystack, $needle) {
          return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
        }
        
        function ai_endsWith($haystack, $needle) {
          return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
        }
    
        function ai_createCustomFolder() {
          $filenamedir  = dirname(__FILE__) . '/../advanced-iframe-custom';
          if (!@file_exists($filenamedir)) {
             if (!@mkdir($filenamedir)) {
                echo 'The directory "advanced-iframe-custom" could not be created in the plugin folder. Custom files are stored in this directory because Wordpress does delete the normal plugin folder during an update. Please create the folder manually.'; 
                return false; 
             }
          } 
        }
        
        function checkIE8() {
           $filenamedir  = dirname(__FILE__) . '/../advanced-iframe-custom/browser-check-failed.txt'; 
           if (file_exists($filenamedir)) {
               return false;
           } else {
              $this->ai_createCustomFolder();
              $fh = @fopen($filenamedir, 'w');
              if ($fh) {
                  @fwrite($fh, "Browser detection crashed. Please increase your php memory, delete this file and retry.");
                  @fclose($fh);
              }
              @unlink($filenamedir);
              return ai_is_ie(8);
           }    
        }
            
        function ai_plugin_action_links($links, $file) {
            $plugin_file = basename(__FILE__);
            $file = basename($file);
            if ($file == $plugin_file) {
                $settings_link = '<a href="options-general.php?page='.$plugin_file.'">'.__('Settings', 'advanced-iframe').'</a>';
                array_unshift($links, $settings_link);
            }
            return $links;
        }

      /**
       *  Intercepts the Ajax resize events in iframes.
       */
      function interceptAjaxResize( $iframe_id, $resize_width, $timeout, $resize_on_ajax_jquery,
                                    $click_timeout,  $resize_on_click_elements, $resize_min_height) {
        $debug = false;
        $val = '';
        if ($timeout != '' || $click_timeout != '') {
          $val .= '<script type="text/javascript">';
          $val .= 'function local_resize_'.$iframe_id.'(timeout) {
            if (timeout != 0) {
               setTimeout(function() { aiResizeIframe(ifrm_'.$iframe_id.', "'.$resize_width.'","'.$resize_min_height.'")},timeout);
            } else {
               aiResizeIframe(ifrm_'.$iframe_id.', "'.$resize_width.'","'.$resize_min_height.'");
            }
          }';
          $val .= '</script>';

          if ($resize_on_ajax_jquery == 'true' || $click_timeout != '') {
            $val .=  '<script type="text/javascript">
                function ai_jquery_ajax_resize_'.$iframe_id.'() {
                    jQuery("#'.$iframe_id.'").bind("load",function(){
                    doc = this.contentWindow.document;';
            if ($timeout != '' && $resize_on_ajax_jquery == 'true') {
              $val .= 'var instance = this.contentWindow.jQuery;';
              $val .= 'instance(doc).ajaxComplete(function(){';
              if ($debug) {
                 $val .= 'alert("AJAX request completed.");';
              }
              $val .= 'local_resize_'.$iframe_id.'('.$timeout.');';
              $val .= '});';
            }
            if ($click_timeout != '' && $resize_on_click_elements != '') {
              $val .= 'doc.addEventListener("click", function(evt) { ';
              $val .= '  if (checkIfValidTarget(evt,"'.$resize_on_click_elements.'")) {';
              if ($debug) {
                 $val .= 'alert("Click event intercepted.");';
              }
              $val .= '   local_resize_'.$iframe_id.'('.$click_timeout.');';
              $val .= '  }';
              $val .= '}, true);';
            }
            $val .= '});
            }';
            $val .= 'ai_jquery_ajax_resize_'.$iframe_id.'();';

            $val .= '</script>';
          }
          if ($resize_on_ajax_jquery == 'false' && $timeout != '') {
            $val .=  '<script type="text/javascript">';
            $val .= '

              var send_'.$iframe_id.' = ifrm_'.$iframe_id.'.contentWindow.XMLHttpRequest.prototype.send,
                  onReadyStateChange_'.$iframe_id.';

              function sendReplacement_'.$iframe_id.'(data) {
                  if(this.onreadystatechange) {
                      this._onreadystatechange_'.$iframe_id.' = this.onreadystatechange;
                  }
                  this.onreadystatechange = onReadyStateChangeReplacement_'.$iframe_id.';
                  return send_'.$iframe_id.'.apply(this, arguments);
              }

              function onReadyStateChangeReplacement_'.$iframe_id.'() {
                  if(this.readyState == 4 ) {
                      var retValue;
                      if (this._onreadystatechange_'.$iframe_id.') {
                          retValue = this._onreadystatechange_'.$iframe_id.'.apply(this, arguments);
                      }';
              $val .= 'local_resize_'.$iframe_id.'('.$timeout.');';
              $val .= 'return retValue;
                  }
              }';
              $val .= '  ifrm_'.$iframe_id.'.contentWindow.XMLHttpRequest.prototype.send = sendReplacement_'.$iframe_id.';';
              $val .= '</script>';
              }
          }
          return $val;
        }
        
        /**
         * Replace placeholders in the url and fill them with proper values.
         */
        function ai_replace_placeholders($str_input, $enable_replace) {
          global $aip_standalone;

          // wordpress does encode ' by default which does kill urls that contain this char
          $str_input = str_replace('&#8242;', '%27', $str_input);
          $str_input = str_replace('&#8217;', '%27', $str_input);

          if ($enable_replace) {
              $str_input = str_replace('{host}', $_SERVER['HTTP_HOST'], $str_input);
              $str_input = str_replace('{port}', $_SERVER['SERVER_PORT'], $str_input);
              
              if (!isset($aip_standalone)) {
                $str_input = str_replace('{site}', site_url(), $str_input);
                
                $current_user = wp_get_current_user();
                $str_input = str_replace('{userid}', urlencode($current_user->ID), $str_input);
                if ( 0 == $current_user->ID ) {
                  $str_input = str_replace('{username}', '', $str_input);
                  $str_input = str_replace('{useremail}', '', $str_input);
                } else {
                  $str_input = str_replace('{username}', urlencode($current_user->user_login), $str_input);
                  $str_input = str_replace('{useremail}', urlencode($current_user->user_email), $str_input); 
                
                  // dynamic $propertyName = 'id'; print($phpObject->{$propertyName});
                  if (strpos($str_input,'{userinfo') !== false) {
                     
                     $regex = '/{(userinfo.*?)}/';
                     $result = preg_match_all( $regex, $str_input, $match);  
                     if ($result) {
                       foreach ($match[1] as $hits) {
                         $key = substr($hits, 9);
                         $str_input = str_replace('{'.$hits.'}', urlencode($current_user->$key), $str_input); 
                       } 
                     }   
                  }
                  if (strpos($str_input,'{usermeta') !== false) {
                     $regex = '/{(usermeta.*?)}/';
                     $result = preg_match_all( $regex, $str_input, $match);  
                     if ($result) {
                       foreach ($match[1] as $hits) {
                         $key = substr($hits, 9);
                         $user_last = get_user_meta( $current_user->ID, $key, true ); 
                         $str_input = str_replace('{'.$hits.'}', urlencode($user_last), $str_input); 
                       } 
                     }   
                  }
                }
                
                // postmeta! https://codex.wordpress.org/Custom_Fields
                
                 
                $admin_email = get_option( 'admin_email' );
                $str_input = str_replace('{adminemail}', urlencode($admin_email), $str_input); 
                
                $uri = $_SERVER['REQUEST_URI'];
                
                if (strpos($str_input,'{urlpath') !== false) {
                  // part of the url are extracted {urlpath1} = first path element
                  $path_elements = explode("/", trim($uri, "/")); 
                  $count = 1;
                  foreach($path_elements as $path_element){ 
                      $str_input = str_replace('{urlpath'.$count.'}', urlencode($path_element), $str_input); 
                      $count++;   
                  }
                  // part of the url counting from the end {urlpath-1} = last path element 
                  reset($path_elements);
                  $rpath_elements = array_reverse($path_elements);
                  $count = 1;
                  foreach($rpath_elements as $path_element){ 
                      $str_input = str_replace('{urlpath-'.$count.'}', urlencode($path_element), $str_input); 
                      $count++;   
                  }
                } 
                
                // the full url
                if (strpos($str_input,'{href}') !== false) {
                   $location = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
                   if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443" ) {
                      $location .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
                   } else {
                      $location .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
                   }
                   $str_input = str_replace('{href}', urlencode($location), $str_input); 
                }
      
                if (strpos($str_input,'{query') !== false) {
                   $regex = '/{(query.*?)}/';
                   $result = preg_match_all( $regex, $str_input, $match);  
                   if ($result) {
                     foreach ($match[1] as $hits) {
                       $key = substr($hits, 6);
                       $value = $this->param($key);
                       $str_input = str_replace('{'.$hits.'}', $value , $str_input); 
                     } 
                   }   
                }

                // evaluate shortcodes for the parameter 
                $str_input = str_replace('{{', "[", $str_input);
                $str_input = str_replace('}}', "]", $str_input);
                $str_input = do_shortcode($str_input);
              }
          }
          return $str_input;
      }
          
    }
}

if (!isset($aip_standalone)) {
  //  setup new instance of plugin if not standalone
  if (class_exists("advancediFrame")) {
      $cons_advancediFrame = new advancediFrame();
  }
}
//Actions and Filters
if (isset($cons_advancediFrame)) {
    //Initialize the admin panel
    if (!function_exists('advancediFrame_ap')) {
        function advancediFrame_ap() {
            global $cons_advancediFrame;
            if (!isset($cons_advancediFrame)) {
                return;
            }
            $aiOptions = $cons_advancediFrame->getAiAdminOptions();
            
            $pro = (file_exists(dirname(__FILE__) . "/includes/class-cw-envato-api.php")) ? " Pro" : "";
                
            if (function_exists('add_options_page')) {
                add_options_page('Advanced iFrame' . $pro, 'Advanced iFrame'. $pro, 'manage_options',
                    basename(__FILE__), array($cons_advancediFrame, 'printAdminPage'));
            }  
            if  ($aiOptions['show_menu_link'] == "true") {
                add_menu_page('Advanced iFrame' . $pro, 'Advanced iFrame'. $pro, 'manage_options',  
                    basename(__FILE__), array($cons_advancediFrame, 'printAdminPage'));
            }
            if (!empty($aiOptions['alternative_shortcode'])) {    
                // setup shortcode alternative style  
                add_shortcode($aiOptions['alternative_shortcode'], array($cons_advancediFrame, 'do_iframe_script'), 1); 
            }  
           
            add_action('admin_print_footer_scripts', array($cons_advancediFrame, 'addAiButtonJs'), 199);
            add_action('media_buttons', array($cons_advancediFrame, 'addAiButton'), 11);
           
        }
    }
    add_action('admin_menu', 'advancediFrame_ap', 1); //admin page
    add_action('init', array($cons_advancediFrame, 'loadLanguage'), 1); // add languages
    add_action('admin_enqueue_scripts', array($cons_advancediFrame, 'addAdminHeaderCode'), 99); // load css
    add_action('wp_enqueue_scripts',  array($cons_advancediFrame, 'addWpHeaderCode'), 98); // load js
    add_action('wp_footer',  array($cons_advancediFrame, 'add_script_footer'), 2);
    add_shortcode('advanced_iframe', array($cons_advancediFrame, 'do_iframe_script'), 1); // setup shortcode
    add_shortcode('advanced-iframe', array($cons_advancediFrame, 'do_iframe_script'), 1); // setup shortcode alternative style   
    register_activation_hook(__FILE__, array($cons_advancediFrame, 'activate'));
    
    add_filter( 'widget_text', 'shortcode_unautop');
    add_filter( 'widget_text', 'do_shortcode');     
    add_filter('plugin_action_links', array($cons_advancediFrame, 'ai_plugin_action_links'),10,2);
}

// ==============================================
//	Setup for widget + remove update functionality
// ==============================================
function ai_remove_update($value) {
    if(isset( $value ) && is_object( $value ) && isset($value->response[ plugin_basename(__FILE__) ])) {
       unset($value->response[ plugin_basename(__FILE__) ]);
    }
    return $value;
}

function advanced_iframe_widget_init(){
	  register_widget('AdvancedIframe_Widget');
}

if (!isset($aip_standalone) && file_exists(dirname(__FILE__) . "/includes/advanced-iframe-widget.php")) {
    require_once('includes/advanced-iframe-widget.php');
    add_action('widgets_init','advanced_iframe_widget_init');
    add_filter('site_transient_update_plugins', 'ai_remove_update');
}

// ==============================================
//	Get Plugin Version
// ==============================================
function advanced_iframe_plugin_version() {
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

// ==============================================
//	Add Links in Plugins Table
// ==============================================
function advanced_iframe_plugin_meta_free( $links, $file ) {
	if ( strpos( $file, '/advanced-iframe.php' ) !== false ) {
		$iconstyle = 'style="-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;"';
    $reviewlink = 'https://wordpress.org/support/view/plugin-reviews/advanced-iframe?rate=5#postform';
    $links = array_merge( $links, array( '<a href="http://codecanyon.net/item/advanced-iframe-pro/5344999?ref=mdempfle">Advanced iFrame Pro</a>',
     '<a href="'.$reviewlink.'"><span class="dashicons dashicons-star-filled"' . $iconstyle . 'title="Give a 5 Star Review"></span></a>'
     ) );
  }
  return $links;
}

function advanced_iframe_plugin_meta_pro( $links, $file ) {
	if ( strpos( $file, '/advanced-iframe.php' ) !== false ) {
		$iconstyle = 'style="-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;"';
    $links = array();
    $links = array_merge( $links, 
        array( 'Version ' . advanced_iframe_plugin_version(), 
               'By <a href="http://www.tinywebgallery.com">Michael Dempfle</a>',
               '<a href="http://codecanyon.net/item/advanced-iframe-pro/5344999?ref=mdempfle">Code canyon - Advanced iFrame Pro</a>',
               '<a href="http://www.tinywebgallery.com/blog/advanced-iframe/advanced-iframe-pro-demo">Demos</a>'
        ));
  }
  return $links;
}

if (!isset($aip_standalone)) {
  if ( file_exists(dirname(__FILE__) . "/includes/advanced-iframe-widget.php")) {
    add_filter( 'plugin_row_meta', 'advanced_iframe_plugin_meta_pro', 10, 2 );
  } else {
    add_filter( 'plugin_row_meta', 'advanced_iframe_plugin_meta_free', 10, 2 );
  }
}

?>