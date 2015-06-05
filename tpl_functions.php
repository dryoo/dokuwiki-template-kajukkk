<?php

  function tpl_ID($text=null) {
    global $conf;
    global $ID;
    if ($text==null) $text=$ID;
    if ($conf['useslash'])
        return str_replace(":","/",$text);
    else 
        return $text;
  }
  
  function tpl_bs_actionlink($type, $pre = '', $suf = '', $class='', $inner = '', $return = false) {
       global $lang;
       $data = tpl_get_action($type);
       if($data === false) {
           return false;
       } elseif(!is_array($data)) {
           $out = sprintf($data, 'link');
       } else {
           /**
            * @var string $accesskey
            * @var string $id
            * @var string $method
            * @var bool   $nofollow
            * @var array  $params
            * @var string $replacement
            */
           extract($data);
           if(strpos($id, '#') === 0) {
               $linktarget = $id;
           } else {
               $linktarget = wl($id, $params);
           }
           $caption = $lang['btn_'.$type];
           if(strpos($caption, '%s')){
               $caption = sprintf($caption, $replacement);
           }
           $akey    = $addTitle = '';
           if($accesskey) {
               $akey     = 'accesskey="'.$accesskey.'" ';
               $addTitle = ' ['.strtoupper($accesskey).']';
           }
           $rel = $nofollow ? 'rel="nofollow" ' : '';
           $out = tpl_link(
               $linktarget, $pre.(($inner) ? $inner : $caption).$suf,
               'class="btn action '.$type.' '.$class.'" '.
                   $akey.$rel.
                   'title="'.hsc($caption).$addTitle.'"', 1
           );
           $out='<a href="'.$linktarget.'" ';
           $out.='class="action '.$type.' '.$class.'" '.
                   $akey.$rel.
                   'title="'.hsc($caption).$addTitle.'"';
           $out.='>';
           if ($pre) $out.='<span class="glyphicon glyphicon-'.$pre.'"></span>&nbsp;';
           $out.=(($inner) ? $inner : "&nbsp;".$caption);
           $out.='</a>';
           if ($suf) $out='<'.$suf.'>'.$out.'</'.$suf.'>';
           
       }
       if($return) return $out;
       echo $out;
       return true;
   }
   
  function tpl_button_a($type, $pre = '', $suf = '', $class='', $inner = '', $return = false) {
       global $lang;
       $data = tpl_get_action($type);
       if($data === false) {
           return false;
       } elseif(!is_array($data)) {
           $out = sprintf($data, 'link');
       } else {
           /**
            * @var string $accesskey
            * @var string $id
            * @var string $method
            * @var bool   $nofollow
            * @var array  $params
            * @var string $replacement
            */
           extract($data);
           if(strpos($id, '#') === 0) {
               $linktarget = $id;
           } else {
               $linktarget = wl($id, $params);
           }
           $caption = $lang['btn_'.$type];
           if(strpos($caption, '%s')){
               $caption = sprintf($caption, $replacement);
           }
           $akey    = $addTitle = '';
           if($accesskey) {
               $akey     = 'accesskey="'.$accesskey.'" ';
               $addTitle = ' ['.strtoupper($accesskey).']';
           }
           $rel = $nofollow ? 'rel="nofollow" ' : '';
           $out = tpl_link(
               $linktarget, $pre.(($inner) ? $inner : $caption).$suf,
               'class="btn action '.$type.' '.$class.'" '.
                   $akey.$rel.
                   'title="'.hsc($caption).$addTitle.'"', 1
           );

           $out='<a href="'.$linktarget.'" ';
           $out.='class="action '.$type.' '.$class.'" '.
                   $akey.$rel.
                   'title="'.hsc($caption).$addTitle.'"';
           $out.='>';
         //  if ($pre) $out.='<span class="glyphicon glyphicon-'.$pre.'"></span>&nbsp;';
           if ($pre) $out.='<div><i class="fa fa-'.$pre.'"></i></div>';
        //   $out.=(($inner) ? $inner : "&nbsp;".$caption);
           $out.='<div>'.(($inner) ? $inner : $caption).'</div>';
           $out.='</a>';
         //  if ($suf) $out='<'.$suf.'>'.$out.'</'.$suf.'>';
           
       }
       if($return) return $out;
       echo $out;
       return true;
   }

  function ds_html_msgarea(){  /* ½ºÆ®·¦¿ë msg */
	global $MSG, $MSG_shown;
     /** @var array $MSG */
     // store if the global $MSG has already been shown and thus HTML output has been started
     $MSG_shown = true;
 
     if(!isset($MSG)) return;
 
     $shown = array();
     foreach($MSG as $msg){
         $hash = md5($msg['msg']);
         if(isset($shown[$hash])) continue; // skip double messages
         if(info_msg_allowed($msg)){
             print '<div class="alert-'.$msg['lvl'].' alert alert-dismissible" role="alert">';
			 print '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
             print $msg['msg'];
             print '</div>';
         }
         $shown[$hash] = 1;
     }
 
     unset($GLOBALS['MSG']);
 }
 


   function tpl_bs_breadcrumbs($tag='li') {
       global $lang;
       global $conf;
 
     //check if enabled
     if(!$conf['breadcrumbs']) return false;
 
     $crumbs = breadcrumbs(); //setup crumb trace
  
     $last = count($crumbs);

     if ($last==1) return false;
     $i    = 0;
     print '<ol class="breadcrumb text-capitalize hidden-xs">';
     print '<span class="glyphicon glyphicon-book"></span>';
     foreach($crumbs as $id => $name) {
         $i++;
         print '<'.$tag.'>';
         tpl_link(wl($id), hsc($name), '  title="'.$id.'"');
         print '</'.$tag.'>';
       }
     print '</ol>';
     return true;
 }
 
 /*
    from twitter bootstrap template
  * @author Anika Henke <anika@selfthinker.org>
 */
 
 
 
function _tpl_toc_to_twitter_bootstrap_event_hander_dump_level($data, $header='', $firstlevel=false)
{
    global $lang;

    if (count($data) == 0)
    {
        return '';
    }

 

    $ret = '';
    $ret .= '<li class="divider"></li>';
   // $ret .= '<ul class="nav list-group">';
    if ($header != '') {
        $ret .= '<li class="dropdown-header">'.$header.'</li>';
    }
  //  $ret .= '<li class="divider"></li>';

  //  $first = true;
   // $li_inner = ' class ="active"';

    //Only supports top level links for now.
    foreach($data as $heading)
    {
        $ret .= '<li' . $li_inner . '><a href="#' . $heading['hid'] . '">'. $chevronHTML . $heading['title'] . '</a></li>';

        $li_inner = '';
    }

    //$ret .= '<li class="divider"></li>';
   // $ret .= '</ul>';

    return $ret;
}

function _tpl_toc_to_twitter_bootstrap_event_hander(&$event, $param)
{
    global $conf;
    global $lang;
    //This is tied to the specific format of the DokuWiki TOC.
    echo _tpl_toc_to_twitter_bootstrap_event_hander_dump_level($event->data,$lang['toc'], true);
}

function _tpl_toc_to_twitter_bootstrap()
{
    //Force generation of TOC, request that the TOC is returned as HTML, but then ignore the returned string. The hook will instead dump out the TOC.
    global $EVENT_HANDLER;
    $EVENT_HANDLER->register_hook('TPL_TOC_RENDER', 'AFTER', NULL, '_tpl_toc_to_twitter_bootstrap_event_hander');
    tpl_toc(true);
}

function tpl_logo ($return = false) {
    global $INFO;

            $logoSize = array();
            $logo = tpl_getMediaFile(array(':'.$INFO['namespace'].':logo.jpg',':'.$INFO['namespace'].':logo.png',':¿À´Ã:'.date("n¿ù_jÀÏ").'.png',':logo.png',':wiki:logo.png', 'images/logo.png'), false, $logoSize); 
			$out='<img class="logo" src="'.$logo.'" alt="" >';
            $out=tpl_link(wl($INFO['namespace']),$out,'',1);
            if($return) return $out;
            echo $out;
            return true;
}
function tpl_background ($return = false) {
    global $INFO;
    $bg=tpl_getConf('bg_ns');
    $logoSize = array();
    $img = tpl_getMediaFile(array(':'.$INFO['namespace'].':'.$bg,':'.$bg, 'images/bg.png'), false); 
	$out=$img;
    if($return) return $out;
    echo $out;
    return true;
}

function tpl_title ($return=false) {
    global $INFO;
    global $conf;
    //strip_tags($conf['title'])
    $out='<div class="title" >'.tpl_link(  wl($INFO['namespace']),p_get_first_heading(':'.$INFO['namespace'].':home'),'accesskey="h" title="[H]"',1).'</div>';
             if($return) return $out;
            echo $out;
            return true;   
}

  function tpl_apple_touch_icon() {
 
     $return = '';
 
     $look = array(':wiki:apple-touch-icon.png', ':apple-touch-icon.png', 'images/apple-touch-icon.png');
     $return .= tpl_getMediaFile($look);
 
     return $return;
 }


?>