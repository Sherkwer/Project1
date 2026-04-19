(function() {
            const loginModal = document.getElementById('loginModal');
            const loginBtn = document.getElementById('loginBtn');
            const loginBtnCta = document.getElementById('loginBtnCta');
            const closeModal = document.getElementById('closeModal');

            function openModal() {
                loginModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden'; // Prevent background scroll
            }

            function closeModalFunc() {
                loginModal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = ''; // Restore scroll
            }

            if (loginBtn) {
                loginBtn.addEventListener('click', openModal);
            }

            if (loginBtnCta) {
                loginBtnCta.addEventListener('click', openModal);
            }

            if (closeModal) {
                closeModal.addEventListener('click', closeModalFunc);
            }

            // Close modal when clicking outside
            loginModal.addEventListener('click', function(e) {
                if (e.target === loginModal) {
                    closeModalFunc();
                }
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && loginModal.getAttribute('aria-hidden') === 'false') {
                    closeModalFunc();
                }
            });
        })();

        (function() {
            const header = document.getElementById('header');
            if (header) {
                const observer = new IntersectionObserver(
                    ([entry]) => {
                        header.classList.toggle('scrolled', !entry.isIntersecting);
                    },
                    { threshold: 0.1, rootMargin: '-1px 0px 0px 0px' }
                );
                observer.observe(document.querySelector('.hero__content'));
            }
        })();
