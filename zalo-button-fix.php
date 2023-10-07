<?php

/**
 * Zalo Button Fix
 *
 * @package       zalo-button-fix
 * @author        Bang Nguyen (Based on FoxTheme code)
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Zalo Button Fix
 * Plugin URI:    https://bangdigi.one
 * Description:   Sửa lỗi nút bấm zalo không truy cập được khi gọi trực tiếp
 * Version:       1.0.0
 * Author:        Bang Nguyen
 * Author URI:    https://bangdigi.one
 * Text Domain:   zalo-button-fix
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

require_once dirname(__FILE__) . '/inc/class.zaloadmin.php';

/* 
 * Retrieve this value with:
 * $button_zalo_options = get_option( 'button_zalo_option_name' ); // Array of All Options
 * $so_dien_thoai_0 = $button_zalo_options['so_dien_thoai_0']; // Số điện thoại
 * $qr_id_1 = $button_zalo_options['qr_id_1']; // QR ID
 * $vi_tri_2 = $button_zalo_options['vi_tri_2']; // Vị trí
 */


function register_zalo_button()
{
	$button_zalo_options = get_option( 'button_zalo_option_name' );
	$position = isset( $button_zalo_options['vi_tri_2'] ) ? $button_zalo_options['vi_tri_2'] : '';
	$position_class = $position === 'left' ? 'zalo-left' : 'zalo-right';
?>
	<button title="Zalo" id="nutzalo" class="<?php echo $position_class; ?>">ZALO</button>
	<style>
		#nutzalo {
			border: none;
			border-radius: 100%;
			width: 50px;
			height: 50px;
			background: #0065f7;
			color: #fff;
			font-weight: bold;
			position: fixed;
			display: grid;
			align-items: center;
			text-align: center;
			font-size: 12px;
			padding: 0px;
			bottom: 50px;
			
			animation: zalo 1000ms infinite;
			z-index: 999999999;
		}

		.zalo-left {
			left: 10px;
		}
		.zalo-right {
			right: 10px;
		}

		#nutzalo:hover {
			opacity: 0.6;
		}

		@keyframes zalo {
			0% {
				transform: translate3d(0, 0, 0) scale(1);
			}

			33.3333% {
				transform: translate3d(0, 0, 0) scale(0.9);
			}

			66.6666% {
				transform: translate3d(0, 0, 0) scale(1);
			}

			100% {
				transform: translate3d(0, 0, 0) scale(1);
			}

			0% {
				box-shadow: 0 0 0 0px #0065f7, 0 0 0 0px #0065f7;
			}

			50% {
				transform: scale(0.8);
			}

			100% {
				box-shadow: 0 0 0 15px rgba(0, 210, 255, 0), 0 0 0 30px rgba(0, 210, 255, 0);
			}
		}
	</style>
	<script>
		function isMobileDevice() {
			return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
		}
		const nutzalo = document.getElementById('nutzalo');

		function ZaloClick() {
			let link;
			if (isMobileDevice()) {
				if (navigator.userAgent.includes('Android')) { 
					// android	
					<?php if (!empty($button_zalo_options['qr_id_1'])) : ?>
					  link = `https://zaloapp.com/qr/p/<?php echo $button_zalo_options['qr_id_1']; ?>`;
					<?php endif; ?>
				} else {
					// ios
					link = `zalo://qr/p/<?php echo $button_zalo_options['qr_id_1']; ?>`;
				}
			} else {
				// link mở zalo pc
				<?php if(!empty($button_zalo_options['so_dien_thoai_0'])) : ?>
					link = `zalo://conversation?phone=<?php echo $button_zalo_options['so_dien_thoai_0']; ?>`;
				<?php endif; ?>
			}
			window.open(link, '_blank');
		}
		nutzalo.addEventListener('click', ZaloClick);
	</script>
<?php }
add_action('wp_footer', 'register_zalo_button');
