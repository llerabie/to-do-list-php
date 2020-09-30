<?php

class Application {

    public function run(){
            $this->Loader();
            Routing::buildRoute();
    }

    public function Loader(){
        spl_autoload_register(['ClassLoader', 'autoload'], true, true);
    }

}
