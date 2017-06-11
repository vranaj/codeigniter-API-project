<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:basics/sidebar.mobile.style2 -->
		<div class="well">
			<a href="#" id="menu_add_link" title="Click to add new menu item"><span class="label label-info arrowed-in-right arrowed-in"><button  class="btn btn-info btn-sm">Add Menu</button></span></a>
		</div>
                <div class="col-md-12">
                    
                    <div>
                        <h3 class="header smaller lighter blue">Menu List</h3>

                        <div class="clearfix">
                                <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header">
                                Results for "Available Menus List"
                        </div>
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover responsive">
                            <thead>
                                <tr>
                                    <!--<th class="center">
                                            <label class="pos-rel">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                            </label>
                                    </th>-->
                                    <th>Menu </th>
                                    <th class="hidden-480">Controller Name</th>
                                    <th class="hidden-480">Display Order</th>

                                    <th class="hidden-480">
                                            <i class="ace-icon fa fa-cogs bigger-110 hidden-480"></i>
                                            Icon
                                    </th>
                                    <th class="hidden-480">Status</th>
                                    <th class="">Action</th>

                                </tr>
                            </thead>

                            <tbody class="menu_view_table">

                            </tbody>
                        </table>
                    </div>
                </div>

		<div class="col-xs-12">
			
			<div id="add_menu_model" class="hide">
                                        <div id="wait" style="display:none;width:100px;height:100px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url('assets\images\ring.gif')?>' width="64" height="64" /><br>Loading....</div>
                                        
					<form class="form-horizontal info" role="form">
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="menu_name"> Menu Name </label>

							<div class="col-sm-9">
								<input type="text" name="menu_name" id="menu_name"  placeholder="Menu Name" class="col-xs-10" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="controller_name"> Controller Name </label>

							<div class="col-sm-9">
								<input type="text" name="controller_name" id="controller_name" placeholder="Controller Name" class="col-xs-10" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="icon_name"> Icon Name </label>

							<div class="col-sm-9">
								<input type="text" name="icon_name" id="icon_name" placeholder="Icon Name" class="col-xs-10" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="display_order"> Display Order </label>

							<div class="col-sm-9">
								<input type="number" name="display_order" id="display_order" placeholder="Display Order" class="col-xs-5" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="is_active"> Status </label>

							<div class="col-sm-9">
								<select class="col-md-5" name="is_active" id="is_active">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
						
						
					</form>
				<div class="space-6"></div>

				<p class="bigger-110 bolder center grey">
					<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
					Are you sure?
				</p>
			</div><!-- #add_menu_model -->
		</div>

		<!-- /section:basics/sidebar.mobile.style2 -->

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->





<script type="text/javascript">
jQuery(function($){
//tooltips

	$( "#menu_add_link" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
	});

});
</script>

