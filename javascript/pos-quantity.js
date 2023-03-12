function updateSubtotal() {
    var subtotal = 0;
    $(".price-display").each(function() {
      subtotal += parseFloat($(this).text());
    });
    $("#subtotal").val(subtotal.toFixed(2));
  }


$(document).ready(function() {
    $('.quantity-input').on('input', function() {
      // get the product ID and quantity value
      var productId = $(this).data('product-id');
      var quantity = $(this).val();
  
      // send an AJAX request to update the database
      $.ajax({
        url: '../process/update-quantity.php',
        method: 'POST',
        data: { productId: productId, quantity: quantity },
        success: function(response) {
            $('.price-display[data-product-id="' + productId + '"]').text(response);
            updateSubtotal()

            var subtotal = parseFloat($('#subtotal').val());
            var taxPercentage = parseFloat($('#tax-percentage').val());
            var discountpercentage = parseFloat($('#discount-percentage').val());

            var vat = subtotal * taxPercentage;

            var subtotal2 = subtotal + vat;

            var discount = subtotal2 * discountpercentage;

            var total = subtotal2 - discount;
            
            $('#discount').val(discount.toFixed(2));
            $('#vat').val(vat.toFixed(2));
            $('#total').val(total.toFixed(2));
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });
    });
  });