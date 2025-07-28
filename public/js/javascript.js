const logoutBtn = document.getElementById("btn-logout");

logoutBtn?.addEventListener("click", logout);

async function logout() {
  if (confirm("Do you really want to logout?")) {
    try {
      const data = await fetch("/logout", { method: "POST" });

      window.location.href = data?.url;
    } catch (error) {
      console.log(error);
    }
  }
}
