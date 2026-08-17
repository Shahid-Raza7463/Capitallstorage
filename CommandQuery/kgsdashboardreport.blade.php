    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet"> --}}


    @extends('backEnd.layouts.layout') @section('backEnd_content')
        @php
            $parameterlist = [];

            if (!empty($partnerId)) {
                $parameterlist['partnerId'] = $partnerId;
            }
            if (!empty($yearly)) {
                $parameterlist['yearly'] = $yearly;
            }
            if (!empty($monthsdigit)) {
                $parameterlist['monthsdigit'] = $monthsdigit;
            }

            $parameters = !empty($parameterlist) ? '?' . http_build_query($parameterlist) : '';
        @endphp
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                /* font-family: 'Poppins', sans-serif; */
                background-color: #f5f7fa;
                color: #333;
                padding: 20px;
                /* font-family: Arial, sans-serif; */
            }

            .dashboard-card-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 25px;
            }

            .dashboard-card-fullcontent {
                display: grid;
                grid-template-columns: 1fr;
                gap: 25px;
                margin-top: 25px
            }

            .card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                padding: 25px;
                margin-bottom: 25px;
                transition: transform 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
            }

            .card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid #eee;
            }

            .card-header h2 {
                font-size: 20px;
                font-weight: 800;
                color: #2c3e50;
                margin-left: -16px;
            }

            .priority-tag {
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .high-priority {
                background-color: #ffebee;
                color: #e53935;
            }

            .on-track {
                background-color: #e8f5e9;
                color: #43a047;
            }

            .on-open {
                background-color: rgb(243 244 246);
                color: rgb(75 85 99);
            }

            .on-progress {
                background-color: rgb(219 234 254);
                color: rgb(37 99 235);
            }

            .on-closed {
                background-color: rgb(254 226 226);
                color: rgb(220 38 38);
            }

            .delayed {
                background-color: #fff8e1;
                color: #ff8f00;
            }


            .completed {
                background-color: #c4ffc8;
                color: #0b680f;
            }

            .on-track1 {
                background-color: #3ea9dc42;
                color: #4b43a0;
            }

            .delayed1 {
                background-color: #e3938554;
                color: #ff2f00;
            }

            .completed1 {
                background-color: #caf4cd;
                color: #0b680f;
            }


            .assignment-card {
                padding: 20px;
                margin-bottom: 10px;
                border-radius: 10px;
                background: #f8f9fa;
            }

            .assignment-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .assignment-title h3 {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .assignment-title p {
                font-size: 14px;
                color: #7f8c8d;
            }

            .assignment-status {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }

            .progress-container {
                margin-top: -42px;
            }

            .progress-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
            }

            .progress-bar {
                height: 10px;
                background: #e0e0e0;
                border-radius: 5px;
                overflow: hidden;
            }

            .progress-fill {
                height: 100%;
                border-radius: 5px;
            }

            .progress-85 {
                width: 85%;
                background: linear-gradient(to right, #4facfe, #00f2fe);
            }

            .progress-45 {
                width: 45%;
                background: linear-gradient(to right, #ff9a9e, #fad0c4);
            }

            .progress-84 {
                width: 84%;
                background: linear-gradient(to right, #4facfe, #00f2fe);
            }

            .progress-60 {
                width: 60%;
                background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            }

            .progress-100 {
                width: 100%;
                background: linear-gradient(to right, #0fd850, #0fd850);
            }

            .progress-37 {
                width: 37%;
                background: linear-gradient(to right, #ff9a9e, #fad0c4);
            }

            .progress-80 {
                width: 80%;
                background: linear-gradient(to right, #a1c4fd, #c2e9fb);
            }


            .progress-document-84 {
                width: 84%;
                background: linear-gradient(to right, #0a0a0b, #650997);
            }


            .progress-document-45 {
                width: 45%;
                background: linear-gradient(to right, #0a0a0b, #650997);
            }

            .progress-document-100 {
                width: 100%;
                background: linear-gradient(to right, #0a0a0b, #650997);
            }


            .document-progress {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .document-card {
                background: #f8f9fa;
                padding: 15px;
                margin-bottom: 12px;
                border-radius: 10px;
            }

            .document-card h3 {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 10px;
            }

            .document-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
                font-size: 14px;
            }

            .progress-value {
                font-weight: 600;
            }

            .ecqr-card {
                padding: 20px;
                margin-bottom: 10px;
                border-radius: 10px;
                background: #f8f9fa;
            }

            .ecqr-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }


            .ecqr-title h3 {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .ecqr-title p {
                font-size: 14px;
                color: #7f8c8d;
            }

            .ecqr-status {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }

            .dashboard-bottom {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 25px;
                margin-top: 15px;
            }

            .badge {
                padding: 3px 10px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 500;
            }

            .badge-open {
                background: #e3f2fd;
                color: #1976d2;
            }

            .badge-working {
                background: #fff8e1;
                color: #ff8f00;
            }

            .badge-close {
                background: #e8f5e9;
                color: #43a047;
            }

            /* filter section  */
            .filter-maincontainer {
                display: grid;
                grid-template-columns: 1fr;
                gap: 25px;
                margin-top: 25px;
                /* width: 930px; */
                margin-left: 23px;
                margin-right: 23px;
            }

            .filtercontainer {
                background: white;
                border-radius: 12px;
                /* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); */
                padding: 25px;
                /* margin-bottom: 25px; */
                transition: transform 0.3s ease;
            }

            .filterfield {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid #eee;
            }

            /* scrollbar enable on card */
            .scrollbarcontrol {
                /* max-height: 218px; */
                max-height: 618px;
                overflow-y: auto;
                padding-right: 5px;
            }

            .table-responsive.scrollbarcontroltable {
                max-height: 618px;
                overflow-y: auto;
            }

            @media (max-width: 992px) {

                .dashboard-card-content,
                .dashboard-bottom {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- <div class="content-header row align-items-center m-0">
            <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#" onclick="window.print(); return false;">Download as pdf</a>
                    </li>
                </ol>
            </nav>
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="typcn typcn-home-outline mr-2"></i></div>
                    <div class="media-body">
                        <h1 class="font-weight-bold">Dashboard Report</h1>
                        <small>From now on you will start your activities.</small>
                    </div>
                </div>
            </div>
        </div> --}}
        <style>
            /* filter section  */
            .filter-maincontainer22 {
                display: grid;
                grid-template-columns: 1fr;
                gap: 25px;
                margin-top: 25px;
                /* width: 930px; */
                margin-left: 23px;
                margin-right: 23px;
            }

            .filtercontainer22 {
                display: flex;
                background: white;
                border-radius: 12px;
                /* box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); */
                padding: 25px;
                /* margin-bottom: 25px; */
                transition: transform 0.3s ease;
            }

            #test {
                margin-left: 0.5rem;
            }

            #testpdf {
                margin-left: 30rem;
            }

            .filter-maincontainer22 {
                margin-top: 18px;
            }

            .filtercontainer22 {
                align-items: center;
                border-left: 5px solid #0f8f5a;
                border-radius: 10px;
                border-top: 1px solid #e5ece8;
                border-right: 1px solid #e5ece8;
                border-bottom: 1px solid #e5ece8;
                box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
                padding: 20px 22px;
            }

            .filtercontainer22 .btn {
                border-radius: 7px;
                padding: 12px 20px;
                font-size: 14px;
                font-weight: 700;
                border: 1px solid transparent;
                box-shadow: none;
            }

            .filtercontainer22 .btn-success {
                background: #e9fbef !important;
                border-color: #bdeccc !important;
                color: #078146 !important;
                box-shadow: 0 4px 10px rgba(15, 143, 90, .22);
            }

            .filtercontainer22 .btn-light {
                background: #fff !important;
                border-color: transparent !important;
                color: #43564c !important;
            }

            #test {
                margin-left: 12px;
            }

            #testpdf {
                margin-left: auto;
                border: 1px solid #dfe9e5 !important;
                background: #fff !important;
                color: #43564c !important;
            }

            .matched-dashboard-card {
                border: 1px solid #e2ebe7 !important;
                border-radius: 12px !important;
                box-shadow: 0 10px 24px rgba(15, 23, 42, .08) !important;
                padding: 16px !important;
                background: #fff !important;
            }

            .matched-dashboard-card>.card-header {
                position: relative;
                padding: 0 0 12px !important;
                margin-bottom: 14px !important;
                border-bottom: 1px solid #edf2ef !important;
                background: transparent !important;
            }

            .matched-dashboard-card>.card-header::after {
                content: "";
                position: absolute;
                left: 0;
                bottom: -1px;
                width: 50px;
                height: 2px;
                background: #0f8f5a;
            }

            .matched-dashboard-card>.card-header h2 {
                margin-left: 0 !important;
                color: #31473b;
                font-size: 18px;
                font-weight: 800;
            }

            .matched-dashboard-card .assignment-card,
            .matched-dashboard-card .document-card,
            .matched-dashboard-card .ecqr-card {
                border: 1px solid #dde8e3;
                border-left: 3px solid #69bd98;
                border-radius: 8px;
                background: #fff;
                box-shadow: none;
                padding: 12px;
            }

            .matched-dashboard-card .assignment-title h3,
            .matched-dashboard-card .document-card h3,
            .matched-dashboard-card .ecqr-title h3 {
                color: #40564a;
                font-size: 16px;
                font-weight: 700;
            }

            .matched-dashboard-card .assignment-title p,
            .matched-dashboard-card .ecqr-title p,
            .matched-dashboard-card .progress-info,
            .matched-dashboard-card .document-info {
                color: #7c8c84;
                font-size: 13px;
            }

            .matched-dashboard-card .priority-tag {
                border-radius: 5px;
                font-size: 11px;
                font-weight: 700;
                padding: 6px 10px;
            }

            .matched-dashboard-card .progress-bar {
                height: 7px;
                border-radius: 999px;
                background: #e8efeb;
            }

            .matched-dashboard-card .progress-fill {
                border-radius: 999px;
            }

            .matched-dashboard-card .table-responsive {
                border: 1px solid #dde8e3;
                border-radius: 8px;
                overflow: auto;
            }

            .matched-dashboard-card .table {
                margin-bottom: 0;
            }

            .matched-dashboard-card .table thead th {
                background: #f5f1f1;
                color: #496356;
                border-bottom: 1px solid #d8e7df !important;
                font-size: 13px;
                font-weight: 800;
            }

            .matched-dashboard-card .table tbody td {
                border-top: 1px solid #edf2ef !important;
                color: #7d8782;
                font-size: 13px;
            }

            /* Reference-matched sections only */
            .body-content>.row {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
                /* margin-left: 23px;
                                            margin-right: 23px; */
            }

            .body-content>.row>[class*="col-"] {
                width: auto;
                max-width: none;
                flex: none;
                padding: 0;
                margin-bottom: 0 !important;
            }

            .body-content>.row>[class*="col-"] a {
                text-decoration: none;
            }

            .body-content>.row>[class*="col-"] a>div {
                position: relative;
                min-height: 122px;
                height: 100%;
                padding: 14px !important;
                /* border: 1px solid #e8eef5 !important; */
                border-radius: 18px !important;
                background: #ffffff !important;
                box-shadow: 0 12px 28px rgba(15, 23, 42, .07) !important;
                transition: .2s ease;
            }

            .body-content>.row>[class*="col-"] a>div:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 34px rgba(15, 23, 42, .1) !important;
            }

            .body-content>.row>[class*="col-"] a>div::after {
                position: absolute;
                top: 14px;
                right: 14px;
                width: 30px;
                height: 30px;
                border-radius: 12px;
                display: grid;
                place-items: center;
                font-family: "Font Awesome 6 Free";
                font-weight: 900;
                font-size: 14px;
            }

            .body-content>.row>[class*="col-"]:nth-child(1) a>div::after {
                content: "\f570";
                color: #a16207;
                background: #fff7ed;
            }

            .body-content>.row>[class*="col-"]:nth-child(2) a>div::after {
                content: "\f53a";
                color: #0284c7;
                background: #e0f2fe;
            }

            .body-content>.row>[class*="col-"]:nth-child(3) a>div::after {
                content: "\f058";
                color: #059669;
                background: #dcfce7;
            }

            .body-content>.row>[class*="col-"]:nth-child(4) a>div::after {
                content: "\f071";
                color: #ef4444;
                background: #fee2e2;
            }

            .body-content>.row>[class*="col-"]:nth-child(5) a>div::after {
                content: "\f1ec";
                color: #64748b;
                background: #f1f5f9;
            }

            .body-content>.row>[class*="col-"]:nth-child(6) a>div::after {
                content: "\f7a9";
                color: #f43f5e;
                background: #ffe4e6;
            }

            .body-content>.row>[class*="col-"]:nth-child(7) a>div::after {
                content: "\f3fd";
                color: #0ea5e9;
                background: #e0f2fe;
            }

            .body-content>.row>[class*="col-"]:nth-child(8) a>div::after {
                content: "\f15c";
                color: #fb7185;
                background: #ffe4e6;
            }

            .body-content>.row>[class*="col-"]:nth-child(9) a>div::after {
                content: "\f017";
                color: #b45309;
                background: #fef3c7;
            }

            .body-content>.row>[class*="col-"]:nth-child(10) a>div::after {
                content: "\f555";
                color: #10b981;
                background: #d1fae5;
            }

            .body-content>.row .font-weight-bold.small {
                max-width: calc(100% - 46px);
                color: #4a5568;
                font-size: 12px;
                line-height: 1.35;
            }

            .body-content>.row .h4 {
                color: #17233c;
                font-size: 24px;
                margin: 12px 0 6px;
            }

            .body-content>.row .text-muted.small {
                color: #718096 !important;
                line-height: 1.35;
            }

            .reference-section-card {
                border: 1px solid #e8eef5 !important;
                border-radius: 22px !important;
                box-shadow: 0 12px 28px rgba(15, 23, 42, .07) !important;
                background: #fff !important;
            }

            .dashboard-card-content,
            .dashboard-card-fullcontent {
                gap: 14px;
                margin-top: 14px;
            }

            .dashboard-card-content {
                align-items: start;
            }

            .dashboard-card-content>.card,
            .dashboard-card-fullcontent>.card {
                margin-bottom: 14px;
            }

            .reference-section-card>.card-header {
                padding-bottom: 12px;
                border-bottom: 1px solid #eef3f8;
            }

            .reference-section-card>.card-header h2 {
                margin-left: 0;
                color: #1d2939;
                font-size: 16px;
                font-weight: 800;
            }

            .reference-section-card .table-responsive {
                border: 1px solid #e8eef5;
                border-radius: 16px;
                overflow: auto;
            }

            .reference-section-card .table {
                margin-bottom: 0;
            }

            .reference-section-card .table thead th {
                background: #f6f9fc;
                border-bottom: 1px solid #e8eef5 !important;
                color: #667085;
                font-size: 11px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .04em;
            }

            .reference-section-card .table tbody td {
                border-top: 1px solid #edf2f7 !important;
                color: #344054;
                font-size: 13px;
                vertical-align: middle;
            }

            .reference-section-card canvas {
                max-width: 100%;
            }

            .reference-checkin {
                padding: 22px !important;
                margin-top: 25px;
                border: 1px solid #e0e6ef !important;
                border-radius: 18px !important;
                box-shadow: 0 6px 16px rgba(15, 23, 42, .08) !important;
                background: #fff !important;
            }

            .reference-checkin-heading {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 20px;
                padding: 0 0 16px;
                border-bottom: 1px solid #eef3f8;
            }

            .reference-checkin-heading h2 {
                margin: 0;
                color: #001b3d;
                font-size: 18px;
                font-weight: 800;
                line-height: 1.2;
            }

            .reference-checkin-heading h3 {
                margin: 0;
                color: #8a96ad;
                font-size: 16px;
                font-weight: 500;
                line-height: 1.2;
            }

            .reference-checkin-body {
                display: block !important;
                padding: 0 !important;
                margin: 0 !important;
                border: 0 !important;
            }

            .reference-checkin-grid {
                display: grid !important;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
                margin: 0 !important;
                padding: 0;
                border: 0 !important;
                border-radius: 0;
                background: #fff;
                box-shadow: none;
            }

            .reference-checkin-title {
                width: 100%;
                flex: 0 0 100%;
                max-width: 100%;
                height: auto !important;
                padding: 0 !important;
                transform: translateY(-70px);
                margin-bottom: -42px;
            }

            .reference-checkin-title .card {
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: 0 !important;
                background: transparent !important;
            }

            .reference-checkin-title .card-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 !important;
                margin: 0 !important;
                border: 0 !important;
            }

            .reference-checkin-title h2 {
                margin: 0 !important;
                color: #1d2939;
                font-size: 24px;
                font-weight: 800;
                text-transform: none;
            }

            .reference-checkin-title h3 {
                margin: 0 !important;
                color: #8a96ad;
                font-size: 20px !important;
                font-weight: 500 !important;
            }

            .reference-checkin-title h3::before {
                content: "";
            }

            .reference-checkin-metric {
                height: auto !important;
                margin-bottom: 0 !important;
                width: auto !important;
                max-width: none !important;
                padding: 0 !important;
            }

            .reference-checkin-metric .card {
                min-height: 92px;
                height: 92px;
                padding: 18px 20px !important;
                margin-bottom: 0 !important;
                border: 1px solid #e8eef5 !important;
                border-radius: 14px !important;
                box-shadow: none !important;
                background: #fbfcfe !important;
            }

            .reference-checkin-metric .card-header {
                display: flex;
                align-items: center;
                gap: 14px;
                min-height: 54px;
                padding: 0 !important;
                margin: 0 !important;
                border: 0 !important;
                background: transparent !important;
                text-align: left !important;
            }

            .reference-checkin-metric .card-icon {
                flex: 0 0 38px;
                width: 38px !important;
                height: 38px !important;
                min-width: 38px;
                margin: 0 !important;
                border-radius: 10px;
                background-image: none !important;
                color: #2563ff;
                box-shadow: none;
                font-size: 16px;
            }

            .reference-checkin-metric .card-icon i {
                color: inherit !important;
                font-size: 16px !important;
                line-height: 1;
            }

            .reference-checkin-metric:nth-of-type(1) .card-icon {
                background: #e9edff !important;
                color: #2563ff;
            }

            .reference-checkin-metric:nth-of-type(2) .card-icon,
            .reference-checkin-metric:nth-of-type(7) .card-icon {
                background: #dff2ef !important;
                color: #07987d;
            }

            .reference-checkin-metric:nth-of-type(3) .card-icon {
                background: #f3eadc !important;
                color: #d88312;
            }

            .reference-checkin-metric:nth-of-type(4) .card-icon,
            .reference-checkin-metric:nth-of-type(8) .card-icon {
                background: #fae4ea !important;
                color: #f43f5e;
            }

            .reference-checkin-metric:nth-of-type(5) .card-icon {
                background: #eeeaff !important;
                color: #7c6ff0;
            }

            .reference-checkin-metric:nth-of-type(6) .card-icon {
                background: #e9edff !important;
                color: #2563ff;
            }

            .reference-checkin-metric a {
                min-width: 0;
                flex: 1;
                text-decoration: none !important;
                display: flex;
                flex-direction: column-reverse;
                background: transparent !important;
            }

            .reference-checkin-metric .card-category {
                margin: 3px 0 0 !important;
                color: #435775 !important;
                font-size: 12px !important;
                font-weight: 500 !important;
                line-height: 1.25;
                text-transform: none !important;
                white-space: normal;
                word-break: normal;
                overflow-wrap: normal;
            }

            .reference-checkin-metric .card-title {
                margin: 0 !important;
                color: #001b3d;
                font-size: 18px !important;
                font-weight: 800 !important;
                line-height: 1;
            }

            @media (max-width: 1199px) {
                .body-content>.row {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .reference-checkin-metric {
                    width: auto !important;
                    max-width: none !important;
                }

                .reference-checkin-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }

            @media (max-width: 991px) {
                .body-content>.row {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .reference-checkin-metric {
                    width: auto !important;
                    max-width: none !important;
                }

                .reference-checkin-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 575px) {
                .body-content>.row {
                    grid-template-columns: 1fr;
                    margin-left: 12px;
                    margin-right: 12px;
                }

                .reference-checkin-metric {
                    width: auto !important;
                    max-width: none !important;
                }

                .reference-checkin-grid {
                    grid-template-columns: 1fr;
                    padding: 20px;
                }

                .reference-checkin-heading {
                    display: block;
                }

                .reference-checkin-heading h3 {
                    margin-top: 8px;
                    font-size: 16px;
                }
            }
        </style>
        <div class="filter-maincontainer22">
            <div class="filtercontainer22">
                <a href="{{ url('home') }}"
                    class="{{ Request::is('home') ? 'btn btn-success' : 'btn btn-light' }} d-flex align-items-center fw-bold">
                    {{-- <i class="icon-card me-2"></i> --}}
                    <span>Dashboard</span>

                </a>
                <a href="{{ url('dashbordreport') }}"
                    class="{{ Request::is('home') ? 'btn btn-light' : 'btn btn-success' }} d-flex align-items-center fw-bold"
                    id="test">
                    {{-- <i class="icon-programming-arrow me-2"></i> --}}
                    <span>Dashboard Report</span>
                </a>

                <a href="#" onclick="window.print(); return false;"
                    class="btn btn-light d-flex align-items-center fw-bold" id="testpdf">

                    <span>Download as pdf</span>
                </a>
            </div>
        </div>

        @if (Auth::user()->role_id == 11 ||
                Auth::user()->role_id == 12 ||
                Auth::user()->role_id == 13 ||
                Auth::user()->teammember_id == 156)
            <div class="filter-maincontainer">
                <div class="filtercontainer">
                    <form id="filterform" method="POST" action="{{ url('/filterdashboardreport') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $isSpecialUser =
                                in_array(Auth::user()->role_id, [11, 12]) || Auth::user()->teammember_id == 156;

                            $yearCol = $isSpecialUser
                                ? (Request::is('filterdashboardreport')
                                    ? 3
                                    : 4)
                                : (Request::is('filterdashboardreport')
                                    ? 4
                                    : 5);

                            $monthCol = $isSpecialUser ? 3 : 5;
                        @endphp
                        <div class="row">
                            <div class="col-{{ $yearCol }}">
                                <div class="form-group">
                                    <strong><label for="yearly">Select Yearly</label></strong>
                                    <select required class="language form-control" id="yearly" name="yearly">
                                        <option value="">Select Year</option>
                                        @foreach ($financialYears as $fy)
                                            <option value="{{ $fy['value'] }}"
                                                {{ old('yearly') == $fy['value'] ? 'selected' : '' }}>
                                                {{ $fy['value'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-{{ $monthCol }}">
                                <div class="form-group">
                                    <strong><label for="months">Select Month</label></strong>
                                    <select class="language form-control" id="months" name="months">
                                        <option value=''>Select Month</option>
                                        @php
                                            $months = [
                                                1 => 'January',
                                                2 => 'February',
                                                3 => 'March',
                                                4 => 'April',
                                                5 => 'May',
                                                6 => 'June',
                                                7 => 'July',
                                                8 => 'August',
                                                9 => 'September',
                                                10 => 'October',
                                                11 => 'November',
                                                12 => 'December',
                                            ];
                                        @endphp

                                        @foreach ($months as $num => $name)
                                            <option value="{{ $num }}"
                                                {{ old('months') == $num ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->teammember_id == 156)
                                <div class="col-3">
                                    <div class="form-group">
                                        <strong><label for="partner">Select Partner</label></strong>
                                        <select class="language form-control" id="partner" name="partner">
                                            <option value="">Select Partner</option>
                                            @foreach ($partnerlist as $partners)
                                                <option value="{{ $partners->id }}"
                                                    {{ old('partner') == $partners->id ? 'selected' : '' }}>
                                                    {{ $partners->team_member }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" id="partner" name="partner"
                                    value="{{ Auth()->user()->teammember_id }}">
                            @endif
                            <!-- Search Button -->
                            <div class="col-md-2 col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="search">&nbsp;</label>
                                    <button type="submit" class="btn btn-success btn-block">Search</button>
                                </div>
                            </div>
                            @if (Request::is('filterdashboardreport'))
                                <div class="col-1 d-flex justify-content-center align-items-center"
                                    style="margin-left: -17px;">
                                    <div class="form-group m-0">
                                        <a href="{{ url('/dashbordreport') }}">
                                            <img src="{{ url('backEnd/image/reload.png') }}"
                                                style="width: 30px; height: 30px;" alt="Reload">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="body-content">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('billspending' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-danger rounded text-dark"
                                style=" background-color: rgb(249, 231, 231)">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Bills Pending for
                                            Generation</div>
                                        {{-- <div class="h4 font-weight-bold">{{ $billspending }}INR</div> --}}
                                        <div class="h4 font-weight-bold">
                                            ₹{{ number_format($billspending) }}
                                        </div>
                                        {{-- <div class="h4 font-weight-bold">
                                        {{ number_format($billspending) }}
                                        <span class="h6 text-muted">INR</span>
                                    </div> --}}
                                        <div class="text-muted small">Assignment Closed but Invoice not Generated</div>
                                        {{-- <div class="text-danger small mt-2">
                                        <i class="fas fa-arrow-down"></i> 12% vs last month
                                    </div> --}}

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('billspendingforcollection' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-success rounded text-dark"
                                style=" background-color: rgb(240, 253, 244);">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Collection's
                                            Outstanding</div>
                                        <div class="h4 font-weight-bold">
                                            ₹{{ number_format($billspendingforcollection) }}
                                        </div>
                                        <div class="text-muted small">Invoice made but Collection pending</div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('assignments/completed' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-warning rounded text-dark"
                                style="background-color: rgb(254, 252, 232);">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Assignments
                                            Completed</div>
                                        <div class="h4 font-weight-bold">
                                            {{ $assignmentcompleted }}/{{ $assignmentcreatedthisyear }}</div>
                                        <div class="text-muted small">Total Number of Assignment Completed</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('assignments/delayed' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-primary rounded text-dark"
                                style=" background-color: rgb(235, 231, 248)">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Delayed
                                            Assignments </div>
                                        <div class="h4 font-weight-bold">{{ $delayedAssignments }}</div>
                                        <div class="text-muted small">Total Number of Delayed Assignments</div>


                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('exceptionalexpenses' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-primary rounded text-dark"
                                style=" background-color: rgb(235, 231, 248)">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Other Expenses
                                        </div>

                                        <div class="h4 font-weight-bold">
                                            ₹{{ number_format($exceptionalExpenses) }}
                                        </div>
                                        <div class="text-muted small">Expenses other than Salary</div>
                                        <div class="small">&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('lossassignments' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-warning rounded text-dark"
                                style="background-color: rgb(254, 252, 232);">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Loss Making
                                            Assignments</div>
                                        <div class="h4 font-weight-bold">{{ $lossMakingCount }}</div>
                                        <div class="text-muted small">Assignments which are Making Loss</div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- @if (empty($partnerId))
                        <div class="col-md-6 col-lg-3 mb-3">
                            <a href="{{ url('tender/submittedlist' . $parameters) }}">
                                <div class="p-3 shadow-sm border border-success rounded text-dark"
                                    style=" background-color: rgb(240, 253, 244);">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="font-weight-bold small" style="margin-bottom: 10px;">Tenders Under
                                                Process
                                            </div>
                                            <div class="h4 font-weight-bold">{{ $tendersSubmittedCount }}</div>
                                            <div class="text-muted small">Tenders which are filed and Awaiting for Response
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif --}}

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('İndependence/pending' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-success rounded text-dark"
                                style=" background-color: rgb(240, 253, 244);">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Independence
                                            Acceptance</div>
                                        <div class="h4 font-weight-bold">{{ $totalNotFilled }}</div>
                                        <div class="text-muted small">Independence Acceptance Pending from the Partners and
                                            Mangers</div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('assignments/nfra' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-danger rounded text-dark"
                                style=" background-color: rgb(249, 231, 231)">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">NFRA Audits
                                            Ongoing
                                        </div>
                                        <div class="h4 font-weight-bold">{{ $auditsDue }}</div>
                                        <div class="text-muted small">NFRA Audits that are still going and are not closed
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('assignments/upcoming' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-danger rounded text-dark"
                                style=" background-color: rgb(249, 231, 231)">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Upcoming
                                            Assignments
                                        </div>
                                        <div class="h4 font-weight-bold">{{ $totalUpcomingAssignments }}</div>
                                        <div class="text-muted small">Upcoming assignments starting this or next month
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('assignments/paymentsnotrecieved' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-success rounded text-dark"
                                style=" background-color: rgb(240, 253, 244);">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Payments Not
                                            Recieved
                                        </div>

                                        <div class="h4 font-weight-bold">
                                            ₹{{ number_format($billspending15Days) }}
                                        </div>
                                        <div class="text-muted small">Within 15 Days</div>
                                        <div class="small">&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('checkinreportlist' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-warning rounded text-dark"
                                style="background-color: rgb(254, 252, 232);">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Total Check In
                                        </div>
                                        <div class="h4 font-weight-bold">
                                            {{ $checkinreportlisttoday->Total_Checkin_minus_holiday_count }}</div>
                                        <div class="text-muted small">Team Check-in Report </div>
                                        <div class="small">&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> --}}


                    {{-- <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ url('timesheetcreated' . $parameters) }}">
                            <div class="p-3 shadow-sm border border-primary rounded text-dark"
                                style=" background-color: rgb(235, 231, 248)">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="font-weight-bold small" style="margin-bottom: 10px;">Timesheet Filled
                                        </div>
                                        <div class="h4 font-weight-bold">{{ $timesheetOnClosedAssignment }}</div>
                                        <div class="text-muted small" style="font-size: 9px;">Timesheet Filled On Closed
                                            Assignment</div>
                                        <div class="small">&nbsp;</div>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> --}}
                    {{-- <div class="col-md-6 col-lg-3 mb-3">
                        <div class="p-3 shadow-sm border border-primary rounded text-dark"
                            style=" background-color: rgb(235, 231, 248)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold small" style="margin-bottom: 10px;">Work From Home
                                    </div>
                                    <div class="h4 font-weight-bold">{{ $workFromHome }}</div>
                                    <div class="text-muted small" style="font-size: 9px;">Monthly Summary</div>
                                     
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="dashboard-card-content">
                <div class="card reference-section-card">
                    <div class="card-header">
                        <h2>Assignment Status Overview</h2>
                    </div>
                    <div class="scrollbarcontrol">
                        @forelse ($assignmentOverviews as $assignmentOverview)
                            <div class="assignment-card">
                                <div class="assignment-header">
                                    <div class="assignment-title">
                                        <h3> {{ $assignmentOverview->client_name ?? '' }}</h3>
                                        <p>{{ $assignmentOverview->assignmentname ?? '' }}</p>
                                    </div>
                                    <div class="assignment-status">
                                        @php
                                            $endDate = $assignmentOverview->finalassignmentenddate;
                                        @endphp
                                        @if ($assignmentOverview->status == 0)
                                            <span class="priority-tag completed1">COMPLETED</span>
                                        @elseif ($endDate && \Carbon\Carbon::parse($endDate)->isFuture())
                                            <span class="priority-tag on-track1">ON TRACK</span>
                                        @else
                                            <span class="priority-tag delayed1">DELAYED</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="progress-container">
                                    <br>
                                    <div class="progress-info">
                                        <span>Est Hours : {{ $assignmentOverview->esthours }}</span>
                                        <span>Working Hour : {{ $assignmentOverview->workedHours ?? '0' }}</span>
                                    </div>
                                    <div class="progress-info">
                                        <span>Progress</span>
                                        <span>
                                            @if ($assignmentOverview->esthours < $assignmentOverview->workedHours)
                                                100%
                                            @else
                                                {{ $assignmentOverview->completionPercentage }}%
                                            @endif
                                        </span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill"
                                            style="width: {{ $assignmentOverview->completionPercentage }}%; background: @if ($assignmentOverview->esthours < $assignmentOverview->workedHours) linear-gradient(to right, #c10c34, #e21238); @else
												   linear-gradient(to right, #4facfe, #00f2fe); @endif
												   ">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                    {{ $assignmentOverview->finalassignmentenddate }}
                                </div>
                            </div>
                        @empty
                            <div class="assignment-card text-center text-muted p-4">
                                Assignment Status Overview Data Not found.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card matched-dashboard-card">
                    <div class="card-header">
                        <h2>Document Completion Progress</h2>
                    </div>
                    <div class="scrollbarcontrol">
                        @forelse ($documentCompletions as $documentCompletion)
                            <div class="document-card">
                                <h3 class="document-title">{{ $documentCompletion->assignmentname ?? '' }} -
                                    {{ $documentCompletion->client_name ?? '' }}</h3>
                                <div class="document-info">
                                    <span>Audit Progress</span>
                                    <span
                                        class="progress-value">{{ $documentCompletion->documentation_percentage }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill"
                                        style="width: {{ $documentCompletion->documentation_percentage }}%; background: linear-gradient(to right, #0a0a0b, #650997);">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="document-card text-center text-muted p-4">
                                Document Completion Progress Data Not found.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card matched-dashboard-card">
                    <div class="card-header">
                        <h2>NFRA Audits, Quality Reviews & Peer Review</h2>
                    </div>
                    <div class="scrollbarcontrol">
                        @forelse ($ecqrAudits as $ecqrAudit)
                            <div class="ecqr-card">
                                <div class="ecqr-header" style=" margin: 0;">
                                    <div class="ecqr-title">
                                        <h3>{{ $ecqrAudit->assignmentname ?? '' }}</h3>
                                        <p style=" margin: 0;">{{ $ecqrAudit->client_name ?? '' }}</p>
                                        <p style=" margin: 0;">Assigned to: {{ $ecqrAudit->team_member ?? '' }}</p>
                                    </div>
                                    <div class="ecqr-status">

                                        @php
                                            $endDate = $ecqrAudit->finalassignmentenddate;
                                        @endphp
                                        @if ($ecqrAudit->status == 0)
                                            <span class="priority-tag completed">COMPLETED</span>
                                        @elseif ($endDate && \Carbon\Carbon::parse($endDate)->isFuture())
                                            <span class="priority-tag on-track">IN PROGRESS</span>
                                        @else
                                            <span class="priority-tag delayed">DELAYED</span>
                                        @endif
                                        <span class="text-muted small" style="margin-top: 8px; font-size: 12px;">Due:
                                            {{ $ecqrAudit->finalassignmentenddate }}</span>
                                    </div>

                                </div>
                                <div class="document-info mt-1">
                                    <span>Reviewer Progress</span>
                                    <span
                                        class="progress-value">{{ $ecqrAudit->reviewer_documentation_percentage }}%</span>
                                </div>
                                <div class="progress-bar mt-1">
                                    <div class="progress-fill"
                                        style="width: {{ $ecqrAudit->reviewer_documentation_percentage }}%; background: linear-gradient(to right, #0a0a0b, #650997);">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="ecqr-card text-center text-muted p-4">
                                NFRA Audits, Quality Reviews & Peer Review Not found.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card matched-dashboard-card">
                    <div class="card-header">
                        <h2>Partner-wise P&L Statement</h2>
                        <a href="javascript:void(0);"
                            onclick="downloadTableAsCSV('partnerprofit', 'partner_profit_loss.csv')"
                            style="margin-top: -9px;">
                            <i class="bi bi-download" style="font-size: 1rem; color:#0a0a0b" title="Download"></i>
                        </a>
                    </div>


                    <div class="table-responsive scrollbarcontroltable">
                        <table id="partnerprofit" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="padding: 17px;">Partner</th>
                                    <th style="padding: 17px;">Revenue</th>
                                    <th style="padding: 17px;">Expenses</th>
                                    <th style="padding: 17px;">Profit</th>
                                    <th style="padding: 17px;" class="textfixed">Margin %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partnerWiseProfit as $data)
                                    <tr>
                                        <td style="padding: 17px;">{{ $data->team_member }}</td>
                                        <td style="padding: 17px;">₹{{ number_format($data->total, 2) }}</td>
                                        <td style="padding: 17px;">₹{{ number_format($data->cost, 2) }}</td>
                                        <td style="padding: 17px;"
                                            class="{{ $data->profit_loss < 0 ? 'text-danger' : 'text-success' }}">
                                            ₹{{ number_format($data->profit_loss, 2) }}
                                        </td>
                                        @php
                                            $partnerrevenue = $data->total ?? 0;
                                            $partnerprofit = $data->profit_loss ?? 0;
                                            $partnermargin =
                                                $partnerrevenue != 0 ? ($partnerprofit / $partnerrevenue) * 100 : 0;
                                        @endphp
                                        <td style="padding: 17px;"
                                            class="{{ $partnermargin < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($partnermargin, 1) }}%
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card matched-dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Assignment-wise P&L Analysis</h2>
                        <a href="javascript:void(0);"
                            onclick="downloadTableAsCSV('assignmentprofit', 'assignment_profit_loss.csv')"
                            style="margin-top: -9px;">
                            <i class="bi bi-download" style="font-size: 1rem; color:#0a0a0b" title="Download"></i>
                        </a>
                    </div>

                    <div class="table-responsive scrollbarcontroltable">
                        <table id="assignmentprofit" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="padding: 17px;">Assignment Id</th>
                                    <th style="padding: 17px;">Assignment</th>
                                    <th style="padding: 17px;">Client</th>
                                    <th style="padding: 17px;">Revenue</th>
                                    <th style="padding: 17px;">Costs</th>
                                    <th style="padding: 17px;">Profit</th>
                                    <th style="padding: 17px;" class="textfixed">Margin %</th>
                                    <th style="padding: 17px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assignmentprofitandlosses as $assignmentprofitandloss)
                                    <tr>
                                        @php
                                            $revenue = $assignmentprofitandloss->engagementfee ?? 0;
                                            $cost = $assignmentprofitandloss->total_cost ?? 0;
                                            $profit = $revenue - $cost;
                                            $margin = $revenue != 0 ? ($profit / $revenue) * 100 : 0;
                                        @endphp
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $assignmentprofitandloss->assignmentgenerate_id ?? '' }}
                                        </td>
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $assignmentprofitandloss->assignmentname ?? '' }}
                                        </td>
                                        <td class="textfixed" style="padding: 17px;">
                                            {{ $assignmentprofitandloss->client_name ?? '' }}</td>
                                        <td style="padding: 17px;">₹{{ $assignmentprofitandloss->engagementfee ?? '' }}
                                        </td>
                                        <td style="padding: 17px;">₹{{ $assignmentprofitandloss->total_cost ?? '' }}
                                        </td>
                                        <td style="padding: 17px;"
                                            class="{{ $profit < 0 ? 'text-danger' : 'text-success' }}">
                                            ₹{{ $profit }}
                                        </td>

                                        <td style="padding: 17px;"
                                            class="{{ $margin < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($margin, 1) }}%
                                        </td>

                                        <td style="padding: 17px;">
                                            @if ($margin > 0)
                                                <span class="priority-tag on-track">PROFITABLE</span>
                                            @elseif ($margin < 0)
                                                <span class="priority-tag high-priority">LOSS</span>
                                            @else
                                                <span class="priority-tag delayed">BREAKEVEN</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card reference-section-card">
                    <div class="card-header">
                        <h2>Monthly Expense Analysis</h2>
                    </div>
                    <canvas id="expenseChart" width="auto" height="250"></canvas>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Cash Flow Analysis</h2>
                    </div>
                    <canvas id="cashFlowChart" width="auto" height="250"></canvas>
                </div>

                @if (empty($partnerId))
                    <div class="card">
                        <div class="card-header">
                            <h2>Budget vs Actual Cash Flow</h2>
                        </div>
                        <canvas id="budgetcashflow" width="auto" height="250"></canvas>
                    </div>
                @endif


                {{-- <div class="card">
                    <div class="card-header">
                        <h2>Budget vs Actual P&L</h2>
                    </div>
                    <canvas id="budgetvsActual" width="auto" height="250"></canvas>
                </div> --}}

                <div class="card">
                    <div class="card-header">
                        <h2>Lap Days Analysis (Assignment to Invoice)</h2>
                    </div>
                    <canvas id="lapDaysChart" width="auto" height="250"></canvas>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Invoice Due vs Assignment Billing vs Cash Recovery</h2>
                    </div>
                    <canvas id="cashRecovery" width="auto" height="250"></canvas>
                </div>
            </div>

            <div class="dashboard-card-fullcontent">

                @if (isset($checkinreportlisttoday) && Auth::user()->role_id == 13)
                    <div class="card reference-checkin">
                        <div class="card-header reference-checkin-heading">
                            <h2>Today Check-In</h2>
                            <h3>{{ $checkinreportlisttoday->Total_Checkin_minus_holiday_count }}</h3>
                        </div>
                        <div class="reference-checkin-body">
                            <div class="row reference-checkin-grid" style="border: 2px solid gray;">
                                @php
                                    $checkinCards = [
                                        [
                                            'containerStyle' => 'height: 165px;',
                                            'gradient' => 'linear-gradient(to right, #34b4e5, rgba(255, 0, 0, 1))',
                                            'icon' => 'fas fa-mobile-alt',
                                            'title' => 'Office',
                                            'label' => 'Office',
                                            'value' => $checkinreportlisttoday->Office,
                                        ],
                                        [
                                            'containerStyle' => 'height: 165px;',
                                            'gradient' => 'linear-gradient(to right, #34b4e5, rgb(0 86 255))',
                                            'icon' => 'fas fa-home',
                                            'title' => 'Work From Home',
                                            'label' => 'Work from home',
                                            'value' => $checkinreportlisttoday->WFM,
                                        ],
                                        [
                                            'containerStyle' => 'height: 165px;',
                                            'gradient' => 'linear-gradient(to right, #34e537, rgb(0 86 255))',
                                            'icon' => 'far fa-building',
                                            'title' => 'Client Place',
                                            'label' => 'Client place',
                                            'value' => $checkinreportlisttoday->Client_Place,
                                        ],

                                        [
                                            'containerStyle' => 'height: 165px;',
                                            'gradient' => 'linear-gradient(to right, #e53834, rgb(51 20 61))',
                                            'icon' => 'far fa-user',
                                            'fontsize' => 'font-size: 6px',
                                            'title' => 'Business Development',
                                            'label' => 'Business development',
                                            'value' => $checkinreportlisttoday->Business_Development,
                                        ],
                                        [
                                            'containerStyle' => 'height: 165px;',
                                            'gradient' => 'linear-gradient(to right, #4b34e5, rgb(191 0 255))',
                                            'icon' => 'far fa-calendar',
                                            'title' => 'Leave',
                                            'label' => 'Leave',
                                            'value' => $checkinreportlisttoday->Leave_Days,
                                        ],
                                        // [
                                        //     'containerStyle' => 'height: 165px;',
                                        //     'gradient' => 'linear-gradient(to right, #4b34e5, rgb(51 20 61))',
                                        //     'icon' => 'fas fa-user-clock',
                                        //     'title' => 'Unallocated',
                                        //     'value' => 0,
                                        // ],
                                        [
                                            'containerStyle' => 'height: 165px;',
                                            'gradient' => 'linear-gradient(to right, #4b34e5, rgb(51 20 61))',
                                            'icon' => 'far fa-clock',
                                            'title' => 'Before 10:30',
                                            'label' => 'Before 10:30',
                                            'value' => $checkinreportlisttoday->On_Time_Before_10_30,
                                        ],
                                        [
                                            'containerStyle' => 'height: 165px; margin-bottom: 41px;',
                                            'gradient' => 'linear-gradient(to right, #34b4e5, rgb(0 86 255))',
                                            'icon' => 'far fa-clock',
                                            'fontsize' => 'font-size: 8px',
                                            'title' => '10:30AM To 12:00PM',
                                            'label' => '10:30 to 12:00',
                                            'value' => $checkinreportlisttoday->chgg,
                                        ],
                                        [
                                            'containerStyle' => 'height: 165px; margin-bottom: 41px;',
                                            'gradient' => 'linear-gradient(to right, #34b4e5, rgba(255, 0, 0, 1))',
                                            'icon' => 'far fa-clock',
                                            'title' => 'After 12:00 PM',
                                            'label' => 'After 12:00',
                                            'value' => $checkinreportlisttoday->After_12_PM,
                                        ],
                                    ];
                                    $currentDate = date('d-m-Y');
                                @endphp

                                @foreach ($checkinCards as $checkinCard)
                                    <div class="reference-checkin-metric" style="{{ $checkinCard['containerStyle'] }};">
                                        <div class="card card-stats mb-4">
                                            <div
                                                class="card-header card-header-icon position-relative border-0 text-right px-3 py-0">
                                                <div class="card-icon d-flex align-items-center justify-content-center mt-0 mr-0"
                                                    style="background-image: {{ $checkinCard['gradient'] }};">
                                                    <i class="{{ $checkinCard['icon'] }}"></i>
                                                </div>
                                                {{-- <a href="{{ url('checkinreportlist' . $parameters) }}"> --}}
                                                <a href="{{ url("checkinreport/$currentDate/{$checkinCard['title']}") }}">
                                                    <p class="card-category text-uppercase font-weight-bold text-muted mt-4 {{ isset($checkinCard['fontsize']) ? '' : 'fs-10' }}"
                                                        @if (isset($checkinCard['fontsize'])) style="{{ $checkinCard['fontsize'] }}" @endif>
                                                        {{ $checkinCard['label'] ?? $checkinCard['title'] }}
                                                    </p>
                                                    <h3 class="card-title fs-18 font-weight-bold">
                                                        {{ $checkinCard['value'] }}</h3>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card matched-dashboard-card">
                    <div class="card-header">
                        <h2>Staff Allocation vs Actual Timesheet Analysis</h2>
                    </div>
                    {{-- <canvas id="expenseChart2" width="auto" height="80"></canvas> --}}
                    @if ($teamAllocatedHours->isEmpty())
                        <div class="ecqr-card text-center text-muted p-4">
                            Data Not Found.
                        </div>
                    @else
                        <div style="overflow-x: auto; white-space: nowrap;">
                            <canvas id="expenseChart2" height="300"></canvas>
                        </div>
                    @endif
                </div>

                <div class="card matched-dashboard-card">
                    <div class="card-header">
                        <h2>Unresolved Tickets - HR, IT & Admin</h2>
                        <a href="javascript:void(0);" onclick="downloadTableAsCSV('tickets', 'tickets_list.csv')"
                            style="margin-top: -9px;">
                            <i class="bi bi-download" style="font-size: 1rem; color:#0a0a0b" title="Download"></i>
                        </a>
                    </div>

                    <div class="table-responsive scrollbarcontroltable">
                        <table id="tickets" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="textfixed" style="padding: 17px;">Ticket ID</th>
                                    <th style="padding: 17px;">Department</th>
                                    <th class="textfixed" style="padding: 17px;">Created By</th>
                                    <th style="padding: 17px;">Subject</th>
                                    <th class="textfixed" style="padding: 17px;">Assigned To</th>
                                    <th class="textfixed" style="padding: 17px;">Days Open</th>
                                    <th style="padding: 17px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allTickets as $ticket)
                                    <tr>
                                        @php
                                            $department = $ticket['department'];
                                            if ($department == 'IT') {
                                                $bgColor = 'rgb(220 252 231)';
                                                $color = 'rgb(22 163 74)';
                                            } elseif ($department == 'Finance') {
                                                $bgColor = 'rgb(243 232 255)';
                                                $color = 'rgb(147 51 234)';
                                            } elseif ($department == 'HR') {
                                                $bgColor = 'rgb(219 234 254)';
                                                $color = 'rgb(37 99 235)';
                                            } else {
                                                $bgColor = '#e8f5e9';
                                                $color = '#43a047';
                                            }
                                        @endphp
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['ticket_id'] }}</td>
                                        <td style="padding: 17px;">
                                            {{-- <span class="priority-tag on-track">{{ $ticket['department'] }}</span> --}}
                                            <span class="priority-tag on-track"
                                                style=" background-color:{{ $bgColor }}; color: {{ $color }}">{{ $ticket['department'] }}</span>
                                        </td>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['created_by'] }}</td>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['subject'] }}</td>
                                        <td class="textfixed" style="padding: 17px;">{{ $ticket['assigned_to'] }}</td>
                                        <td class="text-success textfixed" style="padding: 17px;">
                                            @php
                                                $dueDate = Carbon\Carbon::parse($ticket['created_at']);
                                                $today = Carbon\Carbon::today();
                                                $diffInDays = abs($today->diffInDays($dueDate, false));
                                            @endphp
                                            {{ $diffInDays }}
                                        </td>
                                        <td style="padding: 17px;">
                                            @php
                                                $status = $ticket['status'];
                                            @endphp

                                            @if ($ticket['source'] === 'ticket')
                                                @if ($status == 0)
                                                    <span class="priority-tag on-open textfixed">Open</span>
                                                @elseif($status == 1)
                                                    <span class="priority-tag on-progress textfixed">In Progress</span>
                                                @elseif($status == 2)
                                                    <span class="priority-tag on-closed textfixed">close</span>
                                                @elseif($status == 3)
                                                    <span class="priority-tag on-track textfixed">Reject</span>
                                                @elseif($status == 4)
                                                    <span class="priority-tag on-closed textfixed">Overdue</span>
                                                @endif
                                            @elseif ($ticket['source'] === 'hr')
                                                @if ($status == 0)
                                                    <span class="priority-tag on-open textfixed">Open</span>
                                                @elseif($status == 1)
                                                    <span class="priority-tag on-closed textfixed">close</span>
                                                @elseif($status == 2)
                                                    <span class="priority-tag on-track textfixed">Request to close</span>
                                                @elseif($status == 3)
                                                    <span class="priority-tag on-closed textfixed">Overdue</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="ecqr-card text-center text-muted p-4">
                                            Data Not Found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <script>
            var msg = '{{ Session::get('alert') }}';
            var exist = '{{ Session::has('alert') }}';
            if (exist) {
                alert(msg);
            }
        </script>

        <script>
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                });
            });
        </script>


        {{-- Staff Allocation vs Actual Timesheet Analysis --}}
        @if (!$teamAllocatedHours->isEmpty())
            <script>
                const staffAllocationCtx = document.getElementById('expenseChart2').getContext('2d');
                var teamAllocatedHours = @json($teamAllocatedHours);
                // Extract data from teamAllocatedHours array
                const allocatedHours = teamAllocatedHours.map(item => parseInt(item.teamallocatedhours));
                const actualHours = teamAllocatedHours.map(item => item.actualhours);
                const discrepancy = teamAllocatedHours.map(item => item.discrepancy);

                // Labels for X-axis (teammember name).
                const teamMembers = teamAllocatedHours.map(item => item.team_member);

                const chartWidth = teamMembers.length * 140; // 140px per team
                document.getElementById('expenseChart2').width = chartWidth;

                const expenseChart2 = new Chart(staffAllocationCtx, {
                    type: 'bar',
                    data: {
                        labels: teamMembers,
                        datasets: [{
                                label: 'Allocated Hours',
                                data: allocatedHours,
                                backgroundColor: 'rgb(59, 130, 246)',
                                borderColor: 'rgb(59, 130, 246)',
                                borderWidth: 1 // border width
                            },
                            {
                                label: 'Actual Hours',
                                data: actualHours,
                                backgroundColor: 'rgb(16, 185, 129)',
                                borderColor: 'rgb(16, 185, 129)',
                                borderWidth: 1 // border width
                            },
                            {
                                label: 'Discrepancy',
                                data: discrepancy,
                                backgroundColor: 'rgb(239, 68, 68)',
                                borderColor: 'rgb(239, 68, 68)',
                                borderWidth: 1 // border width
                            }
                        ]
                    },
                    options: {
                        responsive: false, // scrolling enable
                        maintainAspectRatio: false,
                        scales: {
                            // y axis start value from 0
                            y: {
                                // max: 165,
                                // beginAtZero: true,
                                // // min: 0,
                                // ticks: {
                                //     stepSize: 55
                                // }
                                max: 2400,
                                beginAtZero: true,
                                // min: 0,
                                ticks: {
                                    stepSize: 400
                                }
                            }
                        },

                        plugins: {
                            legend: {
                                // display: false
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 14,
                                        weight: 'bold',
                                    },
                                    color: 'black',
                                    padding: 20,
                                    boxWidth: 20,
                                    boxHeight: 10
                                }
                            },
                            tooltip: {
                                // Default tooltip disabled
                                enabled: false,
                                // custom tooltip using external function.
                                external: function(context) {
                                    // Tooltip Element
                                    let tooltipEl = document.getElementById('chartjs-tooltip');

                                    // Create element on first render
                                    if (!tooltipEl) {
                                        tooltipEl = document.createElement('div');
                                        tooltipEl.id = 'chartjs-tooltip';
                                        tooltipEl.innerHTML = '<div></div>';
                                        document.body.appendChild(tooltipEl);
                                    }

                                    const tooltipModel = context.tooltip;

                                    // Hide if no tooltip
                                    if (tooltipModel.opacity === 0) {
                                        tooltipEl.style.opacity = 0;
                                        return;
                                    }

                                    // Set Text
                                    if (tooltipModel.body) {
                                        const index = tooltipModel.dataPoints[0].dataIndex;
                                        const month = teamMembers[index];
                                        const allocatedHoursValue = allocatedHours[index];
                                        const actualHoursValue = actualHours[index];
                                        const discrepancyValue = discrepancy[index];

                                        const innerHtml = `
                        <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                            <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                            <div style="color: blue;">Allocated Hours: ${allocatedHoursValue} hrs</div>
                            <div style="color: green;">Actual Hours: ${actualHoursValue} hrs</div>
                            <div style="color: red;">Discrepancy: ${discrepancyValue} hrs</div>
                        </div>
                  `;

                                        tooltipEl.innerHTML = innerHtml;
                                    }
                                    // exact position of Tooltip set  near by mouse .
                                    const position = context.chart.canvas.getBoundingClientRect();
                                    tooltipEl.style.opacity = 1;
                                    tooltipEl.style.position = 'absolute';
                                    tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                        'px';
                                    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                        'px';
                                    tooltipEl.style.pointerEvents = 'none';
                                    tooltipEl.style.zIndex = 999;
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                });
            </script>
        @endif

        {{-- Monthly Expense Analysis --}}
        <script>
            const expenseCtx = document.getElementById('expenseChart').getContext('2d');
            var teamsSalaries = @json($teamsSalaries);
            var teamexceptionalExpenses = @json($teamexceptionalExpenses);
            const allMonths = [
                'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December', 'January', 'February', 'March'
            ];

            // teamsSalaries, missing months == 0
            const salariesByMonth = {};
            teamsSalaries.forEach(item => {
                salariesByMonth[item.month] = parseFloat(item.total_amount);
            });

            // teamexceptionalExpenses, missing months == 0
            const expensesByMonth = {};
            teamexceptionalExpenses.forEach(item => {
                expensesByMonth[item.month] = parseFloat(item.total_amount);
            });

            // Create data for all months, if month not on that case assigned 0 
            const normalExpensesData = allMonths.map(month => salariesByMonth[month] || 0);
            const exceptionalExpensesData = allMonths.map(month => expensesByMonth[month] || 0);

            // Labels for X-axis (mahine ke naam).
            const expenseMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];


            const expenseChart = new Chart(expenseCtx, {
                type: 'bar',
                data: {
                    labels: expenseMonths,
                    datasets: [{
                            label: 'Normal Expenses',
                            data: normalExpensesData,
                            backgroundColor: 'rgb(59, 130, 246)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1 // border width
                        },
                        {
                            label: 'Exceptional Expenses',
                            data: exceptionalExpensesData,
                            backgroundColor: 'rgb(239, 68, 68)',
                            borderColor: 'rgb(239, 68, 68)',
                            borderWidth: 1 // border width
                        }
                    ]
                },
                options: {
                    scales: {
                        // y axis start value from 0
                        y: {
                            max: 500000,
                            beginAtZero: true,
                            // min: 0,
                            ticks: {
                                stepSize: 100000
                            }
                        }
                    },

                    plugins: {
                        legend: {
                            // display: false
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold',
                                },
                                color: 'black',
                                padding: 20,
                                boxWidth: 20,
                                boxHeight: 10
                            }
                        },
                        tooltip: {
                            // Default tooltip disabled
                            enabled: false,
                            // custom tooltip using external function.
                            external: function(context) {
                                // Tooltip Element
                                let tooltipEl = document.getElementById('chartjs-tooltip');

                                // Create element on first render
                                if (!tooltipEl) {
                                    tooltipEl = document.createElement('div');
                                    tooltipEl.id = 'chartjs-tooltip';
                                    tooltipEl.innerHTML = '<div></div>';
                                    document.body.appendChild(tooltipEl);
                                }

                                const tooltipModel = context.tooltip;

                                // Hide if no tooltip
                                if (tooltipModel.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }

                                // Set Text
                                if (tooltipModel.body) {
                                    const index = tooltipModel.dataPoints[0].dataIndex;
                                    const month = expenseMonths[index];
                                    const normalExpenses = normalExpensesData[index];
                                    const exceptionalExpenses = exceptionalExpensesData[index];

                                    const innerHtml = `
                                   <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                       <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                       <div style="color: blue;">Normal Expenses: ₹${normalExpenses}</div>
                                       <div style="color: red;">Exceptional Expenses: ₹${exceptionalExpenses}</div>
                                   </div>
                             `;

                                    tooltipEl.innerHTML = innerHtml;
                                }
                                // exact position of Tooltip set  near by mouse .
                                const position = context.chart.canvas.getBoundingClientRect();
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.position = 'absolute';
                                tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                    'px';
                                tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                    'px';
                                tooltipEl.style.pointerEvents = 'none';
                                tooltipEl.style.zIndex = 999;
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });
        </script>

        {{-- Cash Flow Analysis --}}
        <script>
            const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');

            var cashInflowrawData = @json($cashFlowRecieved);
            var cashOutflowrawData = @json($cashFlowtotalspendData);
            // const cashflowrawmonths = ['January', 'February', 'March', 'April', 'May', 'June'];
            const cashflowrawmonths = [
                'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December', 'January', 'February', 'March'
            ];

            // cashInflowrawData, missing months == 0
            const cashInflowrawMonths = {};
            cashInflowrawData.forEach(item => {
                cashInflowrawMonths[item.month] = parseFloat(item.amountreceived);
            });

            // cashOutflowrawData, missing months == 0
            const cashOutflowMonths = {};
            cashOutflowrawData.forEach(item => {
                cashOutflowMonths[item.month] = parseFloat(item.total_amounts);
            });

            // Create data for all months, if month not on that case assigned 0 
            const cashInflowData = cashflowrawmonths.map(month => cashInflowrawMonths[month] || 0);
            const cashOutflowData = cashflowrawmonths.map(month => cashOutflowMonths[month] || 0);
            // const netCashflowData = cashInflowData.map((inflow, index) => inflow - cashOutflowData[index]);
            const netCashflowData = cashInflowData.map((inflow, index) =>
                parseFloat((inflow - cashOutflowData[index]).toFixed(2))
            );
            // Labels for X-axis (mahine ke naam).
            // const cashFlowMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            const cashFlowMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];


            const cashFlowChart = new Chart(cashFlowCtx, {
                type: 'line',
                data: {
                    labels: cashFlowMonths,
                    datasets: [{
                            label: 'Cash Inflow',
                            data: cashInflowData,
                            borderColor: 'rgba(75, 192, 75, 1)',
                            backgroundColor: 'rgba(75, 192, 75, 0.2)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Cash Outflow',
                            data: cashOutflowData,
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgb(239, 68, 68)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Net cash flow',
                            data: netCashflowData,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgb(59, 130, 246)',
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            max: 7000000,
                            beginAtZero: true,
                            // min: 0,
                            ticks: {
                                stepSize: 3500000
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            // display: false
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold',
                                },
                                color: 'black',
                                padding: 20,
                                boxWidth: 20,
                                boxHeight: 10
                            }
                        },
                        tooltip: {
                            enabled: false, // disable the default tooltip
                            external: function(context) {
                                // Tooltip Element
                                let tooltipEl = document.getElementById('chartjs-tooltip');

                                // Create element on first render
                                if (!tooltipEl) {
                                    tooltipEl = document.createElement('div');
                                    tooltipEl.id = 'chartjs-tooltip';
                                    tooltipEl.innerHTML = '<div></div>';
                                    document.body.appendChild(tooltipEl);
                                }

                                const tooltipModel = context.tooltip;

                                // Hide if no tooltip
                                if (tooltipModel.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }

                                // Set Text
                                if (tooltipModel.body) {
                                    const index = tooltipModel.dataPoints[0].dataIndex;
                                    const month = cashFlowMonths[index];
                                    const cashInflowDataValue = cashInflowData[index];
                                    const cashOutflowDataValue = cashOutflowData[index];
                                    const netCashflowDataValue = netCashflowData[index];

                                    const innerHtml = `
                               <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                   <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                   <div style="color: green;">Cash Inflow: ₹${cashInflowDataValue}</div>
                                   <div style="color: red;">Cash Outflow: ₹${cashOutflowDataValue}</div>
                                   <div style="color: blue;">Net cash flow: ₹${netCashflowDataValue}</div>
                               </div>
                           `;

                                    tooltipEl.innerHTML = innerHtml;
                                }

                                const position = context.chart.canvas.getBoundingClientRect();
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.position = 'absolute';
                                tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                    'px';
                                tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                    'px';
                                tooltipEl.style.pointerEvents = 'none';
                                tooltipEl.style.zIndex = 999;
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });
        </script>

        {{-- Invoice Due vs Assignment Billing vs Cash Recovery --}}

        <script>
            const cashRecoveryCtx = document.getElementById('cashRecovery').getContext('2d');

            var assignmentBillingrawData = @json($assignmentBilling);
            var assignmentOutstandingrawData = @json($assignmentOutstanding);
            var cashRecoveryrawData = @json($cashRecovery);

            const cashRecoveryMonths = [
                'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December', 'January', 'February', 'March'
            ];

            // assignmentBillingrawData, missing months == 0
            const billingsMonthsfill = {};
            assignmentBillingrawData.forEach(item => {
                // billingsMonthsfill[item.month] = parseFloat(item.invoices_amount);
                billingsMonthsfill[item.month] = parseFloat(item.total_amount);
            });

            // assignmentOutstandingrawData, missing months == 0
            const outstandingMonthsfill = {};
            assignmentOutstandingrawData.forEach(item => {
                outstandingMonthsfill[item.month] = parseFloat(item.outstanding_amount);
            });

            // cashRecoveryrawData, missing months == 0
            const cashRecoveryMonthsfill = {};
            cashRecoveryrawData.forEach(item => {
                cashRecoveryMonthsfill[item.month] = parseFloat(item.amountreceived);
            });

            // Create data for all months, if month not on that case assigned 0 
            const assignmentBilling = cashRecoveryMonths.map(month => billingsMonthsfill[month] || 0);
            const invoicesDue = cashRecoveryMonths.map(month => outstandingMonthsfill[month] || 0);
            const cashRecovery = cashRecoveryMonths.map(month => cashRecoveryMonthsfill[month] || 0);
            const recoveryRate = cashRecovery.map((recovery, index) => {
                const due = invoicesDue[index];
                if (due === 0) return 0; // Avoid division by zero
                return ((recovery / due) * 100).toFixed(2); // Keep 2 decimal places
            });

            console.log("zzzzzzzzzzzzzz");
            console.log("assignmentBilling:", assignmentBilling);
            console.log("invoicesDue:", invoicesDue);
            console.log("cashRecovery:", cashRecovery);
            console.log("recoveryRate:", recoveryRate);

            // Labels for X-axis (mahine ke naam).
            const cashRecoveryCtxMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];


            const cashRecoveryChart = new Chart(cashRecoveryCtx, {
                type: 'line',
                data: {
                    labels: cashRecoveryCtxMonths,
                    datasets: [{
                            label: 'Assignment Billing',
                            data: assignmentBilling,
                            borderColor: 'rgb(139, 92, 246)',
                            backgroundColor: 'rgb(139, 92, 246)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Invoices Due',
                            data: invoicesDue,
                            borderColor: 'rgb(245, 158, 11)',
                            backgroundColor: 'rgb(245, 158, 11)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Cash Recovery',
                            data: cashRecovery,
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgb(16, 185, 129)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Recovery Rate',
                            data: recoveryRate,
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgb(239, 68, 68)',
                            borderWidth: 2,
                            fill: false
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            max: 30000000,
                            beginAtZero: true,
                            // min: 0,
                            ticks: {
                                stepSize: 7500000
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            // display: false
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold',
                                },
                                color: 'black',
                                padding: 20,
                                boxWidth: 20,
                                boxHeight: 10
                            }
                        },
                        tooltip: {
                            enabled: false, // disable the default tooltip
                            external: function(context) {
                                // Tooltip Element
                                let tooltipEl = document.getElementById('chartjs-tooltip');

                                // Create element on first render
                                if (!tooltipEl) {
                                    tooltipEl = document.createElement('div');
                                    tooltipEl.id = 'chartjs-tooltip';
                                    tooltipEl.innerHTML = '<div></div>';
                                    document.body.appendChild(tooltipEl);
                                }

                                const tooltipModel = context.tooltip;

                                // Hide if no tooltip
                                if (tooltipModel.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }

                                // Set Text
                                if (tooltipModel.body) {
                                    const index = tooltipModel.dataPoints[0].dataIndex;
                                    const month = cashRecoveryCtxMonths[index];
                                    const assignmentBillingValue = assignmentBilling[index];
                                    const invoicesDueValue = invoicesDue[index];
                                    const cashRecoveryValue = cashRecovery[index];
                                    const recoveryRateValue = recoveryRate[index];

                                    const innerHtml = `
                                       <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                           <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                           <div style="color: rgb(139, 92, 246);">Assignment Billing: ₹${assignmentBillingValue}</div>
                                           <div style="color: rgb(245, 158, 11);">Invoices Due: ₹${invoicesDueValue}</div>
                                           <div style="color: rgb(16, 185, 129);">Cash Recovery: ₹${cashRecoveryValue}</div>
                                           <div style="color: rgb(239, 68, 68);">Recovery Rate: ${recoveryRateValue}%</div>
                                       </div>
                                   `;

                                    tooltipEl.innerHTML = innerHtml;
                                }

                                const position = context.chart.canvas.getBoundingClientRect();
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.position = 'absolute';
                                tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                    'px';
                                tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                    'px';
                                tooltipEl.style.pointerEvents = 'none';
                                tooltipEl.style.zIndex = 999;
                            }
                        }

                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });
        </script>

        {{-- Lap Days Analysis (Assignment to Invoice) --}}
        <script>
            const lapDaysChartctx = document.getElementById('lapDaysChart').getContext('2d');

            var assignmentsWithInvoicerawdata = @json($assignmentsWithInvoices);
            const lapDaysChartmonths = [
                'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December', 'January', 'February', 'March'
            ];

            // assignmentsWithInvoicerawdata, missing months == 0
            const assignmentsMonthsfill = {};
            assignmentsWithInvoicerawdata.forEach(item => {
                assignmentsMonthsfill[item.month] = parseFloat(item.averageDifferenceDays);
            });


            // Create data for all months, if month not on that case assigned 0 
            const avgLapDaysData = lapDaysChartmonths.map(month => assignmentsMonthsfill[month] || 0);
            // const targetDays = assignmentsWithInvoicerawdata.map(item => item.targetDays);
            const targetLapDaysData = [7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7];


            // const avgLapDaysData = [12, 8, 16, 12, 6, 10];
            // const targetLapDaysData = [8, 8, 8, 8, 6, 8];
            // const lapDaysMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            const lapDaysMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];

            const lapDaysChart = new Chart(lapDaysChartctx, {
                type: 'bar',
                data: {
                    labels: lapDaysMonths,
                    datasets: [{
                            label: 'avgLapDays',
                            data: avgLapDaysData,
                            backgroundColor: 'rgba(239, 68, 68)',
                            borderColor: 'rgba(239, 68, 68)',
                            borderWidth: 1
                        },
                        {
                            label: 'targetLapDays',
                            data: targetLapDaysData,
                            backgroundColor: 'rgba(16, 185, 129)',
                            borderColor: 'rgba(16, 185, 129)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 1000,
                            ticks: {
                                stepSize: 100
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            // display: false
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold',
                                },
                                color: 'black',
                                padding: 20,
                                boxWidth: 20,
                                boxHeight: 10
                            }
                        },
                        tooltip: {
                            enabled: false, // disable the default tooltip
                            external: function(context) {
                                // Tooltip Element
                                let tooltipEl = document.getElementById('chartjs-tooltip');

                                // Create element on first render
                                if (!tooltipEl) {
                                    tooltipEl = document.createElement('div');
                                    tooltipEl.id = 'chartjs-tooltip';
                                    tooltipEl.innerHTML = '<div></div>';
                                    document.body.appendChild(tooltipEl);
                                }

                                const tooltipModel = context.tooltip;

                                // Hide if no tooltip
                                if (tooltipModel.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }

                                // Set Text
                                if (tooltipModel.body) {
                                    const index = tooltipModel.dataPoints[0].dataIndex;
                                    const month = lapDaysMonths[index];
                                    const avgLapDaysDataValue = avgLapDaysData[index];
                                    const targetLapDaysDataValue = targetLapDaysData[index];

                                    const innerHtml = `
                                       <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                           <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                           <div style="color: red;">Average Lap Days: ${avgLapDaysDataValue} days</div>
                                           <div style="color: green;">Target Lap Days: ${targetLapDaysDataValue} days</div>
                                       </div>
                                   `;

                                    tooltipEl.innerHTML = innerHtml;
                                }

                                const position = context.chart.canvas.getBoundingClientRect();
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.position = 'absolute';
                                tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                    'px';
                                tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                    'px';
                                tooltipEl.style.pointerEvents = 'none';
                                tooltipEl.style.zIndex = 999;
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });
        </script>

        {{-- Budget vs Actual P&L --}}
        {{-- <script>
            const budgetvsActualctx = document.getElementById('budgetvsActual').getContext('2d');

            var budgetRevenueandbudgetExpences = @json($budgetRevenueandbudgetExpences);
            var budgetActualRevenue = @json($budgetActualRevenue);
            var budgetActualExpences = @json($budgetActualExpences);

            const budgetvsActualmonths = [
                'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December', 'January', 'February', 'March'
            ];

            // budgetRevenueandbudgetExpences, missing months == 0
            const budgetRevenueMonthsfill = {};
            budgetRevenueandbudgetExpences.forEach(item => {
                budgetRevenueMonthsfill[item.month] = parseFloat(item.engagementfee);
            });

            // budgetRevenueandbudgetExpences, missing months == 0
            const budgetExpensesMonthsfill = {};
            budgetRevenueandbudgetExpences.forEach(item => {
                budgetExpensesMonthsfill[item.month] = parseFloat(item.total_teamestcost);
            });

            // budgetActualRevenue, missing months == 0
            const budgetActualRevenueMonthsfill = {};
            budgetActualRevenue.forEach(item => {
                // budgetActualRevenueMonthsfill[item.month] = parseFloat(item.invoices_amount);
                budgetActualRevenueMonthsfill[item.month] = parseFloat(item.total_amount);
            });

            // budgetActualExpences, missing months == 0
            const budgetActualExpencesMonthsfill = {};
            budgetActualExpences.forEach(item => {
                budgetActualExpencesMonthsfill[item.month] = parseFloat(item.total_cost);
            });

            // Create data for all months, if month not on that case assigned 0 
            const budgetRevenue = budgetvsActualmonths.map(month => budgetRevenueMonthsfill[month] || 0);
            const actualRevenue = budgetvsActualmonths.map(month => budgetActualRevenueMonthsfill[month] || 0);
            const budgetExpenses = budgetvsActualmonths.map(month => budgetExpensesMonthsfill[month] || 0);
            const actualExpenses = budgetvsActualmonths.map(month => budgetActualExpencesMonthsfill[month] || 0);

            // console.log('budgetRevenue1', budgetRevenue1);
            // console.log('actualRevenue1', actualRevenue1);
            // console.log('budgetExpenses1', budgetExpenses1);
            // console.log('actualExpenses1', actualExpenses1);

            // const budgetRevenue = [2500000, 2700000, 2800000, 2900000, 2900000, 3000000];
            // const actualRevenue = [2250000, 2500000, 2600000, 2700000, 2800000, 2900000];
            // const budgetExpenses = [2000000, 2100000, 2200000, 2300000, 2250000, 2300000];
            // const actualExpenses = [1800000, 1900000, 2000000, 2100000, 2000000, 2000000];

            const budgetvsActualMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];


            const budgetvsActualChart = new Chart(budgetvsActualctx, {
                type: 'bar',
                data: {
                    labels: budgetvsActualMonths,
                    datasets: [{
                            label: 'Budget Revenue',
                            data: budgetRevenue,
                            backgroundColor: 'rgba(139, 92, 246)',
                            borderColor: 'rgba(139, 92, 246)',
                            borderWidth: 1
                        },
                        {
                            label: 'Actual Revenue',
                            data: actualRevenue,
                            backgroundColor: 'rgba(16, 185, 129)',
                            borderColor: 'rgba(16, 185, 129)',
                            borderWidth: 1
                        },
                        {
                            label: 'Budget Expenses',
                            data: budgetExpenses,
                            backgroundColor: 'rgba(245, 158, 11)',
                            borderColor: 'rgba(245, 158, 11)',
                            borderWidth: 1
                        },
                        {
                            label: 'Actual Expenses',
                            data: actualExpenses,
                            backgroundColor: 'rgba(239, 68, 68)',
                            borderColor: 'rgba(239, 68, 68)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            max: 30000000,
                            beginAtZero: true,
                            // min: 0,
                            ticks: {
                                stepSize: 7500000
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            // display: false
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold',
                                },
                                color: 'black',
                                padding: 20,
                                boxWidth: 20,
                                boxHeight: 10
                            }
                        },
                        tooltip: {
                            enabled: false, // disable the default tooltip
                            external: function(context) {
                                // Tooltip Element
                                let tooltipEl = document.getElementById('chartjs-tooltip');

                                // Create element on first render
                                if (!tooltipEl) {
                                    tooltipEl = document.createElement('div');
                                    tooltipEl.id = 'chartjs-tooltip';
                                    tooltipEl.innerHTML = '<div></div>';
                                    document.body.appendChild(tooltipEl);
                                }

                                const tooltipModel = context.tooltip;

                                // Hide if no tooltip
                                if (tooltipModel.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }

                                // Set Text
                                if (tooltipModel.body) {
                                    const index = tooltipModel.dataPoints[0].dataIndex;
                                    const month = budgetvsActualMonths[index];
                                    const budgetRevenueValue = budgetRevenue[index];
                                    const actualRevenueValue = actualRevenue[index];
                                    const budgetExpensesValue = budgetExpenses[index];
                                    const actualExpensesValue = actualExpenses[index];

                                    const innerHtml = `
                                       <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                           <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                           <div style="color: blue;">Budget Revenue: ₹${budgetRevenueValue}</div>
                                           <div style="color: green;">Actual Revenue: ₹${actualRevenueValue}</div>
                                           <div style="color: orange;">Budget Expenses: ₹${budgetExpensesValue}</div>
                                           <div style="color: red;">Actual Expenses: ₹${actualExpensesValue}</div>
                                       </div>
                                   `;

                                    tooltipEl.innerHTML = innerHtml;
                                }

                                const position = context.chart.canvas.getBoundingClientRect();
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.position = 'absolute';
                                tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                    'px';
                                tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                    'px';
                                tooltipEl.style.pointerEvents = 'none';
                                tooltipEl.style.zIndex = 999;
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });
        </script> --}}

        {{-- Budget vs Actual Cash Flow --}}
        @if (empty($partnerId))
            <script>
                const budgetcashflowctx = document.getElementById('budgetcashflow').getContext('2d');
                // const budgetInflowData = [400000, 450000, 400000, 500000, 600000, 700000];
                // const actualInflowData = [350000, 400000, 350000, 450000, 500000, 600000];
                // const budgetOutflowData = [-400000, -350000, -300000, -250000, -200000, -200000];
                // const actualOutflowData = [-350000, -300000, -250000, -200000, -150000, -150000];
                // const budgetcashflowmonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

                const budgetcashflowrawmonths = [
                    'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December', 'January', 'February', 'March'
                ];

                const budgetcashflowChartMonths = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb',
                    'Mar'
                ];

                var actualInflowrawData = @json($cashFlowRecieved);
                var actualOutflowrawData = @json($cashFlowtotalspendData);
                var budgetInflowOutflowData = @json($budgetactualcash);

                const budgetInflowMonths = {};
                budgetInflowOutflowData.forEach(item => {
                    budgetInflowMonths[item.month] = parseFloat(item.budgetinflow);
                });

                const budgetOutflowMonths = {};
                budgetInflowOutflowData.forEach(item => {
                    budgetOutflowMonths[item.month] = parseFloat(item.budgetoutflow);
                });

                const actualInflowMonths = {};
                actualInflowrawData.forEach(item => {
                    actualInflowMonths[item.month] = parseFloat(item.amountreceived);
                });

                const actualOutflowMonths = {};
                actualOutflowrawData.forEach(item => {
                    actualOutflowMonths[item.month] = parseFloat(item.total_amounts);
                });

                const budgetInflowData = budgetcashflowrawmonths.map(month => budgetInflowMonths[month] || 0);
                const actualInflowData = budgetcashflowrawmonths.map(month => actualInflowMonths[month] || 0);
                const budgetOutflowData = budgetcashflowrawmonths.map(month => budgetOutflowMonths[month] || 0);
                const actualOutflowData = budgetcashflowrawmonths.map(month => actualOutflowMonths[month] || 0);

                const budgetcashflowChart = new Chart(budgetcashflowctx, {
                    type: 'line',
                    data: {
                        labels: budgetcashflowChartMonths,
                        datasets: [{
                                label: 'Budget Inflow',
                                data: budgetInflowData,
                                borderColor: 'rgb(139, 92, 246)',
                                backgroundColor: 'rgb(139, 92, 246)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                fill: false
                            },
                            {
                                label: 'Actual Inflow',
                                data: actualInflowData,
                                borderColor: 'rgb(16, 185, 129)',
                                backgroundColor: 'rgb(16, 185, 129)',
                                borderWidth: 2,
                                fill: false
                            },
                            {
                                label: 'Budget Outflow',
                                data: budgetOutflowData,
                                borderColor: 'rgb(245, 158, 11)',
                                backgroundColor: 'rgb(245, 158, 11)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                fill: false
                            },
                            {
                                label: 'Actual Outflow',
                                data: actualOutflowData,
                                borderColor: 'rgb(239, 68, 68)',
                                backgroundColor: 'rgb(239, 68, 68)',
                                borderWidth: 2,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                max: 2500000,
                                beginAtZero: true,
                                // min: 0,
                                ticks: {
                                    stepSize: 500000
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                // display: false
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 14,
                                        weight: 'bold',
                                    },
                                    color: 'black',
                                    padding: 20,
                                    boxWidth: 20,
                                    boxHeight: 10
                                }
                            },
                            tooltip: {
                                enabled: false, // disable the default tooltip
                                external: function(context) {
                                    // Tooltip Element
                                    let tooltipEl = document.getElementById('chartjs-tooltip');

                                    // Create element on first render
                                    if (!tooltipEl) {
                                        tooltipEl = document.createElement('div');
                                        tooltipEl.id = 'chartjs-tooltip';
                                        tooltipEl.innerHTML = '<div></div>';
                                        document.body.appendChild(tooltipEl);
                                    }

                                    const tooltipModel = context.tooltip;

                                    // Hide if no tooltip
                                    if (tooltipModel.opacity === 0) {
                                        tooltipEl.style.opacity = 0;
                                        return;
                                    }

                                    // Set Text
                                    if (tooltipModel.body) {
                                        const index = tooltipModel.dataPoints[0].dataIndex;
                                        const month = budgetcashflowChartMonths[index];
                                        const budgetInflowDataValue = budgetInflowData[index];
                                        const actualInflowDataValue = actualInflowData[index];
                                        const budgetOutflowDataValue = budgetOutflowData[index];
                                        const actualOutflowDataValue = actualOutflowData[index];

                                        const innerHtml = `
                               <div style="background: white; border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
                                   <div style="color: black; font-weight: bold; margin-bottom: 4px;">${month}</div>
                                   <div style="color: blue;">Budget Inflow: ${budgetInflowDataValue}</div>
                                   <div style="color: green;">Actual Inflow: ${actualInflowDataValue}</div>
                                   <div style="color: orange;">Budget Outflow: ${budgetOutflowDataValue}</div>
                                   <div style="color: red;">Actual Outflow: ${actualOutflowDataValue}</div>
                               </div>
                           `;

                                        tooltipEl.innerHTML = innerHtml;
                                    }

                                    const position = context.chart.canvas.getBoundingClientRect();
                                    tooltipEl.style.opacity = 1;
                                    tooltipEl.style.position = 'absolute';
                                    tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX +
                                        'px';
                                    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY +
                                        'px';
                                    tooltipEl.style.pointerEvents = 'none';
                                    tooltipEl.style.zIndex = 999;
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                });
            </script>
        @endif

        <script>
            function downloadTableAsCSV(tableId, filename) {
                const table = document.getElementById(tableId);
                let csvContent = "";

                const headers = table.querySelectorAll("thead th");
                const headerArray = Array.from(headers).map(header => header.textContent.trim());
                csvContent += headerArray.join(",") + "\n";

                const rows = table.querySelectorAll("tbody tr");
                rows.forEach(row => {
                    const cells = row.querySelectorAll("td");
                    const cellArray = Array.from(cells).map(cell => {
                        let text = cell.textContent.trim();

                        // Escape quotes
                        text = text.replace(/"/g, '');

                        // Fix large number formatting (e.g., assignment IDs)
                        if (/^\d{10,}$/.test(text)) {
                            // Add tab to preserve format
                            return `\t${text}`;
                        }

                        return `"${text}"`;
                    });
                    csvContent += cellArray.join(",") + "\n";
                });

                // Add UTF-8 BOM for Excel to read ₹ properly
                const BOM = "\uFEFF";
                const blob = new Blob([BOM + csvContent], {
                    type: "text/csv;charset=utf-8;"
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.setAttribute("href", url);
                a.setAttribute("download", filename);
                a.click();
                window.URL.revokeObjectURL(url);
            }
        </script>
    @endsection
