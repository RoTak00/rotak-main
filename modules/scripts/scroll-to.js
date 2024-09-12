document.addEventListener("DOMContentLoaded", function () {
  // Get all <a> elements with a "data-to" attribute
  const links = document.querySelectorAll("a[data-to]");

  // Add a click event listener to each link
  links.forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // Prevent the default link behavior

      // Get the target ID from the "data-to" attribute
      const targetId = link.getAttribute("data-to");

      // Find the target element by its ID
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        // Scroll to the target element
        targetElement.scrollIntoView({ behavior: "smooth" });
      }
    });
  });

  const sections = document.querySelectorAll("section");
  console.log(sections);
  const content = document.querySelector(".content");

  content.addEventListener("scroll", function (event) {
    let closest_to_top = sections[0];

    Array.from(sections).forEach((el) => {
      if (el.getBoundingClientRect().top < 0) closest_to_top = el;
      else if (
        el.getBoundingClientRect().top < 100 &&
        closest_to_top.getBoundingClientRect().top < 0
      )
        closest_to_top = el;
    });

    // if the div is scroleld to the bottom

    if (
      content.scrollTop + content.offsetHeight - content.scrollHeight >=
      -10
    ) {
      closest_to_top = sections[sections.length - 1];
    }

    let which_section = closest_to_top.getAttribute("id");

    let nav_links = document.querySelectorAll("nav .nav-links a");
    nav_links.forEach((el) => {
      if (el.getAttribute("data-to") == which_section) {
        el.classList.add("selected");
      } else {
        el.classList.remove("selected");
      }
    });
  });
});
