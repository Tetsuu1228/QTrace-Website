const nextBtns = document.querySelectorAll('.next-btn');
    const prevBtns = document.querySelectorAll('.prev-btn');
    const panes = document.querySelectorAll('.step-pane');
    let current = 0;

    // NEXT BUTTON LOGIC
    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const currentPane = panes[current];
            const inputs = currentPane.querySelectorAll('input, textarea');
            
            let isPaneValid = true;

            // Check each input in the current section
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    isPaneValid = false;
                    input.classList.add('is-invalid'); // Show red border
                } else {
                    input.classList.remove('is-invalid'); // Remove red border
                }
            });

            // If everything is filled out, move to the next page
            if (isPaneValid) {
                currentPane.classList.remove('active');
                current++;
                panes[current].classList.add('active');
            }
        });
    });

    // BACK BUTTON LOGIC
    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            panes[current].classList.remove('active');
            current--;
            panes[current].classList.add('active');
        });
    });

    // IMAGE PREVIEW
    document.getElementById('imgInp').addEventListener('change', function() {
        const prev = document.getElementById('imgPrev');
        prev.innerHTML = '';
        [...this.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-img';
                prev.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // FINAL SUBMIT
    document.getElementById('multiStepForm').addEventListener('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            alert("Please complete all fields.");
        }
    });