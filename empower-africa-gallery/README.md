# Empower Africa Gallery

A lightweight WordPress gallery plugin.

## Installation

1. Copy the `empower-africa-gallery` folder into `wp-content/plugins/`.
2. Activate **Empower Africa Gallery** in the WordPress admin Plugins screen.

## Usage

Add shortcode to any post or page:

```text
[ea_gallery ids="10,22,31" columns="3" size="large" link="file" captions="true"]
```

### Shortcode attributes

- `ids` (required): Comma-separated attachment IDs.
- `columns`: Number of columns (1-6).
- `size`: Image size (`thumbnail`, `medium`, `large`, `full`, or custom size).
- `link`: `file` or `none`.
- `captions`: `true` or `false`.
- `class`: Optional extra CSS class on gallery wrapper.
