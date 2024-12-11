<?php

class Boksy extends Main
{

    public function __construct()
    {
        parent::__construct();

        if ($this->en->IsLoggedIn() == true) {
            //aktywna zakładka
            $this->tpl->assign("activetab", "boksyinsurance");
            $this->tpl->assign("module", MODULE);
        }


        switch ($_GET['method']) {
            case 'edit':
                if ($_GET['id'] > 0) {
                    $this->Edit(intval($_GET['id']));
                } else {
                    $this->DisplayList();
                }
                break;
            case 'list':
            default:
                $this->DisplayList();
        }
    }

    private function DisplayList()
    {
        if ($this->en->IsLoggedIn() == true) {

            $dane = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE `page`= 'insurance' ORDER BY `id` ASC");
            for ($i = 0; $i < count($dane); $i++) {
                $dane[$i]['datastart_iso'] = date("Y-m-d", $dane[$i]['datastart']);
                $dane[$i]['datastop_iso'] = date("Y-m-d", $dane[$i]['datastop']);
            }
            $this->tpl->assign("dane", $dane);

            $meta = array();
            $meta['title'] = "Boksy";

            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/vendor/datatables-bootstrap/dataTables.bootstrap.css">';
            $meta['css'] .= '<link rel="stylesheet" href="' . THEMEDIR . 'assets/vendor/datatables-fixedheader/dataTables.fixedHeader.css">';
            $meta['css'] .= '<link rel="stylesheet" href="' . THEMEDIR . 'assets/vendor/datatables-responsive/dataTables.responsive.css">';

            $this->tpl->assign("meta", $meta);
            $this->tpl->display('modules/' . MODULE . '/views/list.tpl.php');
        } else {
            $meta = array();
            $meta['title'] = "Logowanie";
            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/css/pages/login.css">';
            $this->tpl->assign("meta", $meta);
            $this->tpl->display('views/templ_login.tpl.php');
        }
    }

    private function Edit($id)
    {
        if ($this->en->IsLoggedIn() == true) {
            if ($id > 0) {
                $vars = $_POST;
                $files = $_FILES;
                $glyphs = simplexml_load_string(file_get_contents(SITE_URL.'themes/eskipass/css/fonts/font-icons.svg'))->defs->font->glyph;
                $this->tpl->assign("glyphs", $glyphs);
                if ($vars['save'] == 1) {

                    $valid = $this->Valid($vars, $files);
                    if ($valid['status'] == TRUE) {
                        //ok
                        $this->en->query(sprintf("UPDATE `" . TABLE_PREFIX . "podstrony_boksy` "
                            . "SET `nazwa`='%s', `url`='%s', `img`='%s', "
                            . "`text1`='%s', `text2`='%s', `text3`='%s', `text4`='%s', "
                            . "`orderby`=%d, `ishidden`=%d "
                            . "WHERE `id`=%d "
                            . "LIMIT 1",
                            $this->en->Escape($vars['nazwa']),
                            $this->en->Escape($vars['url']),
                            $this->en->Escape($vars['img']),
                            $this->en->Escape($vars['text1']),
                            $this->en->Escape($vars['text2']),
                            $this->en->Escape($vars['text3']),
                            $this->en->Escape($vars['text4']),
                            intval($vars['orderby']),
                            $this->add->CheckboxToInt($vars['ishidden']),
                            $id
                        ));

                        //plik graficzny
                        if ($files['newimg']['tmp_name'] != '') {
                            $nazwa = $this->SaveImg($files['newimg'], $id);
                            $this->en->query("UPDATE `" . TABLE_PREFIX . "podstrony_boksy` SET `img`='" . $this->en->Escape($nazwa) . "' WHERE id=" . $id);
                            $this->RemoveImg($vars['img']);
                        }

                        //current version
                        $postback = $this->en->select_r("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE id=" . $id);
                        $this->tpl->assign("postback", $postback);


                    } else {
                        //error
                        $this->tpl->assign("err", $valid['err']);
                        $postback = $vars;
                        $this->tpl->assign("postback", $postback);
                    }
                } else {
                    //current version
                    $postback = $this->en->select_r("SELECT * FROM `" . TABLE_PREFIX . "podstrony_boksy` WHERE id=" . $id);
                    if(!$postback){
                        $this->DisplayList();
                    }
                    $this->tpl->assign("postback", $postback);
                }
            }
            $meta = array();
            $meta['title'] = "Boksy - edycja";

            $this->tpl->assign("meta", $meta);
            $this->tpl->display('modules/' . MODULE . '/views/edit.tpl.php');
        } else {
            $meta = array();
            $meta['title'] = "Logowanie";
            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/css/pages/login.css">';
            $this->tpl->assign("meta", $meta);
            $this->tpl->display('views/templ_login.tpl.php');
        }


    }

    private function Valid($vars, $files)
    {
        $return = array();
        $return['status'] = TRUE;
        return $return;
    }

    private function SaveImg($plik, $id)
    {
        if (!file_exists('data/boksyinsurance')) {
            mkdir('data/boksyinsurance');
        }
        if (!file_exists('data/boksyinsurance/' . $id)) mkdir('data/boksyinsurance/' . $id);
        $ext = $this->add->FileExt($plik['name']);
        $nazwa = md5($plik['name'] . time()) . "." . $ext;
        move_uploaded_file($plik['tmp_name'], 'data/boksyinsurance/' . $id . '/' . $nazwa);
        return 'data/boksyinsurance/' . $id . '/' . $nazwa;
    }

    private function RemoveImg($plik)
    {
        if (file_exists($plik)) {
            unlink($plik);
        }
    }
}

?>