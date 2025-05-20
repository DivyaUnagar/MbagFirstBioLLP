(function ($) {
  window["cozyBlockPortfolioGalleryInit"] = (e) => {
    const n = e.replace(/-/gi, "_");
    const blockOptions = window[`cozyPortfolioGallery_${n}`];
    const portfolioClass = `#cozyBlock_${n}`;
    const cozyPortfolio = document.querySelector(portfolioClass);

    const sliderAttr = {
      init: true,
      loop: blockOptions.sliderOptions.loop,
      autoplay: { ...blockOptions.sliderOptions.autoplay },
      speed: blockOptions.sliderOptions.speed,
      centeredSlides: blockOptions.sliderOptions.centeredSlides,
      slidesPerView: blockOptions.sliderOptions.slidesPerView,
      spaceBetween: blockOptions.sliderOptions.spaceBetween,
      navigation: {
        nextEl: `${portfolioClass} .swiper-button-next.cozy-block-button-next`,
        prevEl: `${portfolioClass} .swiper-button-prev.cozy-block-button-prev`,
      },
      pagination: {
        clickable: true,
        el: `${portfolioClass} .swiper-pagination`,
      },
      breakpoints: {
        100: {
          slidesPerView: 1,
        },
        767: {
          slidesPerView:
            blockOptions.sliderOptions.slidesPerView <= 2
              ? blockOptions.sliderOptions.slidesPerView
              : 2,
        },
        1024: {
          slidesPerView:
            blockOptions.sliderOptions.slidesPerView <= 3
              ? blockOptions.sliderOptions.slidesPerView
              : 3,
        },
        1180: {
          slidesPerView: blockOptions.sliderOptions.slidesPerView,
        },
      },
    };

    if (blockOptions.sliderOptions.autoplay.status) {
      sliderAttr.autoplay = { ...blockOptions.sliderOptions.autoplay };
    } else {
      delete sliderAttr.autoplay;
    }

    let portfolioSlider = {};

    if (blockOptions.layout === "carousel") {
      portfolioSlider = new Swiper(
        portfolioClass +
          ".layout-carousel.cozy-portfolio-gallery__swiper-container",
        sliderAttr
      );
    }

    const loaderButton = cozyPortfolio.querySelector(".cozy-dynamic-loader");

    const isotopeFilter = cozyPortfolio.querySelectorAll(
      ".cozy-isotope-filter__label"
    );

    isotopeFilter.forEach((label) => {
      label.addEventListener("click", function () {
        // Remove 'active' class from all labels
        isotopeFilter.forEach((l) => {
          l.classList.remove("active");
        });

        // Add 'active' class to the clicked label
        this.classList.add("active");

        const termID = label.getAttribute("data-term-id");
        hideLoaderButton(termID);

        let newTemplates = [];
        const originalItems = [...blockOptions.portfolioTemplates];

        const portfolioCollection =
          cozyPortfolio.querySelectorAll(".cozy-portfolio");

        portfolioCollection.forEach((el) => {
          $(el).fadeOut(600, function () {});
          $(el).animate(
            {
              height: 0,
              width: 0,
              opacity: 0,
            },
            500
          );
          setTimeout(() => {
            $(el).remove();
          }, 500);
        });

        if (termID !== "") {
          // Apply filtering logic to original items
          newTemplates = originalItems.filter((obj) => {
            if (Array.isArray(obj?.post_custom_category)) {
              return obj.post_custom_category.some(
                (category) => category.term_id === parseInt(termID)
              );
            } else {
              return false;
            }
          });
          createPortfolioTemplateDOM(
            newTemplates.slice(
              0,
              parseInt(blockOptions.perPage) === -1
                ? newTemplates.length
                : blockOptions.perPage
            )
          );
        } else {
          createPortfolioTemplateDOM(
            originalItems.slice(
              0,
              parseInt(blockOptions.perPage) === -1
                ? originalItems.length
                : blockOptions.perPage
            )
          );
        }
      });
    });

    if (blockOptions.source === "template") {
      if (parseInt(blockOptions.perPage) === -1) {
        createPortfolioTemplateDOM(blockOptions.portfolioTemplates);
      } else {
        createPortfolioTemplateDOM(
          blockOptions.portfolioTemplates.slice(0, blockOptions.perPage)
        );
      }
    }

    function stripTags(html) {
      var doc = new DOMParser().parseFromString(html, "text/html");
      return doc.body.textContent || "";
    }

    function stripShortcodes(content) {
      return content.replace(/\[.*?\]/g, ""); // This removes any shortcodes enclosed in square brackets.
    }

    function createExcerpt(text, maxLength = 40) {
      // Strip HTML tags and shortcodes
      text = stripTags(stripShortcodes(text));

      // Split the text into words
      var words = text.split(" ");

      // Truncate to the specified length
      if (words.length > maxLength) {
        text = words.slice(0, maxLength).join(" ") + "...";
      } else {
        text = words.join(" ");
      }

      return text;
    }

    function createPortfolioTemplateDOM(templates) {
      switch (blockOptions.orderBy) {
        case "dateDESC":
          templates = templates.sort(compareDatesDesc);
          break;

        case "dateASC":
          templates = templates.sort(compareDatesAsc);
          break;

        case "titleASC":
          templates = templates.sort(compareTitlesASC);
          break;

        case "titleDESC":
          templates = templates.sort(compareTitlesDesc);
          break;

        default:
          break;
      }

      templates.forEach((template) => {
        const wrapperDiv = document.createElement("div");
        wrapperDiv.className = "cozy-portfolio post-ID__" + template.ID;
        wrapperDiv.setAttribute("data-post-id", template.ID);

        if (template.post_custom_category.length > 0) {
          template.post_custom_category.map((obj) => {
            return wrapperDiv.classList.add("taxonomy__term-id-" + obj.term_id);
          });
        }
        if (blockOptions.layout === "carousel") {
          wrapperDiv.classList.add("swiper-slide");
        }
        const postContent = createExcerpt(
          template.post_content,
          blockOptions.enableOptions.excerpt
        );
        wrapperDiv.innerHTML = `
            ${
              blockOptions.featuredImage.position === "before" &&
              template.featured_image
                ? `
                  <div class="cozy-portfolio-gallery__featured-image-wrapper">
                    <div class='cozy-portfolio-gallery__image-overlay'></div>
                    <img
                      class="cozy-portfolio-gallery__featured-image"
                      src='${template.featured_image}'
                      alt='${template.post_title}'
                    />
                  </div>
                `
                : ""
            }
            
            ${
              blockOptions.layoutType !== "default"
                ? '<div class="cozy-portfolio-gallery__title-cat-wrapper">'
                : ""
            }
            ${
              blockOptions.layoutType !== "gallery" &&
              blockOptions.enableOptions.title
                ? `<h2 class="cozy-portfolio-gallery__title">
              ${template.post_title}
            </h2>`
                : ""
            }
          
            ${
              blockOptions.layoutType === "overlay" &&
              blockOptions.enableOptions.content &&
              postContent
                ? `
                  <div>
                    ${postContent}
                  </div>`
                : ""
            }
    
             ${
               blockOptions.layoutType === "overlay" &&
               blockOptions.enableOptions.button
                 ? `
                  <span class="cozy-block-portfolio-gallery__read-more">
                    Read More
                  </span>`
                 : ""
             }
    
           ${
             blockOptions.layoutType === "gallery" &&
             blockOptions.enableOptions.icon
               ? `<i class="cozy-overlay-icon-wrapper">
              <svg class='cozy-portfolio-icon__overlay' 
              width="${blockOptions.galleryOptions.iconSize}"
              height="${blockOptions.galleryOptions.iconSize}"
              viewBox="${blockOptions.galleryOptions.iconViewBox.vx} ${blockOptions.galleryOptions.iconViewBox.vy} ${blockOptions.galleryOptions.iconViewBox.vw} ${blockOptions.galleryOptions.iconViewBox.vh}"
              fill="${blockOptions.galleryOptions.iconColor}"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
                <path d="${blockOptions.galleryOptions.iconPath}"/>
              </svg>
            </i>`
               : ""
           }
            ${blockOptions.layoutType !== "default" ? "</div>" : ""}
    
          
            ${
              blockOptions.featuredImage.position === "after" &&
              template.featured_image
                ? `
                  <div class="cozy-portfolio-gallery__featured-image-wrapper">
                    <div class='cozy-portfolio-gallery__image-overlay'></div>
                    <img
                      class="cozy-portfolio-gallery__featured-image"
                      src='${template.featured_image}'
                      alt='${template.post_title}'
                    />
                  </div>
                `
                : ""
            }
          
          `;

        const layoutWrapper = cozyPortfolio.querySelector(
          ".cozy-layout-" + blockOptions.layout
        );

        if (layoutWrapper) {
          // Append the wrapperDiv to layoutWrapper and then fadeIn
          $(layoutWrapper).append(wrapperDiv).children(":last").fadeIn("slow");
        }
      });
    }

    // Function to compare two dates in ascending order
    function compareDatesAsc(a, b) {
      const dateA = new Date(a.post_date_gmt);
      const dateB = new Date(b.post_date_gmt);
      return dateA - dateB;
    }

    // Function to compare two dates in descending order
    function compareDatesDesc(a, b) {
      const dateA = new Date(a.post_date_gmt);
      const dateB = new Date(b.post_date_gmt);
      return dateB - dateA;
    }

    // Function to compare post_title alphabetically in descending order
    function compareTitlesDesc(a, b) {
      const titleA = a.post_title.toLowerCase();
      const titleB = b.post_title.toLowerCase();
      if (titleA > titleB) {
        return -1;
      }
      if (titleA < titleB) {
        return 1;
      }
      return 0;
    }

    // Function to compare post_title alphabetically in ascending order
    function compareTitlesASC(a, b) {
      const titleA = a.post_title.toLowerCase();
      const titleB = b.post_title.toLowerCase();
      if (titleA < titleB) {
        return -1;
      }
      if (titleA > titleB) {
        return 1;
      }
      return 0;
    }

    // Search Query
    $("#cozy-isotope-filter__search-bar").keyup(function () {
      const searchValue = $(this).val().toLowerCase();
      const originalItems = [...blockOptions.portfolioTemplates];

      originalItems.filter(function (template) {
        if (!template.post_title.toLowerCase().includes(searchValue)) {
          $(blockID + ` [data-post-id="${template.ID}"]`).hide();
        } else {
          $(blockID + ` [data-post-id="${template.ID}"]`).show();
        }
      });
    });

    // Returns slicing portfolio collection with existing content.
    function generatePortfolioTemplates() {
      const portfolioCollection = cozyPortfolio.querySelectorAll(
        ":not(.layout-carousel) .cozy-portfolio"
      );

      const visibleIDS = Array.from(portfolioCollection).map((item) => {
        return item.getAttribute("data-post-id");
      });

      if (
        blockOptions.layout === "grid" &&
        !blockOptions.gridOptions.isotopeFilter
      ) {
        const newTemplates = blockOptions.portfolioTemplates.filter((obj) => {
          return visibleIDS.every((id) => parseInt(id) !== obj.ID);
        });
        return newTemplates;
      }

      if (
        blockOptions.layout === "grid" &&
        blockOptions.gridOptions.isotopeFilter
      ) {
        const activeIsotopeLabel = cozyPortfolio.querySelector(
          ".cozy-isotope-filter__label.active"
        );

        const termID = activeIsotopeLabel.getAttribute("data-term-id");
        let newTemplates = [];
        const originalItems = [...blockOptions.portfolioTemplates];

        const portfolioCollection = cozyPortfolio.querySelectorAll(
          ":not(.layout-carousel) .cozy-portfolio"
        );

        const visibleIDS = Array.from(portfolioCollection).map((item) => {
          return item.getAttribute("data-post-id");
        });

        if (termID !== "") {
          newTemplates = originalItems.filter((obj) => {
            if (Array.isArray(obj?.post_custom_category)) {
              return (
                visibleIDS.every((id) => parseInt(id) !== obj.ID) &&
                obj.post_custom_category.some(
                  (category) => category.term_id === parseInt(termID)
                )
              );
            } else {
              return false;
            }
          });
        } else {
          newTemplates = originalItems.filter((obj) => {
            return visibleIDS.every((id) => parseInt(id) !== obj.ID);
          });
        }
        return newTemplates;
      }
    }

    if (loaderButton) {
      if (blockOptions.source === "template") {
        hideLoaderButton();

        loaderButton.addEventListener("click", function () {
          const newTemplates = generatePortfolioTemplates();
          createPortfolioTemplateDOM(
            newTemplates.slice(0, blockOptions.ajaxButton.contentLoad)
          );

          hideLoaderButton();
        });
      }
    }

    function hideLoaderButton(termID = null) {
      $(loaderButton).show();
      const nextShow = generatePortfolioTemplates();

      if (
        blockOptions.layout === "grid" &&
        blockOptions.gridOptions.isotopeFilter &&
        termID
      ) {
        let originalTax = [];
        let taxCount = 0;
        if (typeof blockOptions.portfolioTax === "object") {
          originalTax = { ...blockOptions.portfolioTax };
          taxCount = Object.values(originalTax)
            .filter((tax) => tax.term_id === parseInt(termID))
            .map((item) => item.count)[0];
        } else {
          originalTax = [...blockOptions.portfolioTax];
          taxCount = originalTax
            .filter((tax) => tax.term_id === parseInt(termID))
            .map((item) => item.count)[0];
        }

        if (taxCount === 1) {
          $(loaderButton).hide();
        }
        return;
      }

      if (nextShow.length <= 0) {
        $(loaderButton).hide();
      }
    }

    // Popup View
    const cozyPopup = cozyPortfolio.querySelector(".cozy-portfolio-popup");

    const galleryContainer = cozyPortfolio.querySelector(
      ".cozy-gallery__swiper-container"
    );
    let gallerySlider = {};
    //Add cozy-overlay-wrapper only if it does not exists
    const ancestorDiv = document.querySelector(".wp-site-blocks");
    const hasChildDiv = document.querySelector(
      ".wp-site-blocks > .cozy-overlay-wrapper"
    );
    const body = document.querySelector("body");
    if (hasChildDiv === null) {
      const overlayWrapper = document.createElement("div");
      overlayWrapper.className = "cozy-overlay-wrapper visibility-none";
      ancestorDiv.appendChild(overlayWrapper);
    }
    const cozyOverlay = document.querySelector(".cozy-overlay-wrapper");
    cozyPortfolio.addEventListener("click", function (event) {
      const popup = event.target.closest(
        ".cozy-block-portfolio-gallery.has-popup-view .cozy-portfolio"
      );
      if (popup) {
        const ID = popup.getAttribute("data-post-id");
        const template = blockOptions.portfolioTemplates.filter(
          (obj) => obj.ID === parseInt(ID)
        );

        if (
          !blockOptions.linkURL ||
          template[0].post_url.length <= 0 ||
          template[0].post_url === "#"
        ) {
          generatePopupView(template[0]);

          $(cozyPopup).removeClass("hide-popup");
          $(cozyPopup).addClass("show-popup");

          // Show cozy overlay wrapper
          cozyOverlay.style.backgroundColor = blockOptions.popup.overlayWrapper;
          cozyOverlay.classList.remove("visibility-none");
          body.classList.add("overflow-hidden");
          if (portfolioSlider && blockOptions.layout === "carousel") {
            portfolioSlider.autoplay.stop();
          }
        }
      }

      const galleryItem = event.target.closest(
        ".cozy-block-portfolio-gallery.layout-type-gallery > .cozy-layout-wrapper > .cozy-portfolio"
      );

      if (galleryContainer && galleryItem && blockOptions.layout === "grid") {
        galleryContainer.classList.remove("hide-cozy-gallery");
        const galleryCloseIcon = `<svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"></path></svg>`;

        // Create a div or any container element to hold the SVG
        const svgContainer = document.createElement("div");
        svgContainer.classList =
          "cozy-block-portfolio-gallery__gallery-close-icon-wrapper";
        svgContainer.innerHTML = galleryCloseIcon;

        // Append the SVG container to the current galleryContainer
        galleryContainer.appendChild(svgContainer);

        const activeIsotopeLabel = cozyPortfolio.querySelector(
          ".cozy-isotope-filter__label.active"
        );

        $(
          portfolioClass +
            " .cozy-block-portfolio-gallery__gallery-close-icon-wrapper"
        ).click(function () {
          galleryContainer.classList.add("hide-cozy-gallery");
          body.classList.remove("overflow-hidden");
          cozyOverlay.classList.add("visibility-none");
          cozyOverlay.style.backgroundColor = "#c3c3c3";
        });

        let termID = null;

        if (activeIsotopeLabel) {
          termID = activeIsotopeLabel.getAttribute("data-term-id");
        }

        let newTemplates = [];
        const originalItems = [...blockOptions.portfolioTemplates];

        if (termID && termID !== "") {
          // Apply filtering logic to original items
          newTemplates = originalItems.filter((obj) => {
            if (Array.isArray(obj?.post_custom_category)) {
              return obj.post_custom_category.some(
                (category) => category.term_id === parseInt(termID)
              );
            } else {
              return false;
            }
          });

          // Find the index of the object with the desired ID
          const activeIndex = newTemplates.findIndex(
            (obj) => obj.ID === parseInt($(galleryItem).attr("data-post-id"))
          );

          if (activeIndex !== -1) {
            // Remove the object from its current position
            const [movedObj] = newTemplates.splice(activeIndex, 1);

            // Add the object at the beginning of the newTemplates
            newTemplates.unshift(movedObj);
          }

          generateCozyGallery(newTemplates);
        } else {
          // Find the index of the object with the desired ID
          const activeIndex = originalItems.findIndex(
            (obj) => obj.ID === parseInt($(galleryItem).attr("data-post-id"))
          );

          if (activeIndex !== -1) {
            // Remove the object from its current position
            const [movedObj] = originalItems.splice(activeIndex, 1);

            // Add the object at the beginning of the originalItems
            originalItems.unshift(movedObj);
          }

          generateCozyGallery(originalItems);
        }

        // const sliderAttr = {
        //   init: true,
        //   speed: 1000,
        //   slidesPerView: 1,
        //   effect: "fade",
        //   fadeEffect: {
        //     crossFade: true,
        //   },
        //   navigation: {
        //     nextEl: `${portfolioClass} .swiper-button-next.cozy-gallery-next`,
        //     prevEl: `${portfolioClass} .swiper-button-prev.cozy-gallery-prev`,
        //   },
        // };

        // gallerySlider = new Swiper(
        //   portfolioClass + " .cozy-gallery__swiper-container",
        //   sliderAttr
        // );

        cozyOverlay.style.backgroundColor = blockOptions.popup.overlayWrapper;
        cozyOverlay.classList.remove("visibility-none");
        body.classList.add("overflow-hidden");
      }
    });

    const popupCloseIcon = cozyPortfolio.querySelector(
      ".cozy-popup-icon.popup-close-icon"
    );
    $(popupCloseIcon).on("click", function () {
      $(cozyPopup).addClass("hide-popup");
      $(cozyPopup).removeClass("show-popup");

      // Hide cozy overlay wrapper
      body.classList.remove("overflow-hidden");
      cozyOverlay.classList.add("visibility-none");
      cozyOverlay.style.backgroundColor = "#c3c3c3";

      if (
        portfolioSlider &&
        blockOptions.layout === "carousel" &&
        blockOptions.sliderOptions.autoplay.status
      ) {
        portfolioSlider.autoplay.start();
      }
    });

    cozyOverlay.addEventListener("click", function () {
      body.classList.remove("overflow-hidden");
      this.classList.add("visibility-none");
      $(cozyPopup).addClass("hide-popup");
      $(cozyPopup).removeClass("show-popup");
      cozyOverlay.style.backgroundColor = "#c3c3c3";

      $(galleryContainer).addClass("hide-cozy-gallery");

      if (
        portfolioSlider &&
        blockOptions.layout === "carousel" &&
        blockOptions.sliderOptions.autoplay.status
      ) {
        portfolioSlider.autoplay.start();
      }

      if (gallerySlider && Object.keys(gallerySlider).length > 0) {
        gallerySlider.destroy();
      }
    });

    function generatePopupView(template) {
      const featuredImage = cozyPopup.querySelector(
        ".cozy-portfolio-gallery__featured-image"
      );
      const title = cozyPopup.querySelector(".cozy-portfolio-gallery__title");
      const portfolioCategory = cozyPopup.querySelector(
        ".cozy-portfolio-gallery__category"
      );
      const projectYear = cozyPopup.querySelector(
        ".cozy-portfolio-gallery__project-year"
      );
      const client = cozyPopup.querySelector(".cozy-portfolio-gallery__client");
      const skills = cozyPopup.querySelector(".cozy-portfolio-gallery__skills");
      const url = cozyPopup.querySelector(".cozy-portfolio-gallery__url");
      const content = cozyPopup.querySelector(
        ".cozy-portfolio-gallery__content"
      );

      const defaultContent = cozyPopup.querySelector(
        ".cozy-popup-content__default"
      );
      const stickyContent = cozyPopup.querySelector(
        ".cozy-popup-content__sticky"
      );
      const cptContent = stickyContent.querySelector(
        ".cozy-portfolio-gallery__cpt"
      );

      if (featuredImage) {
        if (!template.featured_image) {
          $(featuredImage).hide();
        } else {
          $(featuredImage).show();

          featuredImage.setAttribute(
            "src",
            template.featured_image ? template.featured_image : ""
          );
          featuredImage.setAttribute("alt", template.post_title);
        }
      }

      title.innerHTML = template.post_title;

      portfolioCategory.innerHTML = ``;
      if (
        Array.isArray(template.post_custom_category) &&
        template.post_custom_category.length > 0
      ) {
        template.post_custom_category.map((category) => {
          portfolioCategory.innerHTML += `<span class="cozy-portfolio-gallery__category-label" key="${category.term_id}">${category.name}</span>`;
        });
      }

      if (
        template.post_project_year.length > 0 ||
        template.post_client.length > 0 ||
        template.post_skills.length > 0 ||
        template.post_url.length > 1
      ) {
        cptContent.style.setProperty("display", "block");
      } else {
        cptContent.style.setProperty("display", "none");
      }

      projectYear.innerHTML = ``;
      if (template.post_project_year.length > 0) {
        projectYear.innerHTML += `<h3 class="cozy-portfolio-gallery__subtitle">Project Year</h3>`;
        projectYear.innerHTML += `<p class="cozy-portfolio-gallery__cpt-content">${template.post_project_year}</p>`;
      }

      client.innerHTML = ``;
      if (template.post_client.length > 0) {
        client.innerHTML += `<h3 class="cozy-portfolio-gallery__subtitle">Client</h3>`;
        client.innerHTML += `<p class="cozy-portfolio-gallery__cpt-content">${template.post_client}</p>`;
      }

      skills.innerHTML = ``;
      if (template.post_skills.length > 0) {
        skills.innerHTML += `<h3 class="cozy-portfolio-gallery__subtitle">Skills/Technology</h3>`;
        skills.innerHTML += `<p class="cozy-portfolio-gallery__cpt-content">${template.post_skills}</p>`;
      }

      url.innerHTML = ``;
      if (template.post_url.length > 1) {
        url.innerHTML += `<a href="${template.post_url}" target="_blank" rel="noopener"><p class="cozy-portfolio-gallery__cpt-content">Website</p>
            <svg
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill=${blockOptions.portfolioCPT.color}
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path d="M14.805 14.94V18.6C14.805 19.04 14.485 19.4 14.045 19.4H3.60498C3.16498 19.4 2.80498 19.04 2.80498 18.6V5.40001C2.80498 4.96001 3.16498 4.60001 3.60498 4.60001H14.045C14.485 4.60001 14.805 4.96001 14.805 5.40001V9.06002C14.805 9.50002 14.445 9.86002 14.005 9.86002C13.565 9.86002 13.205 9.50002 13.205 9.06002V6.20001H4.40498V17.8H13.205V14.94C13.205 14.5 13.565 14.14 14.005 14.14C14.445 14.14 14.805 14.5 14.805 14.94ZM20.965 11.4L17.825 8.24C17.505 7.92 17.005 7.92 16.685 8.24C16.365 8.56 16.365 9.05999 16.685 9.37999L18.465 11.18L8.76499 11.2C8.32499 11.2 7.96499 11.56 7.96499 12C7.96499 12.44 8.32499 12.8 8.76499 12.8L18.465 12.78L16.685 14.58C16.365 14.9 16.385 15.4 16.685 15.72C16.845 15.88 17.045 15.96 17.245 15.96C17.445 15.96 17.665 15.88 17.805 15.72L20.945 12.56C21.285 12.22 21.285 11.72 20.965 11.4Z" />
          </svg></a>`;
      }

      content.innerHTML = template.render;
    }

    function generateCozyGallery(templates) {
      const galleryWrapper = cozyPortfolio.querySelector(
        ".cozy-gallery__swiper-container .swiper-wrapper"
      );

      $(galleryWrapper).empty();

      templates.forEach((template) => {
        const wrapperDiv = document.createElement("div");

        wrapperDiv.className =
          "cozy-portfolio swiper-slide post-ID__" + template.ID;
        wrapperDiv.setAttribute("data-post-id", template.ID);

        wrapperDiv.innerHTML = `
            ${
              blockOptions.featuredImage.position === "before" &&
              template.featured_image
                ? `
                <img
                  class="cozy-portfolio-gallery__featured-image"
                  src='${template.featured_image}'
                  alt='${template.post_title}'
                />
              `
                : ""
            } <h2 class="cozy-portfolio-gallery__title">
              ${
                blockOptions.enableOptions.title
                  ? `<a href='${
                      template.post_url.length > 1 ? template.post_url : "#"
                    }' target='${
                      template.post_url.length > 1 ? "_blank" : ""
                    }' rel='noopener'>
               
                ${template.post_title}
                
              </a></h2>`
                  : ""
              }
    
            ${
              blockOptions.featuredImage.position === "after" &&
              template.featured_image
                ? `
                <div class='cozy-portfolio-gallery__image-overlay'>
                </div>
                <img
                  class="cozy-portfolio-gallery__featured-image"
                  src='${template.featured_image}'
                  alt='${template.post_title}'
                />
              `
                : ""
            }
    
            `;

        if (galleryWrapper) {
          // Append the wrapperDiv to galleryWrapper and then fadeIn
          $(galleryWrapper).append(wrapperDiv).children(":last").fadeIn("slow");
        }
      });

      const sliderAttr = {
        init: true,
        speed: 1200,
        slidesPerView: 1,
        effect: "fade",
        fadeEffect: {
          crossFade: true,
        },
        navigation: {
          nextEl: `${portfolioClass} .swiper-button-next.cozy-gallery-next`,
          prevEl: `${portfolioClass} .swiper-button-prev.cozy-gallery-prev`,
        },
        on: {
          init: function () {
            // Disable transitions on initialization
            this.setTransition(0);
          },
        },
      };

      gallerySlider = new Swiper(
        portfolioClass + " .cozy-gallery__swiper-container",
        sliderAttr
      );
    }
  };
})(jQuery);
