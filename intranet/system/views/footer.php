<?php
class Footer
{
	function Footer()
	{
	}

	function PrintFooter()
	{
		$r = '<footer class="footer footer-black  footer-white ">
			<div class="container-fluid">
				<div class="row">
					<div class="credits ml-auto">
						<span class="copyright">
							©
							<script>
								document.write(new Date().getFullYear())
							</script>, made with <i class="fa fa-heart heart"></i> by <a href="https://dbusinessaqp.com/">DB Digital Business</a>
						</span>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>
</body>
	</html>';

		echo $r;
	}
}
