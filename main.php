<?php $pagestart=microtime(get_as_float);
/*

Kajukkk
========
Dokuwiki template Kajukk  

Another DokuWiki responsive template using Twitter Bootstrap & font awesome. Supports for togglable dark theme to save energy of mobile phone. Supports various plugins like disqus, shoturl, avatar and searchformgoto.

 * @link     https://github.com/dryoo/dokuwiki-template-kajukkk
 * @author   S.C. Yoo <dryoo@live.com> 
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 
Related/supported plugins
-------------------------
  * Avatar      https://www.dokuwiki.org/plugin:avatar
  * Disqus      https://www.dokuwiki.org/plugin:disqus
  * Shorturl    https://www.dokuwiki.org/plugin:shorturl
  * Searchformgoto      https://www.dokuwiki.org/plugin:searchformgoto


References
----------
  * https://www.dokuwiki.org/devel:localization#template_localization
  * http://getbootstrap.com/
  * http://www.torrentreactor.net/
  
*/

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */

header('X-UA-Compatible: IE=edge,chrome=1');

// 애드센스처리
if (($ACT=="show")||($ACT=="showtag")) $noadsense=false; else $noadsense=true; 
if (p_get_metadata($ID,"adult")) $noadsense=true;
?>
<!DOCTYPE html>
<!--[if lt IE 9]>  <html class="ie"> <![endif]-->
<!--[if gte IE 9]>  <html> <![endif]-->
<!--[if !IE]><!-->        
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title><?php echo (p_get_first_heading($ID))?p_get_first_heading($ID):strrchr(':'.$INFO['id'],":"); ?><?php if (strrchr(':'.$INFO['id'],":")!=":".$conf['start']) echo ' - '.p_get_first_heading(':'.$INFO['namespace'].':'.$conf['start']).' - '.strip_tags($conf['title']); else echo ' - '.strip_tags($conf['tagline']) ?></title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="description" content="<?php $_desc=p_get_metadata($ID,"description"); echo strip_tags($_desc['abstract']); ?>" >
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
    <?php echo tpl_getConf('google_analytics') ?>
   <!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//io.vaslor.net/analytics/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//io.vaslor.net/analytics/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
    <script>
    function tpl_toggleLight() {
     if (DokuCookie.getValue('dark')==1)
     {
          DokuCookie.setValue('dark','0');
        jQuery('body').toggleClass('dark');
        return false;
     }
     else
     {
        DokuCookie.setValue('dark','1');
        jQuery('body').toggleClass('dark');
        return false;
      }
    }
    </script>
    <?php if (tpl_getConf('debug')): ?>
    <script src="<?php echo tpl_getMediaFile(array("js/sendsns.js")); ?>" type="text/javascript"></script>
    <?php endif;?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- <script src="<?php echo tpl_getMediaFile(array("js/respond.min.js")); ?>" type="text/javascript"></script>-->
    <!--[if lt IE 9]>
      <script src="<?php echo tpl_getMediaFile(array("js/html5shiv.js")); ?>" type="text/javascript"></script>
          <![endif]-->
    <?php if (tpl_getConf('debug')): ?>   
    <script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
    <?php endif;?>
</head>

<body class="<?php echo (get_doku_pref('dark', 0)==1)?'dark':''?>" >
<div class="dokuwiki ">
    <div id="dokuwiki__top" class="mode_<?php echo $ACT ?> <?php echo ($showSidebar) ? 'showSidebar' : '';
        ?> <?php echo ($hasSidebar) ? 'hasSidebar' : ''; ?>"  >

 
        <?php tpl_flush(); ?>
        <nav>
       	    <?php if (tpl_getConf('debug')) @include('shortcut.php') /* Shortcut */ ?> 
        </nav>
        <div class="core">
            <div class="home-icon">
             <?php if (!tpl_getConf('debug')) { ?>
            <a href="/" ><i class="fa fa-circle"></i></a>
            <?php }?>
            </div>
			<?php if (!plugin_isdisabled('searchformgoto')) {
				$searchformgoto = &plugin_load('helper','searchformgoto');
				$searchformgoto->gotoform();
				} else { tpl_searchform(); }
			?>         
            <?php ds_html_msgarea(); /* occasional error and info messages */ ?>       
            <?php if  (!$noadsense) echo tpl_getConf('google_adsense') /* google adsense RESPONSIVE */?>
            
 

        <div id="dokuwiki__content">
            <?php tpl_bs_breadcrumbs() ?>
            <?php if ($ACT=="show" ||$ACT=="edit"): ?>
                
            <h1>
                <?php echo p_get_first_heading($ID) ?>      
                <?php   /* Short URL*/
                    if (!plugin_isdisabled("shorturl") && (auth_quickaclcheck($ID) >= AUTH_READ) && ($INFO['exists'])):
                        $shorturl = plugin_load('helper', 'shorturl');
                        $sURL= DOKU_URL.$shorturl->autoGenerateShortUrl($ID);
                        ?>
                <small>
                <a href="<?php echo $sURL ?>" style="font-size:16px;color:rgba(111,111,111,0.5)"><?php echo $sURL ?></a> 
                </small>
                <?php endif ?>
            </h1>
            <?php endif?> 
            <?php if ($ACT=="show") tpl_include_page(tpl_getConf('nsheader'),true,true);   /* page header */ ?>
           
<?php if ((auth_quickaclcheck($ID) >= AUTH_EDIT)&&($ACT=="show")): ?>

<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo strip_tags($conf['tagline']) ?></strong><?php echo tpl_getLang('haspermeditpage');?>
</div>
<?php endif; ?>
   <?php tpl_button_a('edit','pencil','','btn btn-danger pull-right   ');?>      
            <!-- wikipage start -->
            <?php tpl_content(true) ?>
            <!-- wikipage stop -->
            <div class="clearer"></div>
            <!-- Usage as a class -->

            <?php /*Backlinks 참조문서 출력*/  if  ((ft_backlinks($ID)!=null) && (strrchr(':'.$INFO['id'],":")!=":".$conf['start']) &&  (($ACT=='edit') or ($ACT=='preview') or ($ACT=="show") ) ) print '<h2>'.$lang['btn_backlink'].'</h2>'.p_render('xhtml',p_get_instructions('{{backlinks>.}}'),$info);?>     

            <?php if (tpl_getConf('debug')): ?>
                      <?php /************** SNS *************/
                        //$_url=rawurlencode(wl($ID,'',true));       
                        $_url=$sURL;       
                        $_title= p_get_metadata($ID,"title");
                        $_tags=@implode(' #',p_get_metadata($ID, 'subject', METADATA_DONT_RENDER));
                        $_tags=($_tags)?" #".$_tags:null;
                        
                        //$_txt= " $_title ".wl($ID,'',true)." #".strip_tags($conf['title']).$_tags;    
                        $_txt= " $_title ".$_url." #".strip_tags($conf['title']).$_tags;    

                      ?>
                      <div class="text-center">
                      <i class="fa fa-hand-o-right"></i> 
                      <a href="#" class="btn-circle btn-primary slideTextUp" onclick="sendsns('facebook','<?php echo $_url; ?>','txt');return false;" title="페북펌"><div><i class="fa fa-facebook"></i></div><div>페북푸기</div></a>   
                      <a href="#" class="btn-circle btn-info slideTextUp" onclick="sendsns('twitter','<?php //echo $_url; ?>','<?php echo $_txt;?>');return false;" title="트윗펌"><div><i class="fa fa-twitter"></i></div><div>트윗푸기</div></a>  
                      
                      <a href="#" class="btn-circle btn-warning slideTextUp" onclick="sendsns('kakaotalk','<?php echo $_url; ?>','<?php echo $_txt;?>');return false;" title="카톡펌"><div>Kakao</div><div>카톡푸기</div></a>   
                    <a href="#" class="btn-circle btn-success slideTextUp" onclick="sendsns('band','<?php //echo $_url; ?>','<?php echo $_txt;?>');return false;" title="밴드펌"><div>Band</div><div>밴드푸기</div></a>   
                    <i class="fa fa-hand-o-left"></i>
                    </div>
            <?php endif; ?>
            <?php /*미니문법설명*/ if (tpl_getConf('debug') && (($ACT=='edit')or ($ACT=='preview'))) print p_render('xhtml',p_get_instructions('
^  **초미니 문법 설명**  (혹은 [[:syntax]]참조하세요)  ||||
^강조| %%**굵게**%%| %%//기울임//%% | %%__밑줄__%%|
^제목| ======제목1단계|=====제목2단계|====제목3단계 (뒤는 자동)|
^목록| _*_  공백과 총알 한개 (점목록)|_-_ 공백과 빼기 (번호목록)||
^연결| %%[[두개의 대괄호로 연결]]%%| %%URL%% 혹은 %%[[URL]]%%| %%[[URL|표시될 이름]]%%|
^표| %%|셀 내용1|셀 내용2|%% | %%^제목내용1^제목내용2^%% |테이블 끝에 공백이 오면 안됩니다|
'),$info);?>


        <?php if  (!$noadsense) echo tpl_getConf('google_adsense') /* google adsense RESPONSIVE */?>
            
            <?php tpl_license('badge', false, false, true); // license button, no wrapper ?>   
            <div class="docInfo"><?php tpl_pageinfo() ?>
          <?php    $contributors =$INFO['meta']['contributor'];// p_get_metadata($ID, 'contributor' );
      if ($contributors!=null)    { 
         //$contributors=array_unique(array_diff_assoc($contributors,array_unique($contributors)));  
         foreach(array_unique($contributors) as $userid=>$usernick){
             if ( strtolower($userid)=="v_l" ||  strtolower($userid)=="vaslor" )
             {
                 //echo '<a href="https://plus.google.com/102990262307362184016?rel=author"  rel="publisher">'.$usernick.'</a> ';
                  echo  '<a href="/user/'.$userid.'">'.$usernick.'</a> ';
             } else
             {
                 echo  '<a href="/user/'.$userid.'">'.$usernick.'</a> ';
             }
                    
         
         //    $_contributors.="[[:user:".$userid."|".$usernick."]]  "; // [[:user:id|name]]으로 링크형성
         }
         
        // print '<dt>작성자</dt><dd>'.p_render('xhtml',p_get_instructions($_contributors),$info).'</dd>';
    }?>
          

            </div>
                 
            <?php  /* *************디스커즈 disqus************* */
            if($ACT == 'show' &&  (strrchr(':'.$INFO['id'],":")!=":".$conf['start']) ){
                $disqus = &plugin_load('syntax','disqus');
                if($disqus) echo $disqus->_disqus();
            }
            ?>
            <?php tpl_includeFile('pagefooter.html') ?> 
            <?php include('tpl_footer.php') ?> 
    
         

        <?php tpl_flush(); ?>
    </div> <!--core끝 -->


    <!-- ********** sidebar ********** -->
      <asdie><div id="dokuwiki__aside" class="lsb ">
        <div class="sidebar-toggle"><i class="fa fa-forward"></i></div>
        <?php tpl_logo();?>     <div class="clearfix"></div>
        <?php tpl_title();?>
        <div class="tools text-center">
         <?php tpl_flush() ?>
            <a href="#" class="btn-circle btn-danger slideTextUp" data-target="#myModal"  data-toggle="modal" data-toggle="tooltip"   title="Add new page"><div><i class="fa fa-plus"></i></div><div><?php echo tpl_getLang('newpage')?></div></a>
            <?php tpl_button_a('edit','pencil','','btn-info btn-circle slideTextUp');?>   
            <?php tpl_button_a('history','history','','btn-primary btn-circle slideTextUp');?> 
            <?php  if(!plugin_isdisabled('randompage')) {?>
                <a href="?do=randompage" class="btn-circle btn-success slideTextUp" title="<?php echo tpl_getLang('randompage')?>"><div><i class="fa fa-random"></i></div><div><?php echo tpl_getLang('randompage')?></div></a>      
            <?php    }?>
            <a href="#" class="btn-circle btn-danger slideTextUp lightsaving" onclick="tpl_toggleLight();return false;" title="<?php echo tpl_getLang('energysaving')?>"><div><i class="fa fa-lightbulb-o"></i></div><div><?php echo tpl_getLang('energysaving')?></div></a>   
            
            <?php tpl_button_a('login','sign-in','','btn-warning btn-circle slideTextUp');?>          
            <?php if ($INFO['userinfo']!=""): /* If logged-in */?>
                 <?php tpl_button_a('media','image','','btn-primary btn-circle slideTextUp');?>         
                 <?php tpl_button_a('backlink','link','','btn-primary btn-circle slideTextUp');?>
                 <?php tpl_button_a('subscribe','envelope','','btn-primary btn-circle slideTextUp');?>
                 <?php tpl_button_a('recent','spinner','','btn-primary btn-circle slideTextUp');?>
                 <?php tpl_button_a('admin','cog','','btn-default btn-circle slideTextUp');?>    
            <?php endif; ?>
    		<?php if (!plugin_isdisabled('move') && ($INFO['isadmin'])) {?>
    				<a href="?do=admin&page=move_main" class="btn-circle btn-default slideTextUp" title="<?php echo tpl_getLang('movepage') ?>"><div><i class="fa fa-bolt"></i></div><div><?php echo tpl_getLang('movepage') ?></div></a>    
            <?php  }         ?>         
            <a href="#" class="btn-circle btn-danger slideTextUp" data-target="#helpModal"  data-toggle="modal" data-toggle="tooltip"   title="<?php echo tpl_getLang('help')?>"><div><i class="fa fa-question"></i></div><div><?php echo tpl_getLang('help')?></div></a>
         </div>                  

        <div class="content">
            <?php tpl_includeFile('sidebarheader.html') ?>        
            <?php tpl_include_page($conf['sidebar'], 1, 1) /* Default Sidebar*/?>
            <?php tpl_include_page(tpl_getConf('lsb'),1,1) /* Bottom Sidebar */ ?>
            <?php tpl_includeFile('sidebarfooter.html') ?>
        </div>
    </div><!-- /aside -->  </asdie>
                <?php tpl_button_a('top','eject','','btn-primary btn-circle slideTextUp');?>      </div>
	</div></div><!-- /.dokuwiki -->

<!-- Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="helpModalLabel"><?php echo tpl_getLang('help')?></h4>
        
        
      </div>
      <div class="modal-body">
       <?php tpl_include_page(tpl_getConf('help'),true,true);   /* help page  */ ?>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['js']['mediaclose'] ?></button>
      </div>
    </div>
  </div>
</div>

<!-- NEW page Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo tpl_getLang('createnewpage')?></h4>
      </div>
      <div class="modal-body">
        <form class="uk-form-horizontal" action="<?php echo  tpl_basedir()?>newpage.php">
          <input type="text" hidden name="ns" value="<?php echo $INFO['namespace']?>">
          <label class="label-control text-capitalize"><?php echo tpl_getLang('pagename')?></label><br>
          <input class="form-control" id="newpageid" name="title" type="text" required placeholder="<?php echo tpl_getLang('pagename')?>">      <br>
          <label class="label-control text-capitalize">선택하세요</label><br>
          <?php //echo tpl_getLang('namespacedesc') ?>

         <!-- <code>이름공간:페이지이름</code> 형식으로 입력함으로써 새 페이지가 특정한 이름공간에 위치하도록 할 수 있습니다. 아니면, 아래의 단추에서 고르세요. -->
          <div class="radio">
            <label>
              <input type="radio"  name="do" value="root"  <?php echo ($INFO['namespace']=="")?"checked":""?>   >
              <b>최상위(루트)</b>에 새 문서를 만듭니다. 
              <?php //echo tpl_getLang('namespacedesc1') ?>
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="do" value="ns"  <?php echo ($INFO['namespace']=="")?"disabled":"checked"?>    >
              <?php printf (tpl_getLang('namespacedesc2'),$INFO['namespace'] ) ?>
            </label>
          </div>
          <?php if (tpl_getConf('debug')):?>
             <div class="radio">
            <label>
              <input type="radio" name="do" value="namu"      >
              <b>나무위키</b>의 문서를 변환한 뒤 편집합니다. (CC BY-NC-SA 2.0 Kr)
              <?php //printf (tpl_getLang('namespacedesc2'),$INFO['namespace'] ) ?>
            </label>
          </div>        
           <div class="radio">
            <label>
              <input type="radio" name="do" value="enha"      >
              <b>엔하위키미러</b>의 문서를 변환한 뒤 편집합니다. (CC BY-NC-SA 2.0 Kr)
              <?php //printf (tpl_getLang('namespacedesc2'),$INFO['namespace'] ) ?>
            </label>
          </div>
          <?php endif;?>
          <div class="btn-group pull-right ">
            <input type="submit" class="btn btn-primary " value="<?php echo $lang['btn_create'] ?>">
            <button type="button" class="btn btn-warning" data-dismiss="modal"><?php echo $lang['btn_cancel']?></button>
          </div>
          <div class="clearfix"></div>
          <input type="text" hidden name="back" value="<?php echo $ID?>">
        </form>
  
      </div>

    </div>
  </div>
</div> <!--NEW page  Modal -->

 
<script>
jQuery(".dokuwiki table").addClass( "table" );
jQuery(document).ready(function()
{
    <?php if ($ACT=="edit"): /* 편툴바 조작 */?>
        jQuery("#tool__bar").addClass( "btn-group" );
        jQuery(".dokuwiki .toolbutton").addClass( "btn btn-default btn-sm" );
        jQuery(".dokuwiki .editButtons button").addClass( "btn btn-default" );

        jQuery("#edbtn__save").addClass( "btn-primary");
        jQuery("#edbtn__preview").addClass( "btn-success");
    <?php endif ?>
    jQuery("#plugin__backlinks ul li div a").addClass( "btn btn-default" );
    jQuery(".dokuwiki .secedit button").addClass("btn btn-default btn-xs pull-right");
    jQuery(this).scroll(function () { 
    	jQuery(".lsb").scrollTop(jQuery(this).scrollTop());   	
    });
}); 
</script>


<div id="spot-im-root"></div>
<?php /* spot-im community widget */ //echo tpl_getConf('spot-im')?>




<?php /* server processing time */?>
<?php printf("<center  class='small text-muted'>%.3f seconds in processing this page.</center>",(microtime(get_as_float)-$pagestart));?>
<div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
<div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>
</body>
</html>
