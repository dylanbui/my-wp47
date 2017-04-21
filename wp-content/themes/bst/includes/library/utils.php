<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/

require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');

if( ! ( function_exists( 'db_get_custom_field' ) ) ) {
    function db_get_custom_field($field_name, $post_id = null, $single = true)
    {
        // $postMeta = get_post_meta(get_the_ID()); // Show all post meta
        if (is_null($post_id)) $post_id = get_the_ID();
        return get_post_meta($post_id, 'wpcf-' . $field_name, $single);
    }
}

if( ! ( function_exists( 'db_get_custom_image_field' ) ) ) {
    function db_get_custom_image_field($field_name, $size = 'thumbnail', $post_id = null, $single = true)
    {
        $arrImages = db_get_custom_field($field_name, $post_id, false);
        if (empty($arrImages))
            return FALSE;
        $result = array();
        foreach ($arrImages as $imageUrl) {
            $postImg = db_get_attachment_by_url($imageUrl);
            //‘thumbnail’, ‘medium’, ‘large’, size : array(100, 100)
            $result[] = wp_get_attachment_image_url($postImg->ID, $size); // tra ve du lieu
        }
        if ($single)
            return $result[0];
        return $result;
    }
}

if( ! ( function_exists( 'db_get_custom_datetime_field' ) ) ) {
    function db_get_custom_datetime_field($field_name, $format = 'd/m/Y H:i:s', $post_id = null)
    {
        $unixtimestamp = db_get_custom_field($field_name, $post_id);
        if (empty($unixtimestamp))
            return null;
        $myDateTime = date_timestamp_set(date_create(), $unixtimestamp);
        return date_format($myDateTime, $format);
    }
}

if( ! ( function_exists( 'db_get_attachment_by_post_name' ) ) ) {
    function db_get_attachment_by_post_name($post_name) {
        $args = array(
            'post_per_page' => 1,
            'post_type'     => 'attachment',
            'name'          => trim($post_name),
        );
        $get_posts = new Wp_Query( $args );

        if ( $get_posts->posts[0] )
            return $get_posts->posts[0];
        else
            return false;
    }
}

if( ! ( function_exists( 'db_get_attachment_by_url' ) ) ) {
    function db_get_attachment_by_url($url) {
        $path_parts = pathinfo($url);
        return db_get_attachment_by_post_name($path_parts['filename']);
    }
}

if( ! ( function_exists( 'db_redirect' ) ) ) {
    function db_redirect($location, $status = 302) {
        // Note: wp_redirect() does not exit automatically, and should almost always be followed by a call to exit
        wp_redirect($location, $status);
        exit();
    }
}

if( ! ( function_exists( 'db_upload_user_file' ) ) ) {
    function db_upload_user_file($file = array())
    {
        require_once(ABSPATH . 'wp-admin/includes/admin.php');
        $file_return = wp_handle_upload($file, array('test_form' => false));
        if (isset($file_return['error']) || isset($file_return['upload_error_handler'])) {
            return false;
        } else {
            $filename = $file_return['file'];
            $attachment = array(
                'post_mime_type' => $file_return['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $file_return['url']
            );
            $attachment_id = wp_insert_attachment($attachment, $file_return['file']);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
            wp_update_attachment_metadata($attachment_id, $attachment_data);

            if (0 < intval($attachment_id)) {
                // $metaData = wp_get_attachment_metadata($attachment_id); // Not use
                $uploadDir = wp_upload_dir();
                $metaData['full_file_url'] = $uploadDir['baseurl'] . '/' . $attachment_data['file'];
                return $metaData;
            }
        }
        return false;
    }
}

if( !function_exists( 'uiwp_get_template' ) ) {
    /**
     * Retrieve a template file.
     *
     * @param string $path
     * @param mixed $var
     * @param bool $return
     * @return void
     * @since 1.0.0
     */
    function uiwp_get_template( $path, $var = null, $return = false )
    {
        $located = get_theme_root().'/'.get_template().'/'.$path;
        if ( $var && is_array( $var ) )
            extract( $var );

        if( $return )
        { ob_start(); }

        // include file located
        include( $located );

        if( $return )
        { return ob_get_clean(); }
    }
}

if( !function_exists( 'mwp_load_templates_html' ) )
{
    /**
     * Retrieve a template file.
     *
     * @param string $path
     * @param mixed $var
     * @param bool $return
     * @return void
     * @since 1.0.0
     */
    function mwp_load_templates_html( $path, $var = null, $return = false )
    {
        $located = __TEMPLATES_HTML_PATH.'/'.$path;
        if ( $var && is_array( $var ) )
            extract( $var );

        if( $return )
        { ob_start(); }

        // include file located
        include( $located );

        if( $return )
        { return ob_get_clean(); }
    }
}