document.getElementById("adoptionForm").addEventListener("submit", function (e) {
    e.preventDefault();
    document.getElementById("successMessage").textContent =
      "Thank you! Your adoption request has been sent!";
    this.reset();
  });
  