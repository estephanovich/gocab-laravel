/*=====================
    Header Sticky js
==========================*/
$(window).scroll(function () {
    if ($(this).scrollTop() > 120) {
        $('header').addClass('fixed');
    } else {
        $('header').removeClass('fixed');
    }
});


/*=====================
    home Contain opacity js
==========================*/
$(document).ready(function () {
    function updateStyles() {
        var scrollTop = $(window).scrollTop();
        var opacity = 1 - scrollTop / 200;

        $(".home-contain").css('opacity', opacity);

        if (opacity <= 0) {
            $(".home-contain").css('z-index', -1);
        } else {
            $(".home-contain").css('z-index', 0);
        }
    }

    // Update styles on page load
    updateStyles();

    // Update styles on scroll
    $(window).scroll(function () {
        updateStyles();
    });

    $('.spinner-btn').click(function (event) {
        event.preventDefault();

        $('.invalid-feedback').removeClass('d-block');
        if ($(this).parents('form').valid()) {
            $(this).prop('disabled', true);
            $(this).append('<span class="spinner-border spinner-border-sm ms-2 spinner_loader"></span>');
            const form = $(this).parents('form');
            form.submit();
        }
    });

    // Toggle Password
    $('.toggle-password').on('click', function () {
        var input = $(this).closest('.position-relative').find('input');
        var span = $(this).closest('.toggle-password').find('span');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('ri-eye-line').addClass('ri-eye-off-line');
            if (span && span.length > 0) {
                span.html(' Hide');
            }
        } else {
            input.attr('type', 'password');
            $(this).removeClass('ri-eye-off-line').addClass('ri-eye-line');
            if (span && span.length > 0) {
                span.html(' Show');
            }
        }
    });
});


/*=====================
    Counter js
==========================*/

document.addEventListener('DOMContentLoaded', function () {
    if ("IntersectionObserver" in window) {

        // Helper function to automatically format numbers
        function autoFormatCounter(num) {
            // Check if it's a decimal (rating like 4.9)
            if (num % 1 !== 0 || num < 10) {
                return {
                    displayValue: num,
                    suffix: '',
                    isDecimal: true
                };
            }

            // Check for millions
            if (num >= 1000000) {
                return {
                    displayValue: num / 1000000,
                    suffix: 'M+',
                    isDecimal: true
                };
            }

            // Check for thousands
            if (num >= 1000) {
                return {
                    displayValue: num / 1000,
                    suffix: 'K+',
                    isDecimal: true
                };
            }

            // Regular number
            return {
                displayValue: num,
                suffix: '',
                isDecimal: false
            };
        }

        let counterObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    let counter = entry.target;

                    // Get the target value
                    let targetValue = parseFloat(counter.getAttribute('data-target'));
                    if (isNaN(targetValue)) return;

                    // Auto-detect formatting
                    let formatted = autoFormatCounter(targetValue);

                    // Calculate animation step
                    let step = formatted.displayValue / 120; // Adjust for speed
                    let current = 0;

                    // Start animation
                    let timer = setInterval(function () {
                        current += step;

                        // Stop if we reached or exceeded the target
                        if (current >= formatted.displayValue) {
                            current = formatted.displayValue;
                            clearInterval(timer);
                        }

                        // Format the current value for display
                        let displayText;
                        if (formatted.isDecimal) {
                            // For decimal numbers (including K+, M+)
                            displayText = current.toFixed(1);
                        } else {
                            // For whole numbers
                            displayText = Math.floor(current).toLocaleString();
                        }

                        // Add suffix if exists
                        counter.innerText = displayText + formatted.suffix;

                    }, 15); // Adjust interval for smoother/faster animation

                    counterObserver.unobserve(counter);
                }
            });
        }, {
            threshold: 0.3,
            rootMargin: '0px 0px -50px 0px' // Trigger slightly before entering viewport
        });

        // Observe all counters
        document.querySelectorAll(".counter").forEach(function (counter) {
            counterObserver.observe(counter);
        });
    }
});


/*=====================
    sidebar js
==========================*/
const filterButton = document.querySelector(".navbar-toggler");
const filterSideBar = document.querySelector(".header-middle");
const filterOverlay = document.querySelector(".overlay");
const closeBtns = document.querySelectorAll(".close-menu"); // Select all close buttons

// Add class to the element
filterButton.addEventListener("click", function () {
    filterSideBar.classList.add("show");
    filterOverlay.classList.add("show");
});

// Loop through each close button and add event listener
closeBtns.forEach(function (closeBtn) {
    closeBtn.addEventListener("click", function () {
        filterSideBar.classList.remove("show");
        filterOverlay.classList.remove("show");
    });
});

filterOverlay.addEventListener("click", function () {
    filterSideBar.classList.remove("show");
    filterOverlay.classList.remove("show");
});


// document.addEventListener("DOMContentLoaded", function () {
//     var lastScrollTop = 0;
//     var header = document.querySelector("header");
//     var headerHeight = header.offsetHeight;

//     window.addEventListener("scroll", function () {
//         var windowTop = window.scrollY;

//         if (windowTop >= headerHeight) {
//             header.classList.add("nav-down");
//         } else {
//             header.classList.remove("nav-down");
//             header.classList.remove("nav-up");
//         }

//         if (header.classList.contains("nav-down")) {
//             if (windowTop < lastScrollTop) {
//                 header.classList.add("nav-up");
//             } else {
//                 header.classList.remove("nav-up");
//             }
//         }

//         lastScrollTop = windowTop;
//         // document.getElementById("windowtop").textContent = "scrollTop: " + windowTop;
//     });
// });


$(window).scroll(function () {
    if ($(this).scrollTop() > 150) {
        $('header').addClass('active')
    } else {
        $('header').removeClass('active')
    }
});

/*=====================
   Header scrollspy js
==========================*/
// const sections = document.querySelectorAll("section[id]");

// window.addEventListener("scroll", navHighlighter);

// function navHighlighter() {

//     // Get current scroll position
//     let scrollY = window.pageYOffset;

//     // Now we loop through sections to get height, top and ID values for each
//     sections.forEach(current => {
//         const sectionHeight = current.offsetHeight;
//         const sectionTop = current.offsetTop - 50;
//         sectionId = current.getAttribute("id");

//         if (
//             scrollY > sectionTop &&
//             scrollY <= sectionTop + sectionHeight
//         ) {
//             document.querySelector(".nav-item a[href*=" + sectionId + "]").classList.add("active");
//         } else {
//             document.querySelector(".nav-item a[href*=" + sectionId + "]").classList.remove("active");
//         }

//     });
// }
