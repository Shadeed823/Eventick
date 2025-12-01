<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row g-4 text-center text-md-start">
            <div class="col-lg-6 col-md-6">
                <h5>
                    <img style="    background: #ffffff;
    padding: 10px;
    border-radius: 5px;
    height: 58px;" src="{{ asset('images/logo1.png') }}" alt="Eventick Logo" class="navbar-logo">
                </h5>
                <p class="small mt-3">The trusted and transparent ticketing platform in Saudi Arabia.</p>
                <div class="social-icons mt-4">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5>Quick Links</h5>
                <ul class="list-unstyled mt-3">
                    <li><a href="{{route('home')}}" class="footer-link">Home</a></li>
                    <li><a href="{{route('tickets.index')}}" class="footer-link">Explore Tickets</a></li>
                    <li><a href="{{route('about')}}" class="footer-link">About Us</a></li>
                    <li><a href="{{route('contact')}}" class="footer-link">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5>Contact Us</h5>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@eventick.com</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> +966 55 123 4567</li>
                    <li><i class="fas fa-map-marker-alt me-2"></i> Riyadh, Saudi Arabia</li>
                </ul>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.2);">
        <div class="text-center">
            <p class="mb-0 small">© 2025 Eventick. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
    function checkScroll() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight * 0.85;
            if (elementPosition < screenPosition) {
                element.classList.add('animated');
            }
        });
    }
    window.addEventListener('scroll', checkScroll);
    window.addEventListener('load', checkScroll);
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelectorAll('.nav-link');
        const currentPage = window.location.pathname.split('/').pop().split('.')[0];
        navLinks.forEach(link => {
            if (link.dataset.page === currentPage || (currentPage === '' && link.dataset.page === 'home')) {
                link.classList.add('active');
            }
            link.addEventListener('click', function () {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });

    document.getElementById('passwordToggle').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>

@stack('js')
