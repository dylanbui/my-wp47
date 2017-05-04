<?php

/**
 * Created by PhpStorm.
 * User: dylanbui
 * Date: 4/27/17
 * Time: 12:20 AM
 */
class PageController extends Controller
{

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        // -- Start get wordpress page --
        the_post();
        $strPage = lowerCamelcase($this->queried_object->post_name).'Action';
        return $this->{$strPage}(); //lowerCamelcase($this->queried_object->post_name);
    }

    public function gioiThieuAction() {
        return $this->renderView('wp/page/gioi-thieu');
    }

    public function lienHeAction() {
        return $this->renderView('wp/page/lien-he');
    }

    public function hoiDapAction() {

        if ($this->isPostForm()) {

            echo "da post du lieu<pre>";
            print_r($_POST);
            echo "</pre>";

            db_redirect('lien-he');

            exit();
        }

        return $this->renderView('wp/page/hoi-dap');
    }


}