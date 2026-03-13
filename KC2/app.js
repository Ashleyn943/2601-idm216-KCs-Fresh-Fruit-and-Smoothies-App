// ============================================
// CUSTOMIZE PAGE
// ============================================

function initCustomizePage() {
    const sizeSelect = document.querySelectorAll('.size-radio');
    const ingredientCheckboxes = document.querySelectorAll('.ingredient-checkbox');
    const addonCheckboxes = document.querySelectorAll('.addon-checkbox');

    if (!sizeSelect.length) return;

    // ── Size selection: highlight selected button ──
    sizeSelect.forEach(radio => {
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

    const prices = {
    small_1: 4.00, medium_1: 5.00, large_1: 6.00,
    small_2: 4.00, large_2: 5.00,
    small_3: 4.00, medium_3: 5.00, large_3: 6.00,
    small_4: 4.50, medium_4: 5.50, large_4: 6.50
};

    //Updates the price displayed on page
    function updatePrice() {
        const sizePrice = document.querySelector('.size-radio:checked');
        let basePrice = sizePrice ? (prices[sizePrice.value] || 0) : 0;

        document.querySelectorAll('.addon-checkbox:checked').forEach(() => {
            basePrice += 0.50;
        });

        const total = basePrice * quantity; 
        document.querySelector('.total-price').textContent = '$' + total.toFixed(2);
    }

    //specifically updates for when size/addons changes
    document.querySelectorAll('.size-radio, .addon-checkbox').forEach(input => {
        input.addEventListener('change', updatePrice);
    });

    //Handles when quantity changes
    const quantityDisplay = document.querySelector('.quantity');
    const minusButton = document.querySelector('.quantity-button.minus');
    const plusButton = document.querySelector('.quantity-button.plus');
    const quantityInput = document.getElementById('quantity-input'); 

    let quantity = 1;

    if (minusButton) {
        minusButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
                if (quantityInput) quantityInput.value = quantity; 
                updatePrice();
            }
        });
    }

    if (plusButton) {
        plusButton.addEventListener('click', () => {
            quantity++;
            quantityDisplay.textContent = quantity;
            if (quantityInput) quantityInput.value = quantity; 
            updatePrice();
        });
    }
}

// ============================================
// BAG PAGE
// ============================================

function initBagPage() {
    //for quantity selector (recalculates prices)
    document.querySelectorAll('.bag-quantity-controls').forEach(controls => {
        const minus     = controls.querySelector('.minus');
        const plus      = controls.querySelector('.plus');
        const display   = controls.querySelector('.quantity');
        const index     = controls.dataset.index;
        const basePrice = parseFloat(controls.dataset.basePrice);
        const priceEl   = document.getElementById('price-' + index);
        let qty = parseInt(display.textContent) || 1;

        display.textContent = qty;
        if (priceEl) priceEl.textContent = '$' + (basePrice * qty).toFixed(2);

        function saveQuantity() {
            fetch('update_item_quantity.php?index=' + index + '&quantity=' + qty)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        if (priceEl) priceEl.textContent = '$' + parseFloat(data.new_price).toFixed(2);
                        updateSubtotal();
                    }
                });
        }

        plus.addEventListener('click', () => {
            qty++;
            display.textContent = qty;
            saveQuantity();
    });

        minus.addEventListener('click', () => {
            if (qty > 1) {
                qty--;
                display.textContent = qty;
                saveQuantity();
            }
    });
});

    function updateSubtotal() {
        let total = 0;
        document.querySelectorAll('.bag-item-price').forEach(el => {
            total += parseFloat(el.textContent.replace('$', '')) || 0;
        });
        const subtotalEl = document.querySelector('.bag-subtotal-amount');
        if (subtotalEl) subtotalEl.textContent = '$' + total.toFixed(2);
    }

    //for remove 
    const modal = document.getElementById('removeModal');
    let pendingIndex = null;

    document.querySelectorAll('.removeBtn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            pendingIndex = btn.dataset.index;
            modal.classList.add('active'); 
        });
    });

    const cancelBtn  = document.getElementById('cancelRemove');
    const confirmBtn = document.getElementById('confirmRemove');

    if (cancelBtn && confirmBtn) {
        cancelBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            pendingIndex = null;
        });

        confirmBtn.addEventListener('click', () => {
            if (pendingIndex === null) return;
            window.location.href = 'remove_item.php?index=' + pendingIndex;
        });
    }
    
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
            console.log('THIS LISTENER FIRED:', this);
            if (applePayModal) applePayModal.classList.remove('active');
            const subtotal = parseFloat(document.getElementById('summary-subtotal').dataset.subtotal) || 0;
            const tax      = subtotal * 0.08;
            const tipText  = document.getElementById('summary-tip').textContent.replace('$', '').trim();
            const tip      = parseFloat(tipText) || 0;
            const total    = parseFloat(document.getElementById('summary-total').textContent.replace('$', '').trim()) || 0;

            const subtotalEl = document.getElementById('summary-subtotal');
            const tipEl      = document.getElementById('summary-tip');
            const totalEl    = document.getElementById('summary-total');

            if (!subtotalEl || !tipEl || !totalEl) {
                console.error('Summary elements not found!');
                return;
            }

            console.log('Saving:', subtotal, tax, tip, total);

            const summaryData = new FormData();
            summaryData.append('save_summary', true);
            summaryData.append('subtotal', subtotal.toFixed(2));
            summaryData.append('tax',      tax.toFixed(2));
            summaryData.append('tip_amount',      tip.toFixed(2));
            summaryData.append('total',    total.toFixed(2));

            fetch('', { method: 'POST', body: summaryData })
                .then(() => {
                    window.location.href = 'confirmation.php';
                })
                .catch(err => {
                     console.error('Save failed:', err); // redirect even if save fails
                });
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
    console.log('DOM loaded');
    initCustomizePage();
    console.log('Customize page initialized');
    initBagPage();
    console.log('Bag page initialized');
    initCheckoutPage();
    console.log('Checkout page initialized');
    initReceiptPage();
    console.log('Receipt page initialized');
});
