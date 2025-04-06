<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><img class="img-fluid for-light" src="../images/SPTH.png" alt=""
                style="max-width: 113px;"><img class="img-fluid for-dark" src="../images/SPTH.png" alt=""
                style="max-width: 113px;">
            <div class="back-btn"><i class="fa-solid fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><img class="img-fluid" src="../images/logo_jabar.png" alt=""
                style="max-width: 31px;"></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa-solid fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav active" href="/staff/profile">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                            </svg><span>Profile</span></a>
                    </li>
                    @if($userData['role'] == 'penilai')
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav" href="/penilai">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                            </svg><span>List Penilaian Staff</span></a>
                    </li>
                    @endif
                    @if($userData['role'] != 'penilai')
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav active" href="/staff/absensi">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-reports"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-reports"></use>
                            </svg><span>Absensi</span></a>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
