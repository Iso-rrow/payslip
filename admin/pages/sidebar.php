	<div id="kt_aside" class="aside py-9" data-kt-drawer="true" data-kt-drawer-name="aside"
		data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
		data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
		data-kt-drawer-toggle="#kt_aside_toggle">
		<!--begin::Aside menu-->
		<div class="aside-menu flex-column-fluid ps-5 pe-3 mb-7" id="kt_aside_menu">
			<!--begin::Aside Menu-->
			<div class="w-100 hover-scroll-y d-flex pe-2" id="kt_aside_menu_wrapper" data-kt-scroll="true"
				data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
				data-kt-scroll-dependencies="#kt_aside_footer, #kt_header"
				data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="102">
				<!--begin::Menu-->
				<div class="menu menu-column menu-rounded menu-sub-indention menu-active-bg fw-semibold my-auto"
					id="#kt_aside_menu" data-kt-menu="true">
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-element-11 fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
								</i>
							</span>
							<span class="menu-title">Dashboards</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="#">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Dashboard</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<div class="menu-inner flex-column collapse" id="kt_app_sidebar_menu_dashboards_collapse">
							</div>
							<!-- <div class="menu-item">
								<div class="menu-content">
									<a class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 toggle collapsible collapsed" data-bs-toggle="collapse" href="#kt_app_sidebar_menu_dashboards_collapse" data-kt-toggle-text="Show Less">
										<span data-kt-toggle-text-target="true">Show More</span>
										<i class="ki-duotone ki-minus-square toggle-on fs-2 me-0">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<i class="ki-duotone ki-plus-square toggle-off fs-2 me-0">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</a>
								</div>
							</div> -->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--begin:Employee Management-->
					<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-address-book fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</span>
							<span class="menu-title">Employee Management</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin: Menu-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin: Departments-->
							<div class="menu-item">
								<!--begin:All Employees-->
								<a class="menu-link" href="admin?pages=employee">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">All</span>
								</a>
								<!--end:All Employees-->
								<!--begin:Accounting-->
								<a class="menu-link" href="admin?pages=employee">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Accounting Department</span>
								</a>
								<!--end:Accounting-->
								<!-- begin: HR -->
								<a class="menu-link" href="">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">HR Department</span>
								</a>
								<!-- end: HR -->
								<!-- begin: IT -->
								<a class="menu-link" href="">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">IT Department</span>
								</a>
								<!-- end: IT -->
								<!-- begin: Sales -->
								<a class="menu-link" href="">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Sales Department</span>
								</a>
								<!-- end: Sales -->
								<!-- begin: Operation -->
								<a class="menu-link" href="">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Operation Department</span>
								</a>
								<!-- end: Operation -->
							</div>
							<!--end: Departments-->
							<!-- begin: Show more -->
							<!-- <div class="menu-inner flex-column collapse" id="kt_app_sidebar_menu_dashboards_collapse">
							</div>
							<div class="menu-item">
								<div class="menu-content">
									<a class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 toggle collapsible collapsed" data-bs-toggle="collapse" href="#kt_app_sidebar_menu_dashboards_collapse" data-kt-toggle-text="Show Less">
										<span data-kt-toggle-text-target="true">Show More</span>
										<i class="ki-duotone ki-minus-square toggle-on fs-2 me-0">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<i class="ki-duotone ki-plus-square toggle-off fs-2 me-0">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</a>
								</div>
							</div> -->
							<!-- end: Show more -->
						</div>
						<!--begin: Menu-->
					</div>
					<!--end:Employee Management-->
					<!-- begin: Attendance Management -->
					<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-time fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</span>
						
							<span class="menu-title">Attendance</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin: Departments-->
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<!--begin:All Employees-->
								<a class="menu-link" href="admin?pages=attendance">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">All</span>
								</a>
								<!--end:All Employees-->
							</div>
						</div>
						<!--begin: Departments-->
					</div>
					<!-- end: Attendance Management -->
					<!-- begin: Request Management -->
					<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-message-question fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</span>
							<span class="menu-title">File Request</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin: Departments-->
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<!--begin:All Employees-->
								<a class="menu-link" href="admin?pages=request">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">All</span>
								</a>
								<!--end:All Employees-->
							</div>
						</div>
						<!--begin: Departments-->
					</div>
					<!-- end: Request Management -->
					<!-- begin: Reports Management -->
					<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-information-3 fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</span>
							<span class="menu-title">Reports</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin: Departments-->
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<!--begin:All Employees-->
								<a class="menu-link" href="#">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">All</span>
								</a>
								<!--end:All Employees-->
							</div>
						</div>
						<!--begin: Departments-->
					</div>
					<!-- end: Reports Management -->
					 <!-- begin: ApplicationManagement -->
					<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-file-added fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Applications</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin: Departments-->
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<!--begin:All Employees-->
								<a class="menu-link" href="#">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">All</span>
								</a>
								<!--end:All Employees-->
							</div>
						</div>
						<!--begin: Departments-->
					</div>
					<!-- end: Application Management -->
					<!--begin:Menu item-->
					<div class="menu-item pt-5">
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7">Settings</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!-- begin: User Management -->
					<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-profile-user fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
								</i>
							</span>
							<span class="menu-title">Account Management</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin: Departments-->
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<!--begin:All Employees-->
								<a class="menu-link" href="admin?pages=user">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">All</span>
								</a>
								<!--end:All Employees-->
							</div>
						</div>
						<!--begin: Departments-->
					</div>
					<!-- end: User Management -->
					<!--end:Menu item-->
					<!-- begin: Department and Roles-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!-- Other Menu -->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-pointers fs-1">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</span>
							<span class="menu-title">Department and Roles</span>
							<span class="menu-arrow"></span>
						</span>
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link" href="admin?pages=department">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Add New</span>
								</a>
								<!-- <a class="menu-link" href="">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Roles</span>
								</a> -->
							</div>
						</div>
					</div>
					<!-- End of Accordion -->
				</div>
				<!--end::Menu-->
			</div>
			<!--end::Aside Menu-->
		</div>
		<!--end::Aside menu-->
		<!--begin::Footer-->
		<div class="aside-footer flex-column-auto px-9" id="kt_aside_menu">
			<!--begin::User panel-->
			<div class="d-flex flex-stack">
				<!--begin::Wrapper-->
				<div class="d-flex align-items-center">
					<!--begin::Avatar-->
					<div class="symbol symbol-circle symbol-40px">
						<img src="assets/images/profile.png" alt="photo" />
					</div>
					<!--end::Avatar-->
					<!--begin::User info-->
					<div class="ms-2">
						<!--begin::Name-->
						<a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold lh-1">Admin</a>
						<!--end::Name-->
						<!--begin::Major-->
						<span class="text-muted fw-semibold d-block fs-7 lh-1">Human Resource</span>
						<!--end::Major-->
					</div>
					<!--end::User info-->
				</div>
				<!--end::Wrapper-->
				<!--begin::User menu-->
				<div class="ms-1">
					<div class="btn btn-sm btn-icon btn-active-color-primary position-relative me-n2"
						data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-end">
						<i class="ki-duotone ki-setting-2 fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</div>
					<!--begin::User account menu-->
					<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
						data-kt-menu="true">
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<div class="menu-content d-flex align-items-center px-3">
								<!--begin::Avatar-->
								<div class="symbol symbol-50px me-5">
									<img alt="Logo" src="assets/media/avatars/300-1.jpg" />
								</div>
								<!--end::Avatar-->
								<!--begin::Username-->
								<div class="d-flex flex-column">
									<div class="fw-bold d-flex align-items-center fs-5">Max Smith
										<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
									</div>
									<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">max@kt.com</a>
								</div>
								<!--end::Username-->
							</div>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu separator-->
						<div class="separator my-2"></div>
						<!--end::Menu separator-->
						<!--begin::Menu item-->
						<div class="menu-item px-5">
							<a href="account/overview.html" class="menu-link px-5">My Profile</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-5">
							<a href="apps/projects/list.html" class="menu-link px-5">
								<span class="menu-text">My Projects</span>
								<span class="menu-badge">
									<span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
								</span>
							</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
							data-kt-menu-placement="right-end" data-kt-menu-offset="-15px, 0">
							<a href="#" class="menu-link px-5">
								<span class="menu-title">My Subscription</span>
								<span class="menu-arrow"></span>
							</a>
							<!--begin::Menu sub-->
							<div class="menu-sub menu-sub-dropdown w-175px py-4">
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="account/referrals.html" class="menu-link px-5">Referrals</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="account/billing.html" class="menu-link px-5">Billing</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="account/statements.html" class="menu-link px-5">Payments</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="account/statements.html" class="menu-link d-flex flex-stack px-5">Statements
										<span class="ms-2 lh-0" data-bs-toggle="tooltip" title="View your statements">
											<i class="ki-duotone ki-information-5 fs-5">
												<span class="path1"></span>
												<span class="path2"></span>
												<span class="path3"></span>
											</i>
										</span></a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu separator-->
								<div class="separator my-2"></div>
								<!--end::Menu separator-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<div class="menu-content px-3">
										<label class="form-check form-switch form-check-custom form-check-solid">
											<input class="form-check-input w-30px h-20px" type="checkbox" value="1"
												checked="checked" name="notifications" />
											<span class="form-check-label text-muted fs-7">Notifications</span>
										</label>
									</div>
								</div>
								<!--end::Menu item-->
							</div>
							<!--end::Menu sub-->
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-5">
							<a href="account/statements.html" class="menu-link px-5">My Statements</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu separator-->
						<div class="separator my-2"></div>
						<!--end::Menu separator-->

						<!--begin::Menu item-->
						<div class="menu-item px-5 my-1">
							<a href="account/settings.html" class="menu-link px-5">Account Settings</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-5">
							<a href="/payslip/authentication/logout.php" class="menu-link px-5">Sign Out</a>
						</div>
						<!--end::Menu item-->
					</div>
					<!--end::User account menu-->
				</div>
				<!--end::User menu-->
			</div>
			<!--end::User panel-->
		</div>
		<!--end::Footer-->
	</div>