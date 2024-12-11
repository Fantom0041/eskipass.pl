<?php

class Home extends Main
{
    public function __construct()
    {
        parent::__construct();
        if ($this->en->IsLoggedIn() == true) {
            //aktywna zakładka
            $this->tpl->assign("activetab", MODULE);
        }

        $this->tpl->assign("mod", $this);
        $this->tpl->assign("urlparam", $this->urlparam);

        switch ($this->urlparam['a']) {
            default:
                $this->DisplayHome();
        }
    }

    private function DisplayHome()
    {
        if(array_key_exists('return_message',$_SESSION)){
            $this->tpl->assign("return_message", '<div class="alert-'.$_SESSION['return_message'][1].' text-center">'.$_SESSION['return_message'][0].'</div>');
            unset($_SESSION['return_message']);
        }
        $this->headerparams['meta']['title'] = SITE_NAME;

        //slider główny
        $slider = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_slider` WHERE `ishidden`=0 AND `datastart`<=" . time() . " AND `datastop`>=" . time() . " ORDER BY `orderby` ASC");
        $this->tpl->assign('slider', $slider);

        //boksy
        $boksy = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `ishidden`=0 AND `datastart`<=" . time() . " AND `datastop`>=" . time() . " AND `type`='osrodek'  ORDER BY `orderby` ASC, RAND() ASC");
        $this->tpl->assign('boksy', $boksy);

        //oldboksy
        $oldboksy = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `ishidden`=0 AND (`datastart`>" . time() . " OR `datastop`<" . time() . ") AND `type`='osrodek'  ORDER BY `orderby` ASC, RAND() ASC");
        $this->tpl->assign('oldboksy', $oldboksy);

        //boksy obok slidera
        $slider_boksy = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `type`='slider'  ORDER BY `orderby` ASC");
        $this->tpl->assign('slider_boksy', $slider_boksy);

        //paralaksa
        $paralaksa = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `type`='paralaksa'  ORDER BY `orderby` ASC");
        $this->tpl->assign('paralaksa', $paralaksa);

        //loga
        $loga = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `ishidden`=0 AND `type`='logo' ORDER BY `orderby` ASC, RAND() ASC");
        $this->tpl->assign('loga', $loga);

        //theme_style
        $theme_style_array = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "settings` WHERE `variable`='theme_style'");
        $theme_style = $theme_style_array[0]['value'];
        $this->topnavparams['theme_style'] = $theme_style;
        $this->tpl->assign("theme_style", $theme_style);
        $states = array();
        foreach (array_merge($boksy,$oldboksy) as $boks){
            if(!in_array($boks['state'],$states)){
                array_push($states,$boks['state']);
            }
        }
        $this->tpl->assign("states", $states);

        //utm_source=Google%20Adwords&utm_medium=Remarketing&utm_campaign=Kampania%20Grudniowa%202015
        if ($_GET['utm_source'] != '' && $_GET['utm_medium'] == 'Remarketing') {
            $this->tpl->assign('glownapopup', true);
        }

        //random FAQ
        require_once ENSETTINGSDIR . 'libs/class.TextPages.php';
        $textpages = new TextPages();
        $textpages->init($this->en, $this->add);
        $this->tpl->assign('glownaopis', $textpages->GetPage('glowna-opis', 'content'));
        /*
        $faqs = $textpages->GetPage('sidebar-pomoc');
        $pytania = $faqs['cf']['faq'];
        if(count($pytania)>0 && is_array($pytania)) {
            $pytaniek = array_rand ($pytania, 1);
            $this->tpl->assign('faq', $pytania[$pytaniek]);
        }
        */


        $this->tpl->assign("header", $this->LoadWidget('header', $this->headerparams));
        $this->tpl->assign("topnav", $this->LoadWidget('topnav', $this->topnavparams));
        $this->tpl->assign("footer", $this->LoadWidget('footer', $this->footerparams));
        $this->tpl->assign("scripts", $this->LoadWidget('scripts', array()));
        $this->tpl->assign("contact", $this->LoadWidget('contact', array()));

        $this->output = $this->tpl->fetch("front-home.tpl.php");
    }
}

?>
