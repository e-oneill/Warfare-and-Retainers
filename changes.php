<?php 


if (is_array($changes)) {

if (count($changes) > 0) { ?>



<div class="alert alert-success">
    <h4>Retainer Record Successfully Updated
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></h4>
<!--
    <hr>
    The following changes were made:
    <?php foreach ($changes as $change) : ?>
     <p><?php echo $change; ?></p>
    <?php endforeach ?>
-->
        
</div>
<?php    }
} ?>
