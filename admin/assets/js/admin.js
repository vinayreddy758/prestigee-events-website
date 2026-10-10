(() => {
  const showToast = (message, ok = true) => {
    const wrap = document.getElementById("toastWrap");
    if (!wrap) return;
    const item = document.createElement("div");
    item.className = `rounded-xl px-4 py-3 text-sm shadow-lg ${ok ? "bg-emerald-500 text-white" : "bg-red-500 text-white"}`;
    item.textContent = message;
    wrap.appendChild(item);
    setTimeout(() => {
      item.remove();
    }, 2800);
  };

  const sidebar = document.getElementById("adminSidebar");
  const sidebarToggle = document.getElementById("sidebarToggle");
  const sidebarBackdrop = document.getElementById("sidebarBackdrop");
  const openSidebar = () => {
    if (!sidebar || !sidebarBackdrop) return;
    sidebar.classList.remove("-translate-x-full");
    sidebarBackdrop.classList.remove("hidden");
  };
  const closeSidebar = () => {
    if (!sidebar || !sidebarBackdrop) return;
    sidebar.classList.add("-translate-x-full");
    sidebarBackdrop.classList.add("hidden");
  };
  sidebarToggle?.addEventListener("click", openSidebar);
  sidebarBackdrop?.addEventListener("click", closeSidebar);

  document.querySelectorAll("[data-open-modal]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const modalId = btn.getAttribute("data-open-modal");
      if (!modalId) return;
      const modal = document.getElementById(modalId);
      if (!modal) return;
      modal.classList.remove("hidden");
      modal.classList.add("flex");

      if (modalId === "serviceModal") {
        document.getElementById("serviceId").value = btn.getAttribute("data-id") || "";
        document.getElementById("serviceTitle").value = btn.getAttribute("data-title") || "";
        document.getElementById("serviceCategory").value = btn.getAttribute("data-category") || "";
      }

      if (modalId === "portfolioModal") {
        document.getElementById("portfolioId").value = btn.getAttribute("data-id") || "";
        document.getElementById("portfolioTitle").value = btn.getAttribute("data-title") || "";
        document.getElementById("portfolioCategory").value = btn.getAttribute("data-category") || "";
        const imageUrl = btn.getAttribute("data-image_url") || "";
        const imagePreview = btn.getAttribute("data-image_preview") || imageUrl;
        document.getElementById("portfolioImageUrl").value = imageUrl;
        const preview = document.getElementById("portfolioPreview");
        if (preview && imagePreview) {
          preview.src = imagePreview;
          preview.classList.remove("hidden");
        } else if (preview) {
          preview.classList.add("hidden");
        }
      }
    });
  });

  document.querySelectorAll("[data-close-modal]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const modal = btn.closest(".fixed.inset-0");
      modal?.classList.add("hidden");
      modal?.classList.remove("flex");
    });
  });

  const serviceForm = document.getElementById("serviceForm");
  serviceForm?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const res = await fetch("api/services.php", { method: "POST", body: new FormData(serviceForm) });
    const data = await res.json();
    showToast(data.message, !!data.ok);
    if (data.ok) window.location.reload();
  });

  document.querySelectorAll("[data-delete-service]").forEach((btn) => {
    btn.addEventListener("click", async () => {
      if (!window.confirm("Delete this service?")) return;
      const body = new URLSearchParams({ id: btn.getAttribute("data-delete-service") || "0" });
      const res = await fetch("api/services.php", { method: "DELETE", body });
      const data = await res.json();
      showToast(data.message, !!data.ok);
      if (data.ok) window.location.reload();
    });
  });

  const portfolioImage = document.getElementById("portfolioImage");
  const portfolioImageUrl = document.getElementById("portfolioImageUrl");
  const portfolioPreview = document.getElementById("portfolioPreview");
  const toAdminPreviewSrc = (url) => {
    const value = (url || "").trim();
    if (value === "") return "";
    if (/^https?:\/\//i.test(value)) return value;
    if (value.startsWith("/assets/") || value.startsWith("/admin/")) return `..${value}`;
    if (value.startsWith("assets/") || value.startsWith("admin/")) return `../${value}`;
    if (value.startsWith("uploads/")) return `../admin/${value}`;
    return value;
  };

  portfolioImageUrl?.addEventListener("input", () => {
    const imageUrl = (portfolioImageUrl.value || "").trim();
    if (!portfolioPreview) return;
    if (imageUrl === "") {
      portfolioPreview.classList.add("hidden");
      portfolioPreview.removeAttribute("src");
      return;
    }
    portfolioPreview.src = toAdminPreviewSrc(imageUrl);
    portfolioPreview.classList.remove("hidden");
  });

  portfolioImage?.addEventListener("change", () => {
    const file = portfolioImage.files?.[0];
    if (!portfolioPreview || !file) return;
    portfolioPreview.src = URL.createObjectURL(file);
    portfolioPreview.classList.remove("hidden");
  });

  const portfolioForm = document.getElementById("portfolioForm");
  portfolioForm?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const res = await fetch("api/portfolio.php", { method: "POST", body: new FormData(portfolioForm) });
    const data = await res.json();
    showToast(data.message, !!data.ok);
    if (data.ok) window.location.reload();
  });

  document.querySelectorAll("[data-delete-portfolio]").forEach((btn) => {
    btn.addEventListener("click", async () => {
      if (!window.confirm("Delete this portfolio item?")) return;
      const body = new URLSearchParams({ id: btn.getAttribute("data-delete-portfolio") || "0" });
      const res = await fetch("api/portfolio.php", { method: "DELETE", body });
      const data = await res.json();
      showToast(data.message, !!data.ok);
      if (data.ok) window.location.reload();
    });
  });

  const aboutForm = document.getElementById("aboutForm");
  aboutForm?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const res = await fetch("api/about.php", { method: "POST", body: new FormData(aboutForm) });
    const data = await res.json();
    showToast(data.message, !!data.ok);
  });

  const settingsForm = document.getElementById("settingsForm");
  settingsForm?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const res = await fetch("api/settings.php", { method: "POST", body: new FormData(settingsForm) });
    const data = await res.json();
    showToast(data.message, !!data.ok);
  });

  document.querySelectorAll("[data-contact-quote]").forEach((btn) => {
    btn.addEventListener("click", async () => {
      const body = new FormData();
      body.append("id", btn.getAttribute("data-contact-quote") || "0");
      const res = await fetch("api/quotes.php", { method: "POST", body });
      const data = await res.json();
      showToast(data.message, !!data.ok);
      if (data.ok) window.location.reload();
    });
  });
})();
