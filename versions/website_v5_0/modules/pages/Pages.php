<?php

class Pages extends Main
{

    private $pagecache = array();
    private $pagescache = array();
    private $sectionscache = array();
    private $pagesallcache = array();
    private $textpages = null;

    public function __construct()
    {
        parent::__construct();
        if ($this->en->IsLoggedIn() == true) {
            //aktywna zakładka
            $this->tpl->assign("activetab", MODULE);
        }

        $this->tpl->assign("mod", $this);
        $this->tpl->assign("urlparam", $this->urlparam);

        require_once ENSETTINGSDIR . 'libs/class.TextPages.php';
        $this->textpages = new TextPages();
        $this->textpages->init($this->en, $this->add);

        $params = explode("/", $_GET['params']);
        switch ($params[0]) {
            case 'page':
                $this->DisplayPage();
        }
    }

    /**
     * Generuje stronę tekstową
     */
    private function DisplayPage()
    {
        if(array_key_exists('return_message',$_SESSION)){
            $this->tpl->assign("return_message", '<div class="alert-'.$_SESSION['return_message'][1].' text-center">'.$_SESSION['return_message'][0].'</div>');
            unset($_SESSION['return_message']);
        }
        $params = explode("/", $_GET['params']);
        $id = intval($params[1]);
        $dane = $this->textpages->DisplayPage($id);
        if (intval($dane['id']) > 0) {
            $danereturn = array(
                "id" => $dane['id'],
                "nazwa" => $dane['nazwa'][intval(LANG)],
                "content" => $this->textpages->FixPaths($dane['content'][intval(LANG)]),
                "cf" => $dane['cf']
            );
            $form = false;
            $insurance = false;
            $this->tpl->assign("dane", $danereturn);
            if ($dane['blocks'] == 'partners') {
                $form = true;
            }
            if ($dane['blocks'] == 'insurance') {
                $insurance = true;
            }
            $boxy['top'] = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE `page`= '" . $dane['blocks'] . "' AND `type`='top'");
            $boxy['middle'] = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE `page`= '" . $dane['blocks'] . "' AND `type`='middle'");
            $boxy['bottom'] = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE `page`= '" . $dane['blocks'] . "' AND `type`='bottom'");
            $boxy['bottom_left'] = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE `page`= '" . $dane['blocks'] . "' AND `type`='bottom_left' ORDER BY `orderby` ASC");
            $boxy['bottom_right'] = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE `page`= '" . $dane['blocks'] . "' AND `type`='bottom_right' ORDER BY `orderby` ASC");
            $boxy['bottom_group'] = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE `page`= '" . $dane['blocks'] . "' AND `type`='bottom_group' ORDER BY `orderby` ASC");
            $this->tpl->assign("form", $form);
            $this->tpl->assign("insurance", $insurance);
            $this->tpl->assign("boxy", $boxy);
            $this->topparams['meta']['title'] = $dane['nazwa'][intval(LANG)];
            $theme_style_array = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "settings` WHERE `variable`='theme_style'");
            $theme_style = $theme_style_array[0]['value'];
            $this->tpl->assign("theme_style", $theme_style);

            $loga = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_boksy` WHERE `ishidden`=0 AND `type`='logo' ORDER BY `orderby` ASC, RAND() ASC");
            $this->tpl->assign('loga', $loga);

            $this->tpl->assign("header", $this->LoadWidget('header', $this->headerparams));
            $this->tpl->assign("topnav", $this->LoadWidget('topnav', $this->topnavparams));
            $this->tpl->assign("footer", $this->LoadWidget('footer', $this->footerparams));
            $this->tpl->assign("scripts", $this->LoadWidget('scripts', array()));
            $this->tpl->assign("contact", $this->LoadWidget('contact', array()));

//                $this->tpl->assign("breadcrumbs", $this->LoadWidget('breadcrumbs', $this->breadcrumbsparams));

            $this->output = $this->tpl->fetch("front-pages-" . $dane['template'] . ".tpl.php");
        } else {
            $this->output = $this->tpl->fetch("404.tpl.php");
        }
    }


    public function GetPage($section, $field = false)
    {
        $dane = $this->textpages->GetPage($section, $field);
        return $dane;
    }

    public function GetPageList($section)
    {
        $dane = $this->textpages->GetPageList($section);
        return $dane;
    }
}