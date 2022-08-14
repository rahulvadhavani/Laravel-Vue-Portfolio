    
var toast = Swal.mixin({
    toast: true,
    icon: 'success',
    title: 'General Title',
    animation: false,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function toaster(msg,status=true) {
    let icon = status == 'false'? 'error' : 'success';
    toast.fire({
        title: msg,
        icon: icon
    });
}

window.addEventListener('viewModal', event => { 
    $("#viewModal").modal('show');
});

window.addEventListener('alert', event => { 
    toaster(event.detail.message,event.detail.status);
});

window.addEventListener('viewDelete', event => {
    event.preventDefault();
    Swal.fire({
    text: 'Are you sure you want to delete this record.?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteRecrod',event.detail.id)
        }
    })
});

$(".sign_me_out").click(function (e) { 
    e.preventDefault();
    Swal.fire({
    text: 'Are you sure you want to logout?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Logout'
    }).then((result) => {
    if (result.isConfirmed) {
        window.location.replace($(this).attr('href'));
    }
    })
});


let darkClass = localStorage.getItem('darkmode');
if(darkClass){
    $('body').addClass(darkClass);
    // $('.modal-content').addClass('top_dark');
    $(".setting_switch .btn-darkmode").prop('checked',true);
}
let fixnavbarClass = localStorage.getItem('fixnavbar');
if(fixnavbarClass){
    $('#page_top').addClass(fixnavbarClass);
    $(".setting_switch .btn-fixnavbar").prop('checked',true);
}
let headerDark = localStorage.getItem('pageheaderdark');
if(headerDark){
    $('#page_top').addClass(headerDark);
    $(".setting_switch .btn-pageheader").prop('checked',true);
}
let mainsidebar = localStorage.getItem('mainsidebar');
if(mainsidebar){
    $('#header_top').addClass(mainsidebar);
    $(".setting_switch .btn-min_sidebar").prop('checked',true);
}
let sidebar_dark = localStorage.getItem('sidebar_dark');
if(sidebar_dark){
    $('body').addClass(sidebar_dark);
    $(".setting_switch .btn-sidebar").prop('checked',true);
}
let iconcolor = localStorage.getItem('iconcolor');
if(iconcolor){
    $('body').addClass(iconcolor);
    $(".setting_switch .btn-iconcolor").prop('checked',true);
}
let box_shadow = localStorage.getItem('box_shadow');
if(box_shadow){
    $('.card').addClass(box_shadow);
    $(".setting_switch .btn-boxshadow").prop('checked',true);
}

$(".setting_switch .btn-darkmode").on('click', function () {
    localStorage.setItem('darkmode','');
    if(this.checked){
        localStorage.setItem('darkmode','dark-mode');
        // $('.modal-content').addClass('top_dark');
    }
});
$(".setting_switch .btn-fixnavbar").on('click', function () {
    localStorage.setItem('fixnavbar','');
    if(this.checked){
        localStorage.setItem('fixnavbar','sticky-top');
    }
});
$(".setting_switch .btn-pageheader").on('click', function () {
    localStorage.setItem('pageheaderdark','');
    if(this.checked){
        localStorage.setItem('pageheaderdark','top_dark');
    }
});
$(".setting_switch .btn-min_sidebar").on('click', function () {
    localStorage.setItem('mainsidebar','');
    if(this.checked){
        localStorage.setItem('mainsidebar','dark');
    }
});
$(".setting_switch .btn-sidebar").on('click', function () {
    localStorage.setItem('sidebar_dark','');
    if(this.checked){
        localStorage.setItem('sidebar_dark','sidebar_dark');
    }
});
$(".setting_switch .btn-iconcolor").on('click', function () {
    localStorage.setItem('iconcolor','');
    if(this.checked){
        localStorage.setItem('iconcolor','iconcolor');
    }
});
$(".setting_switch .btn-boxshadow").on('click', function () {
    localStorage.setItem('box_shadow','');
    if(this.checked){
        localStorage.setItem('box_shadow','box_shadow');
    }
});
