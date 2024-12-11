<?php
class TextPages
{

    private $pagecache = array();
    private $pagescache = array();
    private $sectionscache = array();
    private $pagesallcache = array();
    private $en = null;
    private $add = null;

    public function init( $en, $add ) {
            $this->en = $en;
            $this->add = $add;
    }
     
    /**
     * Generuje stronę tekstową
     */
    public function DisplayPage($id)
    {
	$dane = $this->GetPageData($id);
    $cf = $dane['cf']?:[];
	
	if(!empty($cf['faq']) ){
		foreach($dane['cf']['faq'] as $k=>$vcf) {
			if(!empty($vcf['naglowek'])) {
				$dane['cf']['faq'][$k]['naglowek'] = $dane['cf']['faq'][$k]['naglowek'][LANG];
			}
			if(!empty($vcf['pytanie'])) {
				$dane['cf']['faq'][$k]['pytanie'] = $dane['cf']['faq'][$k]['pytanie'][LANG];
			}
			if(!empty($vcf['odpowiedz'])) {
				$dane['cf']['faq'][$k]['odpowiedz'] = $this->FixPaths($dane['cf']['faq'][$k]['odpowiedz'][LANG]);
			}
		}
	}
	
	if(!empty($cf['faq1'])) {
		foreach($cf['faq1'] as $k=>$vcf) {
			if(!empty($vcf['naglowek'])) {
				$dane['cf']['faq1'][$k]['naglowek'] = $dane['cf']['faq1'][$k]['naglowek'][LANG];
			}
			if(!empty($vcf['pytanie'])) {
				$dane['cf']['faq1'][$k]['pytanie'] = $dane['cf']['faq1'][$k]['pytanie'][LANG];
			}
			if(!empty($vcf['odpowiedz'])) {
				$dane['cf']['faq1'][$k]['odpowiedz'] = $this->FixPaths($dane['cf']['faq1'][$k]['odpowiedz'][LANG]);
			}
		}
	}
	
	if(!empty($cf['faq2'])) {
		foreach($cf['faq2'] as $k=>$vcf) {
			if(!empty($vcf['naglowek'])) {
				$dane['cf']['faq2'][$k]['naglowek'] = $dane['cf']['faq2'][$k]['naglowek'][LANG];
			}
			if(!empty($vcf['pytanie'])) {
				$dane['cf']['faq2'][$k]['pytanie'] = $dane['cf']['faq2'][$k]['pytanie'][LANG];
			}
			if(!empty($vcf['odpowiedz'])) {
				$dane['cf']['faq2'][$k]['odpowiedz'] = $this->FixPaths($dane['cf']['faq2'][$k]['odpowiedz'][LANG]);
			}
		}
	}
        
        return $dane;
    }
    
    public function GetPageData($id) {
	$dane = array();
	if($id>0) {
		if(isset($this->pagecache[$id])) return $this->pagecache[$id];
		
		$dane=$this->en->select_r("SELECT * FROM ".TABLE_PREFIX."pages WHERE id=".$id);
		$dane['nazwa']=array();
		$dane['content']=array();
		$res=$this->en->select("SELECT * FROM ".TABLE_PREFIX."pages_lang WHERE item=".$id);
		if(count($res)>0) {
			foreach($res as $r) {
				$dane['nazwa'][$r['lang_id']] = $r['nazwa'];
				$dane['content'][$r['lang_id']] = $r['content'];
			}
		}
		$cf = $this->GetCustomFields($id);
		$dane['cf'] = $cf;
		
		$this->pagecache[$id] = $dane;
	}
	return $dane;
    }
    
    public function GetPageBySection($section) {
	//check section type
	if(isset($this->sectionscache[$section])) $sect = $this->sectionscache[$section];
	else {
		$sect =$this->en->select("SELECT * FROM ".TABLE_PREFIX."pages_sections WHERE `section` = '".$this->en->Escape($section)."'");
		$this->sectionscache[$section] = $sect;
	}
	$return = array();
	
	//get pages
	if(isset($this->pagescache[$sect[0]['id']])) $pages = $this->pagescache[$sect[0]['id']];
	else {
                $pages =$this->en->select("SELECT * FROM ".TABLE_PREFIX."pages WHERE `section` = ".intval($sect[0]['id']));
		$this->pagescache[$sect[0]['id']] = $pages;
	}
	
	switch($sect[0]['stype']) {
		case 'multi': 
			if($pages[0]['id'] > 0) {
				foreach($pages as $page) {
					$return[] = $this->GetPageData($page['id']);
				}
			}
			break;
		case 'single': 
			if($pages[0]['id'] > 0) $return = $this->GetPageData($pages[0]['id']);
			break;
	}
	return $return;
    }
    
    public function GetPage($section, $field = false)
    {
        $dane = $this->GetPageBySection($section);
        
        if($dane['id']>0) {
		//single
		if(count($dane['cf']['faq'])>0) {
			foreach($dane['cf']['faq'] as $k=>$vcf) {
				if(count($vcf['naglowek'])>0) {
					$dane['cf']['faq'][$k]['naglowek'] = $dane['cf']['faq'][$k]['naglowek'][LANG];
				}
				if(count($vcf['pytanie'])>0) {
					$dane['cf']['faq'][$k]['pytanie'] = $dane['cf']['faq'][$k]['pytanie'][LANG];
				}
				if(count($vcf['odpowiedz'])>0) {
					$dane['cf']['faq'][$k]['odpowiedz'] = $this->FixPaths($dane['cf']['faq'][$k]['odpowiedz'][LANG]);
				}
			}
		}
		
		if(count($dane['cf']['faq1'])>0) {
			foreach($dane['cf']['faq1'] as $k=>$vcf) {
				if(count($vcf['naglowek'])>0) {
					$dane['cf']['faq1'][$k]['naglowek'] = $dane['cf']['faq1'][$k]['naglowek'][LANG];
				}
				if(count($vcf['pytanie'])>0) {
					$dane['cf']['faq1'][$k]['pytanie'] = $dane['cf']['faq1'][$k]['pytanie'][LANG];
				}
				if(count($vcf['odpowiedz'])>0) {
					$dane['cf']['faq1'][$k]['odpowiedz'] = $this->FixPaths($dane['cf']['faq1'][$k]['odpowiedz'][LANG]);
				}
			}
		}
		
		if(count($dane['cf']['faq2'])>0) {
			foreach($dane['cf']['faq2'] as $k=>$vcf) {
				if(count($vcf['naglowek'])>0) {
					$dane['cf']['faq2'][$k]['naglowek'] = $dane['cf']['faq2'][$k]['naglowek'][LANG];
				}
				if(count($vcf['pytanie'])>0) {
					$dane['cf']['faq2'][$k]['pytanie'] = $dane['cf']['faq2'][$k]['pytanie'][LANG];
				}
				if(count($vcf['odpowiedz'])>0) {
					$dane['cf']['faq2'][$k]['odpowiedz'] = $this->FixPaths($dane['cf']['faq2'][$k]['odpowiedz'][LANG]);
				}
			}
		}
		
		
		$danereturn = array(
			"id"=>$dane['id'],
			"nazwa"=>$dane['nazwa'][intval(LANG)],
			"content"=>$this->FixPaths($dane['content'][intval(LANG)]),
			"cf"=>$dane['cf']
		);
        } else {
		$danereturn = array();
		for($i=0;$i<count($dane);$i++) {
			$danereturn[] = array(
				"id"=>$dane[$i]['id'],
				"nazwa"=>$dane[$i]['nazwa'][intval(LANG)],
				"content"=>$this->FixPaths($dane[$i]['content'][intval(LANG)]),
				"cf"=>$dane[$i]['cf'],
				"template"=>$dane[$i]['template']
			);
		}
        }
        
        if($field !== false) {
		return $danereturn[$field];
        }
        return $danereturn;
    }
    
    public function GetPageList($section) {
	$return = '';
	$pages = $this->GetPage($section);
	for($i=0;$i<count($pages);$i++) {
	    $link = SITE_URL.'pages/page/'.$pages[$i]['id'].'/'.$this->add->Title2Link($pages[$i]['nazwa']).'.html';
	    if($pages[$i]['template'] == "link") $link = $pages[$i]['cf']['url'];
	    if($pages[$i]['nazwa'] != 'Kontakt'){
            $return .= '<a href="'.$link.'">'.$pages[$i]['nazwa'].'</a>';
            if($i+1 < count($pages)){
                $return .= '|';
            }
        }
	}
	return $return;
    }
    
    public function GetCustomFields($page_id) {
	    $return = array();
	    $cf = $this->en->select("SELECT * FROM ".TABLE_PREFIX."pages_custom_fields WHERE page_id=".$page_id);
	    if(count($cf) > 0) {
		    foreach($cf as $item) {
			    $return[$item['variable']] = unserialize(base64_decode($item['value']));
		    }
	    }
	    return $return;
    }
    
    public function FixPaths($content) {
	    $f = array("data/");
	    $r = array("http://pliki.e-skipass.pl/data/");
	    
	    $content = $this->RenderTags($content);
	    return str_replace($f,$r,$content);
    }
    
    public function RenderTags($content) {
	    $f = array('%ESKIPASS_HOME%','%SITE_URL%');
	    $r = array('<a href="http://e-skipass.pl">e-skipass.pl</a>','<a href="'.SITE_URL.'">'.SITE_URL.'</a>');
	    $content = str_replace($f,$r,$content);
	    
	    if(count($this->pagesallcache) > 0) {
		    $pages = $this->pagesallcache;
	    } else {
		    $pages = $this->en->select("SELECT * FROM ".TABLE_PREFIX."pages");
		    $this->pagesallcache = $pages;
	    }
	    foreach($pages as $p) {
		    $page = $this->GetPageData($p['id']);
		    $f = array('%PAGE_'.$p['id'].'%');
		    $r = array('<a href="'.SITE_URL.'pages/page/'.$p['id'].'/'.$this->add->Title2Link($page['nazwa'][intval(LANG)]).'.html">'.$page['nazwa'][intval(LANG)].'</a>');
		    $content = str_replace($f,$r,$content);
	    }
	    
	    return $content;
    }

}