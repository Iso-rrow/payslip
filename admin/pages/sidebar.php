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
								<i class="ki-duotone ki-element-11 fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
								</i>
							</span>
							<span class="menu-title">Dashboard</span>
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
							
							<!--begin:Menu item-->
							<div class="menu-item d-none">
								<!--begin:Menu link-->
								<a class="menu-link active" href="dashboard.html">
									<span class="menu-title">Launcher</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--begin: Employee Management-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link" href="admin?pages=employee">
							<span class="menu-bullet">
								<span class="bi bi-person-lines-fill"></span>
							</span>
							<span class="menu-title">Employees</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!-- end: Employee Management-->
					<!--begin:User-->
					<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="admin?pages=user">
						<span class="menu-bullet">
							<span class="bi bi-people"></span>
						</span>
						<span class="menu-title">User</span>
					</a>
					<!-- end:Menu link -->
					</div>
					<!--end:User-->
					<!--begin:Attendance-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link" href="#">
							<span class="menu-bullet">
								<span class="bi bi-calendar-check-fill"></span>
							</span>
							<span class="menu-title">Attendance</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end: Attendance-->
					<!--begin:Menu item-->
					<div class="menu-item pt-5">
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7">Pages</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->

					<!-- STOCK -->
					<!-- begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-address-book fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</span>
							<span class="menu-title">User Profile</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/user-profile/overview.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Overview</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/user-profile/projects.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Projects</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/user-profile/campaigns.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Campaigns</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/user-profile/documents.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Documents</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/user-profile/followers.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Followers</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/user-profile/activity.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Activity</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-element-plus fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
									<span class="path5"></span>
								</i>
							</span>
							<span class="menu-title">Account</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/overview.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Overview</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/settings.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Settings</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/security.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Security</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/activity.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Activity</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/billing.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Billing</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/statements.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Statements</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/referrals.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Referrals</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/api-keys.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">API Keys</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="account/logs.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Logs</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-user fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Authentication</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Corporate Layout</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion menu-active-bg">
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/corporate/sign-in.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-in</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/corporate/sign-up.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-up</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/corporate/two-factor.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Two-Factor</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/corporate/reset-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Reset Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/corporate/new-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">New Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Overlay Layout</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion menu-active-bg">
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/overlay/sign-in.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-in</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/overlay/sign-up.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-up</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/overlay/two-factor.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Two-Factor</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/overlay/reset-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Reset Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/overlay/new-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">New Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Creative Layout</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion menu-active-bg">
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/creative/sign-in.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-in</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/creative/sign-up.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-up</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/creative/two-factor.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Two-Factor</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/creative/reset-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Reset Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/creative/new-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">New Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Fancy Layout</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion menu-active-bg">
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/fancy/sign-in.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-in</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/fancy/sign-up.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Sign-up</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/fancy/two-factor.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Two-Factor</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/fancy/reset-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Reset Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/layouts/fancy/new-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">New Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Email Templates</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion menu-active-bg">
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/email/welcome-message.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Welcome Message</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/email/reset-password.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Reset Password</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/email/subscription-confirmed.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Subscription Confirmed</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/email/card-declined.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Credit Card Declined</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/email/promo-1.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Promo 1</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/email/promo-2.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Promo 2</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="authentication/email/promo-3.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Promo 3</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/extended/multi-steps-sign-up.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Multi-steps Sign-up</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/general/welcome.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Welcome Message</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/general/verify-email.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Verify Email</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/general/coming-soon.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Coming Soon</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/general/password-confirmation.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Password Confirmation</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/general/account-deactivated.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Account Deactivation</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/general/error-404.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Error 404</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="authentication/general/error-500.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Error 500</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
						class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-file fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Corporate</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div
							class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-2 py-4 w-200px mh-75 overflow-auto">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/about.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">About</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/team.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Our Team</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/contact.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Contact Us</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/licenses.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Licenses</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/sitemap.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Sitemap</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-abstract-39 fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Social</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/social/feeds.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Feeds</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/social/activity.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Activty</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/social/followers.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Followers</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/social/settings.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Settings</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-bank fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Blog</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion menu-active-bg">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/blog/home.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Blog Home</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/blog/post.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Blog Post</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-chart-pie-3 fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</span>
							<span class="menu-title">FAQ</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion menu-active-bg">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/faq/classic.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">FAQ Classic</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/faq/extended.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">FAQ Extended</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-bucket fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
								</i>
							</span>
							<span class="menu-title">Pricing</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion menu-active-bg">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/pricing.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Column Pricing</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/pricing/table.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Table Pricing</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-call fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
									<span class="path5"></span>
									<span class="path6"></span>
									<span class="path7"></span>
									<span class="path8"></span>
								</i>
							</span>
							<span class="menu-title">Careers</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/careers/list.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Careers List</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="pages/careers/apply.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Careers Apply</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-color-swatch fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
									<span class="path5"></span>
									<span class="path6"></span>
									<span class="path7"></span>
									<span class="path8"></span>
									<span class="path9"></span>
									<span class="path10"></span>
									<span class="path11"></span>
									<span class="path12"></span>
									<span class="path13"></span>
									<span class="path14"></span>
									<span class="path15"></span>
									<span class="path16"></span>
									<span class="path17"></span>
									<span class="path18"></span>
									<span class="path19"></span>
									<span class="path20"></span>
									<span class="path21"></span>
								</i>
							</span>
							<span class="menu-title">Utilities</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Modals</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion">
									<!--begin:Menu item-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">General</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/general/invite-friends.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Invite Friends</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/general/view-users.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">View Users</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/general/select-users.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Select Users</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/general/upgrade-plan.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Upgrade Plan</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/general/share-earn.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Share & Earn</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Forms</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/forms/new-target.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">New Target</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/forms/new-card.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">New Card</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/forms/new-address.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">New Address</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/forms/create-api-key.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Create API Key</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/forms/bidding.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Bidding</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Wizards</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/wizards/create-app.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Create App</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/wizards/create-campaign.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Create Campaign</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/wizards/create-account.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Create Business Acc</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/wizards/create-project.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Create Project</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/wizards/top-up-wallet.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Top Up Wallet</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/wizards/offer-a-deal.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Offer a Deal</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link"
													href="utilities/modals/wizards/two-factor-authentication.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Two Factor Auth</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
										<!--begin:Menu link-->
										<span class="menu-link">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Search</span>
											<span class="menu-arrow"></span>
										</span>
										<!--end:Menu link-->
										<!--begin:Menu sub-->
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/search/users.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Users</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="utilities/modals/search/select-location.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Select Location</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
										</div>
										<!--end:Menu sub-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Search</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion">
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/search/horizontal.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Horizontal</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/search/vertical.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Vertical</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/search/users.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Users</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/search/select-location.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Location</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Wizards</span>
									<span class="menu-arrow"></span>
								</span>
								<!--end:Menu link-->
								<!--begin:Menu sub-->
								<div class="menu-sub menu-sub-accordion">
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/horizontal.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Horizontal</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/vertical.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Vertical</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/two-factor-authentication.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Two Factor Auth</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/create-app.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Create App</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/create-campaign.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Create Campaign</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/create-account.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Create Account</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/create-project.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Create Project</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/modals/wizards/top-up-wallet.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Top Up Wallet</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
									<!--begin:Menu item-->
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link" href="utilities/wizards/offer-a-deal.html">
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">Offer a Deal</span>
										</a>
										<!--end:Menu link-->
									</div>
									<!--end:Menu item-->
								</div>
								<!--end:Menu sub-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<i class="ki-duotone ki-element-7 fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Widgets</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="widgets/lists.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Lists</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="widgets/statistics.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Statistics</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="widgets/charts.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Charts</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="widgets/mixed.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Mixed</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="widgets/tables.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Tables</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="widgets/feeds.html">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Feeds</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item -->
					<!-- STOCK -->


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
							<a href="/h_r_3/authentication/logout.php" class="menu-link px-5">Sign Out</a>
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