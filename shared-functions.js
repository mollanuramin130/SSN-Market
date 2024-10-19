// shared-functions.js

// Function to create a clickable banner
function createBanner(data = {}, className = "") {
  const anchor = document.createElement("a");
  anchor.href = data.link || "#";
  // anchor.target = "_blank"; // Remove or comment this line to open in the same window

  const banner = document.createElement("div");
  banner.className = className;
  banner.style.backgroundImage = `url(${data.image})`;
  banner.style.backgroundSize = "cover";
  banner.style.width = "80px";
  banner.style.height = "105px";

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

// Function to initialize category slider
function initCategorySlider(uniqueId, data) {
  const categorySliderId = `${uniqueId}-categories-slider`;
  renderOffersAndCategories(data, categorySliderId, "category-banner");
}
