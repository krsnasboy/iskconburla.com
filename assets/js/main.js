document.addEventListener('DOMContentLoaded', () => {
  const flashes = document.querySelectorAll('[data-flash]');
  flashes.forEach(f => setTimeout(() => f.remove(), 5000));

  const uploadInput = document.querySelector('#darshanImage');
  if (uploadInput) {
    uploadInput.addEventListener('change', (e) => {
      const file = uploadInput.files && uploadInput.files[0];
      if (!file) return;
      const allowed = ['image/jpeg', 'image/png', 'image/webp'];
      if (!allowed.includes(file.type)) {
        alert('Only JPG, PNG, WEBP images are allowed.');
        uploadInput.value = '';
      }
      if (file.size > 5 * 1024 * 1024) {
        alert('Image must be less than 5MB.');
        uploadInput.value = '';
      }
    });
  }
}); 