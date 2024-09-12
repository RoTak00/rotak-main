document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("project-filter-input");

  searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.toLowerCase();

    const searchElements = searchTerm.split(" ").map((word) => word.trim());

    const projects = document.querySelectorAll(".project");

    if (searchElements.some((word) => word.length)) {
      document
        .querySelector("#projects-volunteering-title")
        .classList.add("title-hidden");
    } else {
      document
        .querySelector("#projects-volunteering-title")
        .classList.remove("title-hidden");
    }

    let existsAtLeastOneProject = false;

    projects.forEach((project) => {
      const title = project.querySelector("h3").textContent.toLowerCase();
      const tags = Array.from(project.querySelectorAll(".tags span"))
        .map((tag) => tag.textContent.toLowerCase())
        .join(" ");

      let allowDisplay = false;

      if (searchElements.length === 0) {
        allowDisplay = true;
        existsAtLeastOneProject = true;
      }
      if (searchElements.length > 0) {
        searchElements.forEach((word) => {
          if (title.includes(word) || tags.includes(word)) {
            allowDisplay = true;
            existsAtLeastOneProject = true;
          }
        });
      }

      allowDisplay
        ? project.classList.remove("project-hidden")
        : project.classList.add("project-hidden");
    });

    let errorDiv = document.querySelector("#projects-error");

    if (!existsAtLeastOneProject) {
      errorDiv.classList.add("title-visible");
    } else errorDiv.classList.remove("title-visible");
  });
});
