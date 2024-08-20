<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>V. Sankar Aiyar & Co</title>

    <!-- stylesheet start -->
    @include('backEnd.layouts.includes.stylesheet')
    <!-- stylesheet end -->
    @if (Request::is('invoiceview/*') || Request::is('creditnote/*'))
        <style>
            @media print {
                @page {
                    margin: 0;
                }

                div.page {
                    page-break-before: always;
                }

                .footer {
                    position: fixed;
                    bottom: 0px;
                }

                .footer:before {
                    content: counter;
                }

                .footerr {
                    position: fixed;
                    bottom: 0px;
                }

                .footerr:before {
                    content: counter;
                }

                .footerrr {
                    position: fixed;
                    bottom: 0px;
                }

                .footerrr:before {
                    content: counter;
                }
            }
        </style>
    @endif
</head>

<body class="fixed">
    <!-- Page Loader
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
    <div class="wrapper">
        <!-- leftsidebar start -->
        @include('backEnd.layouts.includes.leftsidebar')
        <!-- leftsidebar end -->


        <!-- Page Content  -->
        <div class="content-wrapper">
            <div class="main-content">
                <!-- header start -->
                @include('backEnd.layouts.includes.header')
                <!-- header end -->



                <!-- Main Content start-->
                @yield('backEnd_content')
                <!-- Main Content end-->


            </div><!--/.main content-->
            <!-- footer start -->
            @include('backEnd.layouts.includes.footer')
            <!-- footer end -->
        </div><!--/.wrapper-->
    </div>
    <!-- js bar start-->
    @include('backEnd.layouts.includes.js')
    <!-- js bar end -->

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const menuItems = document.querySelectorAll('nav.sidebar-nav li a');
            const currentUrl = document.URL;

            menuItems.forEach((link) => {
                const href = link.href;

                if (href === currentUrl) {
                    $(link).attr("aria-expanded", "true");

                    const parent = link.closest("li");
                    $(parent).addClass("mm-active").css({
                        "background-color": "#37a000",
                        "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                    });

                    const secondLevel = parent.querySelector("ul.nav-second-level");
                    const thirdLevel = parent.querySelector("ul.nav-third-level");

                    if (secondLevel) {
                        const parentMenu = secondLevel.closest("li");
                        $(parentMenu).addClass("mm-active").css({
                            "background-color": "#37a000",
                            "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                        });
                        secondLevel.classList.add("mm-show");
                    }

                    if (thirdLevel) {
                        $(thirdLevel).addClass("mm-show");

                        const secondLevel = thirdLevel.closest("ul.nav-second-level");
                        const parentMenu = secondLevel.closest("li");
                        $(parentMenu).addClass("mm-active").css({
                            "background-color": "#37a000",
                            "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                        });
                        secondLevel.classList.add("mm-show");
                    }
                }
            });
        });
    </script>

</body>

</html>
