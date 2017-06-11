<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:basics/sidebar.mobile.style2 -->
		<div class="well1 col-md-12 col-sm-12 col-xs-12">
                    <a href="#" id="user_func_rights_link"  title="Click to add new functional right"><span style="margin-bottom: 20px;" class="label label-info arrowed-in-right arrowed-in"><button  class="btn btn-info btn-sm">Edit Functional Right</button></span></a>
                        
                        <div class="pull-right col-md-9 col-xs-12 col-sm-12">
                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="user_id"> User </label>

                                                            <div class="col-sm-8">
                                                                    <select class="col-md-11 chosen-select form-control" name="user_id_view" id="user_id_view" data-placeholder="Choose a user name...">
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
                                                                    <select class="col-md-11 chosen-select form-control" name="submenu_id_view" id="submenu_id_view" data-placeholder="Choose a sub menu...">
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
			<div id="add_func_rights_model" class="hide">
                                        <div id="wait" style="display:none;width:100px;height:100px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url('assets\images\ring.gif')?>' width="64" height="64" /><br>Loading....</div>
                                        
					<form class="form-horizontal info" role="form">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label class="col-sm-2 control-label no-padding-right" for="user_id"> User </label>

                                                            <div class="col-sm-8">
                                                                    <select class="col-md-11" name="user_id" id="user_id">
                                                                            <?php foreach($users as $row){ ?>
                                                                                <option value="<?php echo $row['user_id'];?>"><?php echo $row['user_name'];?></option>
                                                                            <?php } ?>

                                                                    </select>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label class="col-sm-2 control-label no-padding-right" for="submenu_id"> Sub Menu</label>

                                                            <div class="col-sm-8">
                                                                    <select class="col-md-11" name="submenu_id" id="submenu_id">
                                                                            <?php foreach($sub_menus as $row){ ?>
                                                                                <option value="<?php echo $row['sub_menu_id'];?>"><?php echo $row['sub_menu_name'];?></option>
                                                                            <?php } ?>

                                                                    </select>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 rights_list margin_top_50">
                                                
                                            </div>
                                            
                                            
						
					</form>
				<div class="space-6 "></div>

				<!--<p class="bigger-110 bolder center grey">
					<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
					Are you sure?
				</p>-->
			</div><!-- #add_func_rights_model -->
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

