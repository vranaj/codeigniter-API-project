<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:basics/sidebar.mobile.style2 -->
		<div class="well">
			<a href="#" id="rights_add_link" title="Click to edit new rights"><span class="label label-info arrowed-in-right arrowed-in"><button  class="btn btn-info btn-sm">Edit Rights</button></span></a>
		</div>
                
                <div class="col-md-12">
                    <h4 class="maller">List of Assign User Rights</h4>
                    <div class="col-xs-12 col-sm-12 pricing-span-body" id="widget">
                        

                    </div>

                    <!-- /section:pages/pricing.small-body -->
                </div>

		<div class="col-xs-12">
			
			<div id="add_rights_model" class="hide">
                                        <div id="wait" style="display:none;width:100px;height:100px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url('assets\images\ring.gif')?>' width="64" height="64" /><br>Loading....</div>
                                                
					<form class="form-horizontal info" role="form">
						
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="role_id"> User Role </label>

							<div class="col-sm-9">
								<select class="col-md-10" name="role_id" id="role_id">
                                                                        <?php foreach($user_roles as $row){ ?>
                                                                            <option value="<?php echo $row['role_id'];?>"><?php echo $row['role_name'];?></option>
                                                                        <?php } ?>
									
								</select>
							</div>
						</div>
                                                <div class="col-md-12 rights_list margin_top_50">

                                                </div>
                                                

                                                    
						
						
					</form>
				<div class="space-6"></div>

				
			</div><!-- #add_user_role_model -->
		</div>
                
                
		<!-- /section:basics/sidebar.mobile.style2 -->

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->





<script type="text/javascript">
jQuery(function($){
//tooltips

	$( "#rights_add_link" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
	});

});
</script>

