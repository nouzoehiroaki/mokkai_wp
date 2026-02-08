// Hamburger menu toggle
const hamburger = document.getElementById('hamburger');
const menuOverlay = document.getElementById('menuOverlay');

hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('active');
  menuOverlay.classList.toggle('active');
});

// Page transition system
let currentPage = 'products';
const pages = document.querySelectorAll('.page-section');
const menuLinks = document.querySelectorAll('[data-page]');

// Update menu active state
function updateMenuActiveState() {
  menuLinks.forEach(link => {
    const linkPage = link.getAttribute('data-page');
    if (linkPage === currentPage) {
      link.classList.add('active');
      link.style.pointerEvents = 'none';
    } else {
      link.classList.remove('active');
      link.style.pointerEvents = 'auto';
    }
  });
}

function showPage(targetPage) {
  if (targetPage === currentPage) return;

  const currentSection = document.getElementById(currentPage);
  const targetSection = document.getElementById(targetPage);

  // Add prev class to current page
  currentSection.classList.add('prev');
  currentSection.classList.remove('active');

  // Show target page
  setTimeout(() => {
    targetSection.classList.add('active');
    targetSection.classList.remove('prev');

    // Clean up prev class after animation
    setTimeout(() => {
      currentSection.classList.remove('prev');
    }, 800);
  }, 100);

  currentPage = targetPage;

  // Update menu active state
  updateMenuActiveState();

  // Close menu
  hamburger.classList.remove('active');
  menuOverlay.classList.remove('active');
}

menuLinks.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const targetPage = link.getAttribute('data-page');
    showPage(targetPage);
    // Update URL hash
    history.pushState(null, '', `#${targetPage}`);
  });
});

// Handle direct URL access and browser back/forward buttons
function handleHashChange() {
  const hash = window.location.hash.slice(1); // Remove '#' from hash
  const validPages = ['about', 'products', 'news', 'contact'];
  
  if (hash && validPages.includes(hash)) {
    // Directly set page without animation on initial load
    if (document.readyState === 'loading') {
      currentPage = hash;
      pages.forEach(page => {
        if (page.id === hash) {
          page.classList.add('active');
        } else {
          page.classList.remove('active');
        }
      });
      updateMenuActiveState();
    } else {
      showPage(hash);
    }
  } else if (!hash) {
    // No hash means home page
    if (currentPage !== 'products') {
      showPage('products');
    }
  }
}

// Listen for hash changes (back/forward buttons)
window.addEventListener('hashchange', handleHashChange);

// Handle initial page load
handleHashChange();

// Initialize menu active state on page load
updateMenuActiveState();

// Close menu when clicking outside
menuOverlay.addEventListener('click', (e) => {
  if (e.target === menuOverlay) {
    hamburger.classList.remove('active');
    menuOverlay.classList.remove('active');
  }
});

// ローディングアニメーション（CSP対応版）
document.addEventListener('DOMContentLoaded', function() {
  const loadingScreen = document.querySelector('.loading-screen');
  const mainSite = document.querySelector('.main-site');

  const isHomePage = document.body.classList.contains('home')
  
  if (isHomePage) {
    // メインサイトを最初は非表示に
    mainSite.style.display = 'none';
    mainSite.style.opacity = '0';

    // 関数として定義してsetTimeoutに渡す（CSP対応）
    function fadeOutLoading() {
      loadingScreen.style.opacity = '0';
      loadingScreen.style.transition = 'opacity 0.5s ease';
      
      // フェードアウト完了後に削除
      function removeLoading() {
        loadingScreen.remove();
      }
      setTimeout(removeLoading, 500);
    }

    function showMainSite() {
      mainSite.style.display = 'block';
      
      function fadeInMainSite() {
        mainSite.style.transition = 'opacity 4s ease';
        mainSite.style.opacity = '1';
      }
      setTimeout(fadeInMainSite, 100);
    }

    // 3.8秒後にローディング画面をフェードアウト
    setTimeout(fadeOutLoading, 3800);

    // 3.8秒後にメインサイトを表示
    setTimeout(showMainSite, 3800);
  } else {
    return
  }
});