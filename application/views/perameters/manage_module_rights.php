<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:basics/sidebar.mobile.style2 -->
		<div class="well1 col-md-12 col-sm-12 col-xs-12">
                    
                        <div class="pull-right col-md-12 col-xs-12 col-sm-12">
                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="user_id"> User </label>

                                                            <div class="col-sm-8">
                                                                    <select class="col-md-11 chosen-select form-control" name="user_id" id="user_id" data-placeholder="Choose a user name...">
                                                                            <?php foreach($users as $row){ ?>
                                                                                <option value="<?php echo $row['user_id'];?>"><?php echo $row['user_name'];?></option>
                                                                            <?php } ?>

                                                                    </select>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="submenu_id"> Sub Menu</label>

                                                            <div class="col-sm-8">
                                                                    <select class="col-md-11 chosen-select form-control" name="submenu_id" id="submenu_id" data-placeholder="Choose a sub menu...">
                                                                            <option value="">View All</option>
                                                                            <?php foreach($sub_menus as $row){ ?>
                                                                                <option value="<?php echo $row['sub_menu_id'];?>"><?php echo $row['sub_menu_name'];?></option>
                                                                            <?php } ?>

                                                                    </select>
                                                            </div>
                                                    </div>
                                                </div>
                                

                                
                        
                        </div>
                </div>
                

		<div class="col-xs-12">
			<div class="col-md-12 clearfix">
                            <h4 class="maller">List of Assigned Functional Rights</h4>
                            <div class="col-xs-12 col-sm-12 pricing-span-body" id="widget">
                                

                            </div>
                        </div>
			
		</div>

		<!-- /section:basics/sidebar.mobile.style2 -->

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->





<script type="text/javascript">
jQuery(function($){
//tooltips

	$( "#user_func_rights_link" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
	});

});
</script>

