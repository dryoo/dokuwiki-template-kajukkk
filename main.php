<?php error_reporting(E_ALL);
/*


References

  * https://www.dokuwiki.org/devel:localization#template_localization

*/

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */

header('X-UA-Compatible: IE=edge,chrome=1');

?>
<!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="utf-8">
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body data-spy="scroll" data-target="#sidetoc">
<div class="dokuwiki mode_<?php echo $ACT ?>" id="dokuwiki__top" >
    <div class="navbar navbar-default <?php echo tpl_getConf('navbar-inverse')?"navbar-inverse":""; ?>  navbar-fixed-top" role="navigation">
      <div id="nav-top" class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
          	<?php 
              $logo = @tpl_getMediaFile(array(':logo.png','images/logo.gif', 'images/logo.png',':wiki:dokuwiki-128.png'), false);
              tpl_link( wl(), 
                  '<img src="'.$logo.'" alt="" class="logo-image" height="28" width="28" /> <span class="hidden-xs hidden-sm">'.$conf['title'].'</span>',
                  'accesskey="h" title="'.$conf['title'].'[H]" class="navbar-brand"'
              );
              ?>

            <div id="qsearch" class="navbar-form  navbar-left hidden-xs" role="search">
            	<?php tpl_searchform(true,false); ?>
          	</div>
               
			<?php if (tpl_getConf('tabsPage')): /*  tab menu */?>
			<div class="tabspage navbar-left ">
			<?php tpl_include_page(tpl_getConf('tabsPage'), 1, 1) ?>
			</div>
			<?php endif; ?>
		</div>   

        <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-navbar-collapse-main">  

          <ul class="nav navbar-nav navbar-right hidden-xs">
          <!-- Button trigger modal -->
          	<li>
			<a href="#" class="" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span>
 			</a></li>

             <li class="dropdown visible-lg">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>

              <ul class="dropdown-menu">
                 <?php tpl_bs_actionlink("login","user","li");?>
                  <?php tpl_bs_actionlink("profile","edit","li");?>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
            <li class="dropdown  ">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span></a>
               <ul class="dropdown-menu" role="menu">
                 
                
                 <li role="presentation" class="dropdown-header"><?=$lang['page_tools']?></li>
                 <?php tpl_bs_actionlink("history","list","li");?>
                 <?php tpl_bs_actionlink("backlink","hand-right","li");?>
                 <?php tpl_bs_actionlink("subscribe","send","li");?>
                 <?php tpl_bs_actionlink("back","arrow-left","li");?>
                 <li class="divider"></li>
                 
                 <li role="presentation" class="dropdown-header"><?=$lang['site_tools']?></li>
                 <?php tpl_bs_actionlink("index","th-list","li");?>
                 <?php tpl_bs_actionlink("recent","fire","li");?>
                 <?php tpl_bs_actionlink("admin","cog","li");?>

               </ul>
              </li>            
            <li><div class="btn-group">
            <?php tpl_bs_actionlink("register","edit",'',"btn navbar-btn btn-sm btn-success");?>
            <?php tpl_bs_actionlink("login","log-in",'',"btn navbar-btn btn-sm btn-default");?>
            </div></li>
           </ul>
             <div   id="qsearch" class="navbar-form visible-xs"  role="search">
            <?php tpl_searchform(true,false); ?>
        </div>
           <ul class="nav navbar-nav navbar-right visible-xs">       
                 <?php tpl_bs_actionlink("login","user","li");?>                       
                 <?php tpl_bs_actionlink("profile","edit","li");?>
                 <?php tpl_bs_actionlink("history","list","li");?>
                 <?php tpl_bs_actionlink("backlink","hand-right","li");?>
                 <?php tpl_bs_actionlink("subscribe","send","li");?>
                 <?php tpl_bs_actionlink("back","arrow-left","li");?> 
                 <?php tpl_bs_actionlink("index","th-list","li");?>
                 <?php tpl_bs_actionlink("recent","fire","li");?>
                 <?php tpl_bs_actionlink("admin","cog","li");?>
           </ul>
           

         </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </div>
<ul class="breadcrumb hidden-xs"><li><?php tpl_breadcrumbs('</li><li>') ?></li></ul>

    <?php //tpl_toc() ;?>
    
<div class="contents">
	<?php ds_html_msgarea(); /* occasional error and info messages */ ?>         
	<?php tpl_flush(); ?>
    <?php tpl_bs_actionlink("edit","pencil","","btn btn-default pull-right");?>

                    <!-- wikipage start -->
                    <?php tpl_content() ?>
                    <!-- wikipage stop -->
                    
	<div class="clearer"></div>
<!-- Usage as a class -->
                <?php /*참조문서 출력*/  if  ((ft_backlinks($ID)!=null) &&($INFO['namespace']!="") && (strrchr(':'.$INFO['id'],":")!=":home") &&  (($ACT=='edit') or ($ACT=='preview') or ($ACT="show") ) ) print $lang['btn_backlink'].p_render('xhtml',p_get_instructions('{{backlinks>.}}'),$info);?>

                <div class="docInfo"><?php tpl_pageinfo() ?></div>
                	<?php tpl_flush(); ?>
</div>
 
        <form class="col-xs-6 col-sm-3 col-" style="font-size:10px">
        <select name="template" class=" input-sm form-control">
          <option value="">Desktop</option>
          <option value="m">Mobile Bright</option>
          <option disabled value="dark">Mobile Dark</option>
        </select><span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
        </form> 
 
       
	</div> <!-- /.dokuwiki -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo tpl_getLang('createnewpage')?></h4>
      </div>
      <div class="modal-body">
        <form class="uk-form-horizontal">
            <label class="label-control"><?php echo tpl_getLang('pagename')?></label>
          <input class="form-control" type="text" placeholder="<?php echo tpl_getLang('pagename')?>"> 
                    <br>
                <label class="label-control"><?php echo $lang['namespaces'] ?></label>
          <div class="radio">

            <label>
              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
              현재 이름공간에 만듭니다. 주소는 "/"
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
              Option two can be something else and selecting it will deselect option one
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
              Option two can be something else and selecting it will deselect option one
            </label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['btn_cancel']?></button>
        <button type="button" class="btn btn-primary"><?php echo $lang['btn_create'] ?></button>
      </div>
    </div>
  </div>
</div> <!-- Modal -->


<script>
var docked = false;
var menu = jQuery('#dw__toc');
var init = menu.offset().top;
            menu.css({
                position : "fixed",
                top: 50,
            });
            menu.addClass("toc_docked");
jQuery(window).scroll(function() 
{       
        if (!docked && (menu.offset().top - jQuery("body").scrollTop() < 0)) 
        {
            menu.css({
                position : "fixed",
                top: 50,
            });
            menu.addClass("toc_docked");
            docked = true;
        } 
        else if(docked && jQuery("body").scrollTop() <= init)
        {
            menu.css({
                position : "inherit",
                top: init + 'px',
            });
            menu.removeClass("toc_docked");
            docked = false;
        }
});
</script>
<script>
jQuery("table").addClass( "table" );
//jQuery("input").addClass( "form-control" );
jQuery(".dokuwiki .contents input.button").addClass( "btn btn-default" );
jQuery(".dokuwiki .contents .secedit input.button").addClass( "btn-sm" );
</script>
<!-- Latest compiled and minified JavaScript
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
<div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>

</body>
</html>
