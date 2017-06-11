<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:basics/sidebar.mobile.style2 -->
		<div class="well">
			<a href="#" id="user_add_link" title="Click to add new user"><span class="label label-info arrowed-in-right arrowed-in"><button  class="btn btn-info btn-sm">Add User</button></span></a>
		</div>
                <div class="col-md-12">
                    <div>
                        <h3 class="header smaller lighter blue">Users List</h3>
                        <div class="clearfix">
                                <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header">
                                Results for "Available Users List"
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
                                    <th>User ID </th>
                                    <th class="hidden-480 " >User Name</th>
                                    <th class="hidden-480 " >E-Mail</th>
                                    <th class="hidden-480 " >Supervisor</th>
                                    <th class="hidden-480 center" >Status</th>
                                    <th class="center" >Action</th>

                                </tr>
                            </thead>

                            <tbody class="users_view_table">
                                
                            </tbody>
                        </table>
                    </div>
                </div>

		<div class="col-xs-12">
			
			<div id="add_user_model" class="hide">
                            <div id="wait" style="display:none;width:100px;height:100px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url('assets\images\ring.gif')?>' width="64" height="64" /><br>Loading....</div>
                                        	
                            <form class="form-horizontal info" role="form" style="padding-top:50px;">
                                            <div class="col-md-6">
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="user_id"> User ID </label>

							<div class="col-sm-9">
								<input type="text" name="user_id" id="user_id"  placeholder="User ID" class="col-xs-10" />
							</div>
						</div>
                                            
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="user_name"> User Name </label>

							<div class="col-sm-9">
								<input type="text" name="user_name" id="user_name"  placeholder="User Name" class="col-xs-10" />
							</div>
						</div>
                                            
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="user_password"> User Password </label>

							<div class="col-sm-9">
								<input type="password" name="user_password" id="user_password"  placeholder="User Password" class="col-xs-10" />
							</div>
						</div>
                                            
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="user_email"> User E-Mail </label>

							<div class="col-sm-9">
								<input type="text" name="user_email" id="user_email"  placeholder="User Email" class="col-xs-10" />
							</div>
						</div>
                                            
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="costcentre"> Cost Centres </label>

							<div class="col-sm-9">
                                                            <select class="col-md-11 chosen-select form-control" title="First one is always primary" multiple="multiple" name="costcentre" id="costcentre" data-placeholder="Choose the cost centre/s..." >
                                                                    <?php foreach($costcentre as $row){ ?>
                                                                        <option value="<?php echo $row['code'];?>"><?php echo $row['description'];?></option>
                                                                    <?php } ?>
                                                            </select>
							</div>
						</div>
                                            
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="designation"> Designations </label>

							<div class="col-sm-9">
                                                            <select class="col-md-11 chosen-select form-control" title="First one is always primary"  multiple="multiple" name="designation" id="designation" data-placeholder="Choose the designation/s..." >
                                                                    <?php foreach($designation as $row){ ?>
                                                                        <option value="<?php echo $row['id'];?>"><?php echo $row['description'];?></option>
                                                                    <?php } ?>
                                                            </select>
							</div>
						</div>
						
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="department"> Department </label>

							<div class="col-sm-9">
                                                            <select class="col-md-11 chosen-select form-control" title="First one is always primary"  multiple="multiple" name="department" id="department" data-placeholder="Choose a Department..." >
                                                                    <?php foreach($departments as $row){ ?>
                                                                        <option value="<?php echo $row['code'];?>"><?php echo $row['description'];?></option>
                                                                    <?php } ?>
                                                            </select>
							</div>
						</div>
                                                
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="supervisor"> Supervisor </label>

							<div class="col-sm-9">
                                                            <select class="col-md-11 chosen-select form-control" name="supervisor" id="supervisor" data-placeholder="Choose a user name..." >
                                                                    <?php foreach($users_list as $row){ ?>
                                                                        <option value="<?php echo $row['user_id'];?>"><?php echo $row['user_name'];?></option>
                                                                    <?php } ?>
                                                            </select>
							</div>
						</div>
                                                
                                                
                                                <div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="user_role"> Role </label>

							<div class="col-sm-9">
                                                            <select class="col-md-11 chosen-select form-control" title="First one is always primary"  multiple="multiple" name="user_role" id="user_role" data-placeholder="Choose the role..." >
                                                                    <?php foreach($roles as $row){ ?>
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
                                            
                                                <div class="form-group hide">
							<label class="col-sm-3 control-label no-padding-right" for="id"> ID </label>

							<div class="col-sm-9">
								<input type="text" name="id" id="id"  placeholder="User Email" class="col-xs-10" />
							</div>
						</div>
						
                                            </div>
                                                
						
					</form>
                            
				<div class="space-6"></div>
                                <div class="col-md-12"><p class="bigger-110 bolder center grey">
					<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
					Are you sure?
				</p>
                                </div>

				
			</div><!-- #add_user_model -->
                        
		</div>

		<!-- /section:basics/sidebar.mobile.style2 -->

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->





<script type="text/javascript">
jQuery(function($){
//tooltips

	$( "#user_role_add_link" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
	});
        
        $( "#costcentre" ).tooltip({ hide: { effect: "explode", delay: 250 }});

});
</script>

