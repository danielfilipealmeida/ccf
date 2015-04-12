<?php 
    $userData = $this->Session->read('userData');
    $userLoggedIn = false;
    if(isset($userData) and !empty($userData))$userLoggedIn=true;
    //debug($userData);exit()
?>
<div id="menuDiv">
    <ul id="menu">

<?php if($userLoggedIn) {?>
       
        <li><?php echo($this->Html->link(__("Ciclos",TRUE), array('controller'=>'ciclos', 'action'=>'admin_index')));?></li>
        <li><?php echo($this->Html->link(__("Sessões",TRUE), array('controller'=>'sessoes', 'action'=>'admin_index')));?></li>
        <li><?php echo($this->Html->link(__("Locais",TRUE), array('controller'=>'locais', 'action'=>'admin_index')));?></li>
        <li><?php echo($this->Html->link(__("Utilizadores",TRUE), array('controller'=>'utilizadores', 'action'=>'admin_index')));?></li>
        <li><?php echo($this->Html->link(__("Logout",TRUE), array('controller'=>'utilizadores', 'action'=>'admin_logout')));?></li>
        
            
<?php } else { ?>
       
        
        <li><?php echo($this->Html->link(__("Login",TRUE), array('controller'=>'utilizadores', 'action'=>'admin_login')));?></li>
           
<?php } ?>
    </ul>
    <br class='clearLeft' />
</div>