<?php
$this->Html->addCrumb('Contactos','');
?>


<div class='col-md-9' id='mainCol'>
    <h2>Contactos</h2>

    <p><?php echo $this->Html->image('Sede-mapa.jpg'); ?></p>

    <p><strong>Moradas</strong></p>
    <p>Rua Dr. Francisco de Sousa Vaz, nº 28A (perto das urgências do Hospital). </p>
    

    <p>Apartado 293. 8000-327 Faro.</p>

    <p><strong>Horário de funcionamento</strong> 2ªf, 4ªf e 6ªf - 10h30-12h30 / 14h30-17h30</p>

    <p><strong>Email</strong> <a href='mailto:cineclubefaro@gmail.com'>cineclubefaro@gmail.com</a></p>

    <p><strong>Telefone</strong> 289 827 627</p>    
</div>
<div class='col-md-3' id='rightCol'>
    <?php echo $this->element('calendar'); ?>      
</div>