const products = {
  1: {
    title: "Бокс для малыша",
    img: "бокс.jpg",
    desc: "Красивый подарочный бокс для новорождённого"
  },
  2: {
    title: "Пелёнка",
    img: "пеленка.jpg",
    desc: "Мягкая муслиновая пелёнка"
  }
};

const catalog = document.getElementById("catalog");
const product = document.getElementById("product");

document.querySelectorAll(".product-card").forEach(card => {
  card.addEventListener("click", () => {
    const id = card.dataset.id;
    const p = products[id];

    document.getElementById("product-title").textContent = p.title;
    document.getElementById("product-img").src = p.img;
    document.getElementById("product-desc").textContent = p.desc;

    catalog.style.display = "none";
    product.style.display = "block";
  });
});

document.getElementById("back").onclick = () => {
  product.style.display = "none";
  catalog.style.display = "block";
};
