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
                            class="sidebar-link sidebar-title link-nav active" href="/admin/profile">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                            </svg><span>Profile</span></a>
                    </li>
                    @if($userData['role'] == 'superadmin')
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav" href="/admin/management-user">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-authenticate"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-authenticate"></use>
                            </svg><span>Management User</span></a>
                    </li>
                    @endif
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav" href="/admin/rekap-penilaian">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-charts"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-charts"></use>
                            </svg><span>Rekap Penilaian</span></a>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav" href="/admin/kriteria-penilaian">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-learning"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-learning"></use>
                            </svg><span>Kriteria Penilaian</span></a>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav" href="/admin/pengajuan-absen">
                            <i class="fas fa-clipboard-check m-l-5 m-r-10" style="text-align: center; color: #adadad; font-size: 17px"></i>
                            <span>Pengajuan Absen</span></a>
                    </li>
                    <svg class="stroke-icon">
                        <use href="../assets/svg/icon-sprite.svg#stroke-form"></use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="../assets/svg/icon-sprite.svg#fill-form"></use>
                    </svg><span>Documentation </span></a></li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
