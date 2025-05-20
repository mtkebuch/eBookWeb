document.addEventListener("DOMContentLoaded", function () {
  const messageOverlay = document.querySelector(".message-overlay");
  if (messageOverlay) {
    setTimeout(() => {
      messageOverlay.classList.add("fade-out");
      setTimeout(() => messageOverlay.remove(), 300);
    }, 500);
  }

  document.querySelectorAll(".edit-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const form = document.getElementById("table-actions-form");
      const selected = form.querySelector("input[name='id']:checked");
      const table = form.querySelector("input[name='table']").value;

      if (!selected) return alert("Select a row to edit.");

      fetch(`crud/edit.php?table=${encodeURIComponent(table)}&id=${encodeURIComponent(selected.value)}`)
        .then((res) => res.text())
        .then((html) => {
          const container = document.getElementById("edit-form-container");
          container.innerHTML = html;
          container.scrollIntoView({ behavior: "smooth" });
        })
        .catch(() => alert("Error loading edit form."));
    });
  });
});
