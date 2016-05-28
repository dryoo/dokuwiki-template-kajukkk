<?php
/**
 * Template footer, included in the main and detail files
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>
<!-- ********** FOOTER ********** -->
<div id="dokuwiki__footer"><div class="pad">
    <?php // tpl_license(); // license text ?>
    <div class="buttons text-center">
        <a href="http://openwiki.kr/" target="openwiki" title="(C)OPENWIKI.KR All rights reserved"><img src="<?php echo tpl_basedir(); ?>images/button-openwiki.png" height="15" width="80" alt="Openwiki.kr"></a>
        <a href="http://openwiki.kr/tech/kajukkk" target="kajukkk" title="DOKUWIKI TEMPLATE KAJUKKK"><img src="<?php echo tpl_basedir(); ?>images/button-kajukkk.png" height="15" width="80" alt="Kajukkk template"></a>
       <!--  <a href="http://kr.dnsever.com" target="dnsever"><img src="<?php echo tpl_basedir(); ?>images/button-dnsever.png" height="15" width="80" alt="DNS Powered by DNSEver.com"></a> -->
        <?php
            //tpl_license('button', true, false, false); // license button, no wrapper
            $target = ($conf['target']['extern']) ? 'target="'.$conf['target']['extern'].'"' : '';
        ?>
       <!-- <a href="http://www.openwiki.kr/donate" title="Donate" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-donate.gif" width="80" height="15" alt="Donate" /></a>
        <a href="http://www.php.net" title="Powered by PHP" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-php.gif" width="80" height="15" alt="Powered by PHP" /></a> -->
       <!--  <a href="http://validator.w3.org/check/referer" title="Valid HTML5" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-html5.png" width="80" height="15" alt="Valid HTML5" /></a>
        <!--<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" title="Valid CSS" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-css.png" width="80" height="15" alt="Valid CSS" /></a>-->
         <a href="http://openwiki.kr/tech/dokuwiki" title="Driven by DokuWiki" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-dokuwiki.png" width="80" height="15" alt="Driven by DokuWiki" /></a>
        <a href="http://openwiki.kr/tech/nginx" title="Powered by Nginx" <?php echo $target?>><img
            src="<?php echo tpl_basedir(); ?>images/button-nginx.png" width="80" height="15" alt="Powered by NginX" /></a>

        <span  ><?php // echo tpl_getConf('whosamungus')?></span>

    </div>
</div></div><!-- /footer -->
<?php tpl_includeFile('footer.html') ?>
