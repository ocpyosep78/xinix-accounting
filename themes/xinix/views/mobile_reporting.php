<?php foreach ($this->data['modules'] as $module): ?>
<div>
    <h1><?php echo $module->name ?></h1>
    <?php foreach ($module->lappfunctions as $appfunction): ?>
    <div class="menu-list"><?php echo menu_link($appfunction->link, $appfunction->label) ?></div>
    <?php endforeach ?>
    <?php foreach ($module->rappfunctions as $appfunction): ?>
    <div class="menu-list"><?php echo menu_link($appfunction->link, $appfunction->label) ?></div>
    <?php endforeach ?>
</div>
<?php endforeach ?>
