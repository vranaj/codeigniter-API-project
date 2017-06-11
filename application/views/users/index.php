<div class="center">
	<h3>
		<span class="white"><?php echo $site_name ?></span>
	</h3>
</div>
<div  style="height:50px;"></div>
<div class="space-6"></div>

<div class="position-relative">
	<div id="login-box" class="login-box visible widget-box no-border">
		<div class="widget-body">
			<div class="widget-main">
				<h4 class="header blue lighter bigger">
					<i class="icon-info green"></i>
					Please Enter Your Information
				</h4>

				<div class="space-6"></div>

				<form id="login_form" action="<?php echo current_url(); ?>" method="POST" class="validateform">
					<fieldset>
						<label class="block clearfix">
							<span class="block input-icon input-icon-right">
								<input name="user_id" id="user_id" value="<?php echo set_value('username'); ?>" type="text" class="form-control" placeholder="User EPF" minlength="3" required/>
								<i class="icon-user"></i>
							</span>
						</label>

						<label class="block clearfix">
							<span class="block input-icon input-icon-right">
								<input name="password" id="password" value="<?php echo set_value('password'); ?>" type="password" class="form-control" placeholder="Password" minlength="3" required/>
								<i class="icon-lock"></i>
							</span>
						</label>

						<div class="space"></div>

						<div class="clearfix">
							<!--<td><input type="hidden" name="login_type" id="login_type" value="default" /></td>-->
							<td><input type="hidden" name="login_type" id="login_type" value="direct" /></td>
							<button type="submit" class="width-35 pull-right btn btn-sm btn-primary" onclick="this.submit();">
								<i class="icon-key"></i>
								Login
							</button>
						</div>

						<div class="space-4"></div>
					</fieldset>
				</form>
			</div><!-- /widget-main -->
		</div><!-- /widget-body -->
	</div><!-- /login-box -->
</div><!-- /position-relative -->
<div  style="height:200px;"></div>
<script type="text/javascript">
	$("#login_form").validate();
</script>
