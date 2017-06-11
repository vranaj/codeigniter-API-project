<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:basics/sidebar.mobile.style2 -->
		<div class="well">
			<a href="#" id="department_add_link" title="Click to add new department"><span class="label label-info arrowed-in-right arrowed-in"><button  class="btn btn-info btn-sm">Add Department</button></span></a>
		</div>
                <div class="col-md-12">
                    <div>
                        <h3 class="header smaller lighter blue">Department List</h3>
                        <div class="clearfix">
                                <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header">
                                Results for "Available Department List"
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
                                    <th class="center" >Code</th>
                                    <th class="center" >Name</th>
                                    <th class="hidden-480 center" >Status</th>
                                    <th class="center" >Action</th>

                                </tr>
                            </thead>

                            <tbody class="departments_view_table">
                                
                            </tbody>
                        </table>
                    </div>
                </div>

		<div class="col-xs-12">
			
			<div id="add_departments_model" class="hide">
				
					<form class="form-horizontal info" role="form">
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="department_name"> Department Code </label>

							<div class="col-sm-9">
								<input type="text" name="department_code" id="department_code"  placeholder="Department Code" class="col-xs-10" />
							</div>
						</div>
                                            
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="department_name"> Department Name </label>

							<div class="col-sm-9">
								<input type="text" name="department_name" id="department_name"  placeholder="Department Name" class="col-xs-10" />
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
			</div><!-- #add_user_cost_centres_model -->
		</div>

		<!-- /section:basics/sidebar.mobile.style2 -->

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->





<script type="text/javascript">
jQuery(function($){
//tooltips

	$( "#department_add_link" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
	});

});
</script>

