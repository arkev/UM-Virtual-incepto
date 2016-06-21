<?php
/**
 *  In this file the dynamic css is created
 */          
 
   // Fix if iframe is above the header div
   if (!empty($show_iframe_as_layer_header_file) && $show_iframe_as_layer_header_position === 'bottom') {
     $html .= '#'.$id.' {display:block;}';
   }
   $html .= '#ai-layer-div-'.$id.' p {height:100%;margin:0;padding:0}';
   if ($show_part_of_iframe == 'true') {
       $html .= '
        #ai-div-'.$id.'
        {
            width    : '.esc_html($this->addPx($show_part_of_iframe_width)) . ';
            height   : '.esc_html($this->addPx($show_part_of_iframe_height)) .';
            overflow : hidden;
            position : relative;'
            ;
        if ($show_part_of_iframe_allow_scrollbar_horizontal == 'true') {
           $html .= 'overflow-x : auto;';
           $html .= '-webkit-overflow-scrolling: touch;';
        }
        if ($show_part_of_iframe_allow_scrollbar_vertical == 'true') {
           $html .= 'overflow-y : auto;';
           $html .= '-webkit-overflow-scrolling: touch;';
        }
        if (!empty($show_part_of_iframe_style)) {
            $html .= esc_html($show_part_of_iframe_style);
        }
        $html .= '
        }
        #'.$id.'
        {
            position : absolute;
            top      : -'.esc_html($show_part_of_iframe_y).'px;
            left     : -'.esc_html($show_part_of_iframe_x).'px;
            width    : '.esc_html($width).';
            height   : '.esc_html($height).';
        }';
   }
   
  $scale_width = $width; 
  $scale_height = $height; 
  
  $enable_ie_8_support = false; 
  if (!empty($iframe_zoom)) {
       if ($width != 'not set' && $width != '') {
           $scale_width = $this->scale_value($width, $iframe_zoom); 
       } else {
          return $error_css . '<div class="errordiv">' . __('Configration error: Zoom does need a specified width.', 'advanced-iframe') . '</div>';         
       }
       if ($height != 'not set' && $height != '') {
            $scale_height = $this->scale_value($height, $iframe_zoom); 
       } else {
           return $error_css . '<div class="errordiv">' . __('Configration error: Zoom does need a specified height.', 'advanced-iframe') . '</div>'; 
       }
        
       $html .= '#ai-zoom-div-'.$id.'
        {
          width: '.$scale_width.';
          height: '.$scale_height.'; 
          padding: 0;
          overflow: hidden;
        }
        #'.$id.'
        {';
           if(version_compare(PHP_VERSION, '5.3.0') >= 0) {
             $enable_ie_8_support = ($iframe_zoom_ie8 == 'true') && $this->checkIE8();
             if ($enable_ie_8_support) {
               $html .= '-ms-zoom:'.$iframe_zoom.';'; 
             }
           }
           $html .= '-ms-transform: scale('.$iframe_zoom.');
              -ms-transform-origin: 0 0;
              -moz-transform: scale('.$iframe_zoom.');
              -moz-transform-origin: 0 0;
              -o-transform: scale('.$iframe_zoom.');
              -o-transform-origin: 0 0;
              -webkit-transform: scale('.$iframe_zoom.');
              -webkit-transform-origin: 0 0;
              transform: scale('.$iframe_zoom.');
              transform-origin: 0 0;
              ';   
              if ($use_zoom_absolute_fix == 'true') {
                 $html .=  ' position:absolute;  ';
              }
          $html .= '
              }';         
  } 
  
  if ($show_iframe_loader == 'true') {
          // div for the loader 
          if ($show_part_of_iframe == 'true') {  // size is show part of the iframe  
              $loader_width = $show_part_of_iframe_width;
              $loader_height = $show_part_of_iframe_height; 
          } else  if (!empty($iframe_zoom)) { // or zoom size
              $loader_width = $scale_width;
              $loader_height = $scale_height; 
          } else { // the iframe size.
              $loader_width = $width;
              $loader_height = $height;
          }   
       $html .= '#ai-div-container-'.$id.'
       { 
           position: relative;
           width: ' . $this->addPx($loader_width);
           if ($enable_responsive_iframe == 'true') {
            $html .= '; max-width: 100%';
           }
       $html .= ';}
       #ai-div-loader-'.$id.'
       {
          position: absolute;
          z-index:1000;
          margin-left:-33px;
          left: 50%;';
       if ($show_part_of_iframe == 'true') {
         $itop = ($show_part_of_iframe_height / 2) - 33;
         if ($itop > 150) {
             $itop = 150;
         }
         $html .= '   top: ' . floor($itop) . 'px;';
       } else {
         $html .= '   top: 150px;
         }';
       }
        $html .= '#ai-div-loader-'.$id.' img
       {
          border: none;
       }';
  }
  
  if ($enable_lazy_load == 'true') {
    $html .= '.ai-lazy-load-'.$id.' {';  
    if ($enable_lazy_load_reserve_space) {
      $html .= '
        width: '.$scale_width.';
        height: '.$scale_height.';';
    } 
    $html .= '
      padding: 0;
      margin: 0;
    }';
  }
  
  if ($hide_page_until_loaded  == 'true' || $hide_page_until_loaded_external == 'true') {
    $html .= '#'.$id.' { visibility:hidden; } ';
    if (!empty($hide_part_of_iframe)) { 
       $html .= '#wrapper-div-'.$id.' { visibility:hidden; } ';
    }   
  }
  
  $html .= '</style>';
?>