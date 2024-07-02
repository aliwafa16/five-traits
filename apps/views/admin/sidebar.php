<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-lightblue elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo base_url('admin'); ?>" class="brand-link">
		<img src="<?php echo ASSETS_URL; ?>adminlte/img/user_favorites.png" alt="BUMN BUKU SAKU" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light"><?= NAME_APL; ?></span>
	</a>
	<?php $uri_1 = ($this->uri->segment(1)) ? $this->uri->segment(1) : 'admin'; ?>
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?php echo ASSETS_URL; ?>adminlte/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="javascript:void(0);" class="d-block"><?= ucwords($this->session->userdata('username')); ?> </a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
				<li class="nav-item">
					<a href="<?= site_url('dashboard'); ?>" class="nav-link <?= ($side_main == 'dashboard') ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<?php
				$is_admin	= $this->ion_auth->is_admin();
				if ($is_admin) {
					$trans = array('reg_account', 'company_events', 'master_variabel', 'master_dimensi', 'master_item');
					$menu_open = '';
					$active = '';
					if (in_array($side_main, $trans)) {
						$menu_open = 'menu-open';
						$active = 'active';
					}
				?>
					<li class="nav-item has-treeview <?= $menu_open; ?>">
						<a href="#" class="nav-link <?= $active; ?>">
							<i class="nav-icon fas fa-cogs"></i>
							<p>
								Master Data
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?= site_url('reg_account'); ?>" class="nav-link <?= ($side_main == 'reg_account') ? 'active' : ''; ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Registered Company</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= site_url('company_events'); ?>" class="nav-link <?= ($side_main == 'company_events') ? 'active' : ''; ?>" class="nav-link">
									<i class="far fa-circle nav-icon"></i>
									<p>Company Event</p>
								</a>
							</li>
							<?php
							$trans1 = array('master_variabel', 'master_dimensi', 'master_item');
							$menu_open1 = '';
							$active1 = '';
							if (in_array($side_main, $trans1)) {
								$menu_open1 = 'menu-open';
								$active1 = 'active';
							}
							?>
							<li class="nav-item has-treeview <?= $menu_open1; ?>">
								<a href="#" class="nav-link <?= $active1; ?>">
									<i class="far fa-circle nav-icon"></i>
									<p>
										Master Item
									</p>
									<i class="fas fa-angle-left right"></i>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?= site_url('master_variabel'); ?>" class="nav-link <?= ($side_main == 'master_variabel') ? 'active' : ''; ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Variabel</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= site_url('master_item'); ?>" class="nav-link <?= ($side_main == 'master_item') ? 'active' : ''; ?>" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Item Pernyataan</p>
										</a>
									</li>
								</ul>
							</li>


						</ul>
					</li>
				<?php

				} // end if is_admin
				$trans = array('leaders', 'gender', 'age', 'length_of_service', 'region', 'work', 'pendidikan', 'position1', 'position2', 'position3', 'position4', 'position5');
				$menu_open = '';
				$active = '';
				if (in_array($side_main, $trans)) {
					$menu_open = 'menu-open';
					$active = 'active';
				}
				?>
				<!-- <li class="nav-item has-treeview <?= $menu_open; ?>">
					<a href="#" class="nav-link <?= $active; ?>">
						<i class="nav-icon fas fa-database"></i>
						<p>
							Master Demografy
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('leaders'); ?>" class="nav-link <?= ($side_main == 'leaders') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Leaders</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('gender'); ?>" class="nav-link <?= ($side_main == 'gender') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Gender</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('age'); ?>" class="nav-link <?= ($side_main == 'age') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Age</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('length_of_service'); ?>" class="nav-link <?= ($side_main == 'length_of_service') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Length of Service</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('region'); ?>" class="nav-link <?= ($side_main == 'region') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Region</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('work'); ?>" class="nav-link <?= ($side_main == 'work') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Level of Work</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('pendidikan'); ?>" class="nav-link <?= ($side_main == 'pendidikan') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Education</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('position1'); ?>" class="nav-link <?= ($side_main == 'position1') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Level 1</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('position2'); ?>" class="nav-link <?= ($side_main == 'position2') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Level 2</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('position3'); ?>" class="nav-link <?= ($side_main == 'position3') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Level 3</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('position4'); ?>" class="nav-link <?= ($side_main == 'position4') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Level 4</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('position5'); ?>" class="nav-link <?= ($side_main == 'position5') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Level 5</p>
							</a>
						</li>
					</ul>
				</li> -->

				<li class="nav-item">
					<a href="<?= site_url('setting_account'); ?>" class="nav-link <?= ($side_main == 'position5') ? 'active' : ''; ?>">
						<i class="nav-icon text-info fa fa-id-card-alt"></i>
						<p>
							Setting Account
						</p>
					</a>
				</li>


				<?php
				$trans = array('item_account', 'setting_survey', 'trx_survey', 'reports');
				$menu_open = '';
				$active = '';
				if (in_array($side_main, $trans)) {
					$menu_open = 'menu-open';
					$active = 'active';
				}
				?>
				<li class="nav-item has-treeview <?= $menu_open; ?>">
					<a href="#" class="nav-link <?= $active; ?>">
						<i class="nav-icon fas fa-globe-asia"></i>
						<p>
							Data Survey
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('item_account'); ?>" class="nav-link <?= ($side_main == 'item_account') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Item Pernyataan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('setting_survey'); ?>" class="nav-link <?= ($side_main == 'setting_survey') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Setting</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('trx_survey'); ?>" class="nav-link <?= ($side_main == 'trx_survey') ? 'active' : ''; ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Transaksi Survey</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item">
					<a href="<?= site_url('auth/logout'); ?>" class="nav-link">
						<i class="nav-icon text-red fa fa-sign-out-alt"></i>
						<p>
							Sign Out
						</p>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>