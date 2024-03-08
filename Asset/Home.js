$(".addToggler").click(() => {
    $(".MobileNewMenuList").addClass("show");
});
$(".removeToggler").click(() => {
    $(".MobileNewMenuList").removeClass("show");
});

$(".sec1-owl-carsoul").owlCarousel({
    loop: true,
    autoplay: true,
   
    autoplaySpeed: 2500,
    nav: true,
    navText: [
        "<i class='fa-solid fa-angle-left'></i>",
        "<i class='fa-solid fa-angle-right'></i>",
    ],
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
        },
    },
});

$(".sec-5-carasoul").owlCarousel({
    loop: true,
    margin: 15,
    nav: false,
    autoplaySpeed: 2500,
    autoplay: true,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 2,
        },
        1000: {
            items: 3,
        },
    },
});

$(".testimSlider").owlCarousel({
    loop: true,
    margin: 35,
    nav: false,
    autoplaySpeed: 2500,
    autoplay: true,
    // dot: false,
    responsive: {
        0: {
            items: 1,
        },
        768: {
            items: 2,
        },
        1000: {
            items: 2,
        },
    },
});
$(".projectCarousel").owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    autoplaySpeed: 2500,
    autoplay: true,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 3,
        },
        1000: {
            items: 3,
        },
    },
});

//***************** counter start *******************************
const counters = document.querySelectorAll(".counter");
const targets = [50,2, 25, 15];
let counts = new Array(targets.length).fill(0);
const speed = 100; // Adjust the speed of counting
const delayBeforeStart = 1000; // 2000 milliseconds (2 seconds) delay before starting the counting

let startCountingTimeout;

// Function to start the counting animation
const startCounting = () => {
    let allFinished = true;

    for (let i = 0; i < counters.length; i++) {
        const target = targets[i];
        const counter = counters[i];

        const increment = target / speed;
        if (counts[i] < target) {
            counts[i] += increment;
            counter.textContent = Math.ceil(counts[i]);
            allFinished = false;
        } else {
            counter.textContent = target;
        }
    }

    if (!allFinished) {
        requestAnimationFrame(startCounting);
    }
};

// Function to check if an element is in the viewport
const isInViewport = (element) => {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <=
            (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <=
            (window.innerWidth || document.documentElement.clientWidth)
    );
};

// Use the Intersection Observer API to trigger counting when in the viewport
const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            clearTimeout(startCountingTimeout); // Clear any previous timeout
            startCountingTimeout = setTimeout(startCounting, delayBeforeStart);
            observer.unobserve(entry.target);
        }
    });
});

// Observe all counter elements
counters.forEach((counter) => {
    observer.observe(counter);
});
//*************************** counter end ****************************//
// ################### Our Team #######################//
$('.our-team-member').owlCarousel({
    loop:true,
    margin:30,
    autoplaySpeed: 500,
    // autoplay: true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:2
        }
    }
})


// ##############################//
let Videobtn1 = document.querySelector(".Videobtn1");
let clip = document.querySelector(".clip");
let close = document.querySelector(".close");
let Yvideoo = document.querySelector("Yvideoo");
Videobtn1.onclick = function () {
    Videobtn1.classList.add("active");
    clip.classList.add("active");
    Yvideoo.play();
};
close.onclick = function () {
    Videobtn1.classList.remove("active");
    clip.classList.remove("active");
};


// *********************CommercialPage*****************//function openCity(evt, cityName) {
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
      }
      document.getElementById("defaultOpen").click();


// *********************GalleryPage*****************//


 
// $(document).ready(function() {
//     $('.gallerys').magnificPopup({
//       delegate: 'a',
//       type: 'img',
//       gallery:{
//         enabled:true
//       }
//     });
//   });