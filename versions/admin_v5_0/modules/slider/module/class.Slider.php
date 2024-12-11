<?php

class Slider extends Main
{

    public function __construct()
    {
        parent::__construct();

        if ($this->en->IsLoggedIn() == true) {
            //aktywna zakładka
            $this->tpl->assign("activetab", "magazyn");
            $this->tpl->assign("module", MODULE);
        }
        if (key_exists('id', $_POST)) {
            if ($_POST['id'] > 0 && $_GET['method'] == 'list') {
                $this->Remove(intval($_GET['id']));
            } else {
                $this->DisplayList();
            }

        } else {
            switch ($_GET['method']) {
                case 'edit':
                    if ($_GET['id'] > 0) {
                        $this->Edit(intval($_GET['id']));
                    } else {
                        $this->Add();
                    }
                    break;
                case 'list':
                default:
                    $this->DisplayList();
            }
        }

    }

    private function DisplayList()
    {
        if ($this->en->IsLoggedIn() == true) {

            $dane = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_slider` ORDER BY `id` ASC");
            for ($i = 0; $i < count($dane); $i++) {
                $dane[$i]['datastart_iso'] = date("Y-m-d", $dane[$i]['datastart']);
                $dane[$i]['datastop_iso'] = date("Y-m-d", $dane[$i]['datastop']);
            }
            $this->tpl->assign("dane", $dane);

            $meta = array();
            $meta['title'] = "Slider główny";

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

    private function Add()
    {
        if ($this->en->IsLoggedIn() == true) {

            $vars = $_POST;
            $files = $_FILES;
            if ($vars['save'] == 1) {
                $valid = $this->Valid($vars, $files);
                if ($valid['status'] == TRUE) {

                    //ok
                    $this->en->query(sprintf("INSERT INTO `" . TABLE_PREFIX . "glowna_slider` "
                        . "(`nazwa`, `datastart`, `datastop`, `url`, `img`, `text1`, `text2`, `text3`, `text4`, "
                        . "`orderby`, `ishidden`) "
                        . "VALUES('%s',%d,%d,'%s','%s','%s','%s','%s','%s',%d,%d)",
                        $this->en->Escape($vars['nazwa']),
                        $this->add->DateToTimestamp($vars['start'] . ' 00:00:00'),
                        $this->add->DateToTimestamp($vars['end'] . ' 23:59:59'),
                        $this->en->Escape($vars['url']),
                        $this->en->Escape($vars['img']),
                        $this->en->Escape($vars['text1']),
                        $this->en->Escape($vars['text2']),
                        $this->en->Escape($vars['text3']),
                        $this->en->Escape($vars['text4']),
                        intval($vars['orderby']),
                        $this->add->CheckboxToInt($vars['ishidden'])
                    ));
                    $insertId = $this->en->insertId();

                    if ($insertId > 0) {
                        //plik graficzny
                        if ($files['newimg']['tmp_name'] != '') {
                            $nazwa = $this->SaveImg($files['newimg'], $insertId);
                            $this->en->query("UPDATE `" . TABLE_PREFIX . "glowna_slider` SET `img`='" . $this->en->Escape($nazwa) . "' WHERE id=" . $insertId);
                        }

                        header("Location: " . SITE_URL . "slider/edit?id=" . $insertId . "&create=1");
                    } else {
                        $this->tpl->assign("err", array(0 => "Nieudana próba dodania rekordu"));
                        $postback = $vars;
                        $this->tpl->assign("postback", $postback);
                    }
                } else {
                    //error
                    $this->tpl->assign("err", $valid['err']);
                    $postback = $vars;
                    $this->tpl->assign("postback", $postback);
                }
            }

            $meta = array();
            $meta['title'] = "Slider główny - dodawanie";

            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/vendor/bootstrap-datepicker/bootstrap-datepicker.css">';

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

    private function Edit($id)
    {
        if ($this->en->IsLoggedIn() == true) {
            if ($id > 0) {
                $vars = $_POST;
                $files = $_FILES;
                if ($vars['save'] == 1) {
                    $valid = $this->Valid($vars, $files);
                    if ($valid['status'] == TRUE) {
                        //ok
                        $this->en->query(sprintf("UPDATE `" . TABLE_PREFIX . "glowna_slider` "
                            . "SET `nazwa`='%s', `datastart`=%d, `datastop`=%d, `url`='%s', `img`='%s', "
                            . "`text1`='%s', `text2`='%s', `text3`='%s', `text4`='%s', "
                            . "`orderby`=%d, `ishidden`=%d "
                            . "WHERE id=%d "
                            . "LIMIT 1",
                            $this->en->Escape($vars['nazwa']),
                            $this->add->DateToTimestamp($vars['start'] . ' 00:00:00'),
                            $this->add->DateToTimestamp($vars['end'] . ' 23:59:59'),
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
                            $this->en->query("UPDATE `" . TABLE_PREFIX . "glowna_slider` SET `img`='" . $this->en->Escape($nazwa) . "' WHERE id=" . $id);
                        }

                        //current version
                        $postback = $this->en->select_r("SELECT * FROM `" . TABLE_PREFIX . "glowna_slider` WHERE id=" . $id);
                        $postback['start'] = date("Y-m-d", $postback['datastart']);
                        $postback['end'] = date("Y-m-d", $postback['datastop']);
                        $this->tpl->assign("postback", $postback);


                    } else {
                        //error
                        $this->tpl->assign("err", $valid['err']);
                        $postback = $vars;
                        $this->tpl->assign("postback", $postback);
                    }
                } else {
                    //current version
                    $postback = $this->en->select_r("SELECT * FROM `" . TABLE_PREFIX . "glowna_slider` WHERE id=" . $id);
                    $postback['start'] = date("Y-m-d", $postback['datastart']);
                    $postback['end'] = date("Y-m-d", $postback['datastop']);
                    $this->tpl->assign("postback", $postback);
                }
            }
            $meta = array();
            $meta['title'] = "Slider główny - dodawanie";

            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/vendor/bootstrap-datepicker/bootstrap-datepicker.css">';

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
        if (!file_exists('data/slider/' . $id)) mkdir('data/slider/' . $id);
        $ext = $this->add->FileExt($plik['name']);
        $nazwa = md5($plik['name'] . time()) . "." . $ext;
        move_uploaded_file($plik['tmp_name'], 'data/slider/' . $id . '/' . $nazwa);
        return 'data/slider/' . $id . '/' . $nazwa;
    }

    private function Remove($id)
    {
        if ($this->en->IsLoggedIn() == true) {
            if ($id > 0) {
                $dane = $this->en->select("SELECT * FROM `" . TABLE_PREFIX . "glowna_slider` WHERE `id`='" . $id . "'");
                if (count($dane)) {
                    $sql = "DELETE FROM `" . TABLE_PREFIX . "glowna_slider` WHERE `id`=" . $id;
                    mysql_query($sql);
                }
            }
            $this->DisplayList();
        } else {
            $meta = array();
            $meta['title'] = "Logowanie";
            $meta['css'] = '<link rel="stylesheet" href="' . THEMEDIR . 'assets/css/pages/login.css">';
            $this->tpl->assign("meta", $meta);
            $this->tpl->display('views/templ_login.tpl.php');
        }
    }

}

?>