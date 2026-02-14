<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userPicture = $_SESSION['user_picture'] ?? '';
?>
<!-- Start Header Area -->
    <header class="rbt-header rbt-header-8 rbt-transparent-header">
        <div class="rbt-sticky-placeholder"></div>
        <!-- Start Header Top  -->
        <div
            class="rbt-header-top rbt-header-top-1 variation-height-60 header-space-betwween bg-color-transparent top-expended-activation">
            <div class="container">
                <div class="top-expended-wrapper">
                    <div class="top-expended-inner rbt-header-sec align-items-center ">
                        <div class="rbt-header-sec-col rbt-header-left">
                            <div class="rbt-header-content">
                                <div class="header-info  d-lg-block">
                                    <ul class="rbt-information-list">

                                        <li>
                                            <a style="font-weight: 900;" href="mailto:edusprayIndia@gmail.com"><i
                                                    class="feather-mail"></i>edusprayIndia@gmail.com</a>
                                        </li>
                                        <li>
                                            <a style="font-weight: 900;" href="tel:+91-8595684716"><i
                                                    class="feather-phone"></i>+91 8595684716</a>
                                        </li>
                                    </ul>

                                </div>
                                <div>
                                    <ul class="social-icon social-default header-social">
                                        <li><a href="https://www.facebook.com/profile.php?id=61569643561294#">
                                                <i class="feather-facebook"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.twitter.com">
                                                <i class="feather-twitter"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.instagram.com/edusprayIndia/">
                                                <i class="feather-instagram"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.linkedin.com/feed/?trk=onboarding-landing">
                                                <i class="feather-linkedin"></i>
                                            </a>
                                        </li>

                                        <li><a href="https://www.youtube.com/@EdusprayIndia">
                                                <i class="feather-youtube"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- End Header Top  -->

        <div class="rbt-header-wrapper  header-sticky">
            <div class="container">
                <div class="mainbar-row rbt-navigation-end align-items-center">
                    <div class="header-left">
                        <div class="logo">
                            <a href="index.html">
                                <img src="images/e-logo.jpeg" alt="Education Logo Images">
                            </a>
                        </div>
                    </div>

                    <div class="rbt-main-navigation d-none d-xl-block">
                        <nav class="mainmenu-nav">
                            <ul class="mainmenu">
                                <li class="with-megamenu has-menu-child-item position-static">
                                    <a href="index.html">Home </a>
                                    <!-- Start Mega Menu  -->

                                    <!-- End Mega Menu  -->
                                </li>
                                <li class="with-megamenu has-menu-child-item position-static">
                                    <a href="about.html" target="_blank">About Us </a>
                                    <!-- Start Mega Menu  -->

                                    <!-- End Mega Menu  -->
                                </li>

                                <li class="with-megamenu has-menu-child-item">
                                    <a href="#">Courses <i class="feather-chevron-down"></i></a>
                                    <!-- Start Mega Menu  -->
                                    <div class="rbt-megamenu grid-item-2">
                                        <div class="wrapper">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mega-top-banner">
                                                        <div class="content">
                                                            <h4 class="title">Eduspray India</h4>
                                                            <p class="description">Best Educational Counsellor service
                                                                for Bachlor's and Master's Degree, We are India's most
                                                                trusted team of study in India
                                                                and abroad Counsellors
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row--15">
                                                <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                                    <h3 class="rbt-short-title">top Courses in India and Abroad</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="course.php?slug=btech"> <img src="images/B.TECH.png" alt="">
                                                                B.Tech</a></li>
                                                        <li><a href="course.php?slug=barch"> <img src="images/B.TECH.png" alt="">
                                                                B.Arch</a></li>
                                                        <li><a href="course.php?slug=bhmct"> <img src="images/B.TECH.png" alt="">
                                                                BHMCT</a></li>
                                                        <li><a href="course.php?slug=bca"><img src="images/BCA.png" alt="">
                                                                BCA</a></li>
                                                        <li><a href="course.php?slug=bba"> <img src="images/BBA.png" alt="">
                                                                BBA</a></li>
                                                        <li><a href="course.php?slug=bbe"> <img src="images/B.TECH.png" alt="">
                                                                BBE</a></li>
                                                        <li><a href="course.php?slug=bajmc"><img src="images/BA-JMC.png" alt="">
                                                                BA-JMC</a></li>
                                                        <li><a href="course.php?slug=bcom"><img src="images/B.COM.png" alt="">
                                                                B.Com (H)</a></li>
                                                        <li><a href="course.php?slug=baeng"><img src="images/BA-ENG.png" alt="">
                                                                BA-Eng</a></li>
                                                        <li><a href="course.php?slug=baeco"><img src="images/BA-ECO.png" alt="">
                                                                BA-Eco</a></li>
                                                        <li><a href="course.php?slug=ballb"><img src="images/BA-LLB.png" alt="">
                                                                BA-LLB</a></li>
                                                        <li><a href="course.php?slug=bballb"><img src="images/BBA-LLB.png" alt="">
                                                                BBA-LLB</a></li>
                                                        <li><a href="course.php?slug=bed"><img src="images/B.Ed.png" alt="">
                                                                B.Ed</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                MBBS</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                BUMS</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                BHMS</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                BPT</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                B.Pharma</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                D.Pharma</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                    MD/MS</a></li>
                                                        
                                                        

                                                    </ul>
                                                </div>
                                                <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                                    <ul class="mega-menu-item">
                                                        <li><a href="course.php?slug=medical"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/medical.webp"
                                                                    alt="">Medical</a></li>
                                                        <li><a href="course.php?slug=engineering"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/engineering.webp"
                                                                    alt="">Engineering</a></li>
                                                        <li><a href="course.php?slug=management"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/management.webp"
                                                                    alt="">Business and Management</a></li>
                                                        <li><a href="course.php?slug=architecture"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/architecture.webp"
                                                                    alt=""> Architecture</a></li>
                                                        <li><a href="course.php?slug=commerce"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/commerce.webp"
                                                                    alt="">Commerce</a></li>
                                                        <li><a href="course.php?slug=aviation"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/aviation.webp"
                                                                    alt="">Aviation</a></li>
                                                        <li><a href="course.php?slug=hotel"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/hotel.webp"
                                                                    alt="">Hotel Management</a></li>
                                                        <li><a href="course.php?slug=humanities"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/arts.webp"
                                                                    alt="">Humanities</a></li>
                                                        <li><a href="course.php?slug=journalism"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/masscom.png"
                                                                    alt="">Journalism, Media and Mass Comm</a></li>
                                                        <li><a href="course.php?slug=law"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/law.webp"
                                                                    alt="">Law</a></li>
                                                        <li><a href="course.php?slug=languages"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/language.png"
                                                                    alt="">Languages and Teaching</a></li>
                                                        <li><a href="course.php?slug=design"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/design.webp"
                                                                    alt=""> Arts and Design</a></li>
                                                        <li><a href="course.php?slug=socialsciences"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/Science.png"
                                                                    alt="">Social Sciences</a></li>
                                                        <li><a href="course.php?slug=agriculture"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/Agriculture.webp"
                                                                    alt="">Agriculture and Forestry</a></li>
                                                        <li><a href="course.php?slug=computerscience"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/Science.webp"
                                                                    alt="">Computer Science and IT</a> </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Mega Menu  -->
                                </li>

                                <li class="has-dropdown has-menu-child-item">
                                    <a href="#">University
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li class="has-dropdown"><a href="#">Study in India</a>
                                            <ul class="submenu">
                                                <li><a href="university-of-delhi.html">University of Delhi-NCR</a></li>
                                                <li><a href="ipu.html">GGSIPU in Delhi-NCR</a></li>
                                                <li><a href="top_reputed.html"> Top Private Universities</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown"><a href="#">Study in Abroad</a>
                                            <!-- <ul class="submenu">
                                                <li><a href="student-dashboard.html">Dashboard</a></li>
                                                <li><a href="student-profile.html">Profile</a></li>
                                                <li><a href="student-enrolled-courses.html">Enrolled Courses</a></li>
                                              
                                            </ul> -->
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-dropdown has-menu-child-item">
                                    <a href="#">Countries
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="#"> <img src="images/India.png" alt=""> India</a>

                                        </li>
                                        <li><a href="#"> <img src="images/uk.png" alt=""> United-Kingdom</a>

                                        </li>
                                        <li><a href="#"><img src="images/usa.png" alt=""> USA</a></li>
                                        <li><a href="#"> <img src="images/ire.png" alt=""> Ireland</a></li>
                                        <li><a href="#"> <img src="images/can.png" alt=""> Canada</a></li>
                                        <li><a href="#"><img src="images/dub.png" alt="">Dubai</a></li>

                                    </ul>
                                </li>
                                
                                

                                <li class="has-dropdown has-menu-child-item">
                                    <a href="#">Medical
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li class="has-dropdown"><a href="#"><img src="images/INDIA-NEET.png" alt="">Study in India</a>
                                            <ul class="submenu">
                                                <li><a href="#"><img src="images/DOCTER-NEET.png" alt="">NEET-UG</a></li>
                                                <li><a href="#"><img src="images/DOCTER-NEET.png" alt="">NEET-PG </a></li>
                                                <!-- <li><a href="top_reputed.html"> Top Reputed Universities</a> -->
                                                
                                            </ul>
                                        </li>
                                        <li class="has-dropdown"><a href="#"><img src="images/ABORAD.png" alt="">Study in Abroad</a>
                                            <!-- <ul class="submenu">
                                                <li><a href="student-dashboard.html">Dashboard</a></li>
                                                <li><a href="student-profile.html">Profile</a></li>
                                                <li><a href="student-enrolled-courses.html">Enrolled Courses</a></li>
                                              
                                            </ul> -->
                                        </li>
                                    </ul>
                                </li>
                                
                                

                                <li class="with-megamenu has-menu-child-item position-static">
                                    <a href="blog.html">Blog </a>
                                    <!-- Start Mega Menu  -->
                                    <!-- <div class="rbt-megamenu grid-item-3">
                                        <div class="wrapper">
                                            <div class="row row--15">
                                                <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                                    <h3 class="rbt-short-title">Blog Styles</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="blog-list.html">Blog List</a></li>
                                                        <li><a href="blog.html">Blog Grid</a></li>
                                                        <li><a href="blog-grid-minimal.html">Blog Grid Minimal</a></li>
                                                        <li><a href="blog-with-sidebar.html">Blog With Sidebar</a></li>
                                                        <li><a href="blog-details.html">Blog Details</a></li>
                                                        <li><a href="post-format-standard.html">Post Format Standard</a>
                                                        </li>
                                                        <li><a href="post-format-gallery.html">Post Format Gallery</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                                    <h3 class="rbt-short-title">Get Started</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="post-format-quote.html">Post Format Quote</a></li>
                                                        <li><a href="post-format-audio.html">Post Format Audio</a></li>
                                                        <li><a href="post-format-video.html">Post Format Video</a></li>
                                                        <li><a href="#">Media Under Title <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                        <li><a href="#">Sticky Sidebar <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                        <li><a href="#">Auto Masonry <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                        <li><a href="#">Meta Overlaid <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                                    <div class="rbt-ads-wrapper">
                                                        <a class="d-block" href="#"><img src="images/mobile-cat.jpg"
                                                                alt="Education Images"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- End Mega Menu  -->
                                </li>


                            </ul>
                        </nav>
                    </div>

                    <div class="header-right">
                        <!-- Login/Register Button (shown when not logged in) -->
                        <div class="rbt-btn-wrapper d-none d-xl-block" id="loginBtnWrapper">
                            <a class="rbt-btn rbt-switch-btn btn-gradient btn-sm hover-transform-none"
                                href="login.html">
                                <span data-text="Login / Register">Login / Register</span>
                            </a>
                        </div>
                        
                        <!-- User Menu (shown when logged in) - hidden by default -->
                        <div class="user-menu-wrapper d-none" id="userMenuWrapper">
                            <div class="user-menu-dropdown">
                                <button class="user-menu-btn" onclick="toggleUserDropdown()">
                                    <div class="user-avatar" id="userAvatar">
                                        <span id="userInitial">U</span>
                                    </div>
                                    <span class="user-name" id="userName">User</span>
                                    <i class="feather-chevron-down"></i>
                                </button>
                                <div class="user-dropdown" id="userDropdown">
                                    <a href="dashboard.html"><i class="feather-user"></i> My Dashboard</a>
                                    <a href="php/logout.php"><i class="feather-log-out"></i> Logout</a>
                                </div>
                            </div>
                        </div>

                        <!-- Start Mobile-Menu-Bar -->
                        <div class="mobile-menu-bar d-block d-xl-none">
                            <div class="hamberger">
                                <button class="hamberger-button rbt-round-btn">
                                    <i class="feather-menu"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Start Mobile-Menu-Bar -->
                    </div>

                </div>
            </div>
        </div>


    </header>
    
    <!-- Mobile Menu Section -->
    <div class="popup-mobile-menu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="content">
                    <div class="logo">
                        <a href="index.html">
                            <img src="images/log.png" alt="Education Logo Images">
                        </a>
                    </div>
                    <div class="rbt-btn-close">
                        <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </div>
                <p class="description">Announce upcoming events, workshops, or conferences related to education.</p>
                <ul class="navbar-top-left rbt-information-list justify-content-start">
                    <li>
                        <a href="mailto:edusprayIndia@gmail.com"><i class="feather-mail"></i>edusprayIndia@gmail.com</a>
                    </li>
                    <li>
                        <a href="tel:+91-8595684716"><i class="feather-phone"></i>+91 8595684716</a>
                    </li>
                </ul>
            </div>

            <nav class="mainmenu-nav">
                <ul class="mainmenu">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="about.html" target="_blank">About Us</a>
                    </li>
                    <li class="with-megamenu has-menu-child-item">
                        <a href="#">Courses <i class="feather-chevron-down"></i></a>
                        <!-- Start Mega Menu  -->
                        <div class="rbt-megamenu grid-item-2">
                            <div class="wrapper">

                                <div class="row row--15">
                                    <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                        <h3 class="rbt-short-title">top Courses in India and Abroad</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="course.php?slug=bca"><img src="images/BCA.png" alt=""> BCA</a></li>
                                            <li><a href="course.php?slug=bcom"><img src="images/B.COM.png" alt=""> B.com</a>
                                            </li>
                                            <li><a href="course.php?slug=btech"> <img src="images/B.TECH.png" alt=""> B.tech</a>
                                            </li>
                                            <li><a href="course.php?slug=bba"> <img src="images/BBA.png" alt=""> BBA</a></li>
                                            <li><a href="course.php?slug=bajmc"><img src="images/BA-JMC.png" alt=""> BA-jmc</a>
                                            </li>
                                            <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png" alt="">
                                                    B.Pharma</a></li>
                                            <li><a href="course.php?slug=bed"><img src="images/B.Ed.png" alt=""> B.Ed</a></li>
                                            <li><a href="course.php?slug=baeng"><img src="images/BA-ENG.png" alt=""> BA-Eng</a>
                                            </li>
                                            <li><a href="course.php?slug=baeco"><img src="images/BA-ECO.png" alt=""> BA-Eco</a>
                                            </li>
                                            <li><a href="course.php?slug=ballb"><img src="images/BA-LLB.png" alt=""> BA-LLB</a>
                                            </li>
                                            <li><a href="course.php?slug=bballb"><img src="images/BBA-LLB.png" alt=""> BBA-LLB</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                        <ul class="mega-menu-item">
                                            <li><a href="course.php?slug=medical"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/medical.webp"
                                                        alt="">Medical</a></li>
                                            <li><a href="course.php?slug=engineering"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/engineering.webp"
                                                        alt="">Engineering</a></li>
                                            <li><a href="course.php?slug=management"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/management.webp"
                                                        alt="">Business and Management</a></li>
                                            <li><a href="course.php?slug=architecture"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/architecture.webp"
                                                        alt=""> Architecture</a></li>
                                            <li><a href="course.php?slug=commerce"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/commerce.webp"
                                                        alt="">Commerce</a></li>
                                            <li><a href="course.php?slug=aviation"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/aviation.webp"
                                                        alt="">Aviation</a></li>
                                            <li><a href="course.php?slug=hotel"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/hotel.webp"
                                                        alt="">Hotel Management</a></li>
                                            <li><a href="course.php?slug=humanities"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/arts.webp"
                                                        alt="">Humanities</a></li>
                                            <li><a href="course.php?slug=journalism"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/masscom.png"
                                                        alt="">Journalism, Media and Mass Comm</a></li>
                                            <li><a href="course.php?slug=law"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/law.webp"
                                                        alt="">Law</a></li>
                                            <li><a href="course.php?slug=languages"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/language.png"
                                                        alt="">Languages and Teaching</a></li>
                                            <li><a href="course.php?slug=design"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/design.webp"
                                                        alt=""> Arts and Design</a></li>
                                            <li><a href="course.php?slug=socialsciences"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/Science.png"
                                                        alt="">Social Sciences</a></li>
                                            <li><a href="course.php?slug=agriculture"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/Agriculture.webp"
                                                        alt="">Agriculture and Forestry</a></li>
                                            <li><a href="course.php?slug=computerscience"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/Science.webp"
                                                        alt="">Computer Science and IT</a> </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Mega Menu  -->
                    </li>

                    <li class="has-dropdown has-menu-child-item">
                        <a href="#">University
                            <i class="feather-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li class="has-dropdown has-menu-child-item">
                                <a href="#">Study in India
                                </a>
                                <ul class="submenu">
                                    <li><a href="university-of-delhi.html">University of Delhi-NCR</a></li>
                                    <li><a href="ipu.html">GGSIPU in Delhi-NCR</a></li>
                                    <li><a href="top_reputed.html"> Top Reputed Universities</a>
                                    </li>

                                </ul>
                            </li>

                    
                    <li><a href="studyinireland.html">Study in Abroad</a>

                    </li>
                </ul>
                </li>

                <li class="has-dropdown has-menu-child-item">
                    <a href="#">Countries
                        <i class="feather-chevron-down"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="#"> <img src="images/India.png" alt=""> India</a>

                        </li>
                        <li><a href="#"> <img src="images/uk.png" alt=""> United-Kingdom</a>

                        </li>
                        <li><a href="#"><img src="images/usa.png" alt=""> USA</a></li>
                        <li><a href="#"> <img src="images/ire.png" alt=""> Ireland</a></li>
                        <li><a href="#"> <img src="images/can.png" alt=""> Canada</a></li>
                        <li><a href="#"><img src="images/dub.png" alt="">Dubai</a></li>

                    </ul>
                </li>

                <li>
                    <a href="contact.html">Medical</a>
                    

                </li>
                <li>
                    <a href="blog.html">Blog</a>
                </li>

                </ul>
            </nav>

            <div class="mobile-menu-bottom">
                <div class="rbt-btn-wrapper mb--20">
                    <a target="_blank"
                        class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center"
                        href="contact.html">
                        <span>Register</span>
                    </a>
                </div>

                <div class="social-share-wrapper">
                    <span class="rbt-short-title d-block">Find With Us</span>
                    <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                        <li><a href="https://www.facebook.com/edusprayIndia1/">
                                <i class="feather-facebook"></i>
                            </a>
                        </li>
                        <li><a href="https://www.twitter.com">
                                <i class="feather-twitter"></i>
                            </a>
                        </li>
                        <li><a href="https://www.instagram.com/edusprayIndia/">
                                <i class="feather-instagram"></i>
                            </a>
                        </li>
                        <li><a href="https://www.linkedin.com/feed/?trk=onboarding-landing">
                                <i class="feather-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div id="whats_icon">
        <a href="https://wa.me/+918595684716" style=" width: 70px;
        height:70px;
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 99999;
        display: block;
        object-fit: cover;"><img
                src="https://res.cloudinary.com/dxhwn8am2/image/upload/v1701074747/png-clipart-phone-logo-whatsapp-computer-icons-blackberry-10-mobile-phones-instant-messaging-icon-whatsapp-grass-symbol-removebg-preview_qrw0p0.png"
                alt="WhatsApp"></a>
    </div>
    
    <!-- User Authentication & Menu Script -->
    <script>
        // Toggle user dropdown
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const btn = document.querySelector('.user-menu-btn');
            if (dropdown) dropdown.classList.toggle('show');
            if (btn) btn.classList.toggle('open');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const btn = document.querySelector('.user-menu-btn');
            if (dropdown && !e.target.closest('.user-menu-dropdown')) {
                dropdown.classList.remove('show');
                if (btn) btn.classList.remove('open');
            }
        });
        
        // Check authentication status on page load
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const response = await fetch('php/auth_check.php');
                const data = await response.json();
                
                const loginBtn = document.getElementById('loginBtnWrapper');
                const userMenu = document.getElementById('userMenuWrapper');
                
                if (data.logged_in && data.user) {
                    // Add logged-in class to body for CSS fallback
                    document.body.classList.add('user-logged-in');
                    
                    // Show user menu, hide login button
                    if (loginBtn) {
                        loginBtn.classList.add('d-none');
                        loginBtn.classList.remove('d-xl-block');
                    }
                    if (userMenu) {
                        userMenu.classList.remove('d-none');
                        userMenu.classList.add('d-xl-block');
                        
                        // Set user name
                        const nameEl = document.getElementById('userName');
                        const initialEl = document.getElementById('userInitial');
                        const avatarEl = document.getElementById('userAvatar');
                        
                        if (nameEl) nameEl.textContent = data.user.name.split(' ')[0];
                        if (initialEl) initialEl.textContent = data.user.name.charAt(0).toUpperCase();
                        
                        // If user has profile picture (from Google)
                        if (data.user.picture && avatarEl) {
                            avatarEl.innerHTML = '<img src="' + data.user.picture + '" alt="Profile">';
                        }
                    }
                } else {
                    // Show login button, hide user menu (default state is correct, no changes needed)
                    if (loginBtn) {
                        loginBtn.classList.remove('d-none');
                        loginBtn.classList.add('d-xl-block');
                    }
                    if (userMenu) {
                        userMenu.classList.add('d-none');
                        userMenu.classList.remove('d-xl-block');
                    }
                }
            } catch (error) {
                console.log('Auth check failed:', error);
            }
        });
    </script>
