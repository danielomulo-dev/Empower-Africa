<?php
/**
 * Plugin Name: Empower Africa Gallery
 * Description: A lightweight responsive image gallery plugin with shortcode support for WordPress.
 * Version: 1.0.0
 * Author: Empower Africa
 * License: GPL-2.0-or-later
 * Text Domain: empower-africa-gallery
 */

if (!defined('ABSPATH')) {
    exit;
}

final class Empower_Africa_Gallery {
    public function __construct() {
        add_shortcode('ea_gallery', [$this, 'render_gallery_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    public function register_assets() {
        wp_register_style(
            'empower-africa-gallery',
            plugin_dir_url(__FILE__) . 'assets/gallery.css',
            [],
            '1.0.0'
        );
    }

    public function render_gallery_shortcode($atts) {
        $atts = shortcode_atts(
            [
                'ids' => '',
                'columns' => 3,
                'size' => 'large',
                'link' => 'file',
                'captions' => 'true',
                'class' => '',
            ],
            $atts,
            'ea_gallery'
        );

        if (empty($atts['ids'])) {
            return '';
        }

        $ids = array_filter(array_map('absint', explode(',', $atts['ids'])));
        if (empty($ids)) {
            return '';
        }

        $columns = max(1, min(6, absint($atts['columns'])));
        $size = sanitize_key($atts['size']);
        $link = in_array($atts['link'], ['file', 'none'], true) ? $atts['link'] : 'file';
        $captions = filter_var($atts['captions'], FILTER_VALIDATE_BOOLEAN);
        $extra_class = sanitize_html_class($atts['class']);

        wp_enqueue_style('empower-africa-gallery');

        $classes = ['ea-gallery-grid', 'ea-gallery-columns-' . $columns];
        if (!empty($extra_class)) {
            $classes[] = $extra_class;
        }

        $output = '<div class="' . esc_attr(implode(' ', $classes)) . '">';

        foreach ($ids as $id) {
            $image_html = wp_get_attachment_image(
                $id,
                $size,
                false,
                [
                    'class' => 'ea-gallery-image',
                    'loading' => 'lazy',
                ]
            );

            if (!$image_html) {
                continue;
            }

            $caption = wp_get_attachment_caption($id);
            $image_url = wp_get_attachment_url($id);

            $output .= '<figure class="ea-gallery-item">';

            if ($link === 'file' && $image_url) {
                $output .= '<a class="ea-gallery-link" href="' . esc_url($image_url) . '">';
                $output .= $image_html;
                $output .= '</a>';
            } else {
                $output .= $image_html;
            }

            if ($captions && $caption) {
                $output .= '<figcaption class="ea-gallery-caption">' . esc_html($caption) . '</figcaption>';
            }

            $output .= '</figure>';
        }

        $output .= '</div>';

        return $output;
    }
}

new Empower_Africa_Gallery();
