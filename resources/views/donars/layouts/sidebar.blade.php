<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="javascript:void(0)" class="logo logo-dark">
            <span class="logo-sm">
                <img src="https://gausevasociety.com/wp-content/uploads/2024/01/gaushala-logo.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="https://gausevasociety.com/wp-content/uploads/2024/01/gaushala-logo.png" alt="" height="55">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="javascript:void(0)" class="logo logo-light">
            <span class="logo-sm">
                <img src="https://gausevasociety.com/wp-content/uploads/2024/01/gaushala-logo.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="https://gausevasociety.com/wp-content/uploads/2024/01/gaushala-logo.png" alt="" height="55">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{url('dashboard')}}">
                        <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{url('settings')}}">
                        <i class="ri-user-line"></i> <span data-key="t-settings">My Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#mydonations" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="mydonations">
                        <i class="ri-user-smile-line"></i> <span data-key="t-dashboards">My Donations</span>
                    </a>
                    <div class="collapse menu-dropdown" id="mydonations">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('donor/donations') }}" class="nav-link" data-key="donations"> My Payments </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('donor/80G-donations') }}" class="nav-link" data-key="monthly-donations">80G Donation's </a>
                            </li>
                             <li class="nav-item">
                                <a href="{{ route('donations.consolidated-receipts') }}" class="nav-link" data-key="consolidated-receipt">Consolidated Receipts</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="{{ url('donar/consolidated-receipt') }}" class="nav-link" data-key="consolidated-receipt">Consolidated Receipt </a>
                            </li> -->
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#dontae-online" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="dontae-online">
                         <i class="ri-earth-line"></i> <span data-key="online-donation">Donate Online</span>
                    </a>
                    <div class="collapse menu-dropdown" id="dontae-online">
                        <ul class="nav nav-sm flex-column">
                            <!--<li class="nav-item">-->
                            <!--    <a href="{{route('online-donation')}}" class="nav-link" data-key="online-donation"> Donate Online </a>-->
                            <!--</li>-->
                            <li class="nav-item">
                                <a href="{{route('online-donation')}}" class="nav-link" data-key="online-donation">Donate Monthly </a>
                            </li>
                           
                            <li class="nav-item">
                                <a href="https://gausevasociety.com/donations-for-gaushala" class="nav-link" data-key="monthly-donations">Support To Save Cow </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('MyReferences')}}">
                        <i class="ri-user-line"></i> <span data-key="my-references">My References</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('celebrations.index') }}">
                        <i class="ri-heart-line"></i> <span data-key="celebrations">Celebrate in Gaushala</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('feedbacks')}}">
                        <i class="ri-headphone-line"></i> <span data-key="t-settings">FeedBack / Complaints</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbarNav = document.getElementById('navbar-nav');
        const navLinks = navbarNav.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                // Prevent the default link behavior (navigation) if needed
                // event.preventDefault();

                // Remove active class from all links
                navLinks.forEach(otherLink => {
                    otherLink.classList.remove('active');
                });

                // Add active class to the clicked link
                this.classList.add('active');
            });
        });

        // Optional: Add active class to the initially active link based on the current URL
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            if (linkPath === currentPath) {
                link.classList.add('active');
            }
        });
    });
</script>