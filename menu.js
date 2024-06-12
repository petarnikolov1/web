document.querySelector('.menu-toggle').addEventListener('click', function() {
    this.classList.toggle('open');
    document.querySelector('.menu').classList.toggle('open');
});

const sections = document.querySelectorAll('section');
const menuLinks = document.querySelectorAll('.menu a');
const bottomNavLinks = document.querySelectorAll('.bottom-nav a');
const introSection = document.getElementById('intro');

function updateActiveLink() {
    let currentSection = '';

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY  >= sectionTop - sectionHeight / 3) {
            currentSection = section.getAttribute('id');
        }
    });

    const introVisible = isElementInViewport(introSection);
    if (!introVisible) {
        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes(currentSection)) {
                link.classList.add('active');
            }
        });

        bottomNavLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes(currentSection)) {
                link.classList.add('active');
            }
        });
    } else {
        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes('intro')) {
                link.classList.add('active');
            }
        });

        bottomNavLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes('intro')) {
                link.classList.add('active');
            }
        });
    }
}

function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

window.addEventListener('scroll', updateActiveLink);