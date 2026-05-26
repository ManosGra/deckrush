$(document).ready(function () {
    // New products owl carousel
    $("#top-sale .owl-carousel").owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 500,
        responsive: {
            0: { items: 1 },
            600: { items: 3 },
            1000: { items: 5 }
        }
    });

    // Increment and Decrement quantity buttons
    $('.increment-btn, .decrement-btn').click(function (e) {
        e.preventDefault();
        var $productData = $(this).closest('.product_data');
        var qty = $productData.find('.input-qty');
        var value = parseInt(qty.val(), 5) || 0;

        if ($(this).hasClass('increment-btn') && value < 5) {
            value++;
        } else if ($(this).hasClass('decrement-btn') && value > 1) {
            value--;
        }
        qty.val(value);
        updateCartQuantity($productData);
    });

    // Initial load of item count in cart
    updateCartCount();

    // Add product to cart (ΔΙΟΡΘΩΘΗΚΕ: Έγινε dynamic delegation με .on για να πιάνει και το καρουζέλ)
    $(document).on('click', '.addToCartBtn', function (e) {
        e.preventDefault();
        var $productData = $(this).closest('.product_data');
        var qty = $productData.find('.input-qty').val();
        var prod_id = $(this).val();

        $.ajax({
            method: "POST",
            // ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στην αρχή
            url: "/functions/handlecart.php",
            data: {
                "prod_id": prod_id,
                "prod_qty": qty,
                "scope": "add"
            },
            success: function (response) {
                if (response.trim() == "200") {
                    alertify.alert("Το προϊόν προστέθηκε στο καλάθι");
                    updateCartCount();
                } else if (response.trim() == "existing") {
                    alertify.alert("Το προϊόν είναι ήδη στο καλάθι");
                } else if (response.trim() == "0") {
                    alertify.alert("Πρέπει να συνδεθείτε για να συνεχίσετε");
                } else {
                    alertify.alert("Something went wrong");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    // Delete product from cart
    $(document).on('click', '.deleteItem', function () {
        var cart_id = $(this).val();
        $.ajax({
            method: "POST",
            // ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στην αρχή
            url: "/functions/handlecart.php",
            data: {
                "cart_id": cart_id,
                "scope": "delete"
            },
            success: function (response) {
                if (response == 200) {
                    $('#mycart').load(location.href + " #mycart > *");
                    alertify.alert("Το προϊόν αφαιρέθηκε από το καλάθι");
                    updateCartCount();
                } else {
                    alertify.error("Κάτι πήγε στραβά.");
                }
            },
            error: function (error) {
                console.error("Error: " + error);
            }
        });
    });

    // Update cart quantity
    function updateCartQuantity($productData) {
        var qty = $productData.find('.input-qty').val();
        var prod_id = $productData.find('.prodId').val();

        $.ajax({
            method: "POST",
            // ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στην αρχή
            url: "/functions/handlecart.php",
            data: {
                "prod_id": prod_id,
                "prod_qty": qty,
                "scope": "update"
            },
            success: function (response) {
                if (response.trim() == "200") {
                    alertify.success("Ποσότητα ενημερώθηκε!");
                } else {
                    alertify.error("Κάτι πήγε στραβά κατά την ενημέρωση.");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Update cart count
    function updateCartCount() {
        $.ajax({
            method: "POST",
            // ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στην αρχή
            url: "/functions/handlecart.php",
            data: { "scope": "getCount" },
            success: function (response) {
                $('#cart-empty').text(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    // Checkbox filtering logic
    $('input[type="checkbox"]').not('#exampleCheck1').change(function () {
        if ($(this).is(':checked')) {
            $('input[type="checkbox"]').not(this).prop('checked', false).prop('disabled', true);
        } else {
            const anyChecked = $('input[type="checkbox"]:checked').length > 0;
            $('input[type="checkbox"]').not('#exampleCheck1').prop('disabled', anyChecked);
            if (!$('input[type="checkbox"]:checked').length) {
                $('#exampleCheck1').prop('checked', true);
            }
        }
        filterProducts();
    });

    $('#exampleCheck1').change(function () {
        if ($(this).is(':checked')) {
            $('input[type="checkbox"]').not(this).prop('checked', false).prop('disabled', true);
        } else {
            $('input[type="checkbox"]').not('#exampleCheck1').prop('disabled', false);
        }
        filterProducts();
    });

    // Filter products based on selected checkboxes
    function filterProducts() {
        const selectedTitles = [];

        $('input[type="checkbox"]:checked').each(function () {
            const title = $(this).data('title'); 
            if (this.id !== 'exampleCheck1') {
                selectedTitles.push(title);
            }
        });

        const productsToShow = [];
        const productsToHide = [];

        if (selectedTitles.length === 0) {
            $('.product-col').each(function () {
                productsToShow.push($(this));
            });
        } else {
            $('.product-col').each(function () {
                const productTitle = $(this).find('.product-info p').text().trim();
                const matches = selectedTitles.some(selectedTitle => productTitle.includes(selectedTitle));
                const isAllProductsChecked = $('#exampleCheck1').is(':checked');

                if (isAllProductsChecked && matches) {
                    productsToShow.push($(this));
                } else if (matches) {
                    productsToShow.push($(this));
                } else {
                    productsToHide.push($(this));
                }
            });
        }

        $('.product-col').removeClass('visible').addClass('hidden')
            .animate({ opacity: 0 }, 20, function () {
                $(this).css('display', 'none');
                if (productsToShow.length > 0) {
                    productsToShow.forEach((product) => {
                        product.removeClass('hidden').addClass('visible')
                            .css({ display: 'block', opacity: 0 })
                            .animate({ opacity: 1 }, 0);
                    });
                }
            });

        $('.product-col').css('display', 'flex');
    }

    // Επιλέγουμε όλες τις εικόνες με το data-src attribute (lazy-loaded)
    const lazyLoadImages = document.querySelectorAll('img[data-src]');
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    // Συνάρτηση για την αλλαγή της πηγής της εικόνας και την προσθήκη εφέ fade-in
    const lazyLoad = (image) => {
        image.src = image.dataset.src;
        image.onload = () => {
            image.classList.add('fade-in'); 
        };
        image.classList.remove('lazy');
    };

    // Δημιουργούμε έναν IntersectionObserver για να παρατηρεί πότε η εικόνα εμφανίζεται στην οθόνη
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                lazyLoad(entry.target);
                observer.unobserve(entry.target); 
            }
        });
    }, options);

    lazyLoadImages.forEach(image => {
        observer.observe(image);
    });
});
