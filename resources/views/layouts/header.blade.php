<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- <script src="{{asset('js/turbolink.js')}}"></script> -->

<link rel="icon" href="favicon.ico" type="image/x-icon"/>

<title>{{env('APP_NAME')}}</title>

<!-- Bootstrap Core and vandor -->
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" />

<!-- Plugins css -->
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/c3.min.css')}}"/>

<!-- Core css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/theme1.css')}}"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" integrity="sha512-7x3zila4t2qNycrtZ31HO0NnJr8kg2VI67YLoRSyi9hGhRN66FHYWr7Axa9Y1J9tGYHVBPqIjSE1ogHrJTz51g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.css"/>

<livewire:styles>
<style>
    [x-cloak] { display: none !important; }
    button:focus {
        outline: none;
    }
</style>
<style>
    .btn.focus, .btn:focus {
        outline: 0;
        box-shadow: none!important;
    }
    .btn-success.focus, .btn-success:focus {
        box-shadow: none;
    }
    .AddModalBtn{
        position: fixed;
        border-radius: 50%;
        right:40px; 
        bottom:40px; 
        width:50px; 
        height:50px; 
        display:flex; 
        align-items:center; 
        justify-content:center;
    }
    .m-pointer{
        cursor: pointer;
    }

    .dark-from{
        border: 1px solid #dee2e6!important;
    }
    #profile_img .profile-pic {
        /* border-radius: 50%; */
        height: 200px;
        width: 100%;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        vertical-align: middle;
        text-align: center;
        color: transparent;
        transition: all .3s ease;
        text-decoration: none;
        /* cursor: pointer; */
        overflow: hidden;
    }

    #profile_img .profile-pic {
        z-index: 10;
        color: black;
        transition: all .3s ease;
        text-decoration: none;
    }

    #profile_img .profile-pic label {
        display: flex;
        position: absolute;
        top: 5px;
        right: 6px;
        font-size: 20px;
        background:#4343437a;
        width: 40px;
        height: 40px;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        cursor: pointer;
    }

    #fileToUpload{
            display: none;
            cursor: pointer;
    }
    #profile_img{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        border-bottom: 1px solid lightgray;
    }
</style>
@stack('css')
</head>