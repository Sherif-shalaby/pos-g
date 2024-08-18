<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')}}" type="text/css">

<link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css')}}"
    type="text/css">

<link rel="stylesheet" href="{{asset('vendor/jquery-timepicker/jquery.timepicker.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap-select.min.css')}}" type="text/css">
<!-- Font Awesome CSS-->
<link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" type="text/css">
<!-- Drip icon font-->
<link rel="stylesheet" href="{{asset('vendor/dripicons/webfont.css')}}" type="text/css">
<!-- Google fonts - Roboto -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,500,700">
<!-- jQuery Circle-->
<link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}" type="text/css">
<!-- Custom Scrollbar-->
<link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}"
    type="text/css">
<!-- virtual keybord stylesheet-->
<link rel="stylesheet" href="{{asset('vendor/keyboard/css/keyboard.css')}}" type="text/css">
<!-- date range stylesheet-->
<link rel="stylesheet" href="{{asset('vendor/daterange/css/daterangepicker.min.css')}}" type="text/css">
<!-- table sorter stylesheet-->
<link rel="stylesheet" href="{{asset('vendor/datatable/dataTables.bootstrap4.min.css')}}" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css"
    type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"
    type="text/css">
<link rel="stylesheet" href="{{asset('vendor/toastr/toastr.min.css')}}" id="theme-stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('css/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('vendor/cropperjs/cropper.min.css') }}">
<link rel="stylesheet" href="{{asset('css/bootstrap-treeview.css')}}">
<link rel="stylesheet" href="{{asset('css/style.css')}}">


<!-- Custom stylesheet - for your changes-->
<link rel="stylesheet" href="{{asset('css/custom-default.css') }}" type="text/css" id="custom-style">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
</style>
<style>
    :root {
        --primary-color: #4f46e5;
        /* Light Blue */
        --secondary-color: #84ceed;
        /* Bright Blue */
        --tertiary-color: #1565c0;
        /* Dark Blue */
        --complementary-color-1: #5bb9b0;
        /* Muted Blue-Green */
        --complementary-color-2: #a5d6a7;
        /* Light Muted Blue-Green */
        --text-color: #333;
        /* Dark Gray for Text */
        --white: #fff;
        /* Dark Gray for Text */
        --grey-color: #ebebeb;
        /* Soft Muted Red */
    }




    /* HTML: <div class="loader"></div> */
    #loader {
        width: 20px;
        aspect-ratio: 1;
        border-radius: 50%;
        background: var(--primary-color);
        box-shadow: 0 0 0 0 #4e46e549;
        animation: l2 1.5s infinite linear;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    #loader:before,
    #loader:after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        box-shadow: 0 0 0 0 #4e46e549;
        animation: inherit;
        animation-delay: -0.5s;
    }

    #loader:after {
        animation-delay: -1s;
    }

    @keyframes l2 {
        100% {
            box-shadow: 0 0 0 40px #0000
        }
    }


    body {
        font-family: "Roboto", sans-serif !important;
    }

    .page-title {
        border-left: 2px solid #4f46e5;
    }


    ::-webkit-scrollbar-track {
        border: 3px solid white;

        background-color: #b2bec3;
    }

    ::-webkit-scrollbar {
        width: 8px;
        background-color: #dfe6e9;
    }

    ::-webkit-scrollbar-thumb {
        background-color: var(--primary-color);
        border-radius: 3px;
    }

    .btn-modal {
        border-radius: 0 6px 6px 0px;
        border: 2px solid #4f46e5;
    }
</style>
<style>
    .my-group .form-control {
        width: 50% !important;
    }

    .bs-searchbox .form-control {
        width: 100% !important;
    }

    .error {
        color: red !important;
    }

    .text-red {
        color: maroon !important;
    }

    .hide {
        display: none !important;
    }

    ul#ui-id-1 {
        max-height: 320px;
        overflow-y: scroll;
    }
</style>
