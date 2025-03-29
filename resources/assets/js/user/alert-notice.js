
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý đóng thông báo
    const alertCloseButtons = document.querySelectorAll('.service__alert-close');
    alertCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.service__alert');
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        });
    });
});