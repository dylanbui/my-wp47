<?php

class HomesController extends MvcPublicController {

    public function index() {

    }

    public function show() {

    }

    public function giatri() {


        echo "<pre>";
        print_r($this->params);

        echo "</pre>";
        exit();

    }


}

?>