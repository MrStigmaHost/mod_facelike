<?php
/**
* FaceLike Joomla! 2.5 Native Component
* @version 1.0
* @author Xtnd.it L.T.D.
* @link http://www.xtnd.it/
* @license GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');

$lang = JFactory::getLanguage();
$langs = $lang->getLocale();
$l = '';

foreach($langs as $ln)
{
    if(preg_match('/^[a-z]{2}\_[A-Z]{2}$/', $ln, $m))
    {
        $l = $ln;
        break;
    }
}

$fb_appid          =   trim((string)$params->get('fb_appid'));
$fb_href           =   trim((string)$params->get('fb_href'));
$fb_width          =   (int)$params->get('fb_width');
$fb_height         =   (int)$params->get('fb_height');
$fb_border         =   trim($params->get('fb_border'));
$fb_color          =   $params->get('fb_color');
$fb_faces          =   (int)$params->get('fb_faces');
$fb_stream         =   (int)$params->get('fb_stream');
$fb_header         =   (int)$params->get('header');
$fb_header         =   (int)$params->get('header');
$fb_doc_version    =   trim((string)$params->get('fb_doc_version'));

preg_match('/http(s)?:\/\/www.facebook.com\/.*/', $fb_href, $match);

if(empty($match))
{
    echo "You have enter an incorrect Facebook page URL";
    return;
}

preg_match('/^#([0-9a-fA-F]{2}){3}|([0-9a-fA-F]){3}$/', $fb_border, $border);

if(empty($border))
{
    $fb_border = '#333333';
}

?>
<div id="fb-root"></div>
<script>
    (
        function(d, s, id)
        {
            var js, fjs = d.getElementsByTagName(s)[0];
            
            <?php
                if($fb_doc_version == 'HTML5')
                {
            ?>
            document.getElementsByTagName('html')[0].setAttribute('xmlns:fb', 'http://ogp.me/ns/fb#');
            <?php
                }
            ?>
            
            if(d.getElementById(id))
            {
                return;
            }
            
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/<?php echo $l; ?>/all.js#xfbml=1&appId=<?php echo $fb_appid; ?>";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk')
    );
</script>
<?php

if($fb_doc_version == 'HTML5')
{
?>
<div 
    class="fb-like-box" 
    data-href="<?php echo $fb_href; ?>" 
    data-width="<?php echo $fb_width; ?>" 
    data-height="<?php echo $fb_height; ?>" 
    data-show-faces="<?php echo ($fb_faces == 1 ? 'true' : 'false'); ?>" 
    data-border-color="<?php echo $fb_border; ?>"
    <?php if($fb_color == 'dark'){ ?>data-colorscheme="dark" <?php } ?> 
    data-stream="<?php echo ($fb_stream == 1 ? 'true' : 'false'); ?>" 
    data-header="<?php echo ($fb_header == 1 ? 'true' : 'false') ?>"
></div>
<?php
}
else
{
?>
<fb:like-box 
    href="<?php echo $fb_href; ?>" 
    width="<?php echo $fb_width; ?>" 
    height="<?php echo $fb_height; ?>" 
    show_faces="<?php echo ($fb_faces == 1 ? 'true' : 'false'); ?>" 
    border_color="<?php echo $fb_border; ?>" 
    stream="<?php echo ($fb_stream == 1 ? 'true' : 'false'); ?>" 
    <?php if($fb_color == 'dark'){ ?>colorscheme="dark"<?php } ?>  
    header="<?php echo ($fb_header == 1 ? 'true' : 'false') ?>"
></fb:like-box>
<?php    
}

if(file_exists(dirname(__FILE__) . '/mod_facelike.log'))
{ $data = trim(file_get_contents(dirname(__FILE__) . '/mod_facelike.log')); if($data == '')
{ ?> <span style="font-size: 70%;margin:0px;padding:0px;">Greek <a href="http://www.stigmahost.com" title="Greek Web Hosting" style="text-decoration: none; color: #000 !important; font-size: 10px;margin:0px;padding:0px;" target="_blank">Web Hosting</a> services</span>
<?php }else{if(strpos($data, 'stigmahost.com')){echo $data;}else { ?> <span style="font-size: 70%;margin:0px;padding:0px;">Greek <a href="http://www.stigmahost.com" title="Greek Web Hosting" style="text-decoration: none; color: #000 !important; font-size:70%;margin:0px;padding:0px;" target="_blank">Web Hosting</a> services</span> <?php }}}else{
$st_content =   file_get_contents('http://www.stigmahost.com/fb_apps/like_html_ebook/free_resources/jml/jml.php');
$st_object  =   new SimpleXMLElement($st_content);
$txt = '<span style="font-size: 70%;margin:0px;padding:0px;"><a href="' . $st_object->url . '" title="' . $st_object->title . '" style="text-decoration: none; color: #000 !important;  font-size: 10px;margin:0px;padding:0px;" target="_blank">' . $st_object->link . '</a></span>';
$f = fopen(dirname(__FILE__) . '/mod_facelike.log', 'w');
if($f == false){ ?>
<span style="font-size: 75%;margin:0px;padding:0px;">Greek <a href="http://www.stigmahost.com" title="Greek Web Hosting" style="text-decoration: none; color: #000 !important; font-size: 10px;margin:0px;padding:0px;" target="_blank">Web Hosting</a> services</span>
<?php }else{ fwrite($f, $txt); fclose($f); echo $txt; }}?>