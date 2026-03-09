# Local Setup Guide — Nordic & Co

Step-by-step instructions for running the store on your local machine with XAMPP.

---

## Requirements

- XAMPP (7.4+) — [download](https://www.apachefriends.org)
- WordPress 6.x — [download](https://wordpress.org/download)
- WooCommerce plugin (installed from WP admin)
- Storefront theme (free, installed from WP admin)

---

## Step 1 — Install XAMPP and start servers

1. Download and install XAMPP.
2. Open XAMPP Control Panel.
3. Start **Apache** and **MySQL** — both status lights should turn green.
4. Open `http://localhost` in your browser to confirm Apache is running.

---

## Step 2 — Create a database

1. Go to `http://localhost/phpmyadmin`.
2. Click **New** in the left sidebar.
3. Database name: `nordic_store`
4. Collation: `utf8mb4_unicode_ci`
5. Click **Create**.

---

## Step 3 — Install WordPress

1. Download WordPress and extract the zip.
2. Copy the extracted `wordpress` folder to `C:\xampp\htdocs\nordic`.
3. Open `http://localhost/nordic` — the WordPress setup wizard starts.
4. Fill in:
   - Database name: `nordic_store`
   - Username: `root`
   - Password: _(leave blank for XAMPP default)_
   - Database host: `localhost`
   - Table prefix: `wp_`
5. Complete the install with your admin username and password.

---

## Step 4 — Install the Storefront parent theme

1. In WordPress admin go to **Appearance → Themes → Add New**.
2. Search for "Storefront".
3. Install and **Activate** it.

---

## Step 5 — Install the Nordic child theme

1. Zip the `theme/nordic-child/` folder from this repo.
2. In WP admin go to **Appearance → Themes → Add New → Upload Theme**.
3. Upload the zip and click **Activate**.

---

## Step 6 — Install WooCommerce

1. In WP admin go to **Plugins → Add New**.
2. Search "WooCommerce" — install and activate it.
3. Run through the WooCommerce setup wizard (you can skip payment settings for local testing).

---

## Step 7 — Install the Nordic Customizer plugin

1. Zip the `plugins/nordic-customizer/` folder from this repo.
2. In WP admin go to **Plugins → Add New → Upload Plugin**.
3. Upload the zip and click **Activate**.

---

## Step 8 — Add sample products

Use WooCommerce's built-in sample data:

1. Go to **WooCommerce → Status → Tools**.
2. Click **Import sample data**.

Or add products manually via **Products → Add New**.

---

## Testing the shortcode

Add this to any page content:

```
[nordic_featured limit="4"]
```

It will render a 4-column grid of your featured products.

---

## Troubleshooting

| Issue | Fix |
|-------|-----|
| Blank page after theme activation | Check PHP error log at `C:\xampp\php\logs\php_error_log` |
| Products not showing | Make sure **WooCommerce** is installed and at least one product exists |
| Images missing | Go to **Settings → Media** and set upload folder to `wp-content/uploads` |
