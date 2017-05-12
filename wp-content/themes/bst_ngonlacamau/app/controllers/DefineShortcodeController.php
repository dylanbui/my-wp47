<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/27/17
 * Time: 12:20 AM
 */
class DefineShortcodeController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function run() {
        add_shortcode("create_shortcode_thamso", array($this, "create_shortcode_thamso"));
        add_shortcode("googlemap_embed", array($this, "displayGooglemap"));
        add_shortcode("youtube_embed", array($this, "displayYoutube"));
        add_shortcode("answer_form", array($this, "displayAnswerForm"));
    }

    // Shortcode su dng tham so
    // $args => mang 2 chieu the hien tham so
    // $content => noi dung giua 2 tag shortcode
    function create_shortcode_thamso($args, $content) {
        return "Đây là số ". $args['thamso1'];
    }

    // https://www.wp-how-to.com/wordpress-tutorials/embed-google-maps-with-shortcode-in-wordpress/
    // $args = array( "width" => '940', "height" => '300', "src" => '');
    // [googlemap_embed src="link_embed"]
    public function displayGooglemap($args, $content)
    {
        if (!empty($content))
            $args['src'] = $content;

        $args['src'] = df($args['src'], '');
        $args['width'] = df($args['width'], '100%');
        $args['height'] = df($args['height'], '300px');

        return $this->view->fetch('wp/shortcode/displayGooglemap', array("args" => $args));
    }

    // $args = array( "width" => '940', "height" => '300', "src" => '');
    // [youtube_embed src="link_youtube"]
    public function displayYoutube_bak($args, $content)
    {
        if (!empty($content))
            $args['src'] = $content;

        $args['src'] = df($args['src'], '');
        $args['width'] = df($args['width'], '100%');
        $args['height'] = df($args['height'], '500px');

        return $this->view->fetch('wp/shortcode/displayYoutube', array("args" => $args));
    }

    public function displayAnswerForm()
    {
        return $this->view->fetch('wp/shortcode/answerForm');
    }


    /**
     * shortcode function
     *
     * @since 0.1
     * @use [youtube-white-label id=""]
     */
    function displayYoutube( $attr ) {
        global $content_width;

        extract( shortcode_atts( array(
            'url'				=> '',
            'id'				=> '',
            'height'			=> '',
            'width'				=> '',
            'align'				=> 'center',
            'branding'			=> '1',
            'autohide' 		=> '1',
            'autoplay' 		=> '',
            'controls' 		=> '1',
            'hd' 				=> '0',
            'rel' 				=> '0',
            'showinfo' 		=> '0',
            'autosize'			=> '1',
            'border'			=> '0',
            'cc'				=> '0',
            'colorone'			=> '',
            'colortwo'			=> '',
            'disablekb'		=> '',
            'fullscreen'		=> '1',
        ), $attr ) );

//        if ( !empty( $autosize ) && $autosize == '1' )
//            self::$white_label_script = true;

        $height	= str_replace( array( '%', 'em', 'px' ), '', $height );
        $width	= str_replace( array( '%', 'em', 'px' ), '', $width  );



        static $counter = 1;

        $iframe = '';

        if (empty($id)) {
            $url = strip_tags($url);
            $id = $this->strip_youtube_url($url);
        }

        if ( !empty( $id ) ) {

            $iframe .= '<iframe id="youtube-' . absint( $counter ) . '" type="text/html" ';

            if ( !empty( $autosize ) && $autosize == '1' )
                $iframe .= 'class="autosize" ';

            $src = is_ssl() ? 'http' : 'https';

            $iframe .= 'src="' . $src . '://www.youtube.com/embed/' . esc_attr( $id ) . '?';

            /* Branding option must be first in line */
            if ( $branding != '' )
                $iframe .= '&amp;modestbranding=' . $branding;

            if ( $autohide != '' )
                $iframe .= '&amp;autohide=' . $autohide;

            if ( $autoplay != '' && $autoplay == '1' )
                $iframe .= '&amp;autoplay=' . $autoplay;

            if ( $controls != '' )
                $iframe .= '&amp;controls=' . $controls;

            if ( $hd != '' )
                $iframe .= '&amp;hd=' . $hd;

            if ( $rel != '' )
                $iframe .= '&amp;rel=' . $rel;

            if ( $showinfo == '1' )
                $iframe .= '&amp;showinfo=' . $showinfo;

            if ( $border != '' )
                $iframe .= '&amp;border=' . $border;

            if ( $cc != '' )
                $iframe .= '&amp;cc_load_policy=' . $cc;

            if ( $colorone != '' )
                $iframe .= '&amp;color1=' . $colorone;

            if ( $colortwo != '' )
                $iframe .= '&amp;color2=' . $colortwo;

            if ( $fullscreen != '' )
                $iframe .= '&amp;fullscreen=' . $fullscreen;

            if ( !empty( $disablekb ) && $disablekb != '0' )
                $iframe .= '&amp;disablekb=' . $disablekb;

            if ( $showinfo == '1' && $branding == '0' )
                $iframe .= '&amp;title=';

            $iframe .= '" ';

            $height = ( isset( $height ) && ( !empty( $height ) || $height != '' ) ) ? $height : ( $content_width / 1.77 );
            $width = ( isset( $width ) && ( !empty( $width ) || $width != '' ) ) ? $width : $content_width;

            $iframe .= 'style="border:0; height:' . esc_attr( absint( $height ) ) . 'px; width:' . esc_attr( absint( $width ) ) . 'px">';
            $iframe .= '</iframe>';

            $iframe = '<p style="text-align: '.$align.';">'.$iframe.'</p>';

            $counter++;
        }
        return wpautop( $iframe );
    }

    /**
     *
     * MAYBE:
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches );
     *
     */
    function strip_youtube_url( $url ) {
        $id_match = '[0-9a-zA-Z\-_]+';
        if ( preg_match( '|https?://(www\.)?youtube\.com/(watch)?\?.*v=(' . $id_match . ')|', $url, $matches ) )
            $id = $matches[3];
        else if ( preg_match( '|https?://(www\.)?youtube(-nocookie)?\.com/embed/(' . $id_match . ')|', $url, $matches ) )
            $id = $matches[3];
        else if ( preg_match( '|https?://(www\.)?youtube\.com/v/(' . $id_match . ')|', $url, $matches ) )
            $id = $matches[2];
        else if ( preg_match( '|http://youtu\.be/(' . $id_match . ')|', $url, $matches ) )
            $id = $matches[1];
        else if ( !preg_match( '|^http|', $url, $matches ) )
            $id = $url;

        return $id;
    }




}