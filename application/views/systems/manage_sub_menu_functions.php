<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:basics/sidebar.mobile.style2 -->
		<div class="well">
			<a href="#" id="sub_menu_func_add_link" title="Click to add new sub menu function"><span class="label label-info arrowed-in-right arrowed-in"><button  class="btn btn-info btn-sm">Add Sub Menu Function</button></span></a>
		</div>
                <div class="col-md-12">
                    <div>
                        <h3 class="header smaller lighter blue">Sub Menu Functions</h3>
                        
                        <div class="clearfix">
                                <div class="pull-right tableTools-container"></div>
                        </div>
                        
                        <div class="table-header">
                                Results for "Available Sub Menus Functions"
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
                                    <th>Sub Menu Function</th>
                                    <th class="hidden-480">Sub Menu</th>
                                    <th class="hidden-480">Module</th>
                                    <th class="hidden-480">Status</th>
                                    <th class="">Action</th>

                                </tr>
                            </thead>

                            <tbody class="function_view_table">

                            </tbody>
                        </table>
                    </div>
                </div>

		<div class="col-xs-12">
			
			<div id="add_sub_menu_func_model" class="hide">
				
					<form class="form-horizontal info" role="form">
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="func_name"> Function Name </label>

							<div class="col-sm-9">
								<input type="text" name="func_name" id="func_name"  placeholder="Function Name" class="col-xs-10" />
							</div>
						</div>
						
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="sub_menu_id"> Sub Menu </label>

							<div class="col-sm-9">
								<select class="col-md-10" name="sub_menu_id" id="sub_menu_id">
                                                                        <?php foreach($sub_menus as $row){ ?>
                                                                            <option value="<?php echo $row['sub_menu_id'];?>"><?php echo $row['sub_menu_name'];?></option>
                                                                        <?php } ?>
									
								</select>
							</div>
						</div>
                                            
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="func_module"> Function Module </label>

							<div class="col-sm-9">
								<select class="col-md-10" name="func_module" id="func_module">
                                                                        <?php foreach($modules as $row){ ?>
                                                                            <option value="<?php echo $row['id'];?>"><?php echo $row['description'];?></option>
                                                                        <?php } ?>
									
								</select>
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
			</div><!-- #add_sub_menu_func_model -->
		</div>

		<!-- /section:basics/sidebar.mobile.style2 -->

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->





<script type="text/javascript">
jQuery(function($){
//tooltips

	$( "#sub_menu_func_add_link" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
	});

});
</script>

