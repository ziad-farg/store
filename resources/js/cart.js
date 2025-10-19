(function ($) {
    const debounceMap = {};

    function getCsrf() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : window.csrf_token;
    }

    function updateDomAfterResponse(cartId, data) {
        // update item subtotal (if provided)
        const subtotalEl = document.querySelector(`[data-subtotal-id="${cartId}"]`);
        if (subtotalEl && (data.formatted_subtotal || data.subtotal !== undefined)) {
            subtotalEl.textContent = data.formatted_subtotal ?? data.subtotal;
        }

        // update totals
        const totalEl = document.getElementById('cart-total');
        if (totalEl && (data.formatted_total || data.total !== undefined)) {
            totalEl.textContent = data.formatted_total ?? data.total;
        }

        const discountEl = document.getElementById('cart-total-discount');
        if (discountEl && (data.formatted_totalDiscount || data.totalDiscount !== undefined)) {
            discountEl.textContent = data.formatted_totalDiscount ?? data.totalDiscount;
        }
    }

    $(function () {
        // UPDATE quantity (existing)
        $(document).on('change', '.item-quantity', function () {
            const $select = $(this);
            const cartId = $select.data('id');
            const url = $select.data('url');
            const quantity = parseInt($select.val(), 10);
            const token = getCsrf();

            if (!url) {
                console.warn('Missing data-url for cart id', cartId);
                return;
            }

            // debounce per cart item (300ms)
            if (debounceMap[cartId]) clearTimeout(debounceMap[cartId]);
            debounceMap[cartId] = setTimeout(() => {
                $select.prop('disabled', true);

                $.ajax({
                    url: url,
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': token },
                    data: { quantity: quantity },
                    success(response) {
                        updateDomAfterResponse(cartId, response);
                    },
                    error(xhr) {
                        let msg = 'Failed to update cart';
                        try { msg = xhr.responseJSON?.message ?? msg; } catch (e) {}
                        alert(msg);
                    },
                    complete() {
                        $select.prop('disabled', false);
                    }
                });
            }, 300);
        });

        // DELETE item via ajax
        $(document).on('click', '.remove-item', function (e) {
            e.preventDefault();
            const $btn = $(this);
            const cartId = $btn.data('id');
            const url = $btn.data('url'); // expect route('front.cart.destroy', $cart->id')
            const token = getCsrf();

            if (!url) {
                console.warn('Missing data-url on remove-item for cart id', cartId);
                return;
            }

            // optional confirm
            if (!confirm('Are you sure you want to remove this item from the cart?')) {
                return;
            }

            $btn.prop('disabled', true);

            $.ajax({
                url: url,
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': token },
                success(response) {
                    // remove the cart row from DOM
                    // prefer removing closest .cart-single-list
                    const $row = $btn.closest('.cart-single-list');
                    if ($row.length) {
                        $row.remove();
                    } else {
                        // fallback: remove element with data-id
                        $(`[data-id="${cartId}"]`).remove();
                    }

                    // update totals if returned
                    updateDomAfterResponse(cartId, response);

                    // optional success toast if you have Swal or toast lib
                    if (window.Swal) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message ?? 'Item removed',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                },
                error(xhr) {
                    let msg = 'Failed to remove item';
                    try { msg = xhr.responseJSON?.message ?? msg; } catch (e) {}
                    alert(msg);
                },
                complete() {
                    $btn.prop('disabled', false);
                }
            });
        });
    });
})(jQuery);
