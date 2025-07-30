<?php
/**
 * Plugin Name: Masivo Fixed Mobile Bar
 * Plugin URI: https://www.seomasivo.com/
 * Description: Fixed bottom bar on mobile/tablet with configurable buttons and FontAwesome visual icon selector.
 * Version: 1.1
 * Tested up to: 6.8
 * Requires at least: 5.9
 * Requires PHP: 7.4
 * Text Domain: masivo-mobile-bar
 * Domain Path: /languages
 * Author: Raúl Soriano
 * Author URI: https://www.seomasivo.com/
 * License: GPLv2
 */

// idiomas
add_action('plugins_loaded', function () {
add_action('init', function() {
    load_textdomain('wpmasivo', WP_PLUGIN_DIR . '/wpmasivo/languages/wpmasivo-' . get_locale() . '.mo');
});
});

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('wpmasivo-fa', plugins_url('assets/fontawesome/css/all.min.css', __FILE__));
});
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('wpmasivo-fa', plugins_url('assets/fontawesome/css/all.min.css', __FILE__));
});

add_action('wp_footer', function () use ($settings) {
   
        $position = $settings['position'] ?? 'bottom';
        echo '<style>body { padding-' . $position . ': 60px !important; }</style>';
    
});


// Registrar ajustes
add_action('admin_init', function () {
register_setting('wpmasivo_mobile_bar', 'wpmasivo_mobile_bar_settings', function($input){ return $input; });

});
// Crear página ajustes
add_action('admin_menu', function () {
    add_menu_page('WPMasivo Mobile Bar', 'WPMasivo Mobile Bar', 'manage_options', 'wpmasivo_mobile_bar', function () {
        $settings = get_option('wpmasivo_mobile_bar_settings', [
            'buttons' => 4,
            'bg_color' => '#111111',
            'items' => [],
        ]);
        ?>
        <div class="wrap">
            <h1>WPMasivo Fixed Mobile Bar</h1>
            <form method="post" action="options.php">
                <?php settings_fields('wpmasivo_mobile_bar'); ?>
                <label>How many buttons? (1-6):</label>
                <input type="number" name="wpmasivo_mobile_bar_settings[buttons]" min="1" max="6" value="<?php echo intval($settings['buttons']); ?>" />
				<label>Maximum breakpoint (px):</label>
				<input type="number" name="wpmasivo_mobile_bar_settings[breakpoint]" min="0" max="4096" value="<?php echo intval($settings['breakpoint'] ?? 1024); ?>" />
				<label>Background color:</label>
                <input type="color" name="wpmasivo_mobile_bar_settings[bg_color]" value="<?php echo esc_attr($settings['bg_color']); ?>" />
				<label>Icon color:</label>
				<input type="color" name="wpmasivo_mobile_bar_settings[icon_color]" value="<?php echo esc_attr($settings['icon_color'] ?? '#ffffff'); ?>" />
				<select name="wpmasivo_mobile_bar_settings[position]" style="width: 150px;"><option value="bottom" <?php selected($settings['position'] ?? '', 'bottom'); ?>>Abajo</option><option value="top" <?php selected($settings['position'] ?? '', 'top'); ?>>Arriba</option></select>
				<label>Estilo del texto:</label>
				<div style="display:flex; gap:10px; flex-wrap:wrap;">
					<label><input type="checkbox" name="wpmasivo_mobile_bar_settings[uppercase]" value="1" <?php checked($settings['uppercase'] ?? '', 1); ?> /> Mayúsculas</label>
					<label><input type="checkbox" name="wpmasivo_mobile_bar_settings[bold]" value="1" <?php checked($settings['bold'] ?? '', 1); ?> /> Negrita</label>
					<label><input type="checkbox" name="wpmasivo_mobile_bar_settings[underline]" value="1" <?php checked($settings['underline'] ?? '', 1); ?> /> Subrayado</label>
					<label><input type="checkbox" name="wpmasivo_mobile_bar_settings[italic]" value="1" <?php checked($settings['italic'] ?? '', 1); ?> /> Cursiva</label>
				</div><br><br>
                <hr>
               <?php
				$brand_icons = ['whatsapp', 'youtube', 'facebook', 'instagram', 'twitter', 'linkedin', 'tiktok', 'snapchat'];

				$all_icons = [
					'home', 'envelope', 'phone', 'search', 'user', 'cog', 'shopping-cart', 'bell', 'star', 'heart',
					'camera', 'calendar', 'info-circle', 'map-marker-alt', 'clock', 'question-circle', 'thumbs-up',
					'comment', 'bolt', 'wifi', 'car', 'bicycle', 'bus', 'coffee', 'credit-card', 'gift', 'globe',
					'key', 'leaf', 'lightbulb', 'lock', 'mobile-alt', 'paper-plane', 'paperclip', 'plus', 'minus',
					'print', 'reply', 'rocket', 'share', 'smile', 'tag', 'trash', 'truck', 'undo', 'upload',
					'user-circle', 'wrench', 'whatsapp', 'youtube', 'facebook', 'instagram', 'twitter', 'linkedin',
					'tiktok', 'snapchat'
				];

				$count = intval($settings['buttons']);
				for ($i = 0; $i < $count; $i++) {
					$item = $settings['items'][$i] ?? ['icon' => '', 'text' => '', 'url' => ''];
					$icon = !empty($item['icon']) ? $item['icon'] : 'circle';
					$prefix = in_array($icon, $brand_icons) ? 'fab' : 'fas';
					?>
					<fieldset style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
						<legend>Button <?php echo esc_attr($i); ?></legend>
						<div style="display: flex; flex-wrap: wrap; gap: 10px;">
							<div style="display:flex; flex-direction:column;">
								<label>Icon FontAwesome:</label>
								<div class="icon-picker-wrapper" style="position:relative;">
									<span class="icon-picker <?php echo $prefix; ?> fa-<?php echo esc_attr($icon); ?>"></span>
									<input type="hidden" class="icon-input" name="wpmasivo_mobile_bar_settings[items][<?php echo esc_html($i); ?>][icon]" value="<?php echo esc_attr($icon); ?>" />
									<div class="icon-list" style="display:none; flex-wrap: wrap; max-height:200px; overflow-y:auto; border:1px solid #ccc; background:#fff; position:absolute; z-index:9999; width:300px; padding:5px;">
										<?php
										foreach ($all_icons as $icn) {
											$icn_prefix = in_array($icn, $brand_icons) ? 'fab' : 'fas';
											echo '<span data-icon="' . esc_attr($icn) . '" class="' . $icn_prefix . ' fa-' . esc_attr($icn) . '" style="margin:5px; font-size:20px; cursor:pointer; user-select:none;"></span>';
										}
										?>
									</div>
								</div>
							</div>

							<div style="display:flex; flex-direction:column;">
								<label>Text:</label>
								<input type="text" name="wpmasivo_mobile_bar_settings[items][<?php echo esc_html($i); ?>][text]" value="<?php echo esc_attr($item['text']); ?>" style="width:200px;" />
							</div>

							<div style="display:flex; flex-direction:column;">
								<label>URL:</label>
								<input type="url" name="wpmasivo_mobile_bar_settings[items][<?php echo esc_html($i); ?>][url]" value="<?php echo esc_attr($item['url']); ?>" style="width:300px;" />
							</div>
						</div>
					</fieldset>
    <?php
}
?>

                <?php submit_button(); ?>
			</form>
			</div>
			<style>
            .icon-picker {
    font-size: 20px;
    cursor: pointer;
    user-select: none;
    display: inline-block;
    width: 32px;
    text-align: center;
    margin-right: 8px;
}

            }
            .icon-picker.active {
                background: #0073aa;
                color: #fff;
                border-radius: 4px;
            }
        </style>
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.icon-picker-wrapper').forEach(wrapper => {
                const picker = wrapper.querySelector('.icon-picker');
                const input = wrapper.querySelector('.icon-input');
                const list = wrapper.querySelector('.icon-list');
                picker.addEventListener('click', e => {
                    e.stopPropagation();
                    const showing = list.style.display === 'flex';
                    document.querySelectorAll('.icon-list').forEach(l => l.style.display = 'none');
                    document.querySelectorAll('.icon-picker').forEach(p => p.classList.remove('active'));
                    if (!showing) {
                        list.style.display = 'flex';
                        picker.classList.add('active');
                    }
                });
                list.querySelectorAll('span').forEach(iconEl => {
                    iconEl.addEventListener('click', () => {
                        const icon = iconEl.getAttribute('data-icon');
                        input.value = icon;
                        picker.className = 'icon-picker fas fa-' + icon;
                        list.style.display = 'none';
                        picker.classList.remove('active');
                    });
                });
            });
            document.addEventListener('click', () => {
                document.querySelectorAll('.icon-list').forEach(l => l.style.display = 'none');
                document.querySelectorAll('.icon-picker').forEach(p => p.classList.remove('active'));
            });
        });
        </script>
        <?php
    });
});

// Cargar FontAwesome solo frontend
add_action('wp_enqueue_scripts', function () {
wp_enqueue_style('wpmasivo-fa', plugin_dir_url(__FILE__) . 'assets/css/all.min.css', [], '6.4.0');
});

// Imprimir barra en footer solo móvil/tablet
add_action('wp_footer', function () {
    $settings = get_option('wpmasivo_mobile_bar_settings', [
        'buttons' => 4,
        'bg_color' => '#111111',
        'items' => [],
    ]);
    $buttons = intval($settings['buttons']);
    if ($buttons < 1) $buttons = 1;
    if ($buttons > 6) $buttons = 6;
    $bg = esc_attr($settings['bg_color']);
    $items = $settings['items'] ?? [];
    ?>
 <?php
$breakpoint = intval($settings['breakpoint'] ?? 1024);
?>
<style>
    #wpmasivo-mobile-bar {
        display: none;
    }
    @media (max-width: <?php echo esc_html($breakpoint); ?>px) {
        #wpmasivo-mobile-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: <?php echo esc_html($bg); ?>;
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            align-items: center;
            height: 56px;
            z-index: 9999;
            padding: 0;
        }
        #wpmasivo-mobile-bar a {
            flex: 0 0 calc(100% / <?php echo esc_html($buttons); ?>);
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            user-select: none;
            padding: 4px 0;
            box-sizing: border-box;
        }
        #wpmasivo-mobile-bar a i {
            font-size: 20px;
        }
    }
	#wpmasivo-mobile-bar.wpmasivo-bar-top {
    top: 0;
    bottom: auto;
	margin-bottom:56px!important;
}
#wpmasivo-mobile-bar.wpmasivo-bar-bottom {
    bottom: 0;
    top: auto;
	margin-top:56px!important;
}

</style>
<?php
$position_class = ($settings['position'] ?? 'bottom') === 'top' ? 'wpmasivo-bar-top' : 'wpmasivo-bar-bottom';

$text_styles = [];
if (!empty($settings['uppercase'])) $text_styles[] = 'text-transform:uppercase';
if (!empty($settings['bold'])) $text_styles[] = 'font-weight:bold';
if (!empty($settings['underline'])) $text_styles[] = 'text-decoration:underline';
if (!empty($settings['italic'])) $text_styles[] = 'font-style:italic';
$text_style_attr = implode('; ', $text_styles);
?>

<div id="wpmasivo-mobile-bar" class="<?php echo $position_class; ?>" role="navigation" aria-label="WPMasivo Fixed Mobile Bar">
    <?php
    $brand_icons = ['whatsapp', 'youtube', 'facebook', 'instagram', 'twitter', 'linkedin', 'tiktok', 'snapchat'];

    for ($i = 0; $i < $buttons; $i++) {
        $item = $items[$i] ?? ['icon' => '', 'text' => '', 'url' => '#'];
        $icon = esc_attr($item['icon']) ?: 'circle';
        $text = esc_html($item['text']);
        $url = esc_url($item['url']) ?: '#';
        $prefix = in_array($icon, $brand_icons) ? 'fab' : 'fas';

        echo '<a href="' . esc_url($url) . '" tabindex="0">';
        echo '<i class="' . $prefix . ' fa-' . esc_attr($icon) . '" aria-hidden="true"></i>';
        echo '<span class="wpmasivo-text" style="' . esc_attr($text_style_attr) . '">' . $text . '</span>';
        echo '</a>';
    }
    ?>
</div>


    <?php
});