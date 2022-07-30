/* PROUT */

(function () {
	"use strict";

	$(document).ready(function () {
		activeLink();
        resizeMain();
        alertTimeout();

        $(window).resize(function () {
            resizeMain();
        });
	});

    
})();

function activeLink() {
    // Route active
    let pathname = window.location.pathname;

	// Récupérer tous les nav-link
    ($('.nav-link')).each(function () {
        let href = ($(this).attr('href'));
        let currentLink = $(this);

        if (href === pathname) {
            currentLink.addClass('active');
        }
        else {
            currentLink.removeClass('active');
        }
    });
}

function resizeMain() {
    let navHeight = $('nav').outerHeight();
    let titleHeight = ($('.title').length === 0) ? 0 : $('.title').outerHeight();
    let listUsersHeight = titleHeight + $('#addUserButton').outerHeight(); + $('#nb-users').outerHeight();

    $('main').css("height", "calc(100vh - " + navHeight + "px)");
    $('section').css("min-height", "calc(100% - " + titleHeight + "px)");
    $('#display-users').css("min-height", "calc(100% - " + listUsersHeight + "px)");
}

function alertTimeout() {
    setTimeout(function () {
        $(".alert").remove();
    }, 8000);
}
