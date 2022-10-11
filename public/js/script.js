////////////////////// All scroll methods ////////////////
$(document).scroll(function() {
    manageHeaderNavbar();
    resizeHeaderMenubar();
    toggleGoToTopButton();
});

///////navbar close after clicking outside
$(document).ready(function() {
    manageHeaderNavbar();
    resizeHeaderMenubar();
    toggleGoToTopButton();

    $(document).click(function(event) {
        const click = $(event.target);
        const _open = $(".navbar-collapse").hasClass("show");
        if (_open === true && !click.hasClass("navbar-toggler")) {
            $(".navbar-toggler").click();
        }
    });

    // Animations initialization
    new WOW().init();

    // Osano Cookie Consent
    window.cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "#000"
            },
            "button": {
                "background": "#966f03"
            }
        },
        "theme": "classic"
    });

    if ($('#map').length) {
        new Maplace({
            map_div: '#map',
            show_markers: true,
            locations: [
                {
                    html: "<div class='float-start'><img class='marker-image' src='../images/logo.jpg' alt='EinzigTecg e.U.'></div><div class='float-end ml-3'><h5>EinzigTech e.U.</h5>"+ $('#address-austria').html() +"</div>",
                    lat: 47.267479,
                    lon: 11.416985,
                    icon: '../images/map-marker.png',
                    scrollwheel: false
                },
                {
                    html: "<div class='float-start'><img class='marker-image' src='../images/logo.jpg' alt='EinzigTecg Pvt. Ltd.'></div><div class='float-end ml-3'><h5>EinzigTech Pvt. Ltd.</h5>"+ $('#address-india').html() +"</div>",
                    lat: 22.734681,
                    lon: 88.494305,
                    icon: '../images/map-marker.png',
                    scrollwheel: false
                }
            ],
            map_options: {mapTypeId: google.maps.MapTypeId.ROADMAP}
        }).Load();
    }

    if ($('.owl-carousel').length) {
        $(".owl-carousel").owlCarousel({
            loop: true,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsive: {
                0: {
                    items: 3,
                    dotsEach: 3
                },
                350: {
                    items: 3,
                    dotsEach: 3
                },
                500: {
                    items: 4,
                    dotsEach: 4
                },
                1000: {
                    items: 6,
                    dotsEach: 6
                }
            }
        });
    }
});

function manageHeaderNavbar() {
    let scrollPos = $(document).scrollTop();
    let buffer = 200;

    if ($('#portfolio').length) {
        let about = $("#about");
        let services = $("#services");
        let portfolio = $("#portfolio");

        if (scrollPos < (about.offset().top - buffer)) {
            $('.nav-item.current').removeClass('current');
            $('#nav-home').addClass('current');

        } else if (scrollPos > (about.offset().top - buffer) && scrollPos < (services.offset().top - buffer)) {
            $('.nav-item.current').removeClass('current');
            $('#nav-about').addClass('current');

        } else if (scrollPos > (services.offset().top - buffer) && scrollPos < (portfolio.offset().top - buffer)) {
            $('.nav-item.current').removeClass('current');
            $('#nav-services').addClass('current');

        } else if (scrollPos > portfolio.offset().top - buffer) {
            $('.nav-item.current').removeClass('current');
            $('#nav-portfolio').addClass('current');
        }
    }
}

function resizeHeaderMenubar() {
    let scrollPos = $(document).scrollTop();
    // Resize top menu
    if (scrollPos > 80) {
        $('.navbar').addClass('shrink');
        $('#logo').css({'width': '90px', 'height': '90px', 'transition': '0.4s'})
    } else {
        $('.navbar').removeClass('shrink');
        $('#logo').css({'width': '120px', 'height': '120px'})
    }
}

function toggleGoToTopButton() {
    let scrollPos = $(document).scrollTop();
    // Show the go-to-top button
    if (scrollPos > 200) {
        $('#go-to-top').css('display', 'block');
    } else {
        $('#go-to-top').css('display', 'none');
    }
}

function jobApply(element) {
    let jobCode = $(element).data('job-code');
    let jobName = $('#' + jobCode + ' .card-title').text();
    $("#job_application_jobPosition").val(jobCode + ' - ' + jobName).prop('readonly', true);
    $("#job_application_message").prop('hidden', true);
}

function jobApplySI() {
    $("#job_application_jobPosition").val('').prop('readonly', false);
    $("#job_application_message").prop('hidden', false);
}