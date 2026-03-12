// ============================================
// CUSTOMIZE PAGE
// ============================================

function initCustomizePage() {
    const sizeRadios = document.querySelectorAll('.size-radio');
    const ingredientCheckboxes = document.querySelectorAll('.ingredient-checkbox');
    const addonCheckboxes = document.querySelectorAll('.addon-checkbox');

    if (!sizeRadios.length) return;

    // ── Size selection: highlight selected button ──
    sizeRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.size-button').forEach(btn => btn.classList.remove('selected'));
            if (this.checked) {
                this.closest('.size-button').classList.add('selected');
            }
        });
    });

    // ── Ingredients: max 3 ──
    ingredientCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const checked = document.querySelectorAll('.ingredient-checkbox:checked').length;
            if (this.checked && checked > 3) {
                this.checked = false;
                return;
            }
            this.closest('.ingredient-button').classList.toggle('selected', this.checked);
        });
    });

    // ── Add-ons: highlight selected ──
    addonCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            this.closest('.addon-item').classList.toggle('selected', this.checked);
        });
    });

    // ── Quantity buttons ──
    let quantity = 1;
    const quantityDisplay = document.querySelector('.quantity');
    const minusButton = document.querySelector('.quantity-button.minus');
    const plusButton = document.querySelector('.quantity-button.plus');

    if (minusButton) {
        minusButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
            }
        });
    }

    if (plusButton) {
        plusButton.addEventListener('click', () => {
            quantity++;
            quantityDisplay.textContent = quantity;
        });
    }
}


// ============================================
// BAG PAGE
// ============================================

function initBagPage() {
    const removeModal = document.getElementById('removeModal');
    if (!removeModal) return;

    const removeBtn = document.getElementById('removeBtn');
    if (removeBtn) {
        removeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            removeModal.classList.add('active');
        });
    }

    document.getElementById('cancelRemove').addEventListener('click', function () {
        removeModal.classList.remove('active');
    });

    document.getElementById('confirmRemove').addEventListener('click', function () {
        removeModal.classList.remove('active');
    });

    removeModal.addEventListener('click', function (e) {
        if (e.target === this) this.classList.remove('active');
    });
}


// ============================================
// CHECKOUT PAGE
// ============================================

function initCheckoutPage() {
    const radioInputs = document.querySelectorAll('.radio-input');
    if (!radioInputs.length) return;

    // ── Pickup time radio: highlight selected + save + open time modal ──
    document.querySelectorAll('input[name="pickup-time"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('input[name="pickup-time"]').forEach(r => {
                r.closest('.radio-option').classList.remove('selected');
            });
            this.closest('.radio-option').classList.add('selected');

            if (this.value === 'asap') {
                sessionStorage.setItem('pickupTime', 'ASAP (10-15 minutes)');
            }
            if (this.value === 'later') {
                document.getElementById('timeModal').classList.add('active');
            }
        });
    });

    // ── Time modal: slot selection ──
    document.querySelectorAll('.time-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.time-option').forEach(opt => opt.classList.remove('selected'));
            this.closest('.time-option').classList.add('selected');
        });
    });

    // ── Time modal: confirm ──
    const confirmTime = document.getElementById('confirmTime');
    if (confirmTime) {
        confirmTime.addEventListener('click', function () {
            const selected = document.querySelector('.time-radio:checked');
            if (selected) {
                const sublabel = document.querySelector('input[value="later"]').closest('.radio-option').querySelector('.radio-sublabel');
                if (sublabel) sublabel.textContent = selected.value;
                sessionStorage.setItem('pickupTime', selected.value);
            }
            document.getElementById('timeModal').classList.remove('active');
        });
    }

    // ── Time modal: close button ──
    const closeModal = document.getElementById('closeModal');
    if (closeModal) {
        closeModal.addEventListener('click', function () {
            document.getElementById('timeModal').classList.remove('active');
        });
    }

    // ── Time modal: click outside ──
    const timeModal = document.getElementById('timeModal');
    if (timeModal) {
        timeModal.addEventListener('click', function (e) {
            if (e.target === this) this.classList.remove('active');
        });
    }

    // ── Save pickup name as user types ──
    const pickupNameInput = document.getElementById('pickupNameInput');
    if (pickupNameInput) {
        pickupNameInput.addEventListener('input', function () {
            sessionStorage.setItem('pickupName', this.value);
        });
    }

    // ── Payment radio: highlight selected + open Apple Pay modal ──
    document.querySelectorAll('input[name="payment"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('input[name="payment"]').forEach(r => {
                r.closest('.radio-option').classList.remove('selected');
            });
            this.closest('.radio-option').classList.add('selected');

            if (this.value === 'apple') {
                document.getElementById('applePayModal').classList.add('active');
            }
        });
    });

    // ── Apple Pay modal: click outside to close ──
    const applePayModal = document.getElementById('applePayModal');
    if (applePayModal) {
        applePayModal.addEventListener('click', function (e) {
            if (e.target === this) this.classList.remove('active');
        });
    }

    // ── Apple Pay modal: confirm → go to confirmation ──
    const applePayConfirm = document.querySelector('.confirm-section');
    if (applePayConfirm) {
        applePayConfirm.addEventListener('click', function () {
            if (applePayModal) applePayModal.classList.remove('active');
            window.location.href = 'confirmation.html';
        });
    }

    // ── Tip buttons: highlight selected ──
    document.querySelectorAll('.tip-button').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tip-button').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
}


// ============================================
// CONFIRMATION & STATUS PAGES
// ============================================

function initReceiptPage() {
    const readyTime = document.querySelector('.ready-time');
    const pickupName = document.querySelector('.pickup-name');

    if (readyTime) {
        readyTime.textContent = 'Ready by: ' + (sessionStorage.getItem('pickupTime') || 'Not selected');
    }
    if (pickupName) {
        pickupName.textContent = 'Pick up name: ' + (sessionStorage.getItem('pickupName') || 'Guest');
    }
}


// ============================================
// INITIALIZE ON PAGE LOAD
// ============================================

document.addEventListener('DOMContentLoaded', function () {
    initCustomizePage();
    initBagPage();
    initCheckoutPage();
    initReceiptPage();
});
