# Features & Customizations — Nordic & Co

What was customized and why, so future developers (or the client) understand the decisions.

---

## Child theme — `nordic-child`

### Custom colour palette

The brand uses a muted, Scandinavian-inspired palette:

| Token | Hex | Used for |
|-------|-----|----------|
| `--nc-sand` | `#f5f0e8` | Page backgrounds, section fills |
| `--nc-bark` | `#8b7355` | Hover states, accents |
| `--nc-pine` | `#2d4a3e` | Primary buttons, prices |
| `--nc-fog`  | `#e8e4dc` | Borders, dividers |

All values live in `:root` in `style.css` so they're easy to update.

### Typography

Replaced Storefront's default font stack with **Jost** (Google Fonts).
Jost has lighter weights (300, 400) that match the Nordic aesthetic better than sans-serif defaults.

Headings use `font-weight: 300` + `letter-spacing: 0.04em` + `text-transform: uppercase`
to keep the Scandinavian minimal feel consistent.

### Product grid

Overrode WooCommerce's default 3-column float-based grid with CSS Grid (`auto-fill, minmax(240px, 1fr)`).
This makes the grid genuinely responsive without media-query hacks.

### Sale badge — percentage off

Storefront shows "Sale!" by default.
The client asked for the actual discount percentage instead (more convincing to shoppers).

`functions.php` hooks `woocommerce_sale_flash` to calculate and display e.g. "−30%".

---

## Plugin — `nordic-customizer`

### `[nordic_featured]` shortcode

**Client request:** show a hand-picked selection of featured products on the homepage without
requiring a page builder.

Usage:
```
[nordic_featured limit="4" category="living-room" columns="4"]
```

Products must be individually marked as Featured in WooCommerce product settings.
The shortcode uses `WP_Query` directly (not `wc_get_products`) so we can combine
the `featured` visibility term with a category filter in a single query.

### "New Arrival" badge

Shows a green "New" badge on products added in the last 30 days.
Hooks on `woocommerce_before_shop_loop_item_title`.

The 30-day window is hard-coded — if the client wants to adjust it, change the constant
on line 68 of `nordic-customizer.php`.

---

## Performance notes

- Jetpack's `devicepx` script is dequeued on shop/product pages — it adds ~30 KB and
  has no function in this theme.
- Product thumbnail size `nordic-product-thumb` (480×600, hard crop) is registered to avoid
  browsers downloading full-size images and scaling them down.
- All badge CSS is inlined in `<head>` via `wp_head` — one fewer HTTP request vs. a stylesheet.
