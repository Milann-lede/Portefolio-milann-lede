// Animation de révélation des cartes au défilement
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Démonstrations interactives JavaScript
    
    // 1. Manipulation du texte
    const changeTextBtn = document.getElementById('change-text-btn');
    const demoText = document.getElementById('demo-text');
    
    if (changeTextBtn && demoText) {
        changeTextBtn.addEventListener('click', function() {
            const texts = [
                "Le texte a changé !",
                "JavaScript est puissant !",
                "Vous pouvez manipuler le DOM facilement.",
                "Les interactions rendent le web vivant.",
                "Retour au message initial."
            ];
            
            const currentText = demoText.textContent;
            let newText;
            
            do {
                newText = texts[Math.floor(Math.random() * texts.length)];
            } while (newText === currentText && texts.length > 1);
            
            demoText.textContent = newText;
        });
    }
    
    // 2. Compteur interactif
    let counterValue = 0;
    const counterDisplay = document.getElementById('counter-value');
    const incrementBtn = document.getElementById('increment-btn');
    const decrementBtn = document.getElementById('decrement-btn');
    const resetBtn = document.getElementById('reset-btn');
    
    function updateCounter() {
        if (counterDisplay) {
            counterDisplay.textContent = counterValue;
            // Changer la couleur en fonction de la valeur
            if (counterValue > 0) {
                counterDisplay.style.color = '#4ade80'; // Vert
            } else if (counterValue < 0) {
                counterDisplay.style.color = '#f87171'; // Rouge
            } else {
                counterDisplay.style.color = 'var(--accent-start)'; // Couleur par défaut
            }
        }
    }
    
    if (incrementBtn) {
        incrementBtn.addEventListener('click', function() {
            counterValue++;
            updateCounter();
        });
    }
    
    if (decrementBtn) {
        decrementBtn.addEventListener('click', function() {
            counterValue--;
            updateCounter();
        });
    }
    
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            counterValue = 0;
            updateCounter();
        });
    }
    
    // 3. Générateur de couleur
    const generateColorBtn = document.getElementById('generate-color-btn');
    const colorBox = document.getElementById('color-box');
    const colorValue = document.getElementById('color-value');
    
    function generateRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    
    if (generateColorBtn && colorBox && colorValue) {
        generateColorBtn.addEventListener('click', function() {
            const randomColor = generateRandomColor();
            colorBox.style.backgroundColor = randomColor;
            colorValue.textContent = randomColor;
        });
        
        // Générer une couleur initiale
        const initialColor = generateRandomColor();
        colorBox.style.backgroundColor = initialColor;
        colorValue.textContent = initialColor;
    }
});