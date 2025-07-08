let cart = [];

function addToCart(id, name, price, image) {
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ id, name, price, image, qty: 1 });
    }
    renderCart();
}

function renderCart() {
    const cartBox = document.getElementById("cart-box");
    cartBox.innerHTML = "";
    let total = 0;

    cart.forEach((item, i) => {
        total += item.qty * item.price;
        cartBox.innerHTML += `
        <div style="display:flex;align-items:center;margin-bottom:10px;">
            <img src="${item.image}" style="height:50px;width:50px;margin-right:10px;">
            <div style="flex:1;">
                <b>${item.name}</b><br>
                ₹${item.price} x ${item.qty}
            </div>
            <button onclick="cart[${i}].qty--; if(cart[${i}].qty<=0) cart.splice(${i},1); renderCart()">−</button>
            <button onclick="cart[${i}].qty++; renderCart()">+</button>
        </div>`;
    });

    document.getElementById("cart-total").innerText = "Total: ₹" + total;
}

function toggleCart() {
    document.getElementById("cart").classList.toggle("open");
}

function proceedOrder() {
    if (cart.length === 0) return alert("Cart is empty!");
    const form = document.createElement("form");
    form.method = "post";
    form.action = "confirm_order.php";
    cart.forEach((item, index) => {
        form.innerHTML += `<input type="hidden" name="items[${index}][id]" value="${item.id}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][name]" value="${item.name}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][price]" value="${item.price}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][qty]" value="${item.qty}">`;
        form.innerHTML += `<input type="hidden" name="items[${index}][image]" value="${item.image}">`;
    });
    document.body.appendChild(form);
    form.submit();
}