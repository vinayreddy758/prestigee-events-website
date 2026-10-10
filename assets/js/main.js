(() => {
  const hasGSAP = typeof window.gsap !== "undefined";
  const hasScrollTrigger = hasGSAP && typeof window.ScrollTrigger !== "undefined";
  let lenisInstance = null;

  if (typeof window.Lenis !== "undefined") {
    document.documentElement.style.scrollBehavior = "auto";
    lenisInstance = new window.Lenis({
      duration: 1.05,
      smoothWheel: true,
      wheelMultiplier: 0.9,
      touchMultiplier: 1.1,
      syncTouch: true,
      syncTouchLerp: 0.08,
    });

    if (hasGSAP) {
      window.gsap.ticker.add((time) => {
        lenisInstance.raf(time * 1000);
      });
      window.gsap.ticker.lagSmoothing(0);
    } else {
      const lenisRaf = (time) => {
        lenisInstance.raf(time);
        requestAnimationFrame(lenisRaf);
      };
      requestAnimationFrame(lenisRaf);
    }

    lenisInstance.on("scroll", ({ scroll }) => {
      if (hasScrollTrigger) {
        window.ScrollTrigger.update();
      }
    });
  }

  if (hasGSAP && hasScrollTrigger) {
    window.gsap.registerPlugin(window.ScrollTrigger);
  }

  const menuBtn = document.getElementById("menuBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  }

  const brandCards = document.querySelectorAll("[data-brand-card]");
  if (brandCards.length > 0) {
    brandCards.forEach((card) => {
      let isAnimating = false;
      let isFlipped = false;

      // Mouse event handler (click to flip)
      card.addEventListener("click", (e) => {
        if (!isAnimating) {
          isAnimating = true;
          if (isFlipped) {
            card.classList.remove("flip");
            isFlipped = false;
          } else {
            card.classList.add("flip");
            isFlipped = true;
          }
          setTimeout(() => {
            isAnimating = false;
          }, 1150);
        }
      });

      // Scroll trigger handler
      if (hasGSAP && hasScrollTrigger) {
        const wrapper = card.closest(".brand-card-wrapper");

        window.ScrollTrigger.create({
          trigger: wrapper,
          start: "center center",
          onEnter: () => {
            // Scrolling down - flip to back
            if (!isAnimating && !isFlipped) {
              isAnimating = true;
              // Add flip class
              card.classList.add("flip");
              isFlipped = true;
              // Unlock animation flag after animation
              setTimeout(() => {
                isAnimating = false;
              }, 1150);
            }
          },
          onLeaveBack: () => {
            // Scrolling up - flip back to front
            if (!isAnimating && isFlipped) {
              isAnimating = true;
              // Remove flip class
              card.classList.remove("flip");
              isFlipped = false;
              // Unlock animation flag after animation
              setTimeout(() => {
                isAnimating = false;
              }, 1150);
            }
          },
        });
      }
    });
  }

  const revealEls = document.querySelectorAll(".reveal");
  if (!hasScrollTrigger && revealEls.length > 0) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("fade-up");
          }
        });
      },
      { threshold: 0.15 }
    );
    revealEls.forEach((el) => io.observe(el));
  }

  const quoteForm = document.getElementById("quoteForm");
  if (quoteForm) {
    const feedback = document.getElementById("quoteFeedback");
    const submitBtn = document.getElementById("quoteSubmit");
    const fields = [...quoteForm.querySelectorAll("input[name], textarea[name]")];

    const clearFieldStyles = () => {
      fields.forEach((field) => {
        field.classList.remove("border-red-400");
      });
    };

    const showFeedback = (message, ok) => {
      if (!feedback) return;
      feedback.textContent = message;
      feedback.classList.remove("hidden", "bg-red-500/15", "text-red-200", "border-red-400/40", "bg-emerald-500/15", "text-emerald-200", "border-emerald-400/40");
      feedback.classList.add(ok ? "bg-emerald-500/15" : "bg-red-500/15");
      feedback.classList.add(ok ? "text-emerald-200" : "text-red-200");
      feedback.classList.add(ok ? "border-emerald-400/40" : "border-red-400/40");
      feedback.classList.add("border");
    };

    quoteForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      clearFieldStyles();

      if (submitBtn) {
        submitBtn.setAttribute("disabled", "disabled");
        submitBtn.classList.add("opacity-70", "cursor-not-allowed");
      }

      try {
        const response = await fetch("quote.php", {
          method: "POST",
          body: new FormData(quoteForm),
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        const payload = await response.json();
        if (!response.ok || !payload.ok) {
          if (payload.errors && Object.keys(payload.errors).length > 0) {
            const errorMessages = Object.entries(payload.errors)
              .map(([, msg]) => msg)
              .join(" • ");
            showFeedback(errorMessages, false);
            Object.entries(payload.errors).forEach(([name]) => {
              const input = quoteForm.querySelector(`[name="${name}"]`);
              if (input) {
                input.classList.add("border-red-400");
              }
            });
          } else {
            showFeedback(payload.message || "Please check your input.", false);
          }
        } else {
          showFeedback(payload.message || "Submitted successfully.", true);
          quoteForm.reset();
        }
      } catch (error) {
        showFeedback("Network issue. Please try again.", false);
      } finally {
        if (submitBtn) {
          submitBtn.removeAttribute("disabled");
          submitBtn.classList.remove("opacity-70", "cursor-not-allowed");
        }
      }
    });
  }

  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    const feedback = document.getElementById("contactFeedback");
    const submitBtn = document.getElementById("contactSubmit");
    const fields = [...contactForm.querySelectorAll("input[name], textarea[name]")];

    const clearFieldStyles = () => {
      fields.forEach((field) => field.classList.remove("border-red-400"));
    };

    const showFeedback = (message, ok) => {
      if (!feedback) return;
      feedback.textContent = message;
      feedback.classList.remove("hidden", "bg-red-500/15", "text-red-200", "border-red-400/40", "bg-emerald-500/15", "text-emerald-200", "border-emerald-400/40");
      feedback.classList.add(ok ? "bg-emerald-500/15" : "bg-red-500/15");
      feedback.classList.add(ok ? "text-emerald-200" : "text-red-200");
      feedback.classList.add(ok ? "border-emerald-400/40" : "border-red-400/40");
      feedback.classList.add("border");
    };

    contactForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      clearFieldStyles();

      if (submitBtn) {
        submitBtn.setAttribute("disabled", "disabled");
        submitBtn.classList.add("opacity-70", "cursor-not-allowed");
      }

      try {
        const response = await fetch("contact.php", {
          method: "POST",
          body: new FormData(contactForm),
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        const payload = await response.json();
        if (!response.ok || !payload.ok) {
          if (payload.errors && Object.keys(payload.errors).length > 0) {
            const errorMessages = Object.entries(payload.errors)
              .map(([, msg]) => msg)
              .join(" • ");
            showFeedback(errorMessages, false);
            Object.entries(payload.errors).forEach(([name]) => {
              const input = contactForm.querySelector(`[name="${name}"]`);
              if (input) {
                input.classList.add("border-red-400");
              }
            });
          } else {
            showFeedback(payload.message || "Please check your input.", false);
          }
        } else {
          showFeedback(payload.message || "Submitted successfully.", true);
          contactForm.reset();
        }
      } catch (error) {
        showFeedback("Network issue. Please try again.", false);
      } finally {
        if (submitBtn) {
          submitBtn.removeAttribute("disabled");
          submitBtn.classList.remove("opacity-70", "cursor-not-allowed");
        }
      }
    });
  }

  const canvas = document.getElementById("heroCanvas");
  const heroScroll = document.getElementById("heroScroll");
  const heroTextContent = document.getElementById("heroTextContent");
  if (canvas && heroScroll) {
    const context = canvas.getContext("2d");
    if (!context) {
      return;
    }

    const siteLoader = document.getElementById("siteLoader");
    const siteLoaderBar = document.getElementById("siteLoaderBar");
    const siteLoaderPercent = document.getElementById("siteLoaderPercent");

    if (siteLoader) {
      document.body.classList.add("overflow-hidden");
    }

    const totalFrames = 64;
    const frameImages = new Array(totalFrames);
    let viewportWidth = window.innerWidth;
    let viewportHeight = window.innerHeight;
    let targetFrameFloat = 0;
    let renderedFrameFloat = 0;

    const frameUrl = (index) =>
      `assets/frames/frame_${String(index).padStart(3, "0")}.webp`;

    const getFrameImage = (zeroBasedIndex) => frameImages[zeroBasedIndex] || null;

    const drawCoverImage = (image, alpha = 1) => {
      if (!image || !image.complete || !image.naturalWidth) {
        return false;
      }

      const ratio = Math.max(
        viewportWidth / image.naturalWidth,
        viewportHeight / image.naturalHeight
      );
      const drawWidth = image.naturalWidth * ratio;
      const drawHeight = image.naturalHeight * ratio;
      const offsetX = (viewportWidth - drawWidth) / 2;
      const offsetY = (viewportHeight - drawHeight) / 2;

      if (alpha < 1) {
        context.save();
        context.globalAlpha = alpha;
        context.drawImage(image, offsetX, offsetY, drawWidth, drawHeight);
        context.restore();
        return true;
      }

      context.drawImage(image, offsetX, offsetY, drawWidth, drawHeight);
      return true;
    };

  const drawFrameInterpolated = (frameFloat) => {
    const baseIndex = Math.floor(frameFloat);
    const nextIndex = Math.min(baseIndex + 1, totalFrames - 1);
    const blend = frameFloat - baseIndex;
    const baseImg = getFrameImage(baseIndex);
    const nextImg = getFrameImage(nextIndex);

    context.clearRect(0, 0, viewportWidth, viewportHeight);

    const baseDrawn = drawCoverImage(baseImg, 1);
    if (!baseDrawn && nextImg) {
      drawCoverImage(nextImg, 1);
      return;
    }
    if (nextImg && blend > 0.001) {
      drawCoverImage(nextImg, blend);
    }
  };

    const drawFrame = (index) => {
      const image = frameImages[index - 1];
      context.clearRect(0, 0, viewportWidth, viewportHeight);
      drawCoverImage(image, 1);
    };

    const resizeCanvas = () => {
      viewportWidth = window.innerWidth;
      viewportHeight = window.innerHeight;
      const dpr = Math.min(window.devicePixelRatio || 1, 2);

    canvas.width = Math.floor(viewportWidth * dpr);
    canvas.height = Math.floor(viewportHeight * dpr);
      canvas.style.width = `${viewportWidth}px`;
      canvas.style.height = `${viewportHeight}px`;
      context.setTransform(dpr, 0, 0, dpr, 0, 0);
      drawFrameInterpolated(renderedFrameFloat);
    };

    const updateLoaderProgress = (loadedCount) => {
      const percent = Math.min(100, Math.round((loadedCount / totalFrames) * 100));
      if (siteLoaderBar) {
        siteLoaderBar.style.width = `${percent}%`;
      }
      if (siteLoaderPercent) {
        siteLoaderPercent.textContent = `${percent}%`;
      }
    };

    const loadFrame = (index) =>
      new Promise((resolve) => {
        const arrIndex = index - 1;
        if (frameImages[arrIndex]) {
          resolve();
          return;
        }
        const img = new Image();
        img.decoding = "async";
        img.onload = () => {
          if (index === 1) {
            drawFrame(1);
          }
          resolve();
        };
        img.onerror = () => {
          resolve();
        };
        img.src = frameUrl(index);
        frameImages[arrIndex] = img;
      });

    const preloadAllFrames = async () => {
      let loadedCount = 0;
      updateLoaderProgress(0);
      const loaders = [];
      for (let i = 1; i <= totalFrames; i += 1) {
        loaders.push(
          loadFrame(i).then(() => {
            loadedCount += 1;
            updateLoaderProgress(loadedCount);
          })
        );
      }
      await Promise.all(loaders);
    };

    const handleScroll = () => {
      const rect = heroScroll.getBoundingClientRect();
      const totalScrollable = Math.max(heroScroll.offsetHeight - window.innerHeight, 1);
      const scrolled = Math.min(Math.max(-rect.top, 0), totalScrollable);
      const progress = scrolled / totalScrollable;
      targetFrameFloat = progress * (totalFrames - 1);

      if (heroTextContent) {
        const fadeStart = 0.4;
        const fadeEnd = 0.66;
        let opacity = 1;
        if (progress > fadeStart) {
          const fadeProgress = Math.min((progress - fadeStart) / (fadeEnd - fadeStart), 1);
          opacity = 1 - fadeProgress;
        }
        heroTextContent.style.opacity = String(opacity);
        heroTextContent.style.transform = `translate3d(0, ${(1 - opacity) * 18}px, 0)`;
        heroTextContent.style.pointerEvents = opacity < 0.05 ? "none" : "auto";
      }
    };

    const animationLoop = () => {
      const delta = targetFrameFloat - renderedFrameFloat;
      if (Math.abs(delta) > 0.001) {
        renderedFrameFloat += delta * 0.12;
        if (Math.abs(delta) < 0.01) {
          renderedFrameFloat = targetFrameFloat;
        }
        drawFrameInterpolated(renderedFrameFloat);
      }
      requestAnimationFrame(animationLoop);
    };

    const hideLoader = () => {
      if (!siteLoader) {
        if (hasScrollTrigger) {
          window.requestAnimationFrame(() => window.ScrollTrigger.refresh());
        }
        return;
      }
      siteLoader.classList.add("transition-opacity", "duration-700", "opacity-0", "pointer-events-none");
      window.setTimeout(() => {
        siteLoader.remove();
        if (hasScrollTrigger) {
          window.requestAnimationFrame(() => window.ScrollTrigger.refresh());
        }
      }, 760);
      document.body.classList.remove("overflow-hidden");
      if (hasScrollTrigger) {
        window.requestAnimationFrame(() => window.ScrollTrigger.refresh());
      }
    };

    const bootHero = async () => {
      resizeCanvas();
      await preloadAllFrames();
      window.addEventListener("resize", () => {
        resizeCanvas();
        handleScroll();
      });
      window.addEventListener("scroll", handleScroll, { passive: true });
      handleScroll();
      drawFrame(1);
      requestAnimationFrame(animationLoop);
      hideLoader();
    };

    bootHero();
  }

  if (hasGSAP && hasScrollTrigger) {
    const sections = document.querySelectorAll("[data-stagger-section]");
    sections.forEach((section) => {
      const animTargets = section.querySelectorAll(".reveal, [data-card-reveal]");
      if (animTargets.length === 0) {
        return;
      }
      window.gsap.fromTo(animTargets, {
        opacity: 0,
        y: 28,
      }, {
        opacity: 1,
        y: 0,
        duration: 0.95,
        ease: "power3.out",
        stagger: 0.12,
        immediateRender: false,
        scrollTrigger: {
          trigger: section,
          start: "top 88%",
          once: true,
        },
      });
    });

    document.querySelectorAll("[data-scroll-scale]").forEach((item) => {
      const img = item.querySelector("[data-scroll-image]") || item.querySelector("img");
      if (!img) {
        return;
      }
      window.gsap.fromTo(
        img,
        { scale: 1.08 },
        {
          scale: 1,
          ease: "none",
          scrollTrigger: {
            trigger: item,
            start: "top bottom",
            end: "bottom top",
            scrub: 0.9,
          },
        }
      );
    });

    document.querySelectorAll(".mask-reveal .mask-line").forEach((line) => {
      window.gsap.fromTo(
        line,
        { yPercent: 110, opacity: 0 },
        {
          yPercent: 0,
          opacity: 1,
          duration: 0.9,
          ease: "power3.out",
          immediateRender: false,
          scrollTrigger: {
            trigger: line.closest(".mask-reveal"),
            start: "top 88%",
            once: true,
          },
        }
      );
    });

    window.ScrollTrigger.refresh();
  }
})();
