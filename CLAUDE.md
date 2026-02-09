# Protect the Children

## Overview
Password protects child pages when their parent page is password-protected and has the "Protect Children" option enabled. Supports both Classic Editor and Gutenberg.

## Architecture

```
index.php                  # Entry point, template_redirect hook, activation hook
_inc/
├── admin.php              # ProtectTheChildren - admin/editor functionality
├── helpers.php            # ProtectTheChildren_Helpers - static helper methods
└── deprecated.php         # Legacy compatibility code
assets/
├── css/admin.css          # Admin styles
└── js/admin.js            # Classic editor JavaScript
src/                       # Gutenberg block source
build/                     # Compiled Gutenberg block
```

## Key Classes

### ProtectTheChildren (_inc/admin.php)
Admin-side functionality for both Classic and Gutenberg editors.

- `ptc_save_post_meta($post_id, $post, $update)` - Saves `protect_children` meta on post save
- `add_classic_checkbox($post)` - Renders checkbox in Classic Editor publish box
- `register_post_meta_gutenberg()` - Registers meta for REST API / Gutenberg
- `enqueue_block_editor_assets()` - Loads Gutenberg-specific JS
- `adjust_visibility($buffer)` - Modifies admin visibility display for protected children
- `protect_meta($protected, $meta_key)` - Prevents editing via custom fields
- `allow_meta_editing_for_admin($args, ...)` - Auth callback for Gutenberg editing
- `update_pages_meta($post)` - REST API post update handler

### ProtectTheChildren_Helpers (_inc/helpers.php)
Static utility methods.

- `isPasswordProtected($post)` - Checks if post has password (not private status)
- `isEnabled($post)` - Checks if parent has protection enabled (recursive)
- `processPosts($post)` - Processes array of posts for protection check
- `processPost($post_id)` - Single post check: password + meta
- `supportsPTC($post)` - Checks if post type supports PTC (hierarchical + custom-fields)

## Frontend Logic (index.php, `template_redirect`)
1. Gets current post's ancestors
2. Checks if any ancestor has `protect_children` meta enabled
3. If parent is protected, checks for `wp-postpass_` cookie
4. Verifies cookie hash matches parent's password using `PasswordHash`
5. If no valid cookie, adds `post_password_required` filter

## Post Meta
- `protect_children` - Boolean (`1` or empty). Stored on the parent post.

## Testing
Tests are in `../tests/unit/protect-the-children/`. Run with:
```bash
make test-plugin PLUGIN=protect-the-children
```

## Important Notes
- Only works with hierarchical post types (pages, custom types with hierarchy)
- Post type must support `custom-fields` feature
- Protection cascades to grandchildren and deeper
- Old meta key `_protect_children` is auto-migrated to `protect_children` on activation
