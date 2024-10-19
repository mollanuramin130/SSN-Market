const categories = [
    {
    image:
      "image/Samosas.avif",
    link: "product-category.php?id=58&type=mid-category",
  },
  {
    image:
      "image/rolls.avif",
    link: "product-category.php?id=14&type=mid-category",
  },
  {
    image:
      "image/chinese.avif",
    link: "product-category.php?id=13&type=mid-category",
  },
  {
    image:
      "image/biryani.avif",
    link: "product-category.php?id=16&type=mid-category",
  },
  {
    image:
      "image/momos.avif",
    link: "product-category.php?id=19&type=mid-category",
  },
  {
    image:
      "image/burger.avif",
    link: "product-category.php?id=15&type=mid-category",
  },
  {
    image:
      "image/pakoda.avif",
    link: "product-category.php?id=18&type=mid-category",
  },
  {
    image:
      "image/shake.avif",
    link: "product-category.php?id=106&type=end-category",
  },
  {
    image:
      "image/rasgulla.avif",
    link: "product-category.php?id=129&type=end-category",
  },
  {
    image:
      "image/gulab-jamun.avif",
    link: "product-category.php?id=129&type=end-category",
  },
  {
    image:
      "image/rasmalai.avif",
    link: "product-category.php?id=67&type=mid-category",
  },
  {
    image:
      "image/pastry.avif",
    link: "product-category.php?id=130&type=end-category",
  },
  {
    image:
      "image/Cakes.avif",
    link: "product-category.php?id=130&type=end-category",
  },
  {
    image:
      "image/Desserts_2.avif",
    link: "product-category.php?id=130&type=end-category",
  },
  /*{
    image:
      "image/ice-cream.avif",
    link: "product-category.php?id=16&type=mid-category",
  },
  {
    image:
      "image/sandwich.avif",
    link: "product-category.php?id=103&type=end-category",
  },
  {
    image:
      "image/salad.avif",
    link: "product-category.php?id=16&type=mid-category",
  },
  {
    image:
      "image/poori.avif",
    link: "product-category.php?id=16&type=mid-category",
  },
  {
    image:
      "image/Pasta2.avif",
    link: "product-category.php?id=16&type=mid-category",
  },
  {
    image:
      "image/Pav_Bhaji.avif",
    link: "product-category.php?id=16&type=mid-category",
  },
  */
  {
    image:
      "image/Parata.avif",
    link: "product-category.php?id=131&type=end-category",
  },
  {
    image:
      "image/kebabs.avif",
    link: "product.php?id=107",
  },
  /*
  {
    image:
      "image/omelatte.avif",
    link: "product-category.php?id=16&type=mid-category",
  },
  */
  
  // Add more categories in the same format...
];

const offers = []; // Assuming you may add offers later

// Function to create a clickable banner
function createBanner(data = {}, className = "") {
  // Create anchor (link) element
  const anchor = document.createElement("a");
  anchor.href = data.link || "#"; // Use "#" if no link is provided
  anchor.target = ""; // Optional: opens the link in a new tab

  // Create div for the banner
  const banner = document.createElement("div");
  banner.className = className;
  banner.style.backgroundImage = `url(${data.image})`;
  banner.style.backgroundSize = "cover"; // Make sure the image covers the div
  banner.style.width = "80px"; // Optional: adjust size if needed
  banner.style.height = "105px"; // Optional: adjust size if needed

  // Append the banner to the anchor (link)
  anchor.appendChild(banner);

  return anchor;
}

// Function to render banners for offers and categories
function renderOffersAndCategories(data = [], targetId = "", cardType = "") {
  const container = document.getElementById(targetId);
  if (container && data.length > 0) {
    data.forEach((item) => {
      const banner = createBanner(item, cardType);
      container.appendChild(banner);
    });
  }
}


// Rendering the categories slider
renderOffersAndCategories(categories, "categories-slider", "category-banner");

// Optional: Rendering offers (if any)
// renderOffersAndCategories(offers, "offers-slider", "offer-banner");
