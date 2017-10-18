<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

$content = ( isset($content) ) ? $content : '';

?>
<!--link rel="stylesheet" href="<?php echo $view['assets']->getUrl('plugins/MauticAlertsBundle/Assets/css/style.css'); ?>" type="text/css"/-->
<?php echo $content; ?>
<div style="clear:both"></div>