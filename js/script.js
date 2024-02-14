const navBar = document.querySelector("nav");
let menuBtns = document.querySelectorAll(".menu-icon");
const overlay = document.querySelector(".overlay");
    
menuBtns.forEach(menuBtn => {
    menuBtn.addEventListener("click", () => {
        let cart = document.querySelector('.cart');
        if (cart && isCartOpen) { // Verifica se o carrinho existe e está aberto
            closeCart();
        }
        navBar.classList.toggle("open");
    });
});

var swiper = new Swiper(".home-slider", {
    grabCursor: true,
    loop: true,
    centeredSlides: true,
    scrollbar: {
    el: ".swiper-scrollbar",
    hide: true,
    },   
});

var swiper = new Swiper('.slider2', {
    loop: true,
  
    pagination: {
      el: '.swiper-pagination',
    },
  
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
});

function formLoginRegistar() {
    const home = document.querySelector(".login");
    const formContainer = document.querySelector(".form_container");
    const signupBtn = document.querySelector("#signup");
    const loginBtn = document.querySelector("#login");
    const pwShowHide = document.querySelectorAll(".pw_hide");

    pwShowHide.forEach((icon) => {
        icon.addEventListener("click", () => {
            let getPwInput = icon.parentElement.querySelector("input");
            if (getPwInput.type === "password") {
                getPwInput.type = "text";
                icon.classList.replace("fa-eye-slash", "fa-eye"); 
            } else {
                getPwInput.type = "password";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            }
        });
    });

    if (signupBtn) {
        signupBtn.addEventListener("click", (e) => {
            e.preventDefault();
            formContainer.classList.add("active");
        });
    }

    if (loginBtn) {
        loginBtn.addEventListener("click", (e) => {
            e.preventDefault();
            formContainer.classList.remove("active");
        });
    }
}

formLoginRegistar();

document.addEventListener('DOMContentLoaded', function() {
    loadCartItems();

    let cartIcon = document.querySelector('#cart-icon');
    let cart = document.querySelector('.cart');
    let closeCartBtn = document.querySelector('#close-cart');

    if (cartIcon && cart) {
        cartIcon.onclick = () => {
            cart.classList.toggle("active");
            isCartOpen = cart.classList.contains("active");
        };
    }

    if (closeCartBtn && cart) {
        closeCartBtn.onclick = () => {
            cart.classList.remove("active");
            isCartOpen = false;
        };
    }
});

function closeCart() {
    let cart = document.querySelector('.cart');
    cart.classList.remove("active");
    isCartOpen = false;
}

function updateCartBadge() {
    var cartItems = $(".cart-content .cart-box");
    var cartBadge = $(".cart-badge");

    // Filtra os elementos vazios do carrinho antes de contar
    cartItems = cartItems.filter(function () {
        return $(this).children().length > 0;
    });

    var itemCount = cartItems.length;

    // Atualiza o número no distintivo do carrinho
    if (itemCount > 0) {
        cartBadge.text(itemCount); // Atualiza o texto com o número de itens
    } else {
        cartBadge.text(''); // Limpa o texto do distintivo
    }

    // Mantém o distintivo sempre visível
    cartBadge.css("display", "");
}


ready();
isCartOpen = false;

function ready() {
    var removeCartButtons = document.getElementsByClassName("cart-remove");
    for (var i = 0; i < removeCartButtons.length; i++) {
      var button = removeCartButtons[i];
      button.addEventListener("click", removeCartItem);
    }

    var quantityInputs = document.getElementsByClassName("cart-quantity");
    for (var i = 0; i < quantityInputs.length; i++) {
      var input = quantityInputs[i];
      input.addEventListener("change", quantityChange);
    }

    var addCart = document.getElementsByClassName("add-cart");
    for (var i = 0; i < addCart.length; i++) {
      var button = addCart[i];
      button.addEventListener("click", addCartClicked);
    }
    loadCartItems();
}

function removeCartItem(event){
    var buttonClicked = event.target;
    buttonClicked.parentElement.remove();
    updateTotal();
    updateCartBadge();
    saveCartItems();
}

function updateTotal() {
    var cartBoxes = $(".cart-box");
    var total = 0;

    // Itera sobre as caixas do carrinho
    cartBoxes.each(function () {
      var priceElement = $(this).find(".cart-price");
      var quantityElement = $(this).find(".cart-quantity");

      // Obtém preço e quantidade do elemento atual
      if (priceElement.length && quantityElement.length) {
        var priceText = priceElement.text().trim();
        var price =
          parseFloat(priceText.replace("€", "").replace(",", ".")) || 0;
        var quantity = parseInt(quantityElement.val(), 10) || 1;

        // Calcula o total do produto
        if (!isNaN(price) && !isNaN(quantity)) {
          total += price * quantity;
        }
      }
    });

    // Atualiza o elemento que exibe o total
    $(".total-price").text("€" + total.toFixed(2));
    //Save to local storage
    localStorage.setItem('cartTotal', total);
}


function quantityChange(event) {
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0) {
      input.value = 1;
    }
    updateTotal();
    saveCartItems();
}


function addCartClicked(event) {
    if (!isUserLoggedIn) {
        toastr.warning("Você precisa estar logado para comprar", "Aviso", {
            closeButton: false,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000,
            extendedTimeOut: 1000,
            preventDuplicates: false,
            newestOnTop: false,
            showDuration: 300,
            hideDuration: 300,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "slideDown",
            hideMethod: "slideUp",
            toastClass: "custom-toast-class"
        });
        return;
    }else{
        event.preventDefault();
        var button = event.target;
        var shopItem = button.closest('.pro');
        var title = shopItem.querySelector('h5').innerText;
        var price = shopItem.querySelector('h4').innerText;
        var productImg = shopItem.querySelector('img').src;
        addProductToCart(title, price, productImg);
        updateCartBadge();
        saveCartItems();
    }
}

function addProductToCart(title, price, quantity, productImg) {
    var cartItems = $(".cart-content");
    var cartItemImages = cartItems.find(".cart-img");
    var isProductAdded = false;

    // Verifica se o produto já está no carrinho
    cartItemImages.each(function() {
        var currentImage = $(this).attr("src");
        if (currentImage === productImg) {
            // Atualiza a quantidade se o produto já estiver no carrinho
            var quantityInput = $(this).closest(".cart-box").find(".cart-quantity");
            quantityInput.val(parseInt(quantityInput.val()) + 1);
            isProductAdded = true;
            updateTotal(); // Atualizar o total do carrinho
            saveCartItems();
            return false; // Sair do loop each
        }
    });

    // Adiciona o produto se ele ainda não estiver no carrinho
    if (!isProductAdded) {
        var cartShopBox = $("<div>").addClass("cart-box");
        var cartBoxContent = `
                    <img src="${productImg}" alt="" class="cart-img">
                <div class="detail-box">
                    <div class="cart-product-title">${title}</div>
                    <div class="cart-price">${price}</div>
                    <label for="quantity">Quantidade:
                    <input type="number" value="1" class="cart-quantity" id="quantity"></label>
                </div>
                <i class='bx bx-trash cart-remove'></i>
        `;
        cartShopBox.html(cartBoxContent);
        cartItems.append(cartShopBox);

        // Adicionar ouvintes de eventos para o novo item do carrinho
        cartShopBox.find(".cart-remove").on("click", removeCartItem);
        cartShopBox.find(".cart-quantity").on("change", quantityChange);

        updateTotal(); // Atualizar o total do carrinho
        saveCartItems();
    }
}

function saveCartItems() {
    var cartBoxes = document.querySelectorAll('.cart-box');
    var cartItems = [];

    cartBoxes.forEach(function(cartBox) {
        var title = cartBox.querySelector('.cart-title').innerText;
        var price = cartBox.querySelector('.cart-price').innerText;
        var quantity = cartBox.querySelector('.cart-quantity').value; // Assumindo que é um input
        var productImg = cartBox.querySelector('img').src;

        var item = {
            title: title,
            price: price,
            quantity: quantity,
            productImg: productImg,
        };
        cartItems.push(item);
    });

    localStorage.setItem('cartItems', JSON.stringify(cartItems));
}


function loadCartItems() {
    var savedCartItems = localStorage.getItem('cartItems');
    if (savedCartItems) {
        var cartItems = JSON.parse(savedCartItems);
        cartItems.forEach(function(item) {
            addProductToCart(item.title, item.price, item.quantity, item.productImg);
        });
    }
}