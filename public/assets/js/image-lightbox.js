/**
 * Image Lightbox Functionality
 * Initializes SimpleLightbox for image galleries throughout the site
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize SimpleLightbox for account images
    const accountGallery = new SimpleLightbox('.detail__images-item', {
        captionPosition: 'bottom',
        captionsData: 'alt',
        closeText: '×',
        navText: ['←','→'],
        animationSpeed: 250,
        scaleImageToRatio: true,
        disableRightClick: true
    });

    // Initialize SimpleLightbox for any image gallery with 'gallery' class
    const generalGallery = new SimpleLightbox('.gallery a', {
        captionPosition: 'bottom',
        captionsData: 'title',
        closeText: '×',
        navText: ['←','→'],
        animationSpeed: 250,
        scaleImageToRatio: true
    });
});

/**
 * Prepare Single Image for Lightbox View
 * Wraps single images in a gallery container for lightbox viewing
 */
function prepareSingleImagesForLightbox() {
    const singleImages = document.querySelectorAll('.detail__images-item');

    singleImages.forEach(image => {
        // Make images clickable
        image.style.cursor = 'pointer';

        // Add zoom in icon to indicate lightbox functionality
        const zoomIcon = document.createElement('div');
        zoomIcon.className = 'image-zoom-icon';
        zoomIcon.innerHTML = '<i class="fas fa-search-plus"></i>';

        // Append the zoom icon to the parent container
        const parent = image.parentElement;
        parent.style.position = 'relative'; // Ensure proper positioning
        parent.appendChild(zoomIcon);
    });
}

// Run the preparation function when DOM is loaded
document.addEventListener('DOMContentLoaded', prepareSingleImagesForLightbox);
