/**
 * Discount Code Handler
 *
 * This script provides functionality for validating and applying discount codes
 * across different purchase types: accounts, random accounts, and services.
 */

class DiscountCodeHandler {
    constructor() {
        this.discountCode = '';
        this.originalPrice = 0;
        this.discountedPrice = 0;
        this.context = ''; // 'account', 'random_account', or 'service'
        this.itemId = 0;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    /**
     * Initialize the discount code handler for a specific context
     *
     * @param {string} context - The context ('account', 'random_account', or 'service')
     * @param {number} itemId - The ID of the item being purchased
     * @param {number} originalPrice - The original price of the item
     */
    init(context, itemId, originalPrice) {
        this.context = context;
        this.itemId = itemId;
        this.originalPrice = originalPrice;
        this.discountedPrice = originalPrice;

        // Reset any previous discount code
        this.discountCode = '';

        // Reset any previous messages
        this.showMessage('', 'info');

        // Update UI with initial price
        this.updatePriceDisplay(originalPrice);
    }

    /**
     * Validate a discount code
     *
     * @param {string} code - The discount code to validate
     * @returns {Promise} - A promise that resolves with the validation result
     */
    async validateCode(code) {
        if (!code) {
            this.showMessage('Vui lòng nhập mã giảm giá!', 'error');
            return false;
        }

        this.showMessage('Đang kiểm tra mã...', 'info');

        try {
            const response = await fetch('/discount-code/validate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    code: code,
                    context: this.context,
                    item_id: this.itemId
                })
            });

            const data = await response.json();
            console.log(data);
            if (data.success) {
                this.discountCode = code;
                this.discountedPrice = data.data.discounted_price;
                this.updatePriceDisplay(data.data.discounted_price);

                const savings = data.data.original_price - data.data.discounted_price;
                const formattedSavings = new Intl.NumberFormat('vi-VN').format(savings);

                this.showMessage(`Mã giảm giá đã được áp dụng! Bạn tiết kiệm được ${formattedSavings}đ`, 'success');
                return true;
            } else {
                // Reset to original price if code is invalid
                this.discountCode = '';
                this.discountedPrice = this.originalPrice;
                this.updatePriceDisplay(this.originalPrice);

                this.showMessage(data.message || 'Mã giảm giá không hợp lệ', 'error');
                return false;
            }
        } catch (error) {
            console.error('Error validating discount code:', error);
            this.showMessage('Có lỗi xảy ra khi kiểm tra mã giảm giá', 'error');
            return false;
        }
    }

    /**
     * Update the price display in the UI
     *
     * @param {number} price - The price to display
     */
    updatePriceDisplay(price) {
        // Find price display elements based on context
        let priceElements = [];

        if (this.context === 'account' || this.context === 'random_account') {
            priceElements = document.querySelectorAll('#account-price, .account-price-value');
        } else if (this.context === 'service') {
            priceElements = document.querySelectorAll('.service-modal__value--price, .service-price-value');
        }

        // Update all price display elements
        priceElements.forEach(element => {
            if (element) {
                element.textContent = `${new Intl.NumberFormat('vi-VN').format(price)}đ`;
            }
        });
    }

    /**
     * Show a message in the UI
     *
     * @param {string} message - The message to display
     * @param {string} type - The type of message ('info', 'success', or 'error')
     */
    showMessage(message, type) {
        // Find message elements based on context
        let messageElements = [];

        if (this.context === 'account' || this.context === 'random_account') {
            messageElements = document.querySelectorAll('#discount-message');
        } else if (this.context === 'service') {
            messageElements = document.querySelectorAll('.service-modal__discount-message');
        }

        // Update all message elements
        messageElements.forEach(element => {
            if (element) {
                element.textContent = message;

                // Set color based on message type
                if (type === 'error') {
                    element.style.color = 'red';
                } else if (type === 'success') {
                    element.style.color = 'green';
                } else {
                    element.style.color = 'blue';
                }
            }
        });
    }

    /**
     * Get the current discount code and discounted price
     *
     * @returns {Object} - Object containing the discount code and discounted price
     */
    getDiscountInfo() {
        return {
            discountCode: this.discountCode,
            originalPrice: this.originalPrice,
            discountedPrice: this.discountedPrice
        };
    }
}

// Create a global instance
const discountHandler = new DiscountCodeHandler();

/**
 * Initialize the discount code handler for a specific context
 *
 * @param {string} context - The context ('account', 'random_account', or 'service')
 * @param {number} itemId - The ID of the item being purchased
 * @param {number} originalPrice - The original price of the item
 */
function initDiscountHandler(context, itemId, originalPrice) {
    discountHandler.init(context, itemId, originalPrice);
}

/**
 * Check a discount code from the input field
 *
 * @param {string} contextSelector - The selector for the discount code input
 */
async function checkDiscountCode(contextSelector) {
    const codeInput = document.querySelector('#discount-code');
    if (!codeInput) return;

    const code = codeInput.value.trim();
    await discountHandler.validateCode(code);
}

/**
 * Get the current discount information for use in purchase functions
 *
 * @returns {Object} - Object containing the discount code and discounted price
 */
function getDiscountInfo() {
    return discountHandler.getDiscountInfo();
}
