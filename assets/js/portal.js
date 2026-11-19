lucide.createIcons();

    let currentFlyoutId = null;

    function closeCollapsedFlyout() {
      const flyout = document.getElementById('sidebar-collapsed-flyout');
      if (flyout) {
        flyout.style.display = 'none';
      }
      currentFlyoutId = null;
    }
    window.closeCollapsedFlyout = closeCollapsedFlyout;

    function toggleCollapsedFlyout(menuItem) {
      let flyout = document.getElementById('sidebar-collapsed-flyout');
      if (!flyout) {
        flyout = document.createElement('div');
        flyout.id = 'sidebar-collapsed-flyout';
        flyout.className = 'sidebar-flyout-card';
        flyout.addEventListener('click', function(e) {
          e.stopPropagation();
        });
        document.body.appendChild(flyout);
      }

      // If already open for this menuItem, toggle close
      if (currentFlyoutId === menuItem.id && flyout.style.display !== 'none') {
        closeCollapsedFlyout();
        return;
      }

      currentFlyoutId = menuItem.id;

      // Extract title and sub-items
      const titleSpan = menuItem.querySelector('.menu-link-left span');
      const titleText = titleSpan ? titleSpan.innerText.trim() : 'Menu';
      const subUl = menuItem.querySelector('.submenu-list');
      if (!subUl) return;

      // Clone items and attach click handlers
      let listHtml = '';
      subUl.querySelectorAll('li').forEach(li => {
        const a = li.querySelector('a');
        if (a) {
          const onclickAttr = a.getAttribute('onclick') || '';
          const text = a.innerText.trim();
          const isActive = li.classList.contains('active-sub') ? ' class="active-sub"' : '';
          listHtml += `<li${isActive}><a href="javascript:void(0);" onclick="${onclickAttr}; closeCollapsedFlyout();">${text}</a></li>`;
        }
      });

      flyout.innerHTML = `
        <div class="flyout-header">
          <span class="flyout-title">${titleText}</span>
          <button type="button" class="flyout-close-btn" onclick="closeCollapsedFlyout()" aria-label="Close menu">&times;</button>
        </div>
        <ul class="flyout-menu-list">
          ${listHtml}
        </ul>
      `;

      flyout.style.display = 'block';

      // Position next to menuItem
      const rect = menuItem.getBoundingClientRect();
      const flyoutHeight = flyout.offsetHeight || 160;
      let topPos = rect.top;
      if (topPos + flyoutHeight > window.innerHeight - 20) {
        topPos = window.innerHeight - flyoutHeight - 20;
      }
      if (topPos < 60) topPos = 60;

      flyout.style.left = (rect.right + 6) + 'px';
      flyout.style.top = topPos + 'px';
    }

    function toggleMenu(id, event) {
      if (event) {
        event.preventDefault();
        event.stopPropagation();
      }
      const sidebar = document.getElementById('mainPortalSidebar');
      const menuItem = document.getElementById(id);
      if (!menuItem) return;

      if (sidebar && sidebar.classList.contains('collapsed')) {
        // Hide hover tooltip wording immediately
        if (window.hideSidebarPopover) window.hideSidebarPopover();
        // Open/toggle floating flyout popover next to clicked icon
        toggleCollapsedFlyout(menuItem);
      } else {
        // Normal accordion toggle in expanded sidebar mode
        menuItem.classList.toggle('open');
        closeCollapsedFlyout();
      }
    }

    // Switch Level 1 Category (In Country vs International)
    function switchAllowanceCategory(cat) {
      document.getElementById('btn-cat-incountry').classList.remove('active');
      document.getElementById('btn-cat-international').classList.remove('active');
      document.getElementById('pane-incountry').classList.remove('active-pane');
      document.getElementById('pane-international').classList.remove('active-pane');

      if (cat === 'incountry') {
        document.getElementById('btn-cat-incountry').classList.add('active');
        document.getElementById('pane-incountry').classList.add('active-pane');
      } else if (cat === 'international') {
        document.getElementById('btn-cat-international').classList.add('active');
        document.getElementById('pane-international').classList.add('active-pane');
      }
      lucide.createIcons();
    }

    // Switch Sub-Nav inside International (Pre-Departure vs Return)
    function switchIntlSubNav(sub) {
      document.getElementById('btn-sub-predep').classList.remove('active');
      document.getElementById('btn-sub-return').classList.remove('active');
      document.getElementById('subpane-predep').classList.remove('active-sub-pane');
      document.getElementById('subpane-return').classList.remove('active-sub-pane');

      if (sub === 'predep') {
        document.getElementById('btn-sub-predep').classList.add('active');
        document.getElementById('subpane-predep').classList.add('active-sub-pane');
      } else if (sub === 'return') {
        document.getElementById('btn-sub-return').classList.add('active');
        document.getElementById('subpane-return').classList.add('active-sub-pane');
      }
      lucide.createIcons();
    }

    // Auto-fill bank details when bank dropdown is selected
    const bankDetailsDatabase = {
      bca: {
        bankName: "BCA",
        bankAddress: "Jl. Jend. Sudirman No.Kav.47, Karet Semanggi, Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12930",
        beneficiary: "Kartika Rini",
        accountNumber: "1234567890B",
        routing: "Rout num",
        swift: "swiftco345",
        currency: "IDR"
      }
    };

    function onBankDropdownChange(stage) {
      const select = document.getElementById(`select-bank-${stage}`);
      const val = select.value;
      const isSelected = val === "bca";
      const data = isSelected ? bankDetailsDatabase.bca : { bankName: "", bankAddress: "", beneficiary: "", accountNumber: "", routing: "", swift: "", currency: "" };

      document.getElementById(`${stage}-bank-name`).value = data.bankName;
      document.getElementById(`${stage}-beneficiary`).value = data.beneficiary;
      document.getElementById(`${stage}-account-num`).value = data.accountNumber;
      document.getElementById(`${stage}-routing`).value = data.routing;
      document.getElementById(`${stage}-swift`).value = data.swift;
      document.getElementById(`${stage}-currency`).value = data.currency;
      document.getElementById(`${stage}-bank-address`).value = data.bankAddress;

      const docWrapper = document.getElementById(`${stage}-bank-doc-wrap`);
      if (isSelected) {
        docWrapper.innerHTML = `
          <a href="javascript:void(0);" onclick="alert('Viewing buku-tabungan-bca-kartika.pdf...')" class="file-link-blue">buku-tabungan-bca-kartika.pdf</a>
        `;
      } else {
        docWrapper.innerHTML = `<span style="color: #94a3b8; font-size: 13px; font-style: italic;">-- No document attached --</span>`;
      }
      lucide.createIcons();
    }

    // Top Header Dropdowns Management
    function toggleNotifDropdown(event) {
      if (event) event.stopPropagation();
      const notifCard = document.getElementById('notifDropdown');
      const userCard = document.getElementById('userDropdown');
      const userWidget = document.getElementById('userProfileWidget');

      if (userCard) userCard.classList.remove('show');
      if (userWidget) userWidget.classList.remove('active');

      if (notifCard) {
        notifCard.classList.toggle('show');
      }
    }

    function toggleUserDropdown(event) {
      if (event) event.stopPropagation();
      const notifCard = document.getElementById('notifDropdown');
      const userCard = document.getElementById('userDropdown');
      const userWidget = document.getElementById('userProfileWidget');

      if (notifCard) notifCard.classList.remove('show');

      if (userCard) {
        const isShown = userCard.classList.toggle('show');
        if (userWidget) {
          if (isShown) userWidget.classList.add('active');
          else userWidget.classList.remove('active');
        }
      }
    }

    function closeAllHeaderDropdowns() {
      const notifCard = document.getElementById('notifDropdown');
      const userCard = document.getElementById('userDropdown');
      const userWidget = document.getElementById('userProfileWidget');

      if (notifCard) notifCard.classList.remove('show');
      if (userCard) userCard.classList.remove('show');
      if (userWidget) userWidget.classList.remove('active');
    }

    // Close flyouts on clicking anywhere outside
    document.addEventListener('click', function (e) {
      const notifCard = document.getElementById('notifDropdown');
      const userCard = document.getElementById('userDropdown');
      const notifBtn = document.getElementById('notifBellBtn');
      const userWidget = document.getElementById('userProfileWidget');

      if (notifCard && notifCard.classList.contains('show')) {
        if (!notifCard.contains(e.target) && !notifBtn.contains(e.target)) {
          notifCard.classList.remove('show');
        }
      }

      if (userCard && userCard.classList.contains('show')) {
        if (!userCard.contains(e.target) && !userWidget.contains(e.target)) {
          userCard.classList.remove('show');
          if (userWidget) userWidget.classList.remove('active');
        }
      }
    });

    function handleLogout() {
      if (confirm('Apakah Anda yakin ingin keluar dari akun AMINEF Portal?')) {
        alert('Anda telah berhasil logout.');
      }
    }

    // Travel Arrangement - Level 1 Category (International vs Domestic)
    function switchTravelCategory(cat) {
      const btnIntl = document.getElementById('btn-travel-cat-intl');
      const btnDom = document.getElementById('btn-travel-cat-dom');
      const paneIntl = document.getElementById('pane-travel-intl');
      const paneDom = document.getElementById('pane-travel-dom');

      if (btnIntl) btnIntl.classList.remove('active');
      if (btnDom) btnDom.classList.remove('active');
      if (paneIntl) paneIntl.classList.remove('active-pane');
      if (paneDom) paneDom.classList.remove('active-pane');

      if (cat === 'international') {
        if (btnIntl) btnIntl.classList.add('active');
        if (paneIntl) paneIntl.classList.add('active-pane');
      } else if (cat === 'domestic') {
        if (btnDom) btnDom.classList.add('active');
        if (paneDom) paneDom.classList.add('active-pane');
      }
      lucide.createIcons();
    }

    // Travel Arrangement - Level 2 Sub-Nav (US Departure vs Returning)
    function switchIntlTravelSubNav(sub) {
      const btnUsdep = document.getElementById('btn-intl-travel-usdep');
      const btnReturn = document.getElementById('btn-intl-travel-return');
      const paneUsdep = document.getElementById('subpane-travel-usdep');
      const paneReturn = document.getElementById('subpane-travel-return');

      if (btnUsdep) btnUsdep.classList.remove('active');
      if (btnReturn) btnReturn.classList.remove('active');
      if (paneUsdep) paneUsdep.style.display = 'none';
      if (paneReturn) paneReturn.style.display = 'none';

      if (sub === 'usdep') {
        if (btnUsdep) btnUsdep.classList.add('active');
        if (paneUsdep) paneUsdep.style.display = 'block';
      } else if (sub === 'return') {
        if (btnReturn) btnReturn.classList.add('active');
        if (paneReturn) paneReturn.style.display = 'block';
      }
      lucide.createIcons();
    }

    // Travel Arrangement - Level 2 Domestic Stage Selector (5 stages)
    function switchDomesticStage(stage) {
      const stages = ['interview', 'testprep', 'admission', 'pdo', 'visa'];
      stages.forEach(s => {
        const btn = document.getElementById(`btn-dom-${s}`);
        const pane = document.getElementById(`subpane-dom-${s}`);
        if (btn) btn.classList.remove('active');
        if (pane) pane.style.display = 'none';
      });

      const activeBtn = document.getElementById(`btn-dom-${stage}`);
      const activePane = document.getElementById(`subpane-dom-${stage}`);
      if (activeBtn) activeBtn.classList.add('active');
      if (activePane) activePane.style.display = 'block';

      lucide.createIcons();
    }

    // Visa - Level 1 Category (Nominee vs Ongoing)
    function switchVisaCategory(cat) {
      const btnNominee = document.getElementById('btn-visa-cat-nominee');
      const btnOngoing = document.getElementById('btn-visa-cat-ongoing');
      const paneNominee = document.getElementById('pane-visa-nominee');
      const paneOngoing = document.getElementById('pane-visa-ongoing');

      if (btnNominee) btnNominee.classList.remove('active');
      if (btnOngoing) btnOngoing.classList.remove('active');
      if (paneNominee) paneNominee.classList.remove('active-pane');
      if (paneOngoing) paneOngoing.classList.remove('active-pane');

      if (cat === 'nominee') {
        if (btnNominee) btnNominee.classList.add('active');
        if (paneNominee) paneNominee.classList.add('active-pane');
      } else if (cat === 'ongoing') {
        if (btnOngoing) btnOngoing.classList.add('active');
        if (paneOngoing) paneOngoing.classList.add('active-pane');
      }
      lucide.createIcons();
    }

    // Visa - Level 2 Sub-Nav inside Nominee (Before vs Confirmation vs After)
    function switchVisaNomineeStage(stage) {
      const stages = ['before', 'confirm', 'after'];
      stages.forEach(s => {
        const btn = document.getElementById(`btn-visa-sub-${s}`);
        const pane = document.getElementById(`subpane-visa-${s}`);
        if (btn) btn.classList.remove('active');
        if (pane) pane.style.display = 'none';
      });

      const activeBtn = document.getElementById(`btn-visa-sub-${stage}`);
      const activePane = document.getElementById(`subpane-visa-${stage}`);
      if (activeBtn) activeBtn.classList.add('active');
      if (activePane) activePane.style.display = 'block';

      lucide.createIcons();
    }


    // ============================================================
    // REUSABLE EMPTY STATE CONFIGURATION & RENDERER
    // Informing clearly that the page has not been created yet
    // ============================================================
    const EMPTY_STATE_PAGES = {
      dashboard: { title: 'Dashboard', icon: 'layout-dashboard' },
      profile: { title: 'My Profile', icon: 'user' },
      grants: { title: 'All Grants', icon: 'book-open' },
      selection: { title: 'Selection', icon: 'check-square' },
      preplacement: { title: 'Pre-Placement', icon: 'compass' },
      pdo: { title: 'Pre Departure Orientation (PDO)', icon: 'users' },
      placement: { title: 'Placement', icon: 'building-2' },
      departure: { title: 'Departure', icon: 'plane-takeoff' },
      ongoing: { title: 'Ongoing', icon: 'graduation-cap' },
      returning: { title: 'Returning', icon: 'plane-landing' },
      tc: { title: 'Terms & Conditions', icon: 'shield-check' }
    };

    function renderEmptyStateView(viewName) {
      const viewEmpty = document.getElementById('view-empty-state');
      if (!viewEmpty) return;

      const pageInfo = EMPTY_STATE_PAGES[viewName] || {
        title: viewName.charAt(0).toUpperCase() + viewName.slice(1),
        icon: 'file-question'
      };

      const titleEl = document.getElementById('empty-view-title');
      const badgeEl = document.getElementById('empty-badge');
      const headingEl = document.getElementById('empty-heading');
      const descEl = document.getElementById('empty-description');
      const iconWrapEl = document.getElementById('empty-icon-wrap');
      const contextEl = document.getElementById('empty-context-text');

      if (titleEl) titleEl.innerText = pageInfo.title;
      if (badgeEl) badgeEl.innerText = 'Not Available Yet';
      if (headingEl) headingEl.innerText = 'This page has not been created yet';
      if (descEl) descEl.innerText = 'This page is currently not available because it has not been created yet.';
      if (contextEl) contextEl.innerText = 'This section has not been built yet and does not contain any content.';
      if (iconWrapEl) {
        iconWrapEl.innerHTML = `<i data-lucide="${pageInfo.icon}" aria-hidden="true" style="width: 32px; height: 32px; color: #0070ba;"></i>`;
      }

      // Highlight active menu in sidebar
      const navItem = document.getElementById('nav-' + viewName);
      const subItem = document.getElementById('subnav-' + viewName);
      if (navItem) navItem.classList.add('active-menu');
      if (subItem) {
        subItem.classList.add('active-sub');
        const parentMenu = subItem.closest('.menu-item');
        if (parentMenu) parentMenu.classList.add('active-menu');
      }

      viewEmpty.style.display = 'block';
      lucide.createIcons();
    }

    // Main View Switcher
    function switchMainView(viewName) {
      if (window.closeCollapsedFlyout) window.closeCollapsedFlyout();
      const viewApplication = document.getElementById('view-application');
      const viewTravel = document.getElementById('view-travel');
      const viewAllowance = document.getElementById('view-allowance');
      const viewVisa = document.getElementById('view-visa');
      const viewDashboard = document.getElementById('view-dashboard');
      const viewProfile = document.getElementById('view-profile');
      const viewEmpty = document.getElementById('view-empty-state');

      // Hide all views
      if (viewApplication) viewApplication.style.display = 'none';
      if (viewTravel) viewTravel.style.display = 'none';
      if (viewAllowance) viewAllowance.style.display = 'none';
      if (viewVisa) viewVisa.style.display = 'none';
      if (viewDashboard) viewDashboard.style.display = 'none';
      if (viewProfile) viewProfile.style.display = 'none';
      if (viewEmpty) viewEmpty.style.display = 'none';

      // Reset all active classes on sidebar menu items
      document.querySelectorAll('.sidebar-menu-list .menu-item').forEach(el => el.classList.remove('active-menu'));
      document.querySelectorAll('.sidebar-menu-list .submenu-list li').forEach(el => el.classList.remove('active-sub'));

      if (viewName === 'dashboard') {
        if (viewDashboard) viewDashboard.style.display = 'block';
        const navDash = document.getElementById('nav-dashboard');
        if (navDash) navDash.classList.add('active-menu');
      } else if (viewName === 'profile') {
        if (viewProfile) viewProfile.style.display = 'block';
        const navProf = document.getElementById('nav-profile');
        if (navProf) navProf.classList.add('active-menu');
        if (typeof switchProfileTab === 'function') switchProfileTab('personal');
      } else if (viewName === 'application') {
        if (viewApplication) viewApplication.style.display = 'block';
        const navApp = document.getElementById('nav-application');
        if (navApp) navApp.classList.add('active-menu');
        if (typeof updateApplicationProgress === 'function') updateApplicationProgress();
      } else if (viewName === 'travel') {
        if (viewTravel) viewTravel.style.display = 'block';
        const navSupport = document.getElementById('nav-support');
        const subTravel = document.getElementById('subnav-travel');
        if (navSupport) navSupport.classList.add('active-menu');
        if (subTravel) subTravel.classList.add('active-sub');
      } else if (viewName === 'allowance') {
        if (viewAllowance) viewAllowance.style.display = 'block';
        const navSupport = document.getElementById('nav-support');
        const subAllowance = document.getElementById('subnav-allowance');
        if (navSupport) navSupport.classList.add('active-menu');
        if (subAllowance) subAllowance.classList.add('active-sub');
      } else if (viewName === 'visa') {
        if (viewVisa) viewVisa.style.display = 'block';
        const navSupport = document.getElementById('nav-support');
        const subVisa = document.getElementById('subnav-visa');
        if (navSupport) navSupport.classList.add('active-menu');
        if (subVisa) subVisa.classList.add('active-sub');
      } else {
        // Activate Reusable Empty State Canvas (No more alert!)
        renderEmptyStateView(viewName);
      }

      window.scrollTo({ top: 0, behavior: 'smooth' });
      lucide.createIcons();
    }

    // ============================================================
    // PROFILE TABS & ACTIONS (MATCHING IMAGES 1, 2, 3)
    // ============================================================
    function switchProfileTab(tab) {
      const btnPersonal = document.getElementById('btn-ptab-personal');
      const btnContact = document.getElementById('btn-ptab-contact');
      const btnScholarship = document.getElementById('btn-ptab-scholarship');
      const panePersonal = document.getElementById('ptab-pane-personal');
      const paneContact = document.getElementById('ptab-pane-contact');
      const paneScholarship = document.getElementById('ptab-pane-scholarship');

      if (btnPersonal) btnPersonal.classList.remove('active');
      if (btnContact) btnContact.classList.remove('active');
      if (btnScholarship) btnScholarship.classList.remove('active');

      if (panePersonal) panePersonal.style.display = 'none';
      if (paneContact) paneContact.style.display = 'none';
      if (paneScholarship) paneScholarship.style.display = 'none';

      if (tab === 'personal') {
        if (btnPersonal) btnPersonal.classList.add('active');
        if (panePersonal) panePersonal.style.display = 'block';
      } else if (tab === 'contact') {
        if (btnContact) btnContact.classList.add('active');
        if (paneContact) paneContact.style.display = 'block';
      } else if (tab === 'scholarship') {
        if (btnScholarship) btnScholarship.classList.add('active');
        if (paneScholarship) paneScholarship.style.display = 'block';
      }
      lucide.createIcons();
    }
    window.switchProfileTab = switchProfileTab;

    function saveProfilePersonal() {
      alert('Personal information successfully updated.');
    }
    window.saveProfilePersonal = saveProfilePersonal;

    function saveProfileContact() {
      alert('Contact and emergency information successfully updated.');
    }
    window.saveProfileContact = saveProfileContact;

    // Filter Dashboard Scholarship History (Image 3)
    function filterDashboardHistory() {
      const periodVal = document.getElementById('dash-history-period')?.value || 'all';
      const statusVal = document.getElementById('dash-history-status')?.value || 'all';
      const searchVal = (document.getElementById('dash-history-search')?.value || '').toLowerCase().trim();
      const rows = document.querySelectorAll('#tbody-dashboard-history tr');
      let visibleCount = 0;

      rows.forEach(row => {
        const period = row.getAttribute('data-period') || '';
        const status = row.getAttribute('data-status') || '';
        const text = row.innerText.toLowerCase();

        const matchPeriod = (periodVal === 'all' || period === periodVal);
        const matchStatus = (statusVal === 'all' || status.toLowerCase() === statusVal.toLowerCase());
        const matchSearch = (!searchVal || text.includes(searchVal));

        if (matchPeriod && matchStatus && matchSearch) {
          row.style.display = '';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });

      const counter = document.getElementById('dash-history-counter');
      if (counter) {
        counter.innerText = `Showing 1 to ${visibleCount} of ${rows.length} entries`;
      }
    }
    window.filterDashboardHistory = filterDashboardHistory;

    // ============================================================
    // ONGOING GRANTEES VISA FUNCTIONS
    // ============================================================
    function switchOngoingVisaSubNav(sub) {
      const btnRenewal = document.getElementById('btn-ongoing-sub-renewal');
      const btnDependent = document.getElementById('btn-ongoing-sub-dependent');
      const paneRenewal = document.getElementById('subpane-ongoing-renewal');
      const paneDependent = document.getElementById('subpane-ongoing-dependent');

      if (btnRenewal) btnRenewal.classList.remove('active');
      if (btnDependent) btnDependent.classList.remove('active');
      if (paneRenewal) paneRenewal.style.display = 'none';
      if (paneDependent) paneDependent.style.display = 'none';

      if (sub === 'renewal') {
        if (btnRenewal) btnRenewal.classList.add('active');
        if (paneRenewal) paneRenewal.style.display = 'block';
      } else if (sub === 'dependent') {
        if (btnDependent) btnDependent.classList.add('active');
        if (paneDependent) paneDependent.style.display = 'block';
      }
      lucide.createIcons();
    }


    function switchDependentStage(stage) {
      const stages = ['before', 'confirm', 'after'];
      stages.forEach(s => {
        const btn = document.getElementById('btn-dep-stage-' + s);
        const pane = document.getElementById('dep-stage-' + s);
        if (btn) btn.classList.remove('active');
        if (pane) pane.style.display = 'none';
      });

      const activeBtn = document.getElementById('btn-dep-stage-' + stage);
      const activePane = document.getElementById('dep-stage-' + stage);
      if (activeBtn) activeBtn.classList.add('active');
      if (activePane) activePane.style.display = 'block';
      lucide.createIcons();
    }

    function switchOngoingRenewalStage(stage) {
      const stages = ['before', 'confirm', 'after'];
      stages.forEach(s => {
        const btn = document.getElementById('btn-ongoing-stage-' + s);
        const pane = document.getElementById('ongoing-stage-' + s);
        if (btn) btn.classList.remove('active');
        if (pane) pane.style.display = 'none';
      });

      const activeBtn = document.getElementById('btn-ongoing-stage-' + stage);
      const activePane = document.getElementById('ongoing-stage-' + stage);
      if (activeBtn) activeBtn.classList.add('active');
      if (activePane) activePane.style.display = 'block';
      lucide.createIcons();
    }

    function openAppointmentModal() {
      const modal = document.getElementById('modal-add-appointment');
      if (modal) {
        modal.classList.add('open');
        modal.style.display = 'flex';
        lucide.createIcons();
      }
    }

    function closeAppointmentModal() {
      const modal = document.getElementById('modal-add-appointment');
      if (modal) {
        modal.classList.remove('open');
        modal.style.display = 'none';
      }
    }

    function handleModalOverlayClick(event) {
      if (event.target && event.target.id === 'modal-add-appointment') {
        closeAppointmentModal();
      }
    }

    function toggleGivenName(cb) {
      const givenInput = document.getElementById('modal-given-name');
      if (givenInput) {
        if (cb.checked) {
          givenInput.value = 'FNU';
          givenInput.disabled = true;
        } else {
          givenInput.value = '';
          givenInput.disabled = false;
        }
      }
    }

    function saveAppointmentData() {
      alert('Data Appointment saved successfully!');
      closeAppointmentModal();
    }

    // ============================================================
    // BATCH / CYCLE SWITCHING WITH COMPLETE DUMMY DATA
    // ============================================================
    function switchRenewalBatch(batchId) {
      const b1 = document.getElementById('btn-batch-renewal-1');
      const b2 = document.getElementById('btn-batch-renewal-2');
      const c1 = document.getElementById('renewal-cycle-1');
      const c2 = document.getElementById('renewal-cycle-2');

      if (b1) b1.classList.remove('active');
      if (b2) b2.classList.remove('active');
      if (c1) c1.style.display = 'none';
      if (c2) c2.style.display = 'none';

      if (batchId === 1) {
        if (b1) b1.classList.add('active');
        if (c1) c1.style.display = 'block';
      } else if (batchId === 2) {
        if (b2) b2.classList.add('active');
        if (c2) c2.style.display = 'block';
      }
      lucide.createIcons();
    }

    function switchRenewal2Stage(stage) {
      const stages = ['before', 'confirm', 'after'];
      stages.forEach(s => {
        const btn = document.getElementById('btn-renewal2-stage-' + s);
        const pane = document.getElementById('renewal2-stage-' + s);
        if (btn) btn.classList.remove('active');
        if (pane) pane.style.display = 'none';
      });

      const activeBtn = document.getElementById('btn-renewal2-stage-' + stage);
      const activePane = document.getElementById('renewal2-stage-' + stage);
      if (activeBtn) activeBtn.classList.add('active');
      if (activePane) activePane.style.display = 'block';
      lucide.createIcons();
    }

    function createNewRenewalBatch() {
      const dateStr = prompt('Masukkan tanggal permohonan renewal baru (contoh: October 15, 2027):', 'October 15, 2027');
      if (dateStr) {
        alert('Rangkap permohonan Visa Renewal baru berhasil dibuat untuk tanggal: ' + dateStr);
      }
    }

    function switchDependentBatch(batchId) {
      const b1 = document.getElementById('btn-batch-dep-1');
      const b2 = document.getElementById('btn-batch-dep-2');
      const c1 = document.getElementById('dep-cycle-1');
      const c2 = document.getElementById('dep-cycle-2');

      if (b1) b1.classList.remove('active');
      if (b2) b2.classList.remove('active');
      if (c1) c1.style.display = 'none';
      if (c2) c2.style.display = 'none';

      if (batchId === 1) {
        if (b1) b1.classList.add('active');
        if (c1) c1.style.display = 'block';
      } else if (batchId === 2) {
        if (b2) b2.classList.add('active');
        if (c2) c2.style.display = 'block';
      }
      lucide.createIcons();
    }

    function switchDependent2Stage(stage) {
      const stages = ['before', 'confirm', 'after'];
      stages.forEach(s => {
        const btn = document.getElementById('btn-dep2-stage-' + s);
        const pane = document.getElementById('dep2-stage-' + s);
        if (btn) btn.classList.remove('active');
        if (pane) pane.style.display = 'none';
      });

      const activeBtn = document.getElementById('btn-dep2-stage-' + stage);
      const activePane = document.getElementById('dep2-stage-' + stage);
      if (activeBtn) activeBtn.classList.add('active');
      if (activePane) activePane.style.display = 'block';
      lucide.createIcons();
    }

    function createNewDependentBatch() {
      const dateStr = prompt('Masukkan tanggal permohonan dependent baru (contoh: August 20, 2027):', 'August 20, 2027');
      if (dateStr) {
        alert('Rangkap permohonan Visa for Dependent baru berhasil dibuat untuk tanggal: ' + dateStr);
      }
    }


    // ============================================================
    // APPLICATION WORKSPACE & DYNAMIC PROGRESS STEPPER
    // ============================================================
    const APP_SECTIONS_META = [
      { id: 1, title: 'Academic Background' },
      { id: 2, title: 'Professional Experience' },
      { id: 3, title: 'Curriculum Vitae / Resume' },
      { id: 4, title: 'Awards and Recognitions' },
      { id: 5, title: 'Experience Abroad' },
      { id: 6, title: 'Previous Fulbright and other US Grants' },
      { id: 7, title: 'Language Skills' },
      { id: 8, title: 'Study Plan' },
      { id: 9, title: 'Plagiarism Agreement' },
      { id: 10, title: 'University Preferences' },
      { id: 11, title: 'U.S Institutions Applied To' },
      { id: 12, title: 'Social and Community Involvement' },
      { id: 13, title: 'Recommendations' },
      { id: 14, title: 'Other Scholarships' },
      { id: 15, title: 'Additional Information' },
      { id: 16, title: 'Declaration' }
    ];

    let currentAppSection = 1;

    function clearInputField(btn) {
      if (!btn) return;
      const wrap = btn.closest('.input-clear-wrap');
      if (wrap) {
        const input = wrap.querySelector('input');
        if (input) {
          input.value = '';
          input.dispatchEvent(new Event('input', { bubbles: true }));
        }
      }
    }

    function addWorkHistoryEntry() {
      const container = document.getElementById('work-history-entries-container');
      if (!container) return;
      const entryCount = container.querySelectorAll('.work-history-entry-block').length + 1;
      const newEntry = document.createElement('div');
      newEntry.className = 'work-history-entry-block';
      newEntry.style.cssText = 'margin-top: 24px; padding-top: 20px; border-top: 1px dashed #cbd5e1; position: relative;';
      newEntry.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
          <span style="font-size: 13px; font-weight: 700; color: #072a5a;">Previous Role #${entryCount}</span>
          <button type="button" onclick="this.closest('.work-history-entry-block').remove(); if(typeof updateApplicationProgress === 'function') updateApplicationProgress();" style="background: none; border: none; color: #ef4444; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px;">
            &times; Remove
          </button>
        </div>
        <div class="form-row-horizontal">
          <label>Role</label>
          <input type="text" placeholder="Answer">
        </div>
        <div class="form-row-horizontal">
          <label>Position Title</label>
          <input type="text" placeholder="Answer">
        </div>
        <div class="form-row-horizontal">
          <label>Employer Name (Institution)</label>
          <input type="text" placeholder="Answer">
        </div>
        <div class="form-row-horizontal">
          <label>Start Date</label>
          <div class="input-clear-wrap">
            <input type="text" placeholder="Answer" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
            <button type="button" class="btn-clear-date-cross" onclick="clearInputField(this)" aria-label="Clear date">✕</button>
          </div>
        </div>
        <div class="form-row-horizontal">
          <label>End Date</label>
          <div class="input-clear-wrap">
            <input type="text" placeholder="Answer" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
            <button type="button" class="btn-clear-date-cross" onclick="clearInputField(this)" aria-label="Clear date">✕</button>
          </div>
        </div>
        <div class="form-row-horizontal">
          <label>Country</label>
          <select>
            <option value="">Select Country</option>
            <option value="ID">Indonesia</option>
            <option value="US">United States</option>
            <option value="AU">Australia</option>
            <option value="GB">United Kingdom</option>
            <option value="CA">Canada</option>
            <option value="SG">Singapore</option>
            <option value="MY">Malaysia</option>
            <option value="JP">Japan</option>
            <option value="NL">Netherlands</option>
            <option value="DE">Germany</option>
          </select>
        </div>
        <div class="form-row-horizontal">
          <label>State/Province</label>
          <select>
            <option value="">Select a state</option>
            <option value="JKT">DKI Jakarta</option>
            <option value="JBR">Jawa Barat</option>
            <option value="JTG">Jawa Tengah</option>
            <option value="DIY">D.I. Yogyakarta</option>
            <option value="JTM">Jawa Timur</option>
            <option value="BTM">Banten</option>
            <option value="BLI">Bali</option>
            <option value="SUM">Sumatera Utara</option>
          </select>
        </div>
        <div class="form-row-horizontal">
          <label>City</label>
          <select>
            <option value="">Select a city</option>
            <option value="jaksel">Jakarta Selatan</option>
            <option value="jakpus">Jakarta Pusat</option>
            <option value="jakbar">Jakarta Barat</option>
            <option value="jaktim">Jakarta Timur</option>
            <option value="jakut">Jakarta Utara</option>
            <option value="bandung">Bandung</option>
            <option value="yogyakarta">Yogyakarta</option>
            <option value="surabaya">Surabaya</option>
            <option value="semarang">Semarang</option>
          </select>
        </div>
        <div class="form-row-horizontal">
          <label>Street Address</label>
          <input type="text" placeholder="Answer">
        </div>
        <div class="form-row-horizontal">
          <label>Postal Code</label>
          <input type="text" placeholder="Answer">
        </div>
      `;
      container.appendChild(newEntry);
    }

    function switchAppSection(secIndex) {
      currentAppSection = secIndex;
      for (let i = 1; i <= 16; i++) {
        const stepBtn = document.getElementById('app-step-btn-' + i);
        const secPane = document.getElementById('app-sec-' + i);
        if (stepBtn) stepBtn.classList.remove('active');
        if (secPane) secPane.style.display = 'none';
      }

      const activeStepBtn = document.getElementById('app-step-btn-' + secIndex);
      const activeSecPane = document.getElementById('app-sec-' + secIndex);
      if (activeStepBtn) activeStepBtn.classList.add('active');
      if (activeSecPane) {
        activeSecPane.style.display = 'block';
        activeSecPane.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }

      updateApplicationProgress();
      lucide.createIcons();
    }

    function saveAndGoToSection(nextIndex) {
      updateApplicationProgress();
      switchAppSection(nextIndex);
    }

    function updateApplicationProgress() {
      let completedCount = 0;
      const sectionStatuses = [];

      for (let i = 1; i <= 16; i++) {
        const pane = document.getElementById('app-sec-' + i);
        const badge = document.getElementById('app-step-badge-' + i);
        const iconSpan = document.getElementById('app-step-icon-' + i);
        if (!pane) continue;

        const reqInputs = pane.querySelectorAll('input[required], select[required], textarea[required]');
        const allInputs = pane.querySelectorAll('input:not([type="hidden"]), select, textarea');

        let totalReq = reqInputs.length;
        let filledReq = 0;
        let hasAnyInput = false;

        allInputs.forEach(inp => {
          if (inp.type === 'checkbox' && inp.checked) hasAnyInput = true;
          else if (inp.type !== 'checkbox' && inp.value && inp.value.trim() !== '') hasAnyInput = true;
        });

        reqInputs.forEach(inp => {
          if (inp.type === 'checkbox') {
            if (inp.checked) filledReq++;
          } else if (inp.value && inp.value.trim() !== '') {
            filledReq++;
          }
        });

        let status = 'empty';
        if (totalReq > 0 && filledReq === totalReq) {
          status = 'completed';
          completedCount++;
        } else if (totalReq === 0 && hasAnyInput) {
          status = 'completed';
          completedCount++;
        } else if (hasAnyInput || (totalReq > 0 && filledReq > 0)) {
          status = 'progress';
        } else {
          status = 'empty';
        }

        sectionStatuses.push({ id: i, status: status, filled: filledReq, total: totalReq });

        if (badge) {
          badge.className = 'app-stepper-badge';
          if (status === 'completed') {
            badge.classList.add('badge-status-completed');
            badge.innerText = 'Completed';
          } else if (status === 'progress') {
            badge.classList.add('badge-status-progress');
            badge.innerText = 'Incomplete';
          } else {
            badge.classList.add('badge-status-empty');
            badge.innerText = 'Not Started';
          }
        }

        // Checkmark icons removed per clean AMINEF design system (clean text + badge only)
      }

      const pct = Math.round((completedCount / 16) * 100);
      const counterText = document.getElementById('app-progress-counter-text');
      const barFill = document.getElementById('app-progress-bar-fill');
      if (counterText) counterText.innerText = `${completedCount} of 16 (${pct}%)`;
      if (barFill) barFill.style.width = pct + '%';

      if (typeof updateRailProgress === 'function') updateRailProgress();

      updateDeclarationSummary(completedCount, sectionStatuses);
      lucide.createIcons();
    }

    function updateDeclarationSummary(completedCount, statuses) {
      const grid = document.getElementById('declaration-checklist-grid');
      const statHeader = document.getElementById('checklist-summary-stat');
      const readinessBanner = document.getElementById('submission-readiness-banner');
      const readinessTitle = document.getElementById('readiness-banner-title');
      const readinessDesc = document.getElementById('readiness-banner-desc');
      const btnSubmit = document.getElementById('btn-final-submit');

      if (statHeader) statHeader.innerText = `${completedCount} / 16 Complete`;

      if (grid && statuses && statuses.length === 16) {
        let gridHtml = '';
        statuses.forEach((st, idx) => {
          const meta = APP_SECTIONS_META[idx];
          let statusBadge = '';
          if (st.status === 'completed') {
            statusBadge = '<span style="font-size: 11px; font-weight: 600; color: #16a34a; display: flex; align-items: center; gap: 4px;"><i data-lucide="check" aria-hidden="true" style="width: 13px; height: 13px;"></i> Ready</span>';
          } else if (st.status === 'progress') {
            statusBadge = '<span style="font-size: 11px; font-weight: 600; color: #d97706; display: flex; align-items: center; gap: 4px;"><i data-lucide="alert-circle" aria-hidden="true" style="width: 13px; height: 13px;"></i> Incomplete</span>';
          } else {
            statusBadge = '<span style="font-size: 11px; font-weight: 500; color: #94a3b8;">Empty</span>';
          }

          gridHtml += `
            <div onclick="switchAppSection(${meta.id})" style="display: flex; justify-content: space-between; align-items: center; padding: 7px 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 12px; cursor: pointer; transition: background 0.15s;" onmouseover="this.style.background='#f0f7fd'" onmouseout="this.style.background='#f8fafc'">
              <span style="color: #1e293b; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 180px;">${meta.title}</span>
              ${statusBadge}
            </div>
          `;
        });
        grid.innerHTML = gridHtml;
      }

      if (readinessBanner && btnSubmit) {
        if (completedCount === 16) {
          readinessBanner.style.background = '#f0fdf4';
          readinessBanner.style.borderColor = '#bbf7d0';
          if (readinessTitle) {
            readinessTitle.style.color = '#166534';
            readinessTitle.innerText = 'Application Ready for Submission';
          }
          if (readinessDesc) {
            readinessDesc.style.color = '#15803d';
            readinessDesc.innerText = 'All 16 sections are complete, verified, and ready. Please review your declaration signature before final submission.';
          }
          btnSubmit.style.opacity = '1';
          btnSubmit.style.cursor = 'pointer';
        } else {
          readinessBanner.style.background = '#fffbeb';
          readinessBanner.style.borderColor = '#fde68a';
          if (readinessTitle) {
            readinessTitle.style.color = '#92400e';
            readinessTitle.innerText = 'Submission Incomplete';
          }
          if (readinessDesc) {
            readinessDesc.style.color = '#78350f';
            readinessDesc.innerText = `You have completed ${completedCount} of 16 sections. All mandatory fields must be completed before you can submit your final application.`;
          }
        }
      }
    }

    function submitFinalApplication() {
      const incompleteSections = [];

      for (let i = 1; i <= 16; i++) {
        const pane = document.getElementById('app-sec-' + i);
        if (!pane) continue;
        const reqInputs = pane.querySelectorAll('input[required], select[required], textarea[required]');
        let totalReq = reqInputs.length;
        let filledReq = 0;
        reqInputs.forEach(inp => {
          if (inp.type === 'checkbox') {
            if (inp.checked) filledReq++;
          } else if (inp.value && inp.value.trim() !== '') {
            filledReq++;
          }
        });
        if (totalReq > 0 && filledReq < totalReq) {
          incompleteSections.push(APP_SECTIONS_META[i - 1].title);
        }
      }

      if (incompleteSections.length > 0) {
        alert('Aplikasi belum dapat disubmit! Terdapat seksi yang field mandatory-nya belum lengkap:\n\n• ' + incompleteSections.slice(0, 5).join('\n• ') + (incompleteSections.length > 5 ? `\n...dan ${incompleteSections.length - 5} seksi lainnya.` : ''));
        return;
      }

      const conf = confirm('Apakah Anda yakin ingin mengirimkan (SUBMIT) aplikasi beasiswa Fulbright Doctoral Degree (PhD) Scholarship (2028)?\n\nSetelah disubmit, seluruh data aplikasi akan dikunci untuk peninjauan komite seleksi.');
      if (conf) {
        alert('Selamat! Aplikasi beasiswa Anda telah BERHASIL DISUBMIT secara resmi ke AMINEF & Fulbright.');
      }
    }

    // Application Stepper Sidebar Collapse / Expand Functionality (Slim Mini-Rail)
    function toggleAppStepperSidebar(event) {
      if (event && event.stopPropagation) event.stopPropagation();
      const container = document.querySelector('.app-two-col');
      if (!container) return;

      const isCollapsed = container.classList.toggle('stepper-collapsed');
      if (isCollapsed) {
        updateRailProgress();
      }

      try {
        localStorage.setItem('aminef_app_stepper_collapsed', isCollapsed ? 'true' : 'false');
      } catch (e) { }

      lucide.createIcons();
    }
    window.toggleAppStepperSidebar = toggleAppStepperSidebar;

    function handleStepperRailClick(event) {
      const container = document.querySelector('.app-two-col');
      if (container && container.classList.contains('stepper-collapsed')) {
        toggleAppStepperSidebar(event);
      }
    }
    window.handleStepperRailClick = handleStepperRailClick;

    function updateRailProgress() {
      const counterText = document.getElementById('app-progress-counter-text');
      const railText = document.getElementById('railProgressCounter');
      const railFill = document.getElementById('railProgressFill');
      if (counterText && railText) {
        const match = counterText.innerText.match(/(\d+)\s*of\s*(\d+)(?:\s*\(([\d.]+)%\))?/i);
        if (match) {
          railText.innerText = `${match[1]}/${match[2]}`;
          if (railFill && match[3]) {
            railFill.style.height = `${match[3]}%`;
          }
        }
      }
    }
    window.updateRailProgress = updateRailProgress;

    // Attach listeners on load
    document.addEventListener('DOMContentLoaded', function () {
      try {
        const savedSidebarState = localStorage.getItem('aminef_sidebar_collapsed');
        if (savedSidebarState === 'true') {
          const sidebar = document.getElementById('mainPortalSidebar');
          if (sidebar) sidebar.classList.add('collapsed');
        }
      } catch (e) { }

      try {
        const savedStepperState = localStorage.getItem('aminef_app_stepper_collapsed');
        if (savedStepperState === 'true') {
          const container = document.querySelector('.app-two-col');
          if (container) container.classList.add('stepper-collapsed');
          updateRailProgress();
        }
      } catch (e) { }

      if (typeof setupSidebarHover === 'function') setupSidebarHover();

      const appView = document.getElementById('view-application');
      if (appView) {
        appView.addEventListener('input', updateApplicationProgress);
        appView.addEventListener('change', updateApplicationProgress);
      }
      updateApplicationProgress();
    });


    // ============================================================
    // MAIN SIDEBAR COLLAPSE (MINI-RAIL) TOGGLE
    // ============================================================
    function toggleMainSidebar() {
      if (window.closeCollapsedFlyout) window.closeCollapsedFlyout();
      const sidebar = document.getElementById('mainPortalSidebar');
      if (sidebar) {
        sidebar.classList.toggle('collapsed');
        const isCollapsed = sidebar.classList.contains('collapsed');
        try {
          localStorage.setItem('aminef_sidebar_collapsed', isCollapsed ? 'true' : 'false');
        } catch (e) { }
      }
      if (window.hideSidebarPopover) window.hideSidebarPopover();
      lucide.createIcons();
    }


    // ============================================================
    // COLLAPSED SIDEBAR HOVER WORDING (TOOLTIP ONLY)
    // ============================================================
    function setupSidebarHover() {
      const sidebar = document.getElementById('mainPortalSidebar');
      if (!sidebar) return;

      let popover = document.getElementById('sidebar-hover-popover');
      if (!popover) {
        popover = document.createElement('div');
        popover.id = 'sidebar-hover-popover';
        popover.style.cssText = 'position: fixed; z-index: 9999; display: none; opacity: 0; transition: opacity 0.12s ease, transform 0.12s ease; transform: translateX(-4px); pointer-events: none;';
        document.body.appendChild(popover);
      }

      let hideTimer = null;

      function showWording(el, text) {
        if (!sidebar.classList.contains('collapsed')) return;
        const flyout = document.getElementById('sidebar-collapsed-flyout');
        const parentLi = el.closest('.menu-item');
        if (flyout && flyout.style.display !== 'none' && parentLi && currentFlyoutId === parentLi.id) {
          return;
        }
        clearTimeout(hideTimer);
        const rect = el.getBoundingClientRect();
        popover.innerHTML = `
          <div style="background: #0f172a; color: #ffffff; padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.22); white-space: nowrap; letter-spacing: 0.2px;">
            ${text}
          </div>
        `;
        popover.style.display = 'block';
        popover.style.pointerEvents = 'none';

        const popRect = popover.getBoundingClientRect();
        popover.style.left = (rect.right + 10) + 'px';
        popover.style.top = (rect.top + (rect.height / 2) - (popRect.height / 2)) + 'px';

        requestAnimationFrame(() => {
          popover.style.opacity = '1';
          popover.style.transform = 'translateX(0)';
        });
      }

      function hideWording() {
        hideTimer = setTimeout(() => {
          popover.style.opacity = '0';
          popover.style.transform = 'translateX(-4px)';
          setTimeout(() => { popover.style.display = 'none'; }, 120);
        }, 100);
      }

      window.hideSidebarPopover = function () {
        clearTimeout(hideTimer);
        popover.style.display = 'none';
        popover.style.opacity = '0';
      };

      // Bind mouseenter and mouseleave to all menu items (Wording ONLY on hover, NEVER open menus)
      const links = sidebar.querySelectorAll('.menu-link');
      links.forEach(link => {
        const spanText = link.querySelector('span') ? link.querySelector('span').innerText.trim() : '';
        const tooltip = link.getAttribute('data-tooltip') || spanText;

        link.addEventListener('mouseenter', () => {
          if (sidebar.classList.contains('collapsed')) {
            showWording(link, tooltip);
          }
        });
        link.addEventListener('mouseleave', hideWording);
      });
    }

    // ============================================================
    // ACCESSIBILITY & PERFORMANCE ENHANCEMENTS (Vercel Guidelines)
    // ============================================================
    // Global Escape Key Handler for Modals and Dropdowns
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' || e.key === 'Esc') {
        if (window.closeCollapsedFlyout) window.closeCollapsedFlyout();
        const modal = document.getElementById('modal-add-appointment');
        if (modal && modal.style.display === 'flex') {
          closeAppointmentModal();
          return;
        }
        closeAllHeaderDropdowns();
      }
    });

    // Update ARIA expanded states when dropdowns open/close
    const originalToggleNotif = window.toggleNotifDropdown;
    window.toggleNotifDropdown = function (e) {
      originalToggleNotif(e);
      const card = document.getElementById('notifDropdownCard');
      const btn = document.getElementById('notifBellBtn');
      if (btn && card) {
        btn.setAttribute('aria-expanded', card.classList.contains('active') ? 'true' : 'false');
      }
    };

    const originalToggleUser = window.toggleUserDropdown;
    window.toggleUserDropdown = function (e) {
      originalToggleUser(e);
      const menu = document.getElementById('userDropdownMenu');
      const btn = document.getElementById('userAvatarBtn');
      if (btn && menu) {
        btn.setAttribute('aria-expanded', menu.classList.contains('active') ? 'true' : 'false');
      }
    };

  
    // Close collapsed submenu flyout when clicking outside
    document.addEventListener('click', function(e) {
      const flyout = document.getElementById('sidebar-collapsed-flyout');
      if (flyout && flyout.style.display !== 'none') {
        const sidebar = document.getElementById('mainPortalSidebar');
        if (!flyout.contains(e.target) && (!sidebar || !e.target.closest('.has-submenu'))) {
          closeCollapsedFlyout();
        }
      }
    });

    window.addEventListener('scroll', function() {
      if (window.closeCollapsedFlyout) window.closeCollapsedFlyout();
    }, { passive: true });