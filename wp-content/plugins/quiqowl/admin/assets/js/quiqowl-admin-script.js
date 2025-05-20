(($) => {
  $(document).ready(function () {
    // Product Analytics page
    const $productDashboard = $(".quiqowl-admin__dashboard.product-analytics");
    const $modal = $productDashboard.find(".quiqowl-admin__modal");
    const $spinner = $productDashboard.find("#quiqowl-spinner");

    function closeModal() {
      $modal.find(".quiqowl-modal__product-data").html("");
      $modal.addClass("display-none");
    }

    $productDashboard.find(".close-icon__wrapper").click(function () {
      closeModal();
    });

    $(document).click(function (e) {
      if (e.target === $modal[0]) {
        closeModal();
      }
    });

    $productDashboard
      .find(".product_log.column-product_log svg")
      .click(function () {
        $modal.removeClass("display-none");
        $spinner.removeClass("display-none");

        $btn = $(this);

        const productID = $btn.parent().siblings(".product_id").first().text();

        $.ajax({
          url: adminObject.ajaxURL,
          method: "POST",
          data: {
            action: "quiqowl_admin_render_product_cart_data",
            nonce: adminObject.cartDataNonce,
            productID: productID,
          },
          success: function (response) {
            if (response.success) {
              if (response.data.render.trim() === "") {
                $modal
                  .find(".quiqowl-modal__product-data")
                  .append(
                    '<h4 style="text-align: center">Logs are currently empty!</h4>'
                  );
              } else {
                $modal
                  .find(".quiqowl-modal__product-data")
                  .append(response.data.render);
              }
            } else {
              console.log("Invalid arguments!");
              $modal
                .find(".quiqowl-modal__product-data")
                .append(
                  '<h4 style="text-align: center">Logs are currently empty!</h4>'
                );
            }

            $spinner.addClass("display-none");
          },
          error: function (xhr, status, error) {
            console.log("Unable to fetch data!");
            $spinner.addClass("display-none");
            $modal
              .find(".quiqowl-modal__product-data")
              .append(
                '<h4 style="text-align: center">Logs are currently empty!</h4>'
              );
          },
        });
      });
  });
})(jQuery);
