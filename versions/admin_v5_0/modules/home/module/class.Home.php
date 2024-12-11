<?php

class Home extends Main
{

    public function __construct()
    {
        parent::__construct();

        if ($this->en->IsLoggedIn() == true) {
            //aktywna zakładka
            $this->tpl->assign("activetab", "");
        }
        if (key_exists('theme', $_GET)) {
            $this->ChangeTheme($_GET['theme']);
        } else {
            $this->DisplayHome();
        }
    }

    private function DisplayHome()
    {
        if ($this->en->IsLoggedIn() == true) {

            $stanyreturn = array();
            $datastart = time() - (15 * 84600);
            for ($i = 0; $i < 30; $i++) {
                $dataspr = $datastart + ($i * 84600);

                $slider = $this->en->select_r("SELECT count(id) as ile FROM `" . TABLE_PREFIX . "glowna_slider` WHERE `ishidden`=0 AND `datastart`<=" . $dataspr . " AND `datastop`>=" . $dataspr . " ORDER BY `orderby` ASC, RAND() ASC");
                $boksy = $this->en->select_r("SELECT count(id) as ile FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `ishidden`=0 AND `datastart`<=" . $dataspr . " AND `datastop`>=" . $dataspr . " ORDER BY `orderby` ASC, RAND() ASC");

                $stanyreturn[] = array(
                    "data" => date("d.m", $dataspr),
                    "slider" => $slider['ile'],
                    "boksy" => $boksy['ile']
                );
            }
            $this->tpl->assign("stany", $stanyreturn);

            $slider = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_slider` WHERE `ishidden`=0 AND `datastart`<=" . time() . " AND `datastop`>=" . time() . " ORDER BY `orderby` ASC, RAND() ASC");
            $boksy = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `ishidden`=0 AND `datastart`<=" . time() . " AND `datastop`>=" . time() . " ORDER BY `orderby` ASC, RAND() ASC");

            $theme_style_array = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "settings` WHERE `variable`='theme_style'");
            $theme_style = $theme_style_array[0]['value'];

            $this->tpl->assign("theme_style", $theme_style);

            $stan = count($slider) + count($boksy);
            $this->tpl->assign("stan", $stan);

            $meta = array();
            $meta['title'] = "Pulpit";
            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/css/dashboard/v1.css">' .
                '<link rel="stylesheet" href="' . THEMEDIR . 'assets/css/added.css">';
            $this->tpl->assign("meta", $meta);
            $this->tpl->display('modules/' . MODULE . '/views/' . MODULE . '.tpl.php');
        } else {
            $meta = array();
            $meta['title'] = "Logowanie";
            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/css/pages/login.css">';
            $meta['meta'] = '<meta name="robots" content="noindex" />';
            $this->tpl->assign("meta", $meta);
            $this->tpl->display('views/templ_login.tpl.php');
        }
    }

    private function LogIcon($co)
    {
        switch ($co) {
            case 'editusers':
                return 'user';
            case 'users':
                return 'user';
            case 'editobiekty':
                return 'tag';
            case 'obiekty':
                return 'tag';
            default:
                return 'play-circle';
        }
    }

    private function ChangeTheme($theme)
    {
        $this->en->query(sprintf("UPDATE `" . TABLE_PREFIX . "settings` "
            . "SET `value`='%s' "
            . "WHERE variable='theme_style' "
            . "LIMIT 1",
            $this->en->Escape($theme)
        ));
        return $theme;
    }

}

?>