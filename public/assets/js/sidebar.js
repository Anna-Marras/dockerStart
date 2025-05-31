document.addEventListener('DOMContentLoaded', () => {
  const btn  = document.getElementById('sidebarToggle');
  const side = document.getElementById('sidebar');
  if (!btn || !side) return;

  btn.addEventListener('click', () => {
    side.classList.toggle('-translate-x-full');
    btn.querySelector('svg').classList.toggle('rotate-180');
  });
});