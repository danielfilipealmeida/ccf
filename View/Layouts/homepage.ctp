
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo $this->Html->charset(); ?>
	<title>
		Cineclube de Faro :
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
                echo $this->Html->script('jquery'); 
	?>
</head>
<body class="homepage">
    
    <div class="container">
        <div class='row'>
            <div class='col-md-12'>
                <h1>Cineclube de Faro</h1>
             </div>
        </div>
        <div class='row'>
            <?php echo $this->fetch('content'); ?>
            
        </div>
        
        <div class='row'>
            <div class='col-md-12'>
            <?php
            $menuData = Configure::read("Menu");
            $this->menu = array();
            foreach($menuData as $item) {
                $itemHtml="";
                if (isset($item['controller'])) {
                    $optionsArray = array('controller' => $item['controller'], 'action' => $item['action']);
                    if(isset($item['extra'])) $optionsArray[] = $item['extra'];
                    $itemHtml = $this->Html->link($item['title'], $optionsArray);
                }
                if (isset($item['url'])) {
                    $itemHtml = $this->Html->link($item['title'], $item['url']);   
                }
                $this->menu[] = $itemHtml;
            }
            
            echo "<p>".implode(" | ", $this->menu);

            ?>
            </br>
            <small>
                <?=date('Y');?> Daniel Almeida / CCF
                </small></p>
        
        </div>
        
    </div>

    
     <?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
