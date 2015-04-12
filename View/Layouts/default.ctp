<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?> - Cineclube de Faro</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
                echo $this->Html->script('jquery'); 
	?>
</head>
<body>
    
    <!-- facebok plugin -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    
    <?php echo $this->element('analytics'); ?>

<header>
    <div class='header'>
        <div class="container">
            <div class='col-md-12'>
                 <h1>Cineclube de Faro</h1> 
            </div>
            
        </div>
    </div>

</header>

<nav>
    <div class="menu">
        <div class="container">
        <?php echo $this->element('menu'); ?>
        </div>
    </div>

</nav>
    

    <div id='mainDiv'>
        <div id='breadcrumbs'>
            <div class="container">
                <?php echo $this->Html->getCrumbs(' > ', 'Início'); ?>
            </div>
        </div>
        
        <div class="container">
            <div class='row'>
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </div>



<footer>
    <div id="footer">
        <div class="container">
            
            <?php echo $this->element('footer'); ?>
        </div>
    </div>
</footer>
     <?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
