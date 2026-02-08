document.addEventListener('DOMContentLoaded', function () {
  const images = worksGalleryData.images;
  const modal = document.getElementById('worksModal');
  if (!modal) return;

  const modalImg = modal.querySelector('.works-modal__image');
  const counter = modal.querySelector('.works-modal__counter');
  const items = document.querySelectorAll('.works-gallery-item');
  let currentIndex = 0;

  function showImage(index) {
    currentIndex = index;
    modalImg.src = images[index];
    counter.textContent = (index + 1) + ' / ' + images.length;
  }

  function openModal(index) {
    showImage(index);
    modal.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('is-active');
    document.body.style.overflow = '';
  }

  items.forEach(function (item) {
    item.addEventListener('click', function () {
      openModal(parseInt(this.dataset.index));
    });
  });

  modal.querySelector('.works-modal__close').addEventListener('click', closeModal);
  modal.querySelector('.works-modal__overlay').addEventListener('click', closeModal);

  modal.querySelector('.works-modal__prev').addEventListener('click', function () {
    showImage((currentIndex - 1 + images.length) % images.length);
  });

  modal.querySelector('.works-modal__next').addEventListener('click', function () {
    showImage((currentIndex + 1) % images.length);
  });

  document.addEventListener('keydown', function (e) {
    if (!modal.classList.contains('is-active')) return;
    if (e.key === 'Escape') closeModal();
    if (e.key === 'ArrowLeft') showImage((currentIndex - 1 + images.length) % images.length);
    if (e.key === 'ArrowRight') showImage((currentIndex + 1) % images.length);
  });
});