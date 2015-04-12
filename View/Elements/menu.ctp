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
?>
        <div class='row'>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?php
                    foreach($this->menu as $item) {
                        echo "<li>".$item."</li>\n";
                    }
                    ?>
                </ul>
            </div>
        </div>