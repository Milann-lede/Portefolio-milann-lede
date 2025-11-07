

// ====== Reveal on scroll ======
const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting){
            entry.target.classList.add('visible');
            io.unobserve(entry.target);
        }
    })
}, {threshold: .20, rootMargin: '0px 0px -40px 0px'});

document.querySelectorAll('.card').forEach(el => io.observe(el));


// Animation de révélation des cartes au défilement
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => {
        observer.observe(card);
    });

    // Gestion du menu burger
    const burger = document.getElementById('burger');
    const nav = document.getElementById('nav');

    if (burger && nav) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('active');
        });
    }
});
// Rendre toutes les cartes visibles une fois le DOM chargé (au cas ou IntersectionObserver ne fonctionn pas)
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.card');
  cards.forEach(card => card.classList.add('visible'));
});

// ====== EmailJS Configuration ======
(function() {
    // Initialisation d'EmailJS avec votre Public Key
    emailjs.init("MHWfCFxbSaIfZJ-xN"); 
})();

// ====== Formulaire de contact ======
const contactForm = document.getElementById('contact-form');
const formStatus = document.getElementById('form-status');

contactForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Afficher un message de chargement
    formStatus.textContent = '⏳ Envoi en cours...';
    formStatus.style.color = 'var(--muted)';
    
    // Récupérer les données du formulaire
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        message: document.getElementById('message').value
    };
    
    // Envoyer l'email via EmailJS
    emailjs.send("service_jh1yade", "template_4g6rna6", formData)
        .then(function(response) {
            console.log('SUCCESS!', response.status, response.text);
            formStatus.textContent = '✅ Message envoyé avec succès';
            formStatus.style.color = '#4ade80';
            
            // Réinitialiser le formulaire
            contactForm.reset();
            
            // Masquer le message après 5 secondes
            setTimeout(() => {
                formStatus.textContent = '';
            }, 5000);
        }, function(error) {
            console.log('FAILED...', error);
            formStatus.textContent = 'Erreur lors de l\'envoi. Veuillez réessayer.';
            formStatus.style.color = '#f87171';
            
            // Masquer le message d'erreur après 5 secondes
            setTimeout(() => {
                formStatus.textContent = '';
            }, 5000);
        });
});