document.addEventListener('DOMContentLoaded', () => {
  const quantityInput = document.querySelector('input[id="sylius_shop_add_to_cart_cartItem_quantity"]');
  if (quantityInput) {
    quantityInput.addEventListener('change', () => {
      if (parseInt(quantityInput.value, 10) === 70) {
        alert('Great Choice!');
      }
    });
  }
});
