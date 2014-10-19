<?php
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
 
?>