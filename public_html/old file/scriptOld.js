const categories = [
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029845/PC_Creative%20refresh/3D_bau/banners_new/Burger.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029856/PC_Creative%20refresh/3D_bau/banners_new/Pizza.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1675667625/PC_Creative%20refresh/Biryani_2.png",
    link: "product-category.php?id=16&type=mid-category",
  },
  {
    image:
      "image/nur.png",
    link: "login.php",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029845/PC_Creative%20refresh/3D_bau/banners_new/Burger.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029856/PC_Creative%20refresh/3D_bau/banners_new/Pizza.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1675667625/PC_Creative%20refresh/Biryani_2.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "image/nur.png",
    link: "login.php",
  },{
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029845/PC_Creative%20refresh/3D_bau/banners_new/Burger.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029856/PC_Creative%20refresh/3D_bau/banners_new/Pizza.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1675667625/PC_Creative%20refresh/Biryani_2.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "image/nur.png",
    link: "login.php",
  },{
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029845/PC_Creative%20refresh/3D_bau/banners_new/Burger.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029856/PC_Creative%20refresh/3D_bau/banners_new/Pizza.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1675667625/PC_Creative%20refresh/Biryani_2.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "image/nur.png",
    link: "login.php",
  },{
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029845/PC_Creative%20refresh/3D_bau/banners_new/Burger.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1674029856/PC_Creative%20refresh/3D_bau/banners_new/Pizza.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_288,h_360/v1675667625/PC_Creative%20refresh/Biryani_2.png",
    link: "https://ssnmarket.com/",
  },
  {
    image:
      "image/nur.png",
    link: "login.php",
  },
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
  banner.style.width = "120px"; // Optional: adjust size if needed
  banner.style.height = "150px"; // Optional: adjust size if needed

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
