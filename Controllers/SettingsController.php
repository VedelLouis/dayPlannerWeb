<?php

namespace Controllers;

class SettingsController
{

    public function __construct($action)
    {

        switch ($action) {
            case "index":
                $this->afficherSettingsView();
                break;
        }
    }
    private function afficherSettingsView()
    {
        include "Views/SettingsView.php";
    }

}