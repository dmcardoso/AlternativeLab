<?php
/*
Plugin Name: NG-Migrate
*/

function insertMedia($media) {
	$tmp_path = __DIR__ . UTIL_PATH;

	if ( ! is_dir($tmp_path)) {
		mkdir($tmp_path);
	}

	if (file_exists($media)) {
		//	$tmp = download_url($url);

		$new_path = $tmp_path . basename($media);
		copy($media, $new_path);

		$file_array = array(
			'name'     => basename($media),
			'tmp_name' => $new_path
		);

		/**
		 * Check for download errors
		 * if there are error unlink the temp file name
		 */
//	if (is_wp_error($tmp)) {
//		@unlink($file_array['tmp_name']);
//
//		return $tmp;
//	}

		$media_id = media_handle_sideload($file_array, 0);

		/**
		 * We don't want to pass something to $id
		 * if there were upload errors.
		 * So this checks for errors
		 */
		if (is_wp_error($media_id)) {
			@unlink($file_array['tmp_name']);

			return $media_id;
		}

		return ['id' => $media_id, 'media' => $media];
	} else {
		return ['error' => 0, 'media' => $media];
	}
}

add_action('plugins_loaded', function () {
	if (isset($_REQUEST['ng-migrate-posts'])) {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(__DIR__ . '/utils/configs.php');
		require_once(__DIR__ . '/utils/NucleoRequests.php');

		$post = NucleoRequests::get()['new_post'] ? NucleoRequests::get()['new_post'] : null;

		$return   = [];
		$new_post = json_decode($post, true);

		if (is_array($new_post)) {

			if (is_array($new_post) && isset($new_post['post_content'], $new_post['post_title'], $new_post['post_content'])) {
				$args = [];

				$args['post_content'] = $new_post['post_content'];
				$args['post_title']   = $new_post['post_title'];
				$args['post_excerpt'] = $new_post['post_excerpt'] ?? "";
				$args['post_status']  = $new_post['post_status'] ?? "publish";
				$args['post_type']    = $new_post['post_type'] ?? "post";

				if (isset($new_post['post_date'])) {
					$args['post_date'] = $new_post['post_date'];
				}

				if (isset($new_post['meta_input'])) {
					$args['meta_input'] = $new_post['meta_input'];
				}

				$post_id           = wp_insert_post($args);
				$return['post_id'] = $post_id;

				if (isset($new_post['thumb']) || isset($new_post['galeria'])) {
					if ( ! is_wp_error($post_id)) {

						if (isset($new_post['thumb']) && $new_post['thumb'] !== "") {
							$media_id = insertMedia($new_post['thumb']);

							$value = wp_get_attachment_url($media_id);

							if ( ! is_wp_error($media_id) || ! isset($media_id['error'])) {

								$attach_data = wp_generate_attachment_metadata($media_id['id'], $value);
								wp_update_attachment_metadata($media_id['id'], $attach_data);
								if (set_post_thumbnail($post_id, $media_id['id'])) {
									$return['thumb'] = $media_id;
								} else {
									$return['thumb'] = "thumb not inserted";
								}
							} else {
								$return['thumberror'] = [
									'error' => $media_id,
									'url'   => $new_post['thumb']
								];
							}
						}

						if (isset($new_post['galeria']) && is_array($new_post['galeria']) && count($new_post['galeria']) > 0) {
							$gallery        = $args['post_content'];
							$gallery_ids    = [];
							$figures_string = "";
							foreach ($new_post['galeria'] as $ii => $vv) {
								$figure_id = insertMedia($vv);

								$value = wp_get_attachment_url($figure_id);

								if ( ! is_wp_error($figure_id) && ! isset($figure_id['error'])) {

									$attach_data = wp_generate_attachment_metadata($figure_id['id'], $value);
									wp_update_attachment_metadata($figure_id['id'], $attach_data);

									$gallery_ids[] = $figure_id['id'];

									$date      = date('Y/m');
									$url_media = URL_NEW_SITE . "wp-content/uploads/{$date}/" . basename($vv);
									$url_site  = URL_NEW_SITE;

									$figures_string .= "
										<li class=\"blocks-gallery-item\">
									        <figure><a
									                href=\"{$url_media}\"><img
									                src=\"{$url_media}\"
									                alt=\"\" data-id=\"{$figure_id['id']}\" data-link=\"{$url_site}?attachment_id={$figure_id['id']}\"
									                class=\"wp-image-{$figure_id['id']}\"/></a>
							                </figure>
    									</li>
									";
								} else {
									$return['gallery_errors'][] = $figure_id;
								}
							}

							$ids_string = implode(',', $gallery_ids);
							$gallery    .= "<!-- wp:gallery {\"ids\":[{$ids_string}],\"linkTo\":\"media\"} -->";
							$gallery    .= "<ul class=\"wp-block-gallery columns-3 is-cropped\">";
							$gallery    .= $figures_string;
							$gallery    .= "</ul>";
							$gallery    .= "<!-- /wp:gallery -->";

							$args['post_content'] = $gallery;
							$args['ID']           = $post_id;

							$return['updated'] = wp_insert_post($args);
						}
					}
				}

				exit(json_encode($return));
			}
		}

		exit("failed");
	}
});