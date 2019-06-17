<?php
/*
Plugin Name: NG-Migrate Send
*/

add_action('plugins_loaded', function () {
    if (isset($_REQUEST['ng-migrate-posts'])) {
        require_once(ABSPATH . 'wp-includes/query.php');
        require_once(__DIR__ . '/utils/configs.php');
        require_once(__DIR__ . '/utils/NucleoRequests.php');

        $wp_query = new WP_Query(
            [
                'posts_per_page' => -1,
            ]
        );

        echo "<pre>";


        $srcs = [];
        foreach ($wp_query->posts as $i => $v) {
            $regex = "/((src=\")(.*)(\"))/i";
            $content = $v->post_content;

            // Galerias
            preg_match_all($regex, $content, $matchs, PREG_SET_ORDER);
            foreach ($matchs as $ln) {
                $src = $ln[3] ?? null;

                if ($src != null && strpos($src, '/wp-content') !== false) {
                    $src = explode("\"", $src)[0];

                    $ponto = end(explode("-", $src));
                    $ext = end(explode(".", $ponto));

                    $src = current(explode("-" . $ponto, $src));

                    $src = $src . "." . $ext;

//                    echo $src . " - $ponto<br>";
                    $srcs[$v->ID][] = ABSPATH . 'wp-content' . explode('/wp-content', $src)[1];
//                    $srcs[$v->ID][] = $src;
                }
            }


            $new_post = [
                'post_content' => "<p>" . strip_tags($content) . "</p>",
                'post_date' => $v->post_date,
                'post_title' => $v->post_title,
            ];

            if (isset($srcs[$v->ID])) {
                $new_post['galeria'] = $srcs[$v->ID];
            }

            $thumb = get_the_post_thumbnail_url($v->ID);
            if ($thumb !== "") {
                $new_post['thumb'] = ABSPATH . 'wp-content/uploads' . explode('uploads', $thumb)[1];
            }


//            print_r(json_encode(['new_post' => $new_post]));
//            die;
            $result = NucleoRequests::send("http://192.168.254.221/NucleoWeb/wordpress/", 1, ['new_post' => json_encode($new_post), 'ng-migrate-posts' => true], false);

            echo $v->post_title . "<br>";
            print_r(json_decode($result, true));
            echo "<br>";

        }

        echo $wp_query->post_count;
        exit;
    }

});