<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$conf["title"]?></title>
    <?php tpl_metaheaders() ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	
<div class="dokuwiki">
	<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
		  <?php 
		  	$logo = @tpl_getMediaFile(array(':logo.png', 'images/logo.png'), false);
		  	tpl_link( wl(), 
		  		'<img src="'.$logo.'" alt="" class="logo" height="20"/><span>'.$conf['title'].'</span>',
		  		'accesskey="h" title="[H]" class="navbar-brand"'
		  	);
		  	?>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	      </ul>

	      <ul class="nav navbar-nav navbar-right">
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><b class="caret"></b></a>
	          <ul class="dropdown-menu">
                 <?php tpl_bs_actionlink("login","user","li");?>
                 <?php tpl_bs_actionlink("profile","edit","li");?>
	            <li class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li>
            <li><div class="btn-group">
               <button type="button" class="btn btn-danger navbar-btn">&nbsp;<span style="color:White" class="glyphicon glyphicon-pencil"></span>&nbsp;</button>
               <button type="button" class="btn btn-danger navbar-btn dropdown-toggle" data-toggle="dropdown">
                 <span class="caret"></span>
                 <span class="sr-only">Toggle Dropdown</span>
               </button>
               <ul class="dropdown-menu" role="menu">
                 <li role="presentation" class="dropdown-header">Page tools</li>
                 <?php tpl_bs_actionlink("history","list","li");?>
                 <?php tpl_bs_actionlink("backlink","hand-right","li");?>
                 <?php tpl_bs_actionlink("subscribe","send","li");?>
                 <?php tpl_bs_actionlink("back","arrow-left","li");?>
                 <li class="divider"></li>
                 <li role="presentation" class="dropdown-header">Wiki tools</li>
                 <?php tpl_bs_actionlink("index","th-list","li");?>
                 <?php tpl_bs_actionlink("recent","fire","li");?>
                 <?php tpl_bs_actionlink("admin","cog","li");?>
               </ul>
              </div></li>
          </ul>
        	      <form id="qsearch" class="navbar-form navbar-right" role="search">
			<?php tpl_searchform(true,false); ?>
	      </form>
          
	    </div><!-- /.navbar-collapse -->

	  </div><!-- /.container-fluid -->
	</nav>
<ul class="breadcrumb"><li><?php tpl_youarehere('<span class="divider">/</span></li><li>') ?></li></ul>
<ul class="breadcrumb"><li><?php tpl_breadcrumbs('</li><li>') ?></li></ul>

	<?php tpl_toc() ;?>
	
<div class="contents">

	
<?php tpl_content(false); ?>
</div>

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
  function tpl_bs_actionlink($type, $pre = '', $suf = '', $inner = '', $return = false) {
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
               'class="btn action '.$type.'" '.
                   $akey.$rel.
                   'title="'.hsc($caption).$addTitle.'"', 1
           );
           $out='<a href="'.$linktarget.'" ';
           $out.='class="action '.$type.'" '.
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

?>