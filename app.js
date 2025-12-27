const app = document.getElementById("app");

/**
 * Загружает HTML-файл и вставляет в #app
 */
async function loadPage(page) {
  try {
    const res = await fetch(page);
    const html = await res.text();
    app.innerHTML = html;

    // прокрутка вверх
    window.scrollTo(0, 0);

    // перехват ссылок после загрузки
    hookLinks();
  } catch (e) {
    app.innerHTML = "<h2>Ошибка загрузки страницы</h2>";
  }
}

/**
 * Перехватываем клики по ссылкам
 */
function hookLinks() {
  document.querySelectorAll("a[href]").forEach(link => {
    const href = link.getAttribute("href");

    // нас интересуют ТОЛЬКО product*.html и index.html
    if (
      href &&
      (href.startsWith("product") || href === "index.html")
    ) {
      link.addEventListener("click", e => {
        e.preventDefault();

        if (href === "index.html") {
          history.pushState({}, "", "/");
          loadPage("index.html");
        } else {
          history.pushState({}, "", `#${href}`);
          loadPage(href);
        }
      });
    }
  });
}

/**
 * Назад / вперёд в браузере
 */
window.addEventListener("popstate", () => {
  const hash = location.hash.replace("#", "");
  if (hash) {
    loadPage(hash);
  } else {
    loadPage("index.html");
  }
});

/**
 * ПЕРВЫЙ ЗАПУСК
 */
if (location.hash) {
  loadPage(location.hash.replace("#", ""));
} else {
  loadPage("index.html");
}
