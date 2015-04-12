<?php
$pageTitle = 'Entrar';
$this->Html->addCrumb($pageTitle , '');
?>
<div class="login form">
        <?php /* Login Form */ ?>
        <?php echo $this->Session->flash('auth'); ?>
        <?php echo $this->Form->create('Utilizador', array('role'=>'form', 'class'=>'form', 'novalidate' => "novalidate")); ?>
        <fieldset>
            <legend><?php echo __('Preencher os campos para entrar na área reservada.'); ?></legend>
            <?php
            /*
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            */
            echo $this->Form->input('login', array(
                'div' => 'form-group',
                'class'=>'form-control', 
                 'div'=>'form-group',
            ));
            echo $this->Form->input('senha', array(
                'type' => 'password',
                'div' => 'form-group',
                'class'=>'form-control', 
                 'div'=>'form-group',
            ));
             ?>
             
            <?php echo $this->Form->submit(__('Login'), array('class'=> 'btn btn-default', 'div' => false)); ?>
            <?php echo $this->Form->end(); ?>
</div>
<div class="actions">
    
</div>
        