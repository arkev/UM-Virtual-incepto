<?php

abstract class Inc_Abstract_Slider_Manager_Plugin extends Abstract_Plugin
{
    function save_slider($type, $name, $new_slider)
    {
        if (empty($type)) {
            throw new Exception('The slider type must not be empty');
        }
        if (empty($name)) {
            throw new Exception('The slider name must not be empty');
        }
        $slider_id = sanitize_title($name);
        $sliders = $this->get_sliders();
        foreach ($sliders as $slider) {
            if ($slider['type'] == $type && $slider['id'] == $slider_id) {
                throw new Exception('A slider with the same name and type already exists');
            }
        }

        $slider = array(
            'type' => $type,
            'id' => $slider_id,
            'name' => $name,
            'config' => $new_slider);
        array_push($sliders, $slider);
        update_option(SETTINGS_SLIDERS, $sliders);
    }

    function update_slider($type, $slider_id, $new_slider)
    {
        $save = false;
        $sliders = $this->get_sliders();
        foreach ($sliders as &$slider) {
            if ($slider['type'] == $type && $slider['id'] == $slider_id) {
                $slider['id'] = $new_slider['id'];
                $slider['name'] = $new_slider['name'];
                $slider['config'] = $new_slider['config'];
                $save = true;
            }
        }
        if ($save) {
            update_option(SETTINGS_SLIDERS, $sliders);
        }
    }

    function duplicate_slider($type, $slider_id)
    {
        $sliders = $this->get_sliders();
        $ok = false;
        foreach ($sliders as $slider) {
            if ($slider['type'] == $type && $slider['id'] == $slider_id) {
                $new_slider_name = $slider['name'].'-Copy';
                $new_slider_id = sanitize_title($new_slider_name);
                $new_slider_config = $slider['config'];
                $new_slider = array(
                    'type' => $type,
                    'id' => $new_slider_id,
                    'name' => $new_slider_name,
                    'config' => $new_slider_config);
                array_push($sliders, $new_slider);
            }
            $ok = true;
        }
        if ($ok) {
            update_option(SETTINGS_SLIDERS, $sliders);
        }
    }

    function delete_slider($type, $slider_id)
    {
        $sliders = $this->get_sliders();
        $index = -1;
        $i = 0;
        foreach ($sliders as $slider) {
            if ($slider['type'] == $type && $slider['id'] == $slider_id) {
                $index = $i;
            }
            $i++;
        }
        if ($index >= 0) {
            unset($sliders[$index]);
            update_option(SETTINGS_SLIDERS, $sliders);
        }
    }

    function get_slider($type, $id)
    {
        $all_sliders = $this->get_sliders();
        foreach ($all_sliders as $slider) {
            if ($slider['type'] == $type && $slider['id'] == $id) {
                return $slider;
            }
        }
        return null;
    }

    function get_sliders()
    {
        $sliders = get_option(SETTINGS_SLIDERS);
        if (!$sliders) {
            return array();
        } else {
            return $sliders;
        }
    }

    abstract function render_slider($settings);

    abstract function get_slides($slider_id);
}
