<script>
    // Auto-scroll to next section after save
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('scroll_to'))
            const targetCardId = '{{ session('scroll_to') }}';
            const targetCard = document.getElementById(targetCardId);
            
            if (targetCard) {
                console.log('Found target card:', targetCardId);
                
                // Wait for page to fully load
                setTimeout(() => {
                    // Calculate position with offset
                    const cardPosition = targetCard.getBoundingClientRect().top + window.pageYOffset;
                    const offset = 80; // 80px offset from top (adjust as needed)

                    console.log('Scrolling to position:', cardPosition + offset);
                    
                    // Smooth scroll to position with offset
                    window.scrollTo({
                        top: cardPosition + offset,
                        behavior: 'smooth'
                    });
                    
                    // Wait for scroll to complete, then expand
                    setTimeout(() => {
                        // Find the toggle button - try multiple selectors
                        const toggleButton = targetCard.querySelector('[data-action="toggle"]') || 
                                        targetCard.querySelector('.toggle-card') ||
                                        targetCard.querySelector('[onclick*="toggle"]') ||
                                        targetCard.querySelector('button[aria-expanded]');
                        
                        console.log('Toggle button:', toggleButton);
                        
                        if (toggleButton) {
                            // Check if already expanded
                            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
                            console.log('Is expanded:', isExpanded);
                            
                            if (!isExpanded) {
                                // Programmatically click the toggle button
                                toggleButton.click();
                                console.log('Clicked toggle button');
                            }
                        } else {
                            // Fallback: manually expand the card
                            console.log('No toggle button found, using fallback');
                            const content = targetCard.querySelector('[id$="-content"]') ||
                                        targetCard.querySelector('.card-content') ||
                                        targetCard.querySelector('[class*="hidden"]');
                            
                            if (content) {
                                console.log('Found content:', content);
                                content.classList.remove('hidden');
                                
                                // Rotate chevron if exists
                                const chevron = targetCard.querySelector('svg');
                                if (chevron) {
                                    chevron.classList.remove('rotate-0');
                                    chevron.classList.add('rotate-180');
                                }
                            }
                        }
                    }, 600);
                    
                    // Add highlight effect
                    targetCard.classList.add('ring-2', 'ring-[#0d9488]', 'ring-offset-2');
                    setTimeout(() => {
                        targetCard.classList.remove('ring-2', 'ring-[#0d9488]', 'ring-offset-2');
                    }, 2500);
                }, 300);
            } else {
                console.log('Target card not found:', targetCardId);
            }
        @endif
    });
    // Calculate overall completion percentage
    function calculateOverallCompletion() {
        // Get all percentage elements
        const percentageElements = document.querySelectorAll('[id$="-percentage"]');
        let total = 0;
        let count = 0;
        
        percentageElements.forEach(element => {
            if (element.id !== 'overall-percentage') {
                const value = parseInt(element.textContent);
                if (!isNaN(value)) {
                    total += value;
                    count++;
                }
            }
        });
        
        const overall = count > 0 ? Math.round(total / count) : 0;
        const overallElement = document.getElementById('overall-percentage');
        if (overallElement) {
            overallElement.textContent = overall + '%';
        }
        
        // Update progress bar
        const progressBar = document.querySelector('.bg-gradient-to-r.from-blue-600');
        if (progressBar) {
            progressBar.style.width = overall + '%';
        }
        
        // Calculate points (rough estimate: each section worth ~10 points)
        const points = Math.round((overall / 100) * 80);
        const pointsElement = progressBar?.parentElement?.nextElementSibling;
        if (pointsElement) {
            pointsElement.textContent = points + ' / 80 points';
        }
    }

    // Call on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateOverallCompletion();
    });

    // Auto-scroll to expanded section
    function scrollToCard(cardId) {
        const card = document.getElementById(cardId);
        if (card) {
            setTimeout(() => {
                card.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }
</script>