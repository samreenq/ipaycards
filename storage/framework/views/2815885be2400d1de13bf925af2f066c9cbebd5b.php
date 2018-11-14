<?php if(Session::has(ADMIN_SESS_KEY.'success_msg')): ?>
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <p><strong>Success : </strong><?php echo Session::get(ADMIN_SESS_KEY.'success_msg'); ?></p>
</div>
<?php /**/ Session::forget(ADMIN_SESS_KEY.'success_msg') /**/ ?> 
<?php endif; ?>
<?php if(Session::has(ADMIN_SESS_KEY.'error_msg')): ?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <p><strong>Error : </strong><?php echo Session::get(ADMIN_SESS_KEY.'error_msg'); ?></p>
</div>
<?php /**/ Session::forget(ADMIN_SESS_KEY.'error_msg') /**/ ?> 
<?php endif; ?>
<?php if(Session::has(ADMIN_SESS_KEY.'info_msg')): ?>
<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <p><strong>Info : </strong><?php echo Session::get(ADMIN_SESS_KEY.'info_msg'); ?></p>
</div>
<?php /**/ Session::forget(ADMIN_SESS_KEY.'info_msg') /**/ ?> 
<?php endif; ?>