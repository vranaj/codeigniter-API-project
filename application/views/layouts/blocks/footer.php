					
</div>
                            <div class="col-md-12 center clearfix">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<div id="status_bar">
							<p>Copyright &copy; vranjan - <?php echo $site_name ?></a>. All Rights Reserved - Page rendered in {elapsed_time} seconds using {memory_usage} | Solution by <a href="http://www.vmuresh.com/me" target="_blank">vmk (pvt) Ltd</a></p>
						</div>
						<!--<span class="bigger-120">
							<span class="blue bolder">Ace</span>
							Application &copy; 2013-2014
						</span>-->
							
						&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		
		<?php
		//Load Javascripts
		echo $this->template->block('js', 'layouts/blocks/js');
		?>
		
		
	</body>
</html>

<script type="text/javascript">
//To hide the message box - start
	setTimeout(function(){
		$('.notification').hide();
	}, 1500);
	$('.notification').click(function(){
		$('.notification').hide();
	});
	
//To hide the message box - end
</script>

